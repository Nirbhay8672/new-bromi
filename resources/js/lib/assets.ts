/**
 * Laravel-style asset management utilities
 * Provides consistent asset URL generation following Laravel conventions
 */

// Global asset URL from Vite
declare const __ASSET_URL__: string;
declare const __APP_URL__: string;

/**
 * Laravel-style asset() function
 * Generates a URL for an asset using the configured asset URL
 * @param path - Asset path relative to public directory
 * @returns Complete asset URL
 */
export function asset(path: string): string {
    // Remove leading slash if present
    const cleanPath = path.startsWith('/') ? path.slice(1) : path;
    
    // Check if it's already a complete URL
    if (cleanPath.startsWith('http://') || cleanPath.startsWith('https://')) {
        return cleanPath;
    }
    
    // Get base URL and asset URL from environment with proper fallbacks
    // Check APP_ENV to determine if we should use production URLs
    const isLocal = import.meta.env.VITE_APP_ENV === 'local' || import.meta.env.DEV;
    
    const baseUrl = (typeof __APP_URL__ !== 'undefined' ? __APP_URL__ : '') || 
                   (isLocal ? 'https://new-bromi.test' : 'https://updates.mrweb.co.in');
    
    const assetUrl = (typeof __ASSET_URL__ !== 'undefined' ? __ASSET_URL__ : '') || 
                    (isLocal ? '' : '/growedge/public');
    
    // For Vite-processed assets (contain hash)
    if (cleanPath.includes('assets/') && cleanPath.includes('-')) {
        return `${baseUrl}${assetUrl}/${cleanPath}`;
    }
    
    // For static assets in public directory
    // In production, the public folder is not included in the URL
    const finalUrl = `${baseUrl}${assetUrl}/${cleanPath}`;
    
    // Debug logging in development
    if (import.meta.env.DEV) {
        console.log(`Asset URL generated: ${finalUrl}`, {
            path,
            cleanPath,
            baseUrl,
            assetUrl,
            isDev: import.meta.env.DEV
        });
    }
    
    return finalUrl;
}

/**
 * Laravel-style mix() function for Vite assets
 * @param path - Asset path relative to resources directory
 * @returns Vite-processed asset URL
 */
export function mix(path: string): string {
    // This would typically be handled by Vite's import.meta.url
    // For now, we'll use the asset function
    return asset(path);
}

/**
 * Get the base URL for assets based on environment
 * @deprecated Use asset() function instead
 */
export function getBaseUrl(): string {
    const assetUrl = __ASSET_URL__ || (import.meta.env.DEV ? '' : '/growedge');
    return assetUrl ? assetUrl + '/' : '/';
}

/**
 * Generate asset URL with proper base path
 * @deprecated Use asset() function instead
 * @param path - Asset path relative to public directory
 * @returns Complete asset URL
 */
export function generateAssetUrl(path: string): string {
    return asset(path);
}

// Asset configuration
export const ASSET_CONFIG = {
    // Asset directories
    VENDOR_ASSETS: 'assets/vendor_assets',
    THEME_ASSETS: 'assets/theme_assets',
    IMAGES: 'img',
    FONTS: 'assets/vendor_assets/fonts',
} as const;

/**
 * Asset URL generators for different asset types
 */
export const assets = {
    /**
     * Get image URL - Laravel style
     */
    image: (path: string) => asset(path),
    
    /**
     * Get vendor asset URL - Laravel style
     */
    vendor: (path: string) => asset(`${ASSET_CONFIG.VENDOR_ASSETS}/${path}`),
    
    /**
     * Get theme asset URL - Laravel style
     */
    theme: (path: string) => asset(`${ASSET_CONFIG.THEME_ASSETS}/${path}`),
    
    /**
     * Get CSS URL - Laravel style
     */
    css: (path: string) => asset(path),
    
    /**
     * Get JavaScript URL - Laravel style
     */
    js: (path: string) => asset(path),
    
    /**
     * Get font URL - Laravel style
     */
    font: (path: string) => asset(`${ASSET_CONFIG.FONTS}/${path}`),
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
 * Get common asset URL - Laravel style
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
    return asset(assetPath);
}

/**
 * Laravel-style secure_asset() function for HTTPS assets
 * @param path - Asset path relative to public directory
 * @returns Secure asset URL
 */
export function secure_asset(path: string): string {
    const url = asset(path);
    // Force HTTPS for secure assets
    return url.replace(/^http:/, 'https:');
}

/**
 * Laravel-style url() function for generating URLs
 * @param path - URL path
 * @returns Complete URL
 */
export function url(path: string = ''): string {
    const isLocal = import.meta.env.VITE_APP_ENV === 'local' || import.meta.env.DEV;
    const baseUrl = (typeof __APP_URL__ !== 'undefined' ? __APP_URL__ : '') || 
                   (isLocal ? 'https://new-bromi.test' : 'https://updates.mrweb.co.in');
    const cleanPath = path.startsWith('/') ? path.slice(1) : path;
    return cleanPath ? `${baseUrl}/${cleanPath}` : baseUrl;
}

/**
 * Test function to verify asset URL generation
 * This can be called from browser console for debugging
 */
export function testAssetUrls(): void {
    const isLocal = import.meta.env.VITE_APP_ENV === 'local' || import.meta.env.DEV;
    
    console.log('=== Asset URL Test ===');
    console.log('Environment:', import.meta.env.DEV ? 'Development' : 'Production');
    console.log('APP_ENV:', import.meta.env.VITE_APP_ENV || 'undefined');
    console.log('Is Local:', isLocal);
    console.log('Base URL:', (typeof __APP_URL__ !== 'undefined' ? __APP_URL__ : 'undefined'));
    console.log('Asset URL:', (typeof __ASSET_URL__ !== 'undefined' ? __ASSET_URL__ : 'undefined'));
    console.log('');
    console.log('Test URLs:');
    console.log('logo4.png:', asset('logo4.png'));
    console.log('logo_dark.png:', asset('logo_dark.png'));
    console.log('img/flag.png:', asset('img/flag.png'));
    console.log('Common asset logo main:', getCommonAsset('logo', 'main'));
    console.log('Common asset illustrations signup:', getCommonAsset('illustrations', 'signup'));
    console.log('');
    console.log('Expected Production URL: https://updates.mrweb.co.in/growedge/public/logo4.png');
}
