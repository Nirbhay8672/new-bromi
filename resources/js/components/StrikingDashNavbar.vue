<script setup lang="ts">
import { ref } from 'vue';
import { Link, router, usePage } from '@inertiajs/vue3';
import { logout } from '@/routes';
import { assets, getCommonAsset } from '@/lib/assets';

defineProps<{
    toggleSidebar: () => void;
}>();

const page = usePage();
const user = page.props.auth.user;

// Function to get user initials
const getInitials = (name: string) => {
    if (!name) return 'U';
    return name
        .split(' ')
        .map(word => word.charAt(0))
        .join('')
        .toUpperCase()
        .slice(0, 2);
};

const isSearchOpen = ref(false);
const isProfileOpen = ref(false);
const isNotificationOpen = ref(false);
const isLanguageOpen = ref(false);
const searchQuery = ref('');

const toggleSearch = () => {
    isSearchOpen.value = !isSearchOpen.value;
};

const toggleProfile = () => {
    isProfileOpen.value = !isProfileOpen.value;
};

const toggleNotification = () => {
    isNotificationOpen.value = !isNotificationOpen.value;
};

const toggleLanguage = () => {
    isLanguageOpen.value = !isLanguageOpen.value;
};

const handleLogout = () => {
    router.post(logout.url());
};
</script>

<template>
    <header class="header-top">
        <nav class="navbar navbar-light">
            <div class="navbar-left">
                <a href="javascript:;" class="sidebar-toggle" @click="toggleSidebar">
                    <img class="svg" :src="getCommonAsset('icons', 'bars')" alt="img">
                </a>
                <a class="navbar-brand" href="#">
                    <img class="dark" :src="getCommonAsset('logo', 'main')" alt="svg">
                </a>
                <form action="#" class="search-form">
                    <span data-feather="search"></span>
                    <input 
                        class="form-control me-sm-2 box-shadow-none" 
                        type="text" 
                        placeholder="Search..."
                        v-model="searchQuery"
                    >
                </form>
                <div class="top-menu">
                    <div class="strikingDash-top-menu position-relative">
                        <ul>
                            <li class="has-subMenu">
                                <a href="#" class="active">Dashboard</a>
                                <ul class="subMenu">
                                    <li>
                                        <Link href="/" class="active">Social Media</Link>
                                    </li>
                                    <li>
                                        <Link href="/business" class="">FineTech / Business</Link>
                                    </li>
                                    <li>
                                        <Link href="/performance" class="">Site Performance</Link>
                                    </li>
                                    <li>
                                        <Link href="/ecommerce" class="">Ecommerce</Link>
                                    </li>
                                    <li>
                                        <Link href="/crm" class="">CRM</Link>
                                    </li>
                                    <li>
                                        <Link href="/sales" class="">Sales Performance</Link>
                                    </li>
                                </ul>
                            </li>
                            <li class="has-subMenu">
                                <a href="#" class="">Layouts</a>
                                <ul class="subMenu">
                                    <li class="l_sidebar">
                                        <a href="#" data-layout="light">Light Mode</a>
                                    </li>
                                    <li class="l_sidebar">
                                        <a href="#" data-layout="dark">Dark Mode</a>
                                    </li>
                                    <li class="l_navbar">
                                        <a href="#" data-layout="top">Top Menu</a>
                                    </li>
                                    <li class="l_navbar">
                                        <a href="#" data-layout="side">Side Menu</a>
                                    </li>
                                    <li class="layout">
                                        <a href="https://demo.dashboardmarket.com/rtl">RTL</a>
                                    </li>
                                    <li class="layout">
                                        <a href="https://demo.dashboardmarket.com/ltr">LTR</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="has-subMenu">
                                <a href="#" class="">Apps</a>
                                <ul class="subMenu">
                                    <li>
                                        <Link href="/chat" class="">
                                            <span data-feather="message-square" class="nav-icon"></span>
                                            <span class="menu-text">Chat</span>
                                        </Link>
                                    </li>
                                    <li class="has-subMenu-left">
                                        <a href="#" class="">
                                            <span data-feather="shopping-cart" class="nav-icon"></span>
                                            <span class="menu-text">eCommerce</span>
                                        </a>
                                        <ul class="subMenu">
                                            <li>
                                                <Link href="/products" class="">Products</Link>
                                            </li>
                                            <li>
                                                <Link href="/product-details" class="">Product Details</Link>
                                            </li>
                                            <li>
                                                <Link href="/add-product" class="">Product Add</Link>
                                            </li>
                                            <li>
                                                <Link href="/cart" class="">Cart</Link>
                                            </li>
                                            <li>
                                                <Link href="/orders" class="">Orders</Link>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="navbar-right">
                <ul class="navbar-right__menu">
                    <li class="nav-item nav-item--search">
                        <a href="javascript:;" class="nav-item-toggle" @click="toggleSearch">
                            <span data-feather="search"></span>
                        </a>
                    </li>
                    <li class="nav-item nav-item--notification">
                        <div class="dropdown-custom">
                            <a href="javascript:;" class="nav-item-toggle" @click="toggleNotification">
                                <span data-feather="bell"></span>
                                <span class="badge badge-primary">9</span>
                            </a>
                            <div class="dropdown-wrapper dropdown-wrapper--large" v-show="isNotificationOpen">
                                <div class="nav-author__info">
                                    <h6>Notifications</h6>
                                </div>
                                <div class="list-group">
                                    <span>Content Planner</span>
                                    <ul>
                                        <li>
                                            <a href="">How to customize admin</a>
                                        </li>
                                        <li>
                                            <a href="">How to use</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="nav-flag-select">
                        <div class="dropdown-custom">
                            <a href="javascript:;" class="nav-item-toggle" @click="toggleLanguage">
                                <img :src="getCommonAsset('icons', 'flag')" alt="" class="rounded-circle">
                            </a>
                            <div class="dropdown-wrapper dropdown-wrapper--small" v-show="isLanguageOpen">
                                <a href=""><img :src="getCommonAsset('icons', 'eng')" alt=""> English</a>
                                <a href=""><img :src="getCommonAsset('icons', 'ger')" alt=""> German</a>
                                <a href=""><img :src="getCommonAsset('icons', 'spa')" alt=""> Spanish</a>
                                <a href=""><img :src="getCommonAsset('icons', 'tur')" alt=""> Turkish</a>
                            </div>
                        </div>
                    </li>
                    <li class="nav-author">
                        <div class="dropdown-custom">
                            <a href="javascript:;" class="nav-item-toggle" @click="toggleProfile">
                                <div v-if="user?.profile_photo_url" class="profile-image">
                                    <img :src="user.profile_photo_url" :alt="user.name" class="rounded-circle">
                                </div>
                                <div v-else class="profile-initials rounded-circle d-flex align-items-center justify-content-center">
                                    {{ getInitials(user?.name || 'User') }}
                                </div>
                            </a>
                            <div class="dropdown-wrapper" v-show="isProfileOpen">
                                <div class="nav-author__info">
                                    <div class="author-img">
                                        <div v-if="user?.profile_photo_url" class="profile-image">
                                            <img :src="user.profile_photo_url" :alt="user.name" class="rounded-circle">
                                        </div>
                                        <div v-else class="profile-initials rounded-circle d-flex align-items-center justify-content-center">
                                            {{ getInitials(user?.name || 'User') }}
                                        </div>
                                    </div>
                                    <div>
                                        <h6>{{ user?.name || 'User' }}</h6>
                                        <span>{{ user?.email || 'No Email' }}</span>
                                    </div>
                                </div>
                                <div class="nav-author__options">
                                    <ul>
                                        <li>
                                            <Link href="/settings/profile">
                                                <span data-feather="user"></span> Profile
                                            </Link>
                                        </li>
                                        <li>
                                            <Link href="/settings/password">
                                                <span data-feather="lock"></span> Password
                                            </Link>
                                        </li>
                                        <li>
                                            <Link href="/settings/two-factor">
                                                <span data-feather="shield"></span> Two-Factor Auth
                                            </Link>
                                        </li>
                                    </ul>
                                    <button @click="handleLogout" class="nav-author__signout">
                                        <span data-feather="log-out"></span> Sign Out
                                    </button>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
                <div class="navbar-right__mobileAction d-md-none">
                    <a href="#" class="btn-search" @click="toggleSearch">
                        <span data-feather="search"></span>
                        <span data-feather="x"></span>
                    </a>
                    <a href="#" class="btn-author-action">
                        <span data-feather="more-vertical"></span>
                    </a>
                </div>
            </div>
        </nav>
    </header>
</template>

<style>
/* Navbar specific styles will be handled by the main CSS */
</style>
