import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    server: {   // ADD
        host: '0.0.0.0',  // ADD
        port: 5173,       // ADD
        hmr: {              //ADD
            host: '172.27.0.150',  // O tu IP local
        },
    },
});
