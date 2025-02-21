const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    // .js('resources/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js', 'public/js')
    // .js('resources/assets/libs/jquery/dist/jquery.min.js', 'public/js')
    // .js('resources/assets/libs/switch/js/switch.min.js', 'public/js')
    // .js('resources/assets/libs/select2/dist/js/select2.full.min.js', 'public/js')
    // .js('resources/assets/libs/custom/js/custom.js', 'public/js')
    // .js('resources/assets/libs/chart/apexcharts/apexcharts.min.js', 'public/js')
    // .js('resources/assets/libs/chart/chart.js', 'public/js')
    // .js('resources/assets/libs/datatable/datatables.min.js', 'public/js')


    // .sass('resources/sass/app.scss', 'public/css')
    // .sass('resources/sass/app.scss', 'public/css')
    // .sass('resources/assets/libs/bootstrap/dist/css/bootstrap.min.css', 'public/css')
    // .sass('resources/assets/libs/bootstrap-icons/bootstrap-icons.css', 'public/css')
    // .sass('resources/assets/libs/switch/css/switch.min.css', 'public/css')
    // .sass('resources/assets/libs/select2/dist/css/select2.min.css', 'public/css')
    // .sass('resources/assets/libs/custom/css/custom.css', 'public/css')
    // .sass('resources/assets/libs/custom/css/sass.css', 'public/css')
    // .sass('resources/assets/libs/custom/css/custom2.css', 'public/css')
    // .sass('resources/assets/libs/custom/css/layout.css', 'public/css')
    // .sass('resources/assets/libs/custom/css/responsive.css', 'public/css')
    // .sass('resources/assets/libs/chart/apexcharts/apexcharts.css', 'public/css')
    // .sass('resources/assets/libs/datatable/datatables.min.css', 'public/css')
    // .sass('resources/assets/css/custom-bootstrap.css', 'public/css')






    .sourceMaps();


    // mix.styles([
    //     'resources/css/style1.css',
    //     'resources/css/style2.css',
    //     'resources/css/style3.css'
    // ], 'public/css/app.css');
    
    // // Combine all JS files into one
    // mix.scripts([
    //     'resources/js/script1.js',
    //     'resources/js/script2.js',
    //     'resources/js/script3.js'
    // ], 'public/js/app.js');
//     <link rel="stylesheet" href="{{ mix('css/app.css') }}">
// <script src="{{ mix('js/app.js') }}" defer></script>





// This is for vite 

// npm install --save-dev vite laravel-vite-plugin

// import { defineConfig } from 'vite';
// import laravel from 'laravel-vite-plugin';

// export default defineConfig({
//   plugins: [
//     laravel({
//       input: [
//         'resources/css/style1.css',
//         'resources/css/style2.css',
//         'resources/js/script1.js',
//         'resources/js/script2.js'
//       ],
//       refresh: true, // Enables hot reload during development
//     }),
//   ],
// });

// @vite('resources/css/style1.css')
// @vite('resources/js/script1.js')
