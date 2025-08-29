import motion from "tailwindcss-motion";

export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./resources/**/*.jsx",
    "./resources/**/*.tsx",
  ],
  theme: {
    extend: {},
  },
  plugins: [motion],
}
