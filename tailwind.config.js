import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.jsx',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                azulIMTA: '#22509C',
                cafeIMTA: '#9C8372',
                blancoIMTA: '#F9F7F5',
                grisIMTA: '#D9D9D9',
                azulIMTAHover: '#112f57ff',
            },
            keyframes: {
                slideIn: {
                    'from': { 
                        transform: 'translateX(100%)',
                        opacity: '0' 
                    },
                    'to': { 
                        transform: 'translateX(0)',
                        opacity: '1'
                    },
                },
            },
            animation: {
                slideIn: 'slideIn 0.3s ease-out forwards',
            },
        },
    },

    plugins: [forms],
};
