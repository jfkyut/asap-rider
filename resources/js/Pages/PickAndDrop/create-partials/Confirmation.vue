<script setup>

defineProps({
    form: Object,
});

</script>

<template>
    <div class="space-y-4 pb-4">
        <!-- Pickup Section -->
        <div class="bg-blue-50 dark:bg-blue-950/40 rounded-lg p-4 border-l-4 border-blue-500">
            <div class="flex items-center gap-2 mb-3">
                <span class="text-xl">📍</span>
                <h3 class="text-base font-bold text-zinc-900 dark:text-white">Pickup</h3>
            </div>
            
            <div class="space-y-2.5">
                <div>
                    <p class="text-xs font-semibold text-zinc-600 dark:text-zinc-400 uppercase tracking-wide mb-0.5">From</p>
                    <p class="text-sm text-zinc-900 dark:text-white">{{ form.sender_full_name || '—' }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-zinc-600 dark:text-zinc-400 uppercase tracking-wide mb-0.5">Location</p>
                    <p class="text-sm text-zinc-900 dark:text-white">{{ form.sender_location || '—' }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-zinc-600 dark:text-zinc-400 uppercase tracking-wide mb-0.5">Phone</p>
                    <p class="text-sm text-zinc-900 dark:text-white">{{ form.sender_phone || '—' }}</p>
                </div>
                <div v-if="form.sender_note">
                    <p class="text-xs font-semibold text-zinc-600 dark:text-zinc-400 uppercase tracking-wide mb-0.5">Note</p>
                    <p class="text-sm text-zinc-900 dark:text-white italic">{{ form.sender_note }}</p>
                </div>
            </div>
        </div>

        <!-- Item Description Section -->
        <div class="bg-amber-50 dark:bg-amber-950/40 rounded-lg p-4 border-l-4 border-amber-500">
            <div class="flex items-center gap-2 mb-3">
                <span class="text-xl">📦</span>
                <h3 class="text-base font-bold text-zinc-900 dark:text-white">Item</h3>
            </div>
            
            <div>
                <p class="text-xs font-semibold text-zinc-600 dark:text-zinc-400 uppercase tracking-wide mb-0.5">Description</p>
                <p class="text-sm text-zinc-900 dark:text-white">{{ form.item_description || '—' }}</p>
            </div>
        </div>

        <!-- Delivery Section -->
        <div class="bg-purple-50 dark:bg-purple-950/40 rounded-lg p-4 border-l-4 border-purple-500">
            <div class="flex items-center gap-2 mb-3">
                <span class="text-xl">🏁</span>
                <h3 class="text-base font-bold text-zinc-900 dark:text-white">Delivery</h3>
            </div>
            
            <div class="space-y-2.5">
                <div>
                    <p class="text-xs font-semibold text-zinc-600 dark:text-zinc-400 uppercase tracking-wide mb-0.5">To</p>
                    <p class="text-sm text-zinc-900 dark:text-white">{{ form.receiver_full_name || '—' }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-zinc-600 dark:text-zinc-400 uppercase tracking-wide mb-0.5">Location</p>
                    <p class="text-sm text-zinc-900 dark:text-white">{{ form.receiver_location || '—' }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-zinc-600 dark:text-zinc-400 uppercase tracking-wide mb-0.5">Phone</p>
                    <p class="text-sm text-zinc-900 dark:text-white">{{ form.receiver_phone || '—' }}</p>
                </div>
                <div v-if="form.receiver_note">
                    <p class="text-xs font-semibold text-zinc-600 dark:text-zinc-400 uppercase tracking-wide mb-0.5">Note</p>
                    <p class="text-sm text-zinc-900 dark:text-white italic">{{ form.receiver_note }}</p>
                </div>
            </div>
        </div>

        <!-- Payment Section -->
        <div class="bg-green-50 dark:bg-green-950/40 rounded-lg p-4 border-l-4 border-green-500">
            <div class="flex items-center gap-2 mb-3">
                <span class="text-xl">💳</span>
                <h3 class="text-base font-bold text-zinc-900 dark:text-white">Payment</h3>
            </div>
            
            <div>
                <p class="text-xs font-semibold text-zinc-600 dark:text-zinc-400 uppercase tracking-wide mb-0.5">Method</p>
                <p class="text-sm text-zinc-900 dark:text-white">{{ form.payment_method || '—' }}</p>
            </div>
        </div>

        <!-- Summary Notice -->
        <div class="bg-zinc-100 dark:bg-zinc-800/50 rounded-lg p-3 border border-zinc-300 dark:border-zinc-700">
            <p class="text-xs text-zinc-700 dark:text-zinc-300 leading-relaxed">
                <span class="font-semibold">Ready to submit?</span> Please review all details above before confirming.
            </p>
        </div>
    </div>
</template>