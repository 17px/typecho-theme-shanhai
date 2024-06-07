// tailwind.config.js
module.exports = {
  darkMode: "class",
  content: [
    './src/**/*.{ts,php}', // 根据你的项目结构调整路径
  ],
  theme: {
    extend: {
      colors: {
        primary: {
          light: '#6c63ff',
          DEFAULT: '#5f3dc4',
          dark: '#4a2c94',
        },
        secondary: {
          light: '#ff99c8',
          DEFAULT: '#ff66a5',
          dark: '#ff3382',
        },
      },
    },
  },
  plugins: [],
};