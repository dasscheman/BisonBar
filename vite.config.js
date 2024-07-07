import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import fs from 'fs';
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/js/app.js',
                'resources/scss/app.scss',
                'resources/scss/soft-ui-dashboard.scss'
            ],
            refresh: true
        })
    ],
    resolve: {
        alias: {
            'bootstrap': path.resolve(__dirname, 'node_modules/bootstrap'),
            'Chart': path.resolve(__dirname, 'node_modules/chart.js'),
        }
    },
    server: {
        https: {
            key: fs.readFileSync('docker/certificates/apache/docker.dev.key'),
            cert: fs.readFileSync('docker/certificates/apache/docker.dev.crt'),
        },
        host: true,
        port: 7050,
        hmr: {
            host: 'newbar.docker.dev',
            protocol: 'wss'
        },
    },
});
