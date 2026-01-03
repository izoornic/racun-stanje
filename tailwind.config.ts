import type { Config } from 'tailwindcss'

export default {
  darkMode: 'class',
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./app/Livewire/**/*.php",
  ],
} satisfies Config