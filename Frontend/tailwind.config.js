/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./index.html",
    "./src/**/*.{vue,js,ts,jsx,tsx}",
  ], 
  theme: {
    extend: {
      colors:{
        primary:'#202225',
        secundary:'#5865f2'
      }
    },
  },
  plugins: [],
}

