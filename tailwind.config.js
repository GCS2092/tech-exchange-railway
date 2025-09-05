// tailwind.config.js
import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',    // Pour capturer les classes dans les fichiers JS/Vue/React si utilisés
        './public/css/**/*.css',     // Pour capturer les styles custom
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            screens: {
                'xs': '475px',
                'sm': '640px',
                'md': '768px', 
                'lg': '1024px',
                'xl': '1280px',
                '2xl': '1536px',
                '3xl': '1920px',     // Pour les très grands écrans
            },
            container: {
                center: true,
                padding: {
                    DEFAULT: '1rem',
                    xs: '1rem',
                    sm: '2rem',
                    md: '2rem',
                    lg: '4rem',
                    xl: '5rem',
                    '2xl': '6rem',
                    '3xl': '8rem',
                },
            },
        },
    },
    plugins: [
        forms,
        function({ addComponents, theme }) {
            addComponents({
                '.container': {
                    width: '100%',
                    marginLeft: 'auto',
                    marginRight: 'auto',
                    paddingLeft: theme('container.padding.DEFAULT'),
                    paddingRight: theme('container.padding.DEFAULT'),
                    '@screen xs': {
                        maxWidth: '100%',
                        paddingLeft: theme('container.padding.xs'),
                        paddingRight: theme('container.padding.xs'),
                    },
                    '@screen sm': {
                        maxWidth: theme('screens.sm'),
                        paddingLeft: theme('container.padding.sm'),
                        paddingRight: theme('container.padding.sm'),
                    },
                    '@screen md': {
                        maxWidth: theme('screens.md'),
                        paddingLeft: theme('container.padding.md'),
                        paddingRight: theme('container.padding.md'),
                    },
                    '@screen lg': {
                        maxWidth: theme('screens.lg'),
                        paddingLeft: theme('container.padding.lg'),
                        paddingRight: theme('container.padding.lg'),
                    },
                    '@screen xl': {
                        maxWidth: theme('screens.xl'),
                        paddingLeft: theme('container.padding.xl'),
                        paddingRight: theme('container.padding.xl'),
                    },
                    '@screen 2xl': {
                        maxWidth: theme('screens.2xl'),
                        paddingLeft: theme('container.padding.2xl'),
                        paddingRight: theme('container.padding.2xl'),
                    },
                    '@screen 3xl': {
                        maxWidth: theme('screens.3xl'),
                        paddingLeft: theme('container.padding.3xl'),
                        paddingRight: theme('container.padding.3xl'),
                    }
                },
                // Ajout de composants utilitaires pour la responsivité
                '.responsive-grid': {
                    display: 'grid',
                    gridTemplateColumns: 'repeat(1, minmax(0, 1fr))',
                    gap: '1rem',
                    '@screen sm': {
                        gridTemplateColumns: 'repeat(2, minmax(0, 1fr))',
                    },
                    '@screen lg': {
                        gridTemplateColumns: 'repeat(3, minmax(0, 1fr))',
                    },
                    '@screen xl': {
                        gridTemplateColumns: 'repeat(4, minmax(0, 1fr))',
                    }
                },
                '.responsive-flex': {
                    display: 'flex',
                    flexDirection: 'column',
                    '@screen md': {
                        flexDirection: 'row',
                    }
                }
            });
        },
        // Plugin pour les utilitaires d'espacement dynamic
        function({ addUtilities, theme, e }) {
            const spacingUtilities = {};
            const spacings = theme('spacing');
            
            Object.keys(spacings).forEach(key => {
                spacingUtilities[`.${e(`dynamic-h-${key}`)}`] = {
                    height: spacings[key],
                    '@screen sm': {
                        height: `calc(${spacings[key]} * 1.1)`,
                    },
                    '@screen lg': {
                        height: `calc(${spacings[key]} * 1.2)`,
                    }
                };
            });
            
            addUtilities(spacingUtilities, ['responsive']);
        },
    ],
    safelist: [
        // Classes à toujours inclure dans le build même si non trouvées dans les fichiers
        'hidden', 'block', 'flex', 'grid',
        'sm:hidden', 'sm:block', 'sm:flex', 'sm:grid',
        'md:hidden', 'md:block', 'md:flex', 'md:grid',
        'lg:hidden', 'lg:block', 'lg:flex', 'lg:grid',
        'xl:hidden', 'xl:block', 'xl:flex', 'xl:grid',
    ]
};