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
                sans: ['Poppins', 'sans-serif'],
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
            colors: {
                'primary-dark': '#0f172a',
                'secondary-dark': '#1e293b',
                'accent-blue': '#3b82f6',
                'accent-purple': '#8b5cf6',
            },
            animation: {
                'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
            },
        }
    },
    plugins: [],
};
