import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
        './resources/js/**/*.js',
    ],

    darkMode: 'class',
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                accent: {
                    DEFAULT: 'var(--accent-color, #4f46e5)',
                    hover: 'var(--accent-color-hover, #4338ca)',
                    light: 'var(--accent-color-light, #e0e7ff)',
                    glow: 'var(--accent-color-glow, rgba(79, 70, 229, 0.15))',
                }
            }
        },
    },

    plugins: [forms],
};
