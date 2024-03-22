/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            screens: {
                'md': '900px',
                'lg': '1440px'
            },
            colors: {
                // Primary
                'primary.main': '#032482',
                'primary.light': '#E3E7F4',
                'primary.lighter': '#F5F6FA',


                // Secondary
                'secondary.main': '#C92D39',

                // Text Color
                'text.light.primary': '#212B36',
                'text.light.secondary': '#637381',
                'text.light.disabled': '#919EAB',

                // Grey
                "light-neutral": "#F4F6F8",
                "light-gray": "#EBEDF5",
                "grey-300": "#DFE3E8"
            },
        },
    },
    plugins: [],
}

