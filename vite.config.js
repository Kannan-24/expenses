import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js', 'resources/js/editor.js'],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            tinymce: path.resolve(__dirname, 'node_modules/tinymce'),
        },
    },
    server: {
        host: '0.0.0.0', // Allow external connections
        port: 5173,
        hmr: {
            host: 'localhost', // or your actual IP like '192.168.1.10'
        },
    },
});
