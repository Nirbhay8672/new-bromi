<script setup lang="ts">
import { ref } from 'vue';
import StrikingDashNavbar from '@/components/StrikingDashNavbar.vue';
import StrikingDashSidebar from '@/components/StrikingDashSidebar.vue';

const isSidebarCollapsed = ref(false);

const toggleSidebar = () => {
    isSidebarCollapsed.value = !isSidebarCollapsed.value;
};
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

        <StrikingDashNavbar :toggle-sidebar="toggleSidebar" />
        <StrikingDashSidebar :is-collapsed="isSidebarCollapsed" />
        
        <main class="main-content">
            <div class="contents" :class="{ 'expanded': isSidebarCollapsed }">
                <slot />
            </div>
        </main>
    </div>
</template>

<style>
/* Layout specific styles will be handled by the main CSS */
</style>
