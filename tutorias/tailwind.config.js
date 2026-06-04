/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './resources/views/**/*.blade.php',
    './resources/views/**/*.php',
  ],
  darkMode: 'class',
  safelist: [
    { pattern: /^(bg|text|border|ring|from|to)-(gray|red|yellow|green|blue|indigo|purple|pink|orange|cyan|emerald|rose|amber|teal|lime|violet)-(50|100|200|300|400|500|600|700|800|900)$/ },
    { pattern: /^(bg-gradient-to-r)$/ },
    { pattern: /^(divide)-(gray)-(100|200|300|700)$/ },
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}
