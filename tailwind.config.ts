import type { Config } from 'tailwindcss';

export default {
  content: ['resources/js/**/*.{ts,tsx}', 'resources/css/**/*.css'],
  theme: {
    extend: {},
  },
  plugins: [],
} satisfies Config;
