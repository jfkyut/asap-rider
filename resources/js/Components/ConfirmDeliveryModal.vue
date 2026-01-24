<script setup>

import { Button } from 'primevue';
import Modal from './Modal.vue';
import Container from './Container.vue';
import { ref } from 'vue';

defineProps({
    pickAndDrop: Object,
    pasuyo: Object,
})

const isShowModal = ref(false);

</script>


<template>
    <Button @click="isShowModal = true">
        <i class="ri-check-line"></i>
        <span>Accept</span>
    </Button>

    <Modal
        :show="isShowModal"
        @close="isShowModal = false"
    >
        <Container>
            <template #header>
                <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">Confirm Delivery</h3>
            </template>

            <template #body>
                <p class="text-sm text-zinc-900 dark:text-white">
                    Are you sure you want to accept the delivery for
                    <span class="font-semibold">
                        {{ pickAndDrop ? pickAndDrop.receiver_full_name : pasuyo.full_name }}
                    </span
                    >?
                </p>
            </template>

            <template #footer>
                <div class="flex justify-end items-center gap-2">
                    <Button
                        severity="secondary"
                        variant="outlined"
                        @click="isShowModal = false"
                    >
                        <span>Cancel</span>
                    </Button>
                    <form>
                        <Button type="submit" severity="success">
                            <span>Confirm</span>
                        </Button>
                    </form>
                </div>
            </template>
        </Container>
    </Modal>
</template>
