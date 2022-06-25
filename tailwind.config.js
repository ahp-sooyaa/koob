const defaultTheme = require('tailwindcss/defaultTheme')

module.exports = {
    purge: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
                inter: ['Inter']
            },
            minHeight: {
                '96': '24rem',
            },
            minWidth: {
                '40':'10rem',
            },
            backgroundImage: {
                'hero-image': 'url("/images/hero_image.jpg")',
            },
            width: {
                '69': '4.3125rem'
            }
        },
    },

    variants: {
        extend: {
            opacity: ['disabled'],
        },
    },

    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/line-clamp')
    ],
}
