/**
 * Global asset configuration and utilities
 * Provides consistent asset URL generation across the application
 */

// Asset configuration
export const ASSET_CONFIG = {
    // Base paths for different environments
    DEV_BASE_PATH: '/',
    PROD_BASE_PATH: '/growedge/',
    
    // Asset directories
    VENDOR_ASSETS: 'assets/vendor_assets',
    THEME_ASSETS: 'assets/theme_assets',
    IMAGES: 'img',
    FONTS: 'assets/vendor_assets/fonts',
} as const;

/**
 * Get the base URL for assets based on environment
 */
export function getBaseUrl(): string {
    if (import.meta.env.DEV) {
        return ASSET_CONFIG.DEV_BASE_PATH;
    }
    
    // Check for custom asset URL from environment
    if (import.meta.env.ASSET_URL) {
        return import.meta.env.ASSET_URL + '/';
    }
    
    return ASSET_CONFIG.PROD_BASE_PATH;
}

/**
 * Generate asset URL with proper base path
 * @param path - Asset path relative to public directory
 * @returns Complete asset URL
 */
export function generateAssetUrl(path: string): string {
    // Remove leading slash if present
    const cleanPath = path.startsWith('/') ? path.slice(1) : path;
    
    // Check if it's already a complete URL
    if (cleanPath.startsWith('http://') || cleanPath.startsWith('https://')) {
        return cleanPath;
    }
    
    // Check if it's a Vite-processed asset (contains hash)
    if (cleanPath.includes('assets/') && cleanPath.includes('-')) {
        return `${getBaseUrl()}${cleanPath}`;
    }
    
    // For static assets
    return `${getBaseUrl()}${cleanPath}`;
}

/**
 * Asset URL generators for different asset types
 */
export const assets = {
    /**
     * Get image URL
     */
    image: (path: string) => generateAssetUrl(path),
    
    /**
     * Get vendor asset URL
     */
    vendor: (path: string) => generateAssetUrl(`${ASSET_CONFIG.VENDOR_ASSETS}/${path}`),
    
    /**
     * Get theme asset URL
     */
    theme: (path: string) => generateAssetUrl(`${ASSET_CONFIG.THEME_ASSETS}/${path}`),
    
    /**
     * Get CSS URL
     */
    css: (path: string) => generateAssetUrl(path),
    
    /**
     * Get JavaScript URL
     */
    js: (path: string) => generateAssetUrl(path),
    
    /**
     * Get font URL
     */
    font: (path: string) => generateAssetUrl(`${ASSET_CONFIG.FONTS}/${path}`),
} as const;

/**
 * Predefined asset paths for common assets
 */
export const commonAssets = {
    // Logos
    logo: {
        dark: 'logo_dark.png',
        white: 'logo_white.png',
        main: 'logo4.png',
    },
    
    // Icons
    icons: {
        bars: 'img/svg/bars.svg',
        flag: 'img/flag.png',
        eng: 'img/eng.png',
        ger: 'img/ger.png',
        spa: 'img/spa.png',
        tur: 'img/tur.png',
    },
    
    // Illustrations
    illustrations: {
        signup: 'img/svg/signupIllustration.svg',
    },
} as const;

/**
 * Get common asset URL
 * @param category - Asset category (logo, icons, illustrations)
 * @param name - Asset name
 * @returns Asset URL
 */
export function getCommonAsset(category: keyof typeof commonAssets, name: string): string {
    const assetPath = (commonAssets[category] as any)[name];
    if (!assetPath) {
        console.warn(`Asset not found: ${category}.${name}`);
        return '';
    }
    return generateAssetUrl(assetPath);
}
