// @filename tailwind.config.js
/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
    './resources/**/*.ts',
    './resources/**/*.jsx',
    './resources/**/*.tsx',
  ],
  theme: {
    extend: {},
  },
  plugins: [
    require('tailwindcss-animate'), // 👈 register here
  ],
}
