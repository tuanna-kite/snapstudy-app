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
                'sm': '560px'
            },
            colors: {
                'primary.main': '#032482',
                'primary.light': '#E3E7F4',
                'primary.lighter': '#F5F6FA',

                // Text Color
                'text.light.primary': '#212B36',
                'text.light.secondary': '#637381',
                'text.light.disabled': '#919EAB'
            },
        },
    },
    plugins: [],
}

