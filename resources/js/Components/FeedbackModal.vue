<script setup>

import Modal from './Modal.vue';
import { Button, FloatLabel, Rating, Textarea } from 'primevue';
import Container from './Container.vue';
import { ref, toRefs } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { useToast } from 'vue-toastification';

const props = defineProps({ delivery: Object });

const { delivery } = toRefs(props);

const isShowModal = ref(false);
const toast = useToast();
const submitButtonRef = ref(null);

const form = useForm({
    comment: null,
    star_count: null
})

const submit = (delivery) => {
    form.post(route('delivery-feedback.store', delivery?.id), {
        onSuccess: () => {
            isShowModal.value = false;

            toast.success('Successfully added feedback');
        },
        onError: () => {
            toast.error('Failed to add feedback');
        }
    })
}

</script>

<template>
    <Button
        @click="isShowModal = true"
        size="small"
        icon="ri-feedback-line"
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
                    <header>
                        <h3 class="text-xl font-semibold text-zinc-900 dark:text-white">
                            My Feedback
                        </h3>
                    </header>
                    <div class="flex gap-2 items-center">
                        <Button @click="submitButtonRef.click()">
                            <i class="ri-save-line"></i>
                            <span>Save</span>
                        </Button>
                    </div>
                </div>
            </template>
            <template #body>
                <form @submit.prevent="submit(delivery)" class="space-y-4">

                    <div class="space-y-2 flex justify-between">
                        <label for="rating" class="">Star Count</label>
                        <Rating id="rating" v-model="form.star_count" />
                    </div>
                    <div class="space-y-2 w-full">

                        <FloatLabel variant="on">
                            <Textarea
                                class="w-full"
                                v-model="form.comment"

                            />
                            <label for="comment">Comment</label>
                        </FloatLabel>
                    </div>
                    <button type="submit" class="sr-only" ref="submitButtonRef"></button>
                </form>
            </template>
        </Container>
    </Modal>
</template>
