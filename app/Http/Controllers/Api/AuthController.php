<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Paciente;
use App\Models\Usuario;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Auto-registro de un nuevo paciente desde la aplicación móvil.
     */
    public function registerPaciente(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            // Datos de la cuenta de usuario
            'primer_nombre'        => 'required|string|max:50',
            'segundo_nombre'       => 'nullable|string|max:50',
            'apellido_paterno'     => 'required|string|max:50',
            'apellido_materno'     => 'nullable|string|max:50',
            'email'                => 'required|string|email|max:100|unique:usuarios,email',
            'password'             => 'required|string|min:8|confirmed',

            // Datos clínicos del paciente
            'fecha_nacimiento'     => 'required|date|before:today',
            'telefono_emergencia'  => 'required|string|max:20',
            'sexo'                 => 'required|string|in:Masculino,Femenino,Otro',
            'estatura'             => 'required|numeric|between:0.50,2.60',
            'diagnostico_principal'=> 'required|in:Hipertensión,Diabetes tipo 2,Obesidad',
            'medico_id'            => 'nullable|exists:medicos,id',
        ], [
            'email.unique'          => 'Este correo electrónico ya se encuentra registrado.',
            'password.confirmed'    => 'La confirmación de la contraseña no coincide.',
            'password.min'          => 'La contraseña debe tener al menos 8 caracteres.',
            'fecha_nacimiento.before'=> 'La fecha de nacimiento debe ser anterior al día de hoy.',
            'medico_id.exists'      => 'El médico seleccionado no es válido.',
            'diagnostico_principal.in' => 'El diagnóstico debe ser Hipertensión, Diabetes tipo 2 u Obesidad.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Errores de validación en los datos proporcionados.',
                'errors'  => $validator->errors(),
            ], 422);
        }

        try {
            $data = DB::transaction(function () use ($request) {
                // 1. Crear el usuario con rol de Paciente (rol_id = 3)
                $usuario = Usuario::create([
                    'primer_nombre'    => $request->primer_nombre,
                    'segundo_nombre'   => $request->segundo_nombre,
                    'apellido_paterno' => $request->apellido_paterno,
                    'apellido_materno' => $request->apellido_materno ?? '',
                    'email'            => strtolower(trim($request->email)),
                    'password'         => Hash::make($request->password),
                    'rol_id'           => 3, // Paciente
                    'estado'           => 'Activo',
                    'ultimo_acceso'    => now(),
                ]);

                // 2. Crear el expediente del paciente
                $paciente = Paciente::create([
                    'usuario_id'           => $usuario->id,
                    'medico_id'            => $request->medico_id,
                    'fecha_nacimiento'     => $request->fecha_nacimiento,
                    'telefono_emergencia'  => $request->telefono_emergencia,
                    'sexo'                 => $request->sexo,
                    'estatura'             => $request->estatura,
                    'diagnostico_principal'=> $request->diagnostico_principal,
                    'nivel_riesgo'         => 'Bajo',
                ]);

                if ($request->filled('medico_id')) {
                    $paciente->medicos()->sync([
                        $request->medico_id => ['es_principal' => true],
                    ]);
                }

                // 3. Crear token Sanctum para la app móvil
                $token = $usuario->createToken('mobile_app_patient')->plainTextToken;

                return [
                    'usuario'  => $usuario,
                    'paciente' => $paciente->load('medico.usuario', 'medicos.usuario'),
                    'token'    => $token,
                ];
            });

            return response()->json([
                'success' => true,
                'message' => '¡Paciente registrado exitosamente!',
                'data'    => [
                    'token'    => $data['token'],
                    'token_type' => 'Bearer',
                    'usuario'  => [
                        'id'              => $data['usuario']->id,
                        'nombre_completo' => $data['usuario']->nombre_completo,
                        'email'           => $data['usuario']->email,
                        'rol_id'          => $data['usuario']->rol_id,
                    ],
                    'paciente' => $data['paciente'],
                ],
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error al procesar el registro.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Inicio de sesión desde la aplicación móvil.
     */
    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email'       => 'required|email',
            'password'    => 'required|string',
            'device_name' => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Datos incompletos para iniciar sesión.',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $usuario = Usuario::where('email', strtolower(trim($request->email)))->first();

        if (!$usuario || !Hash::check($request->password, $usuario->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Las credenciales proporcionadas son incorrectas.',
            ], 401);
        }

        if ($usuario->estado !== 'Activo') {
            return response()->json([
                'success' => false,
                'message' => 'Tu cuenta se encuentra inactiva. Contacta al administrador.',
            ], 403);
        }

        // Actualizar último acceso
        $usuario->update(['ultimo_acceso' => now()]);

        // Cargar perfiles asociados
        $usuario->load(['rol', 'paciente.medico.usuario', 'medico']);

        $deviceName = $request->device_name ?? 'mobile_app';
        $token = $usuario->createToken($deviceName)->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Inicio de sesión exitoso.',
            'data'    => [
                'token'      => $token,
                'token_type' => 'Bearer',
                'usuario'    => [
                    'id'              => $usuario->id,
                    'nombre_completo' => $usuario->nombre_completo,
                    'email'           => $usuario->email,
                    'rol_id'          => $usuario->rol_id,
                    'rol_nombre'      => $usuario->rol->nombre ?? null,
                ],
                'perfil'     => $usuario->esPaciente() ? $usuario->paciente : ($usuario->esMedico() ? $usuario->medico : null),
            ],
        ]);
    }

    /**
     * Obtener el perfil del usuario autenticado.
     */
    public function me(Request $request): JsonResponse
    {
        $usuario = $request->user();
        $usuario->load(['rol', 'paciente.medico.usuario', 'medico']);

        return response()->json([
            'success' => true,
            'data'    => [
                'usuario' => [
                    'id'              => $usuario->id,
                    'primer_nombre'   => $usuario->primer_nombre,
                    'segundo_nombre'  => $usuario->segundo_nombre,
                    'apellido_paterno'=> $usuario->apellido_paterno,
                    'apellido_materno'=> $usuario->apellido_materno,
                    'nombre_completo' => $usuario->nombre_completo,
                    'email'           => $usuario->email,
                    'rol_id'          => $usuario->rol_id,
                    'rol_nombre'      => $usuario->rol->nombre ?? null,
                    'estado'          => $usuario->estado,
                ],
                'perfil'  => $usuario->esPaciente() ? $usuario->paciente : ($usuario->esMedico() ? $usuario->medico : null),
            ],
        ]);
    }

    /**
     * Cerrar sesión y revocar el token actual.
     */
    public function logout(Request $request): JsonResponse
    {
        if ($request->user() && $request->user()->currentAccessToken()) {
            $request->user()->currentAccessToken()->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'Sesión cerrada exitosamente y token revocado.',
        ]);
    }
}
