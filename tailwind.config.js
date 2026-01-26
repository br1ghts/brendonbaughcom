/** @type {import('tailwindcss').Config} */
const typography = require('@tailwindcss/typography');

module.exports = {
  darkMode: 'class',
  content: [
    "./**/*.php",
    "./template-parts/**/*.php",
    "./inc/**/*.php"
  ],
  theme: {
    extend: {
      typography: (theme) => ({
        DEFAULT: {
          css: {
            color: theme('colors.slate.700'),
            lineHeight: '1.9',
            strong: {
              color: theme('colors.slate.900'),
            },
            a: {
              color: '#F26D3D',
              fontWeight: '600',
              transition: 'color 0.2s ease',
              '&:hover': {
                color: '#F24E29',
              },
            },
            h1: {
              color: theme('colors.slate.900'),
              fontWeight: '700',
              letterSpacing: '0.01em',
            },
            h2: {
              color: theme('colors.slate.900'),
              fontWeight: '700',
              letterSpacing: '0.015em',
              paddingBottom: theme('spacing.2'),
              borderBottom: `2px solid ${theme('colors.slate.200')}`,
              marginTop: theme('spacing.8'),
            },
            h3: {
              color: theme('colors.slate.900'),
              fontWeight: '600',
              marginTop: theme('spacing.6'),
            },
            p: {
              marginTop: theme('spacing.3'),
            },
            blockquote: {
              borderLeftColor: '#F2A25C',
              backgroundColor: '#FEF9EB',
              color: theme('colors.slate.800'),
              paddingLeft: theme('spacing.4'),
              paddingRight: theme('spacing.4'),
            },
            code: {
              backgroundColor: 'rgba(242,162,92,0.15)',
              color: theme('colors.slate.900'),
              borderRadius: theme('borderRadius.md'),
              padding: '0.1rem 0.25rem',
            },
            'ol li::marker': {
              color: '#F26D3D',
            },
            'ul li::marker': {
              color: '#F26D3D',
            },
            hr: {
              borderColor: '#F2A25C',
              opacity: '0.45',
              marginTop: theme('spacing.10'),
              marginBottom: theme('spacing.10'),
            },
          },
        },
        dark: {
          css: {
            color: theme('colors.slate.200'),
            strong: {
              color: theme('colors.slate.100'),
            },
            a: {
              color: '#F26D3D',
              fontWeight: '600',
              transition: 'color 0.2s ease',
              '&:hover': {
                color: '#F24E29',
              },
            },
            h1: {
              color: theme('colors.slate.100'),
            },
            h2: {
              color: theme('colors.slate.100'),
              borderBottomColor: theme('colors.slate.800'),
            },
            h3: {
              color: theme('colors.slate.100'),
            },
            p: {
              color: theme('colors.slate.200'),
            },
            blockquote: {
              backgroundColor: 'rgba(242,235,141,0.1)',
            },
            code: {
              backgroundColor: 'rgba(0,0,0,0.35)',
              color: theme('colors.slate.100'),
            },
            hr: {
              borderColor: theme('colors.slate.800'),
              opacity: '0.35',
            },
          },
        },
      }),
      keyframes: {
        featuredWave: {
          '0%, 100%': { transform: 'translateY(0)' },
          '50%': { transform: 'translateY(-6px)' },
        },
      },
      animation: {
        featuredWave: 'featuredWave 10s ease-in-out infinite',
      },
    },
  },
  plugins: [typography],
};
