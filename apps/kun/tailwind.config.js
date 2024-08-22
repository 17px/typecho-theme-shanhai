const plugin = require('tailwindcss/plugin');

module.exports = {
  darkMode: "class",
  content: [
    './src/**/*.{ts,php,css,less,js,html}', // 根据你的项目结构调整路径
    "./node_modules/flowbite/**/*.js"
  ],
  theme: {
    extend: {
      keyframes: {
        'fade-in-up': {
          '0%': {
            opacity: '0',
          },
          '100%': {
            opacity: '1',
          },
        },
      },
      animation: {
        'fade-in-up': 'fade-in-up 0.5s ease-out forwards',
      },
      colors: {
        zinc: {
          900: '#0d0e11',
          800: '#232429',
          400: '#abadba'
        }
      },
      fontSize: {
        base: '14px',
      },
      fontFamily: {
        base: ["Punctuation SC",
          "Inter",
          "ui-sans-serif",
          "system-ui",
          "PingFang SC",
          "Noto Sans CJK SC",
          "Noto Sans SC",
          "Heiti SC",
          "DengXian",
          "Microsoft YaHei",
          "sans-serif",
          "Apple Color Emoji",
          "Segoe UI Emoji",
          "Segoe UI Symbol",
          "Noto Color Emoji"]
      }
    },
  },
  plugins: [
    require('flowbite/plugin')
  ],
};