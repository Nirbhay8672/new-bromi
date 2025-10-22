<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { onMounted, nextTick, watch } from 'vue';

const props = defineProps<{
    isCollapsed: boolean;
}>();

// Initialize Feather icons
const initializeIcons = () => {
    nextTick(() => {
        if (typeof feather !== 'undefined') {
            feather.replace();
        }
    });
};

onMounted(() => {
    initializeIcons();
});

// Reinitialize icons when sidebar state changes
watch(() => props.isCollapsed, () => {
    initializeIcons();
});

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
