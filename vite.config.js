import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path'

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            '~bootstrap': path.resolve(__dirname, 'node_modules/bootstrap'),
            '~font-awesome': path.resolve(__dirname, 'node_modules/@fortawesome/fontawesome-free'),
            '~sweetalert2': path.resolve(__dirname,'node_modules/@swertalert2/theme-dark'),
            '~toastr': path.resolve(__dirname,'node_modules/toastr'),
            '@': '/resources/js'
        }
    }
});
