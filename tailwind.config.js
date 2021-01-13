module.exports = {


  purge: {
    mode: 'layers',
    content: [
      "./templates/**/*.html.twig",
      "./templates/*.html.twig"
    ],
  },
  darkMode: false, // or 'media' or 'class'
  theme: {
    extend: {

      fontFamily: {
        'poppins': ['Poppins', 'sans-serif'],
        'openSans': ['Open Sans', 'sans-serif'],
      },

      colors: {
        'purpleEloken': {
          '50': '#f9f7ff',
          '100': '#f3eeff',
          '200': '#e1d5ff',
          '300': '#cfbbff',
          '400': '#ac88ff',
          '500': '#8855FF',
          '600': '#7a4de6',
          '700': '#6640bf',
          '800': '#523399',
          '900': '#432a7d'
        }, 'blueEloken': {
          '50': '#f2fcff',
          '100': '#e6f8ff',
          '200': '#bfefff',
          '300': '#99e5ff',
          '400': '#4dd1ff',
          '500': '#00BDFF',
          '600': '#00aae6',
          '700': '#008ebf',
          '800': '#007199',
          '900': '#005d7d'
        }, 'greenEloken': {
          '50': '#f2fcf9',
          '100': '#e6faf3',
          '200': '#bff2e0',
          '300': '#99e9cd',
          '400': '#4dd9a8',
          '500': '#00C983',
          '600': '#00b576',
          '700': '#009762',
          '800': '#00794f',
          '900': '#006240'
        }, 'yellowEloken': {
          '50': '#fffbf2',
          '100': '#fff8e6',
          '200': '#feedbf',
          '300': '#fde399',
          '400': '#fccd4d',
          '500': '#FAB800',
          '600': '#e1a600',
          '700': '#bc8a00',
          '800': '#966e00',
          '900': '#7b5a00'
        }, 'eloken': {
          '50': '#fafafb',
          '100': '#f5f5f6',
          '200': '#e6e6e9',
          '300': '#c3c4ca',
          '400': '#afb0b8',
          '500': '#686b7a',
          '600': '#404456',
          '700': '#040921'
        }, 'redEloken': {
          '50': '#fdf3f7',
          '100': '#fbe8ef',
          '200': '#f4c4d6',
          '300': '#eea1bd',
          '400': '#e15b8c',
          '500': '#D4145A',
          '600': '#bf1251',
          '700': '#9f0f44',
          '800': '#7f0c36',
          '900': '#680a2c'
        },
      },
    },
  },

  variants: {
    extend: {
      appearance: ['hover', 'focus'],
    },
  },
  plugins: [

    require('@tailwindcss/forms'),

  ],

}
