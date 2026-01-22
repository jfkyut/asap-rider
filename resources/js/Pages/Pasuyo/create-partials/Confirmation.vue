<script setup>

defineProps({
    form: Object,
});

</script>

<template>
    <div class="space-y-4">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-50 to-blue-100 dark:from-blue-900/30 dark:to-blue-800/30 p-4 rounded-lg border border-blue-200 dark:border-blue-700">
            <h3 class="text-lg font-semibold text-blue-900 dark:text-blue-100 flex items-center gap-2">
                <i class="ri-checkbox-circle-line text-xl text-blue-600 dark:text-blue-400"></i>
                Review Your Request
            </h3>
            <p class="text-sm text-blue-700 dark:text-blue-300 mt-1">Please verify the information below before submitting</p>
        </div>

        <!-- Content Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Receiver Details Card -->
            <div class="bg-white dark:bg-zinc-700 p-4 rounded-lg border border-gray-200 dark:border-zinc-600 shadow-sm">
                <h4 class="font-semibold text-gray-900 dark:text-white mb-3 flex items-center gap-2">
                    <i class="ri-user-line text-blue-600"></i>
                    Receiver Details
                </h4>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Name:</span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ form.full_name || 'Not provided' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Phone:</span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ form.phone || 'Not provided' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Location:</span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ form.location || 'Not provided' }}</span>
                    </div>
                </div>
            </div>

            <!-- Request Details Card -->
            <div class="bg-white dark:bg-zinc-700 p-4 rounded-lg border border-gray-200 dark:border-zinc-600 shadow-sm">
                <h4 class="font-semibold text-gray-900 dark:text-white mb-3 flex items-center gap-2">
                    <i class="ri-file-text-line text-blue-600"></i>
                    Request Details
                </h4>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Budget:</span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ form.budget || 'Not provided' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Payment Method:</span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ form.payment_method || 'Not provided' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Status:</span>
                        <span class="font-medium text-gray-900 dark:text-white capitalize">{{ form.status }}</span>
                    </div>
                </div>
            </div>

            <!-- Content Card (Full Width) -->
            <div class="md:col-span-2 bg-white dark:bg-zinc-700 p-4 rounded-lg border border-gray-200 dark:border-zinc-600 shadow-sm">
                <h4 class="font-semibold text-gray-900 dark:text-white mb-3 flex items-center gap-2">
                    <i class="ri-message-3-line text-blue-600"></i>
                    Content
                </h4>
                <p class="text-sm text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-zinc-800 p-3 rounded">
                    {{ form.content || 'No content provided' }}
                </p>
            </div>
        </div>

        <!-- Info Message -->
        <div class="bg-green-50 dark:bg-green-900/20 p-3 rounded-lg border border-green-200 dark:border-green-700">
            <p class="text-sm text-green-800 dark:text-green-200 flex items-start gap-2">
                <i class="ri-information-line mt-0.5 flex-shrink-0"></i>
                <span>Once submitted, your request will be posted and available riders nearby will be notified. They can accept and help you complete your errands.</span>
            </p>
        </div>
    </div>
</template>