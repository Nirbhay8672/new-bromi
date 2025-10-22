/**
 * Asset management composable for proper asset loading
 * Handles both development and production environments
 */

export function useAssets() {
    /**
     * Get the correct asset URL for any asset
     * @param path - The asset path relative to public directory
     * @returns The correct asset URL
     */
    const getAssetUrl = (path: string): string => {
        // Remove leading slash if present
        const cleanPath = path.startsWith('/') ? path.slice(1) : path;
        
        // Check if it's a Vite-processed asset (has hash in name)
        if (cleanPath.includes('assets/') && cleanPath.includes('-')) {
            // This is a Vite-processed asset, use the base URL
            const basePath = import.meta.env.BASE_URL || '/';
            return `${basePath}${cleanPath}`;
        }
        
        // For static assets in public directory
        if (import.meta.env.DEV) {
            return `/${cleanPath}`;
        }
        
        // In production, use the configured base path
        const basePath = import.meta.env.BASE_URL || '/growedge/';
        return `${basePath}${cleanPath}`;
    };

    /**
     * Get image asset URL
     * @param path - Image path relative to public directory
     * @returns The correct image URL
     */
    const getImageUrl = (path: string): string => {
        return getAssetUrl(path);
    };

    /**
     * Get CSS asset URL
     * @param path - CSS path relative to public directory
     * @returns The correct CSS URL
     */
    const getCssUrl = (path: string): string => {
        return getAssetUrl(path);
    };

    /**
     * Get JavaScript asset URL
     * @param path - JS path relative to public directory
     * @returns The correct JS URL
     */
    const getJsUrl = (path: string): string => {
        return getAssetUrl(path);
    };

    /**
     * Get vendor asset URL (for assets in public/assets/vendor_assets/)
     * @param path - Asset path relative to vendor_assets directory
     * @returns The correct vendor asset URL
     */
    const getVendorAssetUrl = (path: string): string => {
        const cleanPath = path.startsWith('/') ? path.slice(1) : path;
        return getAssetUrl(`assets/vendor_assets/${cleanPath}`);
    };

    /**
     * Get theme asset URL (for assets in public/assets/theme_assets/)
     * @param path - Asset path relative to theme_assets directory
     * @returns The correct theme asset URL
     */
    const getThemeAssetUrl = (path: string): string => {
        const cleanPath = path.startsWith('/') ? path.slice(1) : path;
        return getAssetUrl(`assets/theme_assets/${cleanPath}`);
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
