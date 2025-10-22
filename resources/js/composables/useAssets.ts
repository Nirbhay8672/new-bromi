/**
 * Asset management composable for proper asset loading
 * Handles both development and production environments using Laravel-style asset() function
 */

import { asset } from '@/lib/assets';

export function useAssets() {
    /**
     * Get the correct asset URL for any asset - Laravel style
     * @param path - The asset path relative to public directory
     * @returns The correct asset URL
     */
    const getAssetUrl = (path: string): string => {
        return asset(path);
    };

    /**
     * Get image asset URL - Laravel style
     * @param path - Image path relative to public directory
     * @returns The correct image URL
     */
    const getImageUrl = (path: string): string => {
        return asset(path);
    };

    /**
     * Get CSS asset URL - Laravel style
     * @param path - CSS path relative to public directory
     * @returns The correct CSS URL
     */
    const getCssUrl = (path: string): string => {
        return asset(path);
    };

    /**
     * Get JavaScript asset URL - Laravel style
     * @param path - JS path relative to public directory
     * @returns The correct JS URL
     */
    const getJsUrl = (path: string): string => {
        return asset(path);
    };

    /**
     * Get vendor asset URL - Laravel style
     * @param path - Asset path relative to vendor_assets directory
     * @returns The correct vendor asset URL
     */
    const getVendorAssetUrl = (path: string): string => {
        const cleanPath = path.startsWith('/') ? path.slice(1) : path;
        return asset(`assets/vendor_assets/${cleanPath}`);
    };

    /**
     * Get theme asset URL - Laravel style
     * @param path - Asset path relative to theme_assets directory
     * @returns The correct theme asset URL
     */
    const getThemeAssetUrl = (path: string): string => {
        const cleanPath = path.startsWith('/') ? path.slice(1) : path;
        return asset(`assets/theme_assets/${cleanPath}`);
    };

    return {
        getAssetUrl,
        getImageUrl,
        getCssUrl,
        getJsUrl,
        getVendorAssetUrl,
        getThemeAssetUrl,
    };
}
