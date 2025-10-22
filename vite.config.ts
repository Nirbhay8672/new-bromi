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
                assetFileNames: (assetInfo) => {
                    const info = assetInfo.name.split('.');
                    const ext = info[info.length - 1];
                    if (/\.(png|jpe?g|gif|svg|ico|webp)$/i.test(assetInfo.name)) {
                        return `assets/images/[name]-[hash][extname]`;
                    }
                    if (/\.(css)$/i.test(assetInfo.name)) {
                        return `assets/css/[name]-[hash][extname]`;
                    }
                    if (/\.(js)$/i.test(assetInfo.name)) {
                        return `assets/js/[name]-[hash][extname]`;
                    }
                    return `assets/[name]-[hash][extname]`;
                },
            },
        },
    },
    server: {
        hmr: {
            host: 'localhost',
        },
    },
});
