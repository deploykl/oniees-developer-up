import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    server: {   //ADD
        host: '0.0.0.0',  // Permite conexiones externas
        port: 5173,
        strictPort: true,  // Fuerza usar este puerto
        hmr: {     // ADD
            host: '127.0.0.1',  // Tu IP local (NO localhost)
            //host: '172.27.0.150',  // Tu IP local (NO localhost)
            port: 5173,   //ADD
        },
        cors: true,  // Habilita CORS para otras PCs
    },
});