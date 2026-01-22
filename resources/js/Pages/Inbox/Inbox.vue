<script setup>

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import { InputGroup, InputGroupAddon, InputText, Button, Badge } from 'primevue';
import MessageModal from './inbox-partials/MessageModal.vue';
import { useToast } from 'vue-toastification';

defineProps({
    messages: {
        type: Array,
        default: () => []
    }
});

const isShowMessageModal = ref(false);
const isShowUnreadMessagesModal = ref(false);
const toast = useToast();

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

const updateMessageAsRead = (messageId) => {

    if (!messageId) return;

    router.put(route('inbox.mark-as-read', { 
        message: messageId,
        onSuccess: () => {
            toast.success('Message marked as read');
        },
        onError: () => {
            toast.error('Failed to mark message as read');
        }
    }));
};

</script>

<template>
    <Head title="Inbox" />

    <AuthenticatedLayout>
        <template #header>
            Inbox
        </template>

        <div class="px-4 py-4">
            <!-- Search Bar -->
            <!-- <div class="mb-4">
                <InputGroup>
                    <InputGroupAddon>
                        <i class="ri-search-line text-zinc-400"></i>
                    </InputGroupAddon>
                    <InputText 
                        v-model="searchQuery" 
                        placeholder="Search messages..." 
                        class="bg-zinc-100 dark:bg-zinc-800 border-none rounded-lg text-sm"
                    />
                </InputGroup>
            </div> -->

            <!-- Messages List -->
            <div v-if="messages.length > 0" class="space-y-2">
                <!-- Unread Messages Section -->
                <div @click="isShowMessageModal = true" v-if="messages.some(m => m.unread)" class="mb-4">
                    <h3 class="text-xs font-semibold text-zinc-500 uppercase tracking-wide mb-2 px-2">
                        <Badge value="New" severity="info" class="mr-2"></Badge>
                        Unread
                    </h3>
                    <div class="space-y-2">
                        <div 
                            @click="isShowUnreadMessagesModal = true"
                            v-for="message in messages.filter(m => m.unread)" 
                            :key="message.id"
                            class="bg-white dark:bg-zinc-800 rounded-lg p-3 border-l-4 border-teal-500 cursor-pointer hover:bg-zinc-50 dark:hover:bg-zinc-700 transition-colors"
                        >
                            <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between gap-2 mb-1">
                                        <p class="font-semibold text-sm truncate">{{ message.sender }}</p>
                                        <span class="text-xs text-zinc-500 flex-shrink-0">{{ message.timestamp }}</span>
                                    </div>
                                    <p class="text-xs text-zinc-600 dark:text-zinc-400 truncate mb-2">{{ message?.body }}</p>
                                    <div class="flex items-center">
                                        <span :class="['text-xs px-2 py-1 rounded-full flex items-center gap-1', getTypeColor(message.type)]">
                                            <i :class="getTypeIcon(message.type)"></i>
                                            {{ message.type === 'pasuyo' ? 'Pasuyo' : message.type === 'pickup' ? 'Pick & Drop' : 'Support' }}
                                        </span>
                                    </div>

                                <!-- Unread Indicator -->
                                <!-- <div class="flex-shrink-0 w-2 h-2 rounded-full bg-teal-500"></div> -->
                            </div>

                            <MessageModal 
                                :show="isShowUnreadMessagesModal" 
                                @close="isShowUnreadMessagesModal = false"
                                @mark-as-read="updateMessageAsRead(message?.id)"
                                :message="message"
                            />
                        </div>
                    </div>

                    
                </div>

                <!-- Read Messages Section -->
                <div v-if="messages.some(m => !m.unread)">
                    <h3 class="text-xs font-semibold text-zinc-500 uppercase tracking-wide mb-2 px-2">Earlier</h3>
                    <div class="space-y-2">
                        <div 
                            @click="isShowMessageModal = true"
                            v-for="message in messages.filter(m => !m.unread)" 
                            :key="message.id"
                            class="bg-white dark:bg-zinc-800 rounded-lg p-3 cursor-pointer hover:bg-zinc-50 dark:hover:bg-zinc-700 transition-colors"
                        >
                            <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between gap-2 mb-1">
                                        <p class="font-semibold text-sm text-zinc-700 dark:text-zinc-300 truncate">{{ message.sender }}</p>
                                        <span class="text-xs text-zinc-400 flex-shrink-0">{{ message.timestamp }}</span>
                                    </div>
                                    <p class="text-xs text-zinc-500 dark:text-zinc-400 truncate mb-2">{{ message.preview }}</p>
                                    <div class="flex items-center">
                                        <span :class="['text-xs px-2 py-1 rounded-full flex items-center gap-1', getTypeColor(message.type)]">
                                            <i :class="getTypeIcon(message.type)"></i>
                                            {{ message.type === 'pasuyo' ? 'Pasuyo' : message.type === 'pickup' ? 'Pick & Drop' : 'Support' }}
                                        </span>
                                    </div>
                            </div>
                            <MessageModal 
                                :show="isShowMessageModal" 
                                @close="isShowMessageModal = false"
                                :message="message"
                            />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Empty State -->
            <div v-else class="flex flex-col items-center justify-center py-16 text-center">
                <i class="ri-inbox-line text-6xl text-zinc-300 dark:text-zinc-600 mb-4"></i>
                <p class="text-sm font-semibold text-zinc-600 dark:text-zinc-400 mb-1">No messages yet</p>
                <p class="text-xs text-zinc-500 dark:text-zinc-500">Your inbox will appear here</p>
            </div>
        </div>
    </AuthenticatedLayout>
</template>