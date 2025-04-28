/** @type {import('tailwindcss').Config} */
const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            colors: {
                primary: {
                    50: '#f0f9ff',
                    100: '#e0f2fe',
                    200: '#bae6fd',
                    300: '#7dd3fc',
                    400: '#38bdf8',
                    500: '#0ea5e9',
                    600: '#0284c7',
                    700: '#0369a1',
                },
                secondary: '#1e293b',
                light: '#f8fafc',
                'darker': '#0f1923',
                'card': '#1a1a1a',
                'accent': '#6d28d9',
                'text-primary': '#ffffff',
                'text-secondary': '#94a3b8',
            },
            fontFamily: {
                'sans': ['Inter', ...defaultTheme.fontFamily.sans],
                'display': ['Lexend', ...defaultTheme.fontFamily.sans],
                'rajdhani': ['Rajdhani', ...defaultTheme.fontFamily.sans],
                'orbitron': ['Orbitron', ...defaultTheme.fontFamily.sans],
            },
            boxShadow: {
                'modern': '0 0 15px rgba(14, 165, 233, 0.15)',
                'modern-lg': '0 0 30px rgba(14, 165, 233, 0.2)',
                'neon': '0 0 20px rgba(0, 255, 252, 0.4)',
                'neon-lg': '0 0 30px rgba(0, 255, 252, 0.4)',
                'neon-xl': '0 0 40px rgba(0, 255, 252, 0.4)',
            },
            backgroundImage: {
                'cyber-gradient': 'linear-gradient(135deg, var(--primary), #0891b2)',
                'cyber-radial': 'radial-gradient(circle at center, var(--primary) 0%, transparent 70%)',
            },
            animation: {
                'float': 'float 3s ease-in-out infinite',
                'shine': 'shine 1.5s ease-in-out infinite',
                'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                'pulse-glow': 'pulse-glow 2s cubic-bezier(0.4, 0, 0.6, 1) infinite',
            },
            keyframes: {
                float: {
                    '0%, 100%': { transform: 'translateY(0)' },
                    '50%': { transform: 'translateY(-10px)' },
                },
                shine: {
                    '0%': { backgroundPosition: '200% center' },
                    '100%': { backgroundPosition: '-200% center' },
                },
                'pulse-glow': {
                    '0%, 100%': {
                        opacity: '1',
                        boxShadow: '0 0 20px rgba(0, 255, 252, 0.4)',
                    },
                    '50%': {
                        opacity: '.5',
                        boxShadow: '0 0 40px rgba(0, 255, 252, 0.6)',
                    },
                },
            },
        },
    },
    plugins: [require('@tailwindcss/forms')],
} 