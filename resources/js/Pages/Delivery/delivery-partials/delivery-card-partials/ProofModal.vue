<script setup>

import { Button } from 'primevue';
import Modal from '@/Components/Modal.vue';
import Container from '@/Components/Container.vue';
import { ref } from 'vue';

defineProps({
    attachments: Array,
});

const isShowModal = ref(false);

</script>

<template>
    <Button @click="isShowModal = true" severity="secondary" outlined>
        <i class="ri-receipt-line"></i>
    </Button>

    <Modal
        :show="isShowModal"
        @close="isShowModal = false"
    >
        <Container>
            <template #header>
                <div class="flex items-center justify-between">
                    <header>
                        <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">Proof of Delivery</h3>
                    </header>
                    <div class="flex gap-2 items-center">
                        <Button severity="secondary" size="small" variant="outlined" @click="isShowModal = false">
                            Close
                        </Button>
                    </div>
                </div>
            </template>
            <template #body>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div v-for="attachment in attachments" :key="attachment.id" class="border rounded-lg overflow-hidden">
                        <img
                            :src="`/storage/${attachment.file_path}`"
                            alt="Proof of Delivery"
                            class="w-full h-48 object-cover"
                        />
                    </div>
                </div>

            </template>
        </Container>
    </Modal>

</template>