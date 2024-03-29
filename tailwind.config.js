const defaultTheme = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors') 

module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        "./node_modules/flowbite/**/*.js"
    ],
    darkMode: 'class',
    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            colors: { 
                danger: colors.rose,
                primary: colors.cyan,
                success: colors.green,
                warning: colors.yellow,
            },
        },
    },

    variants: {
        extend: {
            opacity: ['disabled'],

        },
    },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography'),require('flowbite/plugin')],
};
