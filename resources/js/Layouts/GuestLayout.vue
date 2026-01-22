<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div
        class="flex min-h-screen flex-col items-center bg-zinc-100 pt-6 sm:justify-center sm:pt-0 dark:bg-zinc-900"
    >
        <div>
            <Link href="/">
                <ApplicationLogo class="h-20 w-20 fill-current text-zinc-500" />
            </Link>
        </div>

        <div
            class="mt-6 w-full overflow-hidden bg-white px-6 py-4 shadow-md sm:max-w-md sm:rounded-lg dark:bg-zinc-800"
        >
            <header>
                <h1 class="mb-4 text-center text-2xl font-bold text-zinc-700 dark:text-zinc-200">
                    <slot name="title" />
                </h1>
            </header>
            <slot />
        </div>
    </div>
</template>
