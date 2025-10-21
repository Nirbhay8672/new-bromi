<script setup lang="ts">
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';

const isCollapsed = ref(false);

const toggleSidebar = () => {
    isCollapsed.value = !isCollapsed.value;
};

const mainMenuItems = [
    {
        title: 'Dashboard',
        icon: 'home',
        active: true,
        hasChild: true,
        open: true,
        children: [
            { title: 'Social Media', href: '/', active: true },
            { title: 'FineTech / Business', href: '/business' },
            { title: 'Site Performance', href: '/performance' },
            { title: 'Ecommerce', href: '/ecommerce' },
            { title: 'CRM', href: '/crm' },
            { title: 'Sales Performance', href: '/sales' }
        ]
    },
    {
        title: 'Layouts',
        icon: 'layout',
        hasChild: true,
        children: [
            { title: 'Light Mode', href: '#', dataLayout: 'light' },
            { title: 'Dark Mode', href: '#', dataLayout: 'dark' },
            { title: 'Top Menu', href: '#', dataLayout: 'top' },
            { title: 'Side Menu', href: '#', dataLayout: 'side' },
            { title: 'RTL', href: 'https://demo.dashboardmarket.com/rtl' },
            { title: 'LTR', href: 'https://demo.dashboardmarket.com/ltr' }
        ]
    },
    {
        title: 'Changelog',
        icon: 'activity',
        href: '/changelog',
        badge: '2.1.6',
        badgeType: 'primary'
    }
];

const applicationItems = [
    {
        title: 'Email',
        icon: 'mail',
        hasChild: true,
        children: [
            { title: 'Inbox', href: '/inbox' },
            { title: 'Read Email', href: '/read-email' }
        ]
    },
    {
        title: 'Chat',
        icon: 'message-square',
        href: '/chat'
    },
    {
        title: 'eCommerce',
        icon: 'shopping-cart',
        hasChild: true,
        children: [
            { title: 'Products', href: '/products' },
            { title: 'Product Details', href: '/product-details' },
            { title: 'Product Add', href: '/add-product' },
            { title: 'Product Edit', href: '/edit-product' },
            { title: 'Cart', href: '/cart' },
            { title: 'Orders', href: '/orders' },
            { title: 'Sellers', href: '/sellers' },
            { title: 'Invoices', href: '/invoices' }
        ]
    },
    {
        title: 'Social App',
        icon: 'aperture',
        hasChild: true,
        children: [
            { title: 'My Profile', href: '/profile' },
            { title: 'Profile Settings', href: '/profile-setting', badge: 'New', badgeType: 'success' },
            { title: 'Timeline', href: '/profile#timeline' },
            { title: 'Activity', href: '/profile#activity' }
        ]
    },
    {
        title: 'Project',
        icon: 'target',
        hasChild: true,
        children: [
            { title: 'Project', href: '/projects' },
            { title: 'Project Details', href: '/application-ui' },
            { title: 'Create Project', href: '/create' }
        ]
    },
    {
        title: 'Calendar',
        icon: 'calendar',
        href: '/calendar'
    },
    {
        title: 'Users',
        icon: 'folder',
        hasChild: true,
        children: [
            { title: 'Team', href: '/users-membar' },
            { title: 'Users Grid', href: '/users-card' },
            { title: 'Users List', href: '/users-list' },
            { title: 'Users Grid style', href: '/users-card2' },
            { title: 'Users Group', href: '/users-group' },
            { title: 'Add User', href: '/user-info', badge: 'New', badgeType: 'success' },
            { title: 'Users Table', href: '/users-datatable' }
        ]
    },
    {
        title: 'Contact',
        icon: 'user-check',
        hasChild: true,
        children: [
            { title: 'Contact Grid', href: '/contact-2' },
            { title: 'Contact List', href: '/contact-1' },
            { title: 'Contact Create', href: '/contact-3' }
        ]
    },
    {
        title: 'Note',
        icon: 'file-text',
        href: '/note'
    },
    {
        title: 'To-Do',
        icon: 'check-square',
        href: '/to-do'
    },
    {
        title: 'Kanban Board',
        icon: 'columns',
        href: 'https://demo.dashboardmarket.com/strikingdash-html/kanban.html',
        badge: 'New',
        badgeType: 'success'
    },
    {
        title: 'Import & Export',
        icon: 'repeat',
        hasChild: true,
        badge: 'New',
        badgeType: 'success',
        children: [
            { title: 'Import', href: '/import' },
            { title: 'Export', href: '/export' },
            { title: 'Export Selected', href: '/export-selected' }
        ]
    },
    {
        title: 'File Manager',
        icon: 'file',
        href: '/file-manager'
    },
    {
        title: 'Task App',
        icon: 'clipboard',
        href: '/task-app',
        badge: 'New',
        badgeType: 'success'
    }
];
</script>

