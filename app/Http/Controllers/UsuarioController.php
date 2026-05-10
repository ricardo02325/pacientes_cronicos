<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsuarioController extends Controller
{
    public function cambiarEstado(Request $request, $id)
    {
        DB::statement(
            'CALL cambiar_estado_usuario(?, ?)',
            [$id, $request->estado]
        );

        return response()->json([
            'success' => true,
        ]);
    }
}
