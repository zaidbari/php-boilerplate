module.exports = {
  content: ["./resources/views/**/*.{html,js,twig}"],
  theme: {
    extend: {},
  },
  plugins: [ require("daisyui") ],
  daisyui: {
    themes: ["light", "corporate", ],
  },

}
