import motion from "tailwindcss-motion";
import animate from "tailwindcss-animate";


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
  plugins: [motion, animate],
}
