<script setup>

import { Button, Timeline } from 'primevue';
import Modal from '@/Components/Modal.vue';
import Container from '@/Components/Container.vue';
import { toRefs, ref } from 'vue';

const props = defineProps({
    delivery: Object,
});

const { delivery } = toRefs(props);

const isShowModal = ref(false);

</script>

<template>
    <Button
        @click="isShowModal = true"
        size="small"
        label="Trackings"
        icon="ri-history-line"
        severity="secondary"
        variant="outlined"
    />

    <Modal
        :show="isShowModal"
        @close="isShowModal = false"
    >
        <Container>
            <template #header>
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-medium">Delivery Trackings</h3>
                    <Button
                        icon="ri-close-line"
                        severity="tertiary"
                        size="small"
                        variant="text"
                        @click="isShowModal = false"
                    />
                </div>
            </template>
            <template #body>
                <div class="whitespace-pre-wrap">
                    <Timeline :value="delivery?.trackings">
                        <template #opposite="slotProps">
                            <small class="text-surface-500 dark:text-surface-400">
                                {{ slotProps.item?.created_at }}
                            </small>
                        </template>
                        <template #content="slotProps">
                            <small class="capitalize">
                                {{ slotProps.item?.status_update?.replace('_', ' ') }}
                            </small>
                        </template>
                    </Timeline>
                </div>
            </template>
        </Container>
    </Modal>
</template>
