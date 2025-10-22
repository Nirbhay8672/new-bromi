<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

defineProps<{
    isCollapsed: boolean;
}>();

const mainMenuItems = [
    {
        title: 'Dashboard',
        icon: 'home',
        active: true,
        href: '/dashboard'
    },
    {
        title: 'Users List',
        icon: 'users',
        href: '/admin/users'
    }
];

const applicationItems = [
    {
        title: 'Email',
        icon: 'mail',
        href: '/email'
    },
    {
        title: 'Chat',
        icon: 'message-square',
        href: '/chat'
    },
    {
        title: 'Calendar',
        icon: 'calendar',
        href: '/calendar'
    },
    {
        title: 'File Manager',
        icon: 'file',
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
                            <span :data-feather="item.icon" class="nav-icon"></span>
                            <span class="menu-text">{{ item.title }}</span>
                        </Link>
                    </li>
                </ul>
            </div>
        </div>
    </aside>
</template>

<style>
/* Sidebar specific styles will be handled by the main CSS */
</style>
