const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Encode Sans', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'arg-azul': '#232D4F',
                'arg-secundario': '#3E5A7E',
                'arg-amarillo': '#E7BA61',
                'arg-verde': '#2E7D33',
                'arg-rojo': '#C62828',
                'arg-info': '#5A7290',
            },
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
