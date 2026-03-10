<script setup>
import { Button, Rating } from 'primevue';
import Modal from './Modal.vue';
import Container from './Container.vue';
import { ref } from 'vue';

defineProps({ delivery: Object });

const isShowModal = ref(false);

</script>

<template>
    <Button
        @click="isShowModal = true"
        size="small"
        severity="secondary"
        variant="outlined"
    >
        <i class="ri-feedback-line"></i>
        <span>Feedback</span>
    </Button>

    <Modal
        :show="isShowModal"
        @close="isShowModal = false"
    >
        <Container>
            <template #header>
                <div class="flex justify-between items-center">
                    <header>
                        <h3 class="text-xl font-semibold text-zinc-900 dark:text-white">
                            Feedback for Delivery #{{ delivery?.id }}
                        </h3>
                    </header>
                </div>
            </template>
            <template #body>
                <div class="flex flex-col gap-4">
                    <p class="text-zinc-700 dark:text-zinc-300 whitespace-pre-wrap">
                        {{ delivery?.feedbacks[0]?.comment }}
                    </p>
                    <Rating
                        :modelValue="delivery?.feedbacks[0]?.star_count"
                        :readonly="true"
                        :stars="5"
                    />
                </div>
            </template>

            
        </Container>
    </Modal>
</template>