<script setup>

import { Button, FloatLabel, Select } from 'primevue';
import Modal from '@/Components/Modal.vue';
import { ref, toRefs, watch } from 'vue';
import Container from '@/Components/Container.vue';
import { useForm } from '@inertiajs/vue3';
import { useToast } from 'vue-toastification';

const props = defineProps({
    delivery: Object,
});

const { delivery } = toRefs(props);

const isShowModal = ref(false);
const toast = useToast();
const submitButtonRef = ref(null);

const form = ref(
    useForm({
        status: null,
    })
)

const submit = (delivery) => {

    form.value.put(route('delivery.update', delivery.id), {
        onSuccess: () => {
            isShowModal.value = false;
            toast.success('Delivery updated successfully!');
        },
        onError: (errors) => {
            toast.error('Failed to update delivery. Please try again.');
            console.error('Submission errors:', errors);
        },
        preserveScroll: true,
    });
}

watch(isShowModal, (isShowModal) => {
    if (isShowModal) {
        setTimeout(() => {
            form.value.status = delivery.value.status;
        }, 300);
    }
});

</script>

<template>
    <Button
        @click="isShowModal = true"
        size="small"
    >
        <i class="ri-edit-line"></i>
        <span>Edit</span>
    </Button>

    <Modal
        :show="isShowModal"
        @close="isShowModal = false"
    >
        <Container>
            <template #header>
                <div class="flex items-center justify-between">
                    <header>
                        <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">Update Delivery Status</h3>
                    </header>
                    <div class="flex gap-2 items-center">
                        <Button severity="secondary" size="small" variant="outlined" @click="isShowModal = false">
                            <span class="text-xs">Close</span>
                        </Button>
                    </div>
                </div>
            </template>
            <template #body>
                <form @submit.prevent="submit(delivery)">
                    <FloatLabel variant="on">
                        <Select
                            name="status"
                            :options="[
                                { label: 'Accepted', value: 'accepted' },
                                { label: 'In Progress', value: 'in_progress' },
                                { label: 'Completed', value: 'completed' },
                            ]"
                            option-label="label"
                            option-value="value"
                            v-model="form.status"
                            class="w-full"
                        />
                        <label for="status">Status</label>
                    </FloatLabel>
                    <button type="submit" class="sr-only" ref="submitButtonRef"></button>
                </form>

            </template>
            <template #footer>
                <div class="flex justify-end items-center gap-2">
                    <Button
                        severity="secondary"
                        size="small"
                        variant="outlined"
                        @click="isShowModal = false"
                    >
                        <span>Cancel</span>
                    </Button>
                    <Button
                        size="small"
                        :loading="form.processing"
                        @click="submitButtonRef.click()"
                        severity="success"
                    >
                        <span>Update</span>
                    </Button>
                </div>
            </template>
        </Container>
    </Modal>
</template>
