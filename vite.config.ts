import { wayfinder } from '@laravel/vite-plugin-wayfinder';
import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin';
import { defineConfig } from 'vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.ts'],
            ssr: 'resources/js/ssr.ts',
            refresh: true,
        }),
        wayfinder({
            formVariants: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    base: process.env.ASSET_URL ? process.env.ASSET_URL + '/' : (process.env.NODE_ENV === 'production' ? '/growedge/' : '/'),
    build: {
        rollupOptions: {
            output: {
                assetFileNames: 'assets/[name]-[hash][extname]',
            },
        },
    },
    server: {
        hmr: {
            host: 'localhost',
        },
    },
    // Define global constants for asset handling
    define: {
        __ASSET_URL__: JSON.stringify(process.env.ASSET_URL || (process.env.VITE_APP_ENV === 'local' ? '' : '/public')),
        __APP_URL__: JSON.stringify(process.env.APP_URL || (process.env.VITE_APP_ENV === 'local' ? 'https://new-bromi.test' : 'https://updates.mrweb.co.in/growedge')),
    },
});
