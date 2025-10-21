<script setup lang="ts">
import StrikingDashNavbar from '@/components/StrikingDashNavbar.vue';
import StrikingDashSidebar from '@/components/StrikingDashSidebar.vue';
</script>

<template>
    <div class="layout-light side-menu overlayScroll">
        <!-- Mobile Search -->
        <div class="mobile-search">
            <form action="#" class="search-form">
                <span data-feather="search"></span>
                <input class="form-control me-sm-2 box-shadow-none" type="text" placeholder="Search...">
            </form>
        </div>
        <!-- Mobile Search End -->

        <!-- Mobile Author actions -->
        <div class="mobile-author-actions"></div>
        <!-- Mobile Author actions End -->

        <StrikingDashNavbar />
        <StrikingDashSidebar />
        
        <main class="main-content">
            <slot />
        </main>
    </div>
</template>

<style>
/* Layout specific styles will be handled by the main CSS */
</style>