<template>
    <aside class="sidebar-wrapper">
        <div class="sidebar sidebar-collapse" :class="{ 'sidebar-collapsed': isCollapsed }" id="sidebar">
            <div class="sidebar__menu-group">
                <ul class="sidebar_nav">
                    <li class="menu-title">
                        <span>Main menu</span>
                    </li>
                    
                    <li 
                        v-for="item in mainMenuItems" 
                        :key="item.title"
                        :class="{ 
                            'has-child': item.hasChild, 
                            'open': item.open,
                            'active': item.active 
                        }"
                    >
                        <a 
                            :href="item.href || '#'" 
                            :class="{ 'active': item.active }"
                            @click.prevent="item.hasChild ? null : null"
                        >
                            <span :data-feather="item.icon" class="nav-icon"></span>
                            <span class="menu-text">{{ item.title }}</span>
                            <span v-if="item.hasChild" class="toggle-icon"></span>
                            <span 
                                v-if="item.badge" 
                                :class="`badge badge-${item.badgeType || 'primary'} menuItem`"
                            >
                                {{ item.badge }}
                            </span>
                        </a>
                        
                        <ul v-if="item.hasChild && item.children">
                            <li v-for="child in item.children" :key="child.title">
                                <Link 
                                    :href="child.href" 
                                    :class="{ 'active': child.active }"
                                    :data-layout="child.dataLayout"
                                >
                                    {{ child.title }}
                                    <span 
                                        v-if="child.badge" 
                                        :class="`badge badge-${child.badgeType || 'success'} menuItem`"
                                    >
                                        {{ child.badge }}
                                    </span>
                                </Link>
                            </li>
                        </ul>
                    </li>
                    
                    <li class="menu-title m-top-30">
                        <span>Applications</span>
                    </li>
                    
                    <li 
                        v-for="item in applicationItems" 
                        :key="item.title"
                        :class="{ 
                            'has-child': item.hasChild, 
                            'open': item.open,
                            'active': item.active 
                        }"
                    >
                        <a 
                            :href="item.href || '#'" 
                            :class="{ 'active': item.active }"
                            @click.prevent="item.hasChild ? null : null"
                        >
                            <span :data-feather="item.icon" class="nav-icon"></span>
                            <span class="menu-text">{{ item.title }}</span>
                            <span v-if="item.hasChild" class="toggle-icon"></span>
                            <span 
                                v-if="item.badge" 
                                :class="`badge badge-${item.badgeType || 'success'} menuItem`"
                            >
                                {{ item.badge }}
                            </span>
                        </a>
                        
                        <ul v-if="item.hasChild && item.children">
                            <li v-for="child in item.children" :key="child.title">
                                <Link 
                                    :href="child.href" 
                                    :class="{ 'active': child.active }"
                                    :data-layout="child.dataLayout"
                                >
                                    {{ child.title }}
                                    <span 
                                        v-if="child.badge" 
                                        :class="`badge badge-${child.badgeType || 'success'} menuItem`"
                                    >
                                        {{ child.badge }}
                                    </span>
                                </Link>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </aside>
</template>

<style>
/* Sidebar specific styles will be handled by the main CSS */
</style>
