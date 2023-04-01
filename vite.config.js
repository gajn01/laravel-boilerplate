import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

const path = require('path')

export default defineConfig({
    resolve: {
        alias: {
          '~bootstrap': path.resolve(__dirname, 'node_modules/bootstrap'),
        }
      },
    plugins: [
        laravel({
            input: ['resources/css/app.scss', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});
