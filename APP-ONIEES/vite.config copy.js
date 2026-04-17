import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    server: {
        host: '0.0.0.0',  // Permite conexiones externas
        port: 5173,
        strictPort: true,  // Fuerza usar este puerto
        hmr: {
            host: '172.27.0.150',  // Tu IP local (NO localhost)
            port: 5173,
        },
        cors: true,  // Habilita CORS para otras PCs
    },
});