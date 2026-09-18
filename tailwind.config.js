/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        'mauve-bark': '#5e3e32',
        'dark-coffee': '#4c3228',
        'dark-coffee-2': '#3a261f',
        'coffee-bean': '#281a15',
        'coffee-bean-2': '#160e0c',
        'pitch-black': '#0d0807',
      },
    },
  },
  plugins: [],
}
