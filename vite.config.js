import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                // === Auth (Breeze / Custom) ===
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/auth/login.css',

                // === Panel Admin ===
                'resources/js/admin/app.js',
                'resources/css/admin/app.css',
                'resources/css/admin/dashboard.css',
                'resources/js/admin/dashboard.js',
                'resources/css/admin/pacientes.css',
                'resources/js/admin/pacientes.js',
                'resources/css/admin/medicos.css',
                'resources/js/admin/medicos.js',

                // === Panel Médico ===
                'resources/css/medico/app.css',
                'resources/css/medico/pacientes.css',
                'resources/css/medico/monitoreo.css',
            ],
            refresh: true,
        }),
    ],
});
