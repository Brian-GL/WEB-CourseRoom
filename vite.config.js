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
                'resources/css/avisos/avisos.css',
                'resources/css/chats/chats.css',
                'resources/css/chats/detallechat.css',
                'resources/css/cursos/cursos.css',
                'resources/css/cursos/detallecurso.css',
                'resources/css/cursos/detallecursoestudiante.css',
                'resources/css/cursos/detallecursoprofesor.css',
                'resources/css/default/acceso.min.css',
                'resources/css/default/recuperacion.min.css',
                'resources/css/default/registro.min.css',
                'resources/css/grupos/detallegrupo.css',
                'resources/css/grupos/grupos.css',
                'resources/css/herramientas/matematicas.min.css',
                'resources/css/herramientas/musica.min.css',
                'resources/css/inicio/acerca.min.css',
                'resources/css/inicio/inicio.min.css',
                'resources/css/layout/core.css',
                'resources/css/layout/home.css',
                'resources/css/preguntasrespuestas/detallepregunta.css',
                'resources/css/preguntasrespuestas/preguntas.min.css',
                'resources/css/tareas/detalletarea.css',
                'resources/css/tareas/detalletareaestudiante.css',
                'resources/css/tareas/detalletareaprofesor.css',
                'resources/css/tareas/tareas.css',
                'resources/css/usuarios/desempeno.css',
                'resources/css/usuarios/perfil.min.css',
                'resources/css/usuarios/sesiones.css',
                'resources/js/avisos/avisos.js',
                'resources/js/chats/chats.js',
                'resources/js/chats/detallechat.js',
                'resources/js/cursos/cursos.js',
                'resources/js/cursos/detallecurso.js',
                'resources/js/cursos/detallecursoestudiante.js',
                'resources/js/cursos/detallecursoprofesor.js',
                'resources/js/default/acceso.js',
                'resources/js/default/recuperacion.js',
                'resources/js/default/registro.js',
                'resources/js/grupos/detallegrupo.js',
                'resources/js/grupos/grupos.js',
                'resources/js/herramientas/matematicas.min.js',
                'resources/js/herramientas/musica.min.js',
                'resources/js/inicio/inicio.min.js',
                'resources/js/layout/core.js',
                'resources/js/layout/evo-calendar.min.js',
                'resources/js/layout/home.js',
                'resources/js/preguntasrespuestas/detallepregunta.js',
                'resources/js/preguntasrespuestas/preguntas.js',
                'resources/js/tareas/detalletarea.js',
                'resources/js/tareas/detalletareaestudiante.js',
                'resources/js/tareas/detalletareaprofesor.js',
                'resources/js/tareas/tareas.js',
                'resources/js/usuarios/desempeno.js',
                'resources/js/usuarios/perfil.js',
                'resources/js/usuarios/sesiones.js',
                'resources/templates/Course_Room_Brand.png',
                'resources/templates/Course_Room_Brand_Blue.png',
                'resources/templates/Course_Room_Brand_Fondo.png',
                'resources/templates/deezer_22419.png',
                'resources/templates/HappyOwl.png',
                'resources/templates/IndiferentOwl.png',
                'resources/templates/SadOwl.png',
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
