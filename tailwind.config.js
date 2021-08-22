module.exports = {
  purge: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
  ],
  darkMode: false, // or 'media' or 'class'
  theme: {
    extend: {
      margin:{
        'min-100': '-100%'
      },
      height:{
        '350': '350px',
        '452': '452px',
        '500': '500px'
      },
      zIndex:{
        '60': '60'
      }
    },
  },
  variants: {
    extend: {},
  },
  plugins: [],
}
