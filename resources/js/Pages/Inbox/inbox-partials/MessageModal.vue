<script setup>

import Modal from '@/Components/Modal.vue';
import Container from '@/Components/Container.vue';
import { Button } from 'primevue';

defineProps({
    show: {
        type: Boolean,
        default: false
    },
    message: {
        type: Object,
        default: () => ({})
    }
});

const getTypeColor = (type) => {
    const colors = {
        pasuyo: 'bg-blue-100 text-blue-800',
        pickup: 'bg-green-100 text-green-800',
        support: 'bg-purple-100 text-purple-800'
    };
    return colors[type] || 'bg-gray-100 text-gray-800';
};

const getTypeIcon = (type) => {
    const icons = {
        pasuyo: 'ri-box-line',
        pickup: 'ri-truck-line',
        support: 'ri-customer-service-2-line'
    };
    return icons[type] || 'ri-message-line';
};

const getTypeLabel = (type) => {
    const labels = {
        pasuyo: 'Pasuyo',
        pickup: 'Pick & Drop',
        support: 'Support'
    };
    return labels[type] || 'Message';
};

</script>

<template>
    <Modal :show="show" @close="$emit('close')">
        <Container>
            <template #header>
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-bold text-zinc-900 dark:text-white">{{ message.sender }}</h2>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ message.timestamp }}</p>
                    </div>
                    <button
                        @click="$emit('close')"
                        class="text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-300"
                    >
                        <i class="ri-close-line text-xl"></i>
                    </button>
                </div>
            </template>

            <template #body>
                <!-- Message Type Badge -->
                <div class="mb-6">
                    <span :class="['inline-flex items-center gap-2 text-xs px-3 py-1 rounded-full font-medium', getTypeColor(message.type)]">
                        <i :class="getTypeIcon(message.type)"></i>
                        {{ getTypeLabel(message.type) }}
                    </span>
                </div>

                <!-- Unread Indicator -->
                <div v-if="message.unread" class="mb-4 flex items-center gap-2 px-3 py-2 rounded-lg bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800">
                    <i class="ri-alert-line text-blue-600 dark:text-blue-400"></i>
                    <span class="text-xs font-medium text-blue-600 dark:text-blue-400">Unread message</span>
                </div>

                <!-- Message Body -->
                <div class="mb-6 p-4 rounded-lg bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700">
                    <p class="text-sm text-zinc-900 dark:text-white leading-relaxed whitespace-pre-wrap">
                        {{ message?.body || message?.preview }}
                    </p>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-3 justify-end">
                    <Button
                        v-if="message.unread"
                        label="Mark as Read"
                        severity="info"
                        size="small"
                        outlined
                        @click="$emit('markAsRead', message.id)"
                    />
                    <Button
                        label="Close"
                        severity="secondary"
                        size="small"
                        @click="$emit('close')"
                    />
                </div>
            </template>
        </Container>
    </Modal>
</template>
