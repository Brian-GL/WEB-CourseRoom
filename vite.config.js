import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path'

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/js/app.js',
                'resources/js/bootstrap.js',
                'resources/css/app.css',
                'resources/templates/Course_Room_Brand.png',
                'resources/templates/Course_Room_Brand_Blue.png',
                'resources/templates/Course_Room_Brand_Fondo.png',
                'resources/templates/deezer_22419.png',
                'resources/templates/HappyOwl.png',
                'resources/templates/IndiferentOwl.png',
                'resources/templates/SadOwl.png',
                'resources/templates/Course_Room_Logo.ico',
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
