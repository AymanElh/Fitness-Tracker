import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', 'sans-serif'],
            },
            fontSize: {
                'xs': ['0.75rem', {lineHeight: '1rem'}],
                'sm': ['0.875rem', {lineHeight: '1.25rem'}],
                'base': ['1rem', {lineHeight: '1.5rem'}],
                'lg': ['1.125rem', {lineHeight: '1.75rem'}],
                'xl': ['1.25rem', {lineHeight: '1.75rem'}],
                '2xl': ['1.5rem', {lineHeight: '2rem'}],
                '3xl': ['1.875rem', {lineHeight: '2.25rem'}],
            },
        }
    },
    plugins: [],
};
