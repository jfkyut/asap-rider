<script setup>
import { computed, toRefs } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { 
    Button, 
    Tag,
    Tab,
    TabList,
    Tabs,
    TabPanels,
    TabPanel,
    InputText

} from 'primevue';
import PasuyoTab from './transaction-partials/PasuyoTab.vue';
import PickAndDropTab from './transaction-partials/PickAndDropTab.vue';

const props = defineProps({
    transactions: Object
});

const { transactions } = toRefs(props);

const pasuyos = computed(() => transactions.value?.pasuyos || []);
const pickAndDrops = computed(() => transactions.value?.pickAndDrops || []);


</script>

<template>
    <AuthenticatedLayout>
        <Head title="My Transactions" />

        <template #header>
            <h2>My Transactions</h2>
        </template>

        <div>
            <div class="max-w-6xl mx-auto sm:px-0">
 
                <!-- Tabs Navigation -->
                <Tabs value="1" class="w-full">
                    <div class="sticky top-10 z-20">
                        <TabList class="flex gap-4 border-b border-zinc-200 dark:border-zinc-800">
                            <Tab value="1" class="w-[50%] bg-red-500">
                                📦 Pasuyos
                                <span class="ml-2 text-xs bg-zinc-200 dark:bg-zinc-700 rounded-full px-2 py-0.5">{{ pasuyos.length }}</span>
                            </Tab>
                            <Tab value="2" class="w-[50%]">
                                🚗 Pick & Drop
                                <span class="ml-2 text-xs bg-zinc-200 dark:bg-zinc-700 rounded-full px-2 py-0.5">{{ pickAndDrops.length }}</span>
                            </Tab>
                        </TabList>
                    </div>

                    <TabPanels >
                        <TabPanel value="1">
                            <!-- Pasuyos Tab -->
                            <PasuyoTab :pasuyos="pasuyos" />
                        </TabPanel>
                        <TabPanel value="2">
                            <!-- Pick & Drop Tab -->
                            <PickAndDropTab :pick-and-drops="pickAndDrops" />
                        </TabPanel>
                    </TabPanels>
                </Tabs>
            </div>
        </div>
    </AuthenticatedLayout>
</template>