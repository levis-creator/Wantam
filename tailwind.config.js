// tailwind.config.ts
import { defineConfig } from 'tailwindcss'

export default defineConfig({
  theme: {
    extend: {
      keyframes: {
        "slide-in-from-bottom": {
          "0%": { transform: "translateY(1rem)", opacity: "0" },
          "100%": { transform: "translateY(0)", opacity: "1" },
        },
      },
      animation: {
        "slide-in-from-bottom": "slide-in-from-bottom 0.5s ease-out",
      },
    },
  },
})
