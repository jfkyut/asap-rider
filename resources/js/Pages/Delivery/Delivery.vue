<script setup>

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {
    Button,
    Tag,
    Tabs,
    Tab,
    TabList,
    TabPanels,
    TabPanel
} from 'primevue';
import { Head, router } from '@inertiajs/vue3';
import { computed, toRefs, ref } from 'vue';
import DeliveryCard from './delivery-partials/DeliveryCard.vue';

const props = defineProps({
    deliveries: Object
});

const { deliveries } = toRefs(props);

const deliveryList = computed(() => {
    return deliveries.value?.data || [];
});

const tabs = [
    { label: 'All', value: 'all', status: null },
    { label: 'Active', value: 'active', status: 'active' },
    { label: 'Completed', value: 'completed', status: 'completed' },
    { label: 'Cancelled', value: 'cancelled', status: 'cancelled' }
];

// Get current status from query parameter
const currentTab = ref(route().params.status || 'all');

const handleTabChange = (tabValue) => {
    const selectedTab = tabs.find(t => t.value === tabValue);
    currentTab.value = tabValue;

    if (selectedTab.status) {
        router.get(route('delivery.index'), { status: selectedTab.status }, { preserveScroll: true });
    } else {
        router.get(route('delivery.index'), {}, { preserveScroll: true });
    }
};

</script>

<template>
    <AuthenticatedLayout :has-padding="false">
        <Head title="My Deliveries" />

        <template #header>
            <h2>My Deliveries</h2>
        </template>

        <Tabs :value="currentTab" @update:value="handleTabChange">
            <TabList>
                <Tab v-for="tab in tabs" :key="tab.value" :value="tab.value" class="flex-1">
                        {{ tab.label }}
                    </Tab>
            </TabList>
            <TabPanels>
                <TabPanel v-for="tab in tabs" :key="tab.value" :value="tab.value">
                    <div class="sm:p-6 max-w-7xl mx-auto sm:py-6">
                        <!-- Empty State -->
                        <div v-if="deliveryList.length === 0" class="text-center py-12">
                            <div class="w-16 h-16 bg-zinc-100 dark:bg-zinc-800 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="ri-inbox-line text-zinc-400 text-2xl"></i>
                            </div>
                            <p class="text-zinc-600 dark:text-zinc-400">No items yet</p>
                        </div>

                        <!-- Delivery Cards -->
                        <DeliveryCard :deliveryList="deliveryList" />
                    </div>
                </TabPanel>
            </TabPanels>
        </Tabs>

    </AuthenticatedLayout>
</template>
