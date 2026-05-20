import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                // App principal
                'resources/css/app.css',
                'resources/js/app.js',

                // Admin
                'resources/css/admin/app.css',
                'resources/js/admin/app.js',

                // Dashboard
                'resources/css/admin/dashboard.css',
                'resources/js/admin/dashboard.js',

                // Médicos
                'resources/css/admin/medicos.css',
                'resources/js/admin/medicos.js',

                // Pacientes
                'resources/css/admin/pacientes.css',
                'resources/js/admin/pacientes.js',
            ],

            refresh: true,
        }),

        tailwindcss(),
    ],

    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});