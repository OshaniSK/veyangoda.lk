import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },

            // ── Brand Color Palette ─────────────────────────────────────────
            colors: {
                primary: '#00A651',     // Teal Green (Veyangoda.lk Brand Color)
                secondary: '#F3F4F6',   // Light Gray for backgrounds
                dark: '#1F2937',        // Dark text / Footer
                brand: {
                    violet: '#6C2BD9',
                    blue: '#2563EB',
                    teal: '#06B6D4',
                    light: '#3B82F6',
                    pink: '#F472B6',
                },
                
                // Keep surface/ink definitions for backward compatibility if needed, 
                // but we will mainly use tailwind defaults and the new brand colors
                surface: {
                    page: '#F9FAFB',
                    card: '#FFFFFF',
                },
                ink: {
                    primary: '#111827',
                    secondary: '#4B5563',
                }
            },
            
            boxShadow: {
                'card': '0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24)',
                'card-hover': '0 4px 6px rgba(0,0,0,0.1), 0 2px 4px rgba(0,0,0,0.06)',
                'brand-sm': '0 4px 14px rgba(108, 43, 217, 0.35)',
                'brand-md': '0 8px 24px rgba(108, 43, 217, 0.45)',
            },

            backgroundImage: {
                'grad-primary': 'linear-gradient(135deg, #6C2BD9 0%, #2563EB 55%, #06B6D4 100%)',
                'grad-cta': 'linear-gradient(135deg, #6C2BD9 0%, #2563EB 100%)',
                'grad-warm': 'linear-gradient(135deg, #D97706 0%, #F59E0B 100%)',
                'grad-secondary': 'linear-gradient(135deg, #3B82F6 0%, #F472B6 100%)',
            }
        },
    },

    plugins: [forms],
};
