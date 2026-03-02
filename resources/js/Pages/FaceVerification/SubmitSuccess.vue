<script setup>

import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Button } from 'primevue';

</script>

<template>
    <Head title="Face Verification Submitted" />

    <GuestLayout>
        <div class="mx-auto text-center">
            <h1 class="text-3xl font-bold mb-4">Face Verification Submitted</h1>
            <p class="text-lg mb-6">Thank you for submitting your face verification photo. We will review it shortly.</p>
            <!-- <Button 
                @click="$inertia.visit(route('dashboard'))"
                class="w-full max-w-xs mx-auto"
                label="Go to Dashboard"
                severity="primary"
            /> -->
        </div>
    </GuestLayout>
</template>