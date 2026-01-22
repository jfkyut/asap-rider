<script setup>

import { ref } from 'vue';
import { TabList, Tab, Tabs, Button } from 'primevue';
import { router } from '@inertiajs/vue3';
import SettingsDropdown from './auth-layout-partials/SettingsDropdown.vue';

const items = [
    {
        label: 'Home',
        icon: 'ri-home-6-line',
        route: '/',
    },
    {
        label: 'Transactions',
        icon: 'ri-exchange-box-line',
        route: '/transactions',
    },
    // {
    //     label: 'Cart',
    //     icon: 'ri-shopping-cart-line',
    //     route: '/cart',
    // },
    {
        label: 'Inbox',
        icon: 'ri-inbox-line',
        route: '/inbox',
    },
    // {
    //     label: 'Profile',
    //     icon: 'ri-user-line',
    //     route: '/profile',
    // },
];

// current path to keep the active tab in sync
const current = ref(window.location.pathname);

function onTabChange(val) {
    if (val && val !== window.location.pathname) {
        router.visit(val);
    }
}

const back = () => {
    window.history.back();
};

</script>

<template>
    <div :class="!route().current().includes('dashboard') ? 'pt-16' : ''" class="bg-zinc-50 dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 min-h-screen pb-24 p-2 select-none text-xs">
        <!-- header -->
        <div v-if="!route().current().includes('dashboard')" class="bg-teal-600 text-white px-2 py-1 flex items-center justify-between shadow-sm fixed top-0 left-0 right-0 z-30">
            <div>
                <Button 
                    @click="back" 
                    severity="secondary"
                    variant="text"
                >
                    <i class="ri-arrow-left-s-line text-white"></i>
                </Button>
            </div>
            <header class="w-full text-center font-semibold">
                <div class="absolute left-1/2 -translate-x-1/2 top-1/2 -translate-y-1/2 uppercase">
                    <slot name="header"></slot>
                </div>
            </header>
        </div>

        <slot />

        <!-- Mobile-first bottom tab bar (visible on small screens only) -->
        <nav class="fixed bottom-0 left-0 right-0 z-40 bg-white dark:bg-zinc-800 border-t dark:border-zinc-700" role="navigation" aria-label="Mobile tabs navigation">
            <div class="mx-auto">
                <Tabs v-model:value="current" variant="scrollable" class="w-full" @update:value="onTabChange">
                    <TabList class="flex w-full">
                        <Tab v-for="tab in items" :key="tab.label" :value="tab.route" class="flex-1">
                            <div class="w-full flex flex-col items-center justify-center">
                                <i :class="tab.icon"></i>
                                <span class="text-xs mt-1">{{ tab.label }}</span>
                            </div>
                        </Tab>
                        <SettingsDropdown />
                    </TabList>
                </Tabs>
            </div>
        </nav>
    </div>
</template>