<script setup>

defineProps({
    headerClass: String,
    bodyClass: String,
    footerClass: String,
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
        <section :class="[bodyClass, isScrollable ? 'max-h-[60vh] overflow-y-auto' : '', !$slots.footer ? 'rounded-b-lg' : '']" class="bg-white dark:bg-zinc-800 dark:border-zinc-700 p-3 border shadow-lg">
            <slot name="body" />
        </section>
        <section v-if="$slots.footer" :class="[footerClass, isScrollable ? 'sticky bottom-0 z-[9]' : '']" class="bg-white p-3 border-t border-x shadow rounded-b-lg dark:bg-zinc-800 dark:border-zinc-700">
            <slot name="footer" />
        </section>
    </div>
</template>
