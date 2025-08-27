import {
    defineConfig
} from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
        require("tailwindcss-animate")
    ],
    server: {
        host: '0.0.0.0',
        port: 5000,
        cors: true,
        watch: {
            usePolling: true,
            interval: 1000,
        },
    },
});
