<script setup>

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Button } from 'primevue';
import { Head } from '@inertiajs/vue3';

defineProps({
    deliveries: Object
});

</script>

<template>
    <AuthenticatedLayout>
        <Head title="Delivery" />

        <template #header>
            <h2>Delivery</h2>
        </template>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-zinc-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-zinc-900 dark:text-zinc-100">
                    Delivery Page
                </div>
            </div>
        </div>

        <div class="whitespace-pre-wrap">
            {{ deliveries?.data }}
        </div>
    </AuthenticatedLayout>
</template>
