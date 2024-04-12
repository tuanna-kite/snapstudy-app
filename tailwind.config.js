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
                'sm': '640px',
                // => @media (min-width: 640px) { ... }

                'md': '768px',
                // => @media (min-width: 768px) { ... }

                'lg': '1024px',
                // => @media (min-width: 1024px) { ... }

                'xl': '1280px',
                // => @media (min-width: 1280px) { ... }

                '2xl': '1536px',
            },
            colors: {
                // Primary
                'primary.main': '#032482',
                'primary.light': '#E3E7F4',
                'primary.lighter': '#F5F6FA',


                // Secondary
                'secondary.main': '#F02D00',

                // Text Color
                'text.light.primary': '#212B36',
                'text.light.secondary': '#637381',
                'text.light.disabled': '#919EAB',
                'action.light.disabled': '#919EABCC',
                // Grey
                "light-neutral": "#F4F6F8",
                "light-gray": "#EBEDF5",
                "grey-300": "#DFE3E8",
                "grey-400": "#C4CDD5",
                // border
                'components.input.outlined': '#919EAB52',
                "border-disabled": '#919EAB3D',



            },
        },
    },
    plugins: [],
}

