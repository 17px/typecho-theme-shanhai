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
        base: '15px',
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
    require('flowbite/plugin'),
    plugin(({ addBase, theme }) => {
      addBase({
        ':root': {
          '--color-line': theme('colors.line'),
          '--color-line-2': theme('colors.line2')
        },
      });
    }),
  ],
};