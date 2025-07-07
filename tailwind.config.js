import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'brand-purple': '#4A5CFF',
                'brand-purple-light': '#6B73FF',
                'brand-purple-lighter': '#8B9EFF',
            },
            animation: {
                'float': 'float 6s ease-in-out infinite',
                'drift': 'drift 20s linear infinite',
                'float-card': 'floatCard 8s ease-in-out infinite',
                'float-icon': 'floatIcon 6s ease-in-out infinite',
                'grow-bar': 'growBar 2s ease-out',
            },
            keyframes: {
                float: {
                    '0%, 100%': { transform: 'translateY(0px) rotate(0deg)' },
                    '50%': { transform: 'translateY(-20px) rotate(180deg)' }
                },
                drift: {
                    '0%': { transform: 'translateX(0) translateY(0)' },
                    '100%': { transform: 'translateX(-100px) translateY(-100px)' }
                },
                floatCard: {
                    '0%, 100%': { transform: 'translateY(0px) rotate(0deg)', opacity: '0.8' },
                    '50%': { transform: 'translateY(-15px) rotate(2deg)', opacity: '1' }
                },
                floatIcon: {
                    '0%, 100%': { transform: 'translateY(0px) scale(1)' },
                    '50%': { transform: 'translateY(-10px) scale(1.1)' }
                },
                growBar: {
                    '0%': { height: '0' },
                    '100%': { height: 'var(--height)' }
                }
            }
        },
    },

    plugins: [forms],
};
