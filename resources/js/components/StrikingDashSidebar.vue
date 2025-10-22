<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { onMounted, nextTick, watch } from 'vue';

const props = defineProps<{
    isCollapsed: boolean;
}>();

// No need to initialize icons - using Font Awesome classes directly

const mainMenuItems = [
    {
        title: 'Dashboard',
        icon: 'fas fa-home',
        active: true,
        href: '/dashboard'
    },
    {
        title: 'Users List',
        icon: 'fas fa-users',
        href: '/admin/users'
    },
    {
        title: 'Roles & Permissions',
        icon: 'fas fa-shield-alt',
        href: '/admin/roles'
    }
];

const applicationItems = [
    {
        title: 'Email',
        icon: 'fas fa-envelope',
        href: '/email'
    },
    {
        title: 'Chat',
        icon: 'fas fa-comments',
        href: '/chat'
    },
    {
        title: 'Calendar',
        icon: 'fas fa-calendar',
        href: '/calendar'
    },
    {
        title: 'File Manager',
        icon: 'fas fa-folder',
        href: '/file-manager'
    }
];
</script>

<template>
    <aside class="sidebar-wrapper">
        <div class="sidebar" :class="{ 'sidebar-collapse': !isCollapsed, 'collapsed': isCollapsed }" id="sidebar">
            <div class="sidebar__menu-group">
                <ul class="sidebar_nav">
                    <li class="menu-title">
                        <span>Main menu</span>
                    </li>
                    
                    <li 
                        v-for="item in mainMenuItems" 
                        :key="item.title"
                        :class="{ 
                            'active': item.active 
                        }"
                    >
                        <Link 
                            :href="item.href" 
                            :class="{ 'active': item.active }"
                        >
                            <i :class="item.icon" class="nav-icon"></i>
                            <span class="menu-text">{{ item.title }}</span>
                        </Link>
                    </li>
                </ul>
            </div>
        </div>
    </aside>
</template>

<style scoped>
/* Ensure sidebar icons are visible */
.sidebar_nav .nav-icon {
    width: 20px;
    height: 20px;
    display: inline-block;
    vertical-align: middle;
    margin-right: 10px;
}

.sidebar_nav a {
    display: flex;
    align-items: center;
    padding: 12px 20px;
    color: #6c757d;
    text-decoration: none;
    transition: all 0.3s ease;
}

.sidebar_nav a:hover,
.sidebar_nav a.active {
    color: #007bff;
    background-color: rgba(0, 123, 255, 0.1);
}

.sidebar_nav .menu-text {
    font-weight: 500;
}

/* Ensure icons are visible in collapsed state */
.sidebar.collapsed .nav-icon {
    margin-right: 0;
    margin: 0 auto;
}

.sidebar.collapsed .menu-text {
    display: none;
}
</style>
