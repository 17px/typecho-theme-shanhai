const plugin = require('tailwindcss/plugin');

module.exports = {
  darkMode: "class",
  content: [
    './src/**/*.{ts,php}', // 根据你的项目结构调整路径
    "./node_modules/flowbite/**/*.js"
  ],
  theme: {
    extend: {
      fontSize: {
        base: '14px', // 默认字体大小
        lg: '16px',
        xl: '28px',
      },
      fontFamily: {
        sans: ['Helvetica', 'Arial', 'sans-serif'], // 默认字体
        serif: ['Georgia', 'serif'],
        mono: ['Courier New', 'monospace'],
      },
      fontWeight: {
        300: 300,
        500: 500,
        700: 700,
      },
      colors: {
        line: 'rgba(0,0,0,1)',
        line2: 'rgba(0,0,0,.3)'
      },
    },
  },
  plugins: [
    require('flowbite/plugin'),
    plugin(({ addBase, theme }) => {
      addBase({
        ':root': {
          '--color-line': theme('colors.line'),
          '--color-line-2': theme('colors.line2'),
        },
      });
    }),
  ],
};