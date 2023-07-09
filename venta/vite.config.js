import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 
            'resources/js/app.js',
            'resources/vendor/nucleo/css/nucleo.css',
            'resources/vendor/@fortawesome/fontawesome-free/css/all.min.css',
            'resources/css/argon.css',
           'resources/vendor/jquery/dist/jquery.min.js',
           'resources/vendor/bootstrap/dist/js/bootstrap.bundle.min.js',
           'resources/vendor/js-cookie/js.cookie.js',
           'resources/vendor/jquery.scrollbar/jquery.scrollbar.min.js',
           'resources/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js',
           'resources/vendor/chart.js/dist/Chart.min.js',
           'resources/vendor/chart.js/dist/Chart.extension.js',
           'resources/js/argon.js',
        ],
            refresh: true,
        }),
    ],
});
