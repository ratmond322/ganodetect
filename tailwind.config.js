/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/views/**/*.blade.php",
    "./resources/js/**/*.js",
    "./resources/css/**/*.css",
    // tambahkan jika Anda pakai blade components/other folders
  ],
  theme: {
    extend: {
      colors: {
        brandOlive: "#7c8d34",      // header/footer green
        brandLight: "#1E201E",     // changed to match location section
        brandCard: "#9aa34a",
        brandCardDark: "#8f9f3f",
        darkTeal: "#0e4e4a"
      },
      fontFamily: {
        inter: ["Inter", "ui-sans-serif", "system-ui", "sans-serif"]
      }
    }
  },
  plugins: [],
}
