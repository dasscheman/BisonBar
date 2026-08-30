import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import fs from 'fs';
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/scss/app.scss',
                'resources/scss/soft-ui-dashboard.scss',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            'bootstrap': path.resolve(__dirname, 'node_modules/bootstrap'),
            // 'Chart': path.resolve(__dirname, 'node_modules/chart.js'),
        }
    },
    server: {
        https: {
            key: fs.readFileSync('docker/certificates/apache/docker.dev.key'),
            cert: fs.readFileSync('docker/certificates/apache/docker.dev.crt'),
        },
        host: true,
        port: 7060,
        hmr: {
            host: 'bisonbar.docker.dev',
            protocol: 'wss'
        },
    },
});
