<script setup>

defineProps({
    headerClass: String,
    bodyClass: String,
    isScrollable: {
        type: Boolean,
        default: () => true
    }
})

</script>

<template>
    <div class="relative">
        <section :class="[headerClass, isScrollable ? 'sticky top-0 z-[9]' : '']" class="bg-white p-3 border-t border-x shadow rounded-t-lg dark:bg-zinc-800 dark:border-zinc-700">
            <slot name="header" />
        </section>
        <section :class="[bodyClass, isScrollable ? 'max-h-[80vh] overflow-y-auto' : '']" class="bg-white dark:bg-zinc-800 dark:border-zinc-700 p-3 border shadow-lg rounded-b-lg">
            <slot name="body" />
        </section>
    </div>
</template>
