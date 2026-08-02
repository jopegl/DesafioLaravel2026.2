import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    400: '#00AAFF', 
                    500: '#0090DD',   
                    600: '#0077BB',   
                    900: '#101010',   
                    1100: '#0d0d0d',
                    1300: '#191919',
                }
            },
        },
    },

    plugins: [forms],
};
