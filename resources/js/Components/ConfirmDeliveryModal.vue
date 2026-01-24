<script setup>

import { Button } from 'primevue';
import Modal from './Modal.vue';
import Container from './Container.vue';
import { ref, toRefs } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { useToast } from 'vue-toastification';

const props = defineProps({
    pickAndDrop: Object,
    pasuyo: Object,
})

const { pickAndDrop, pasuyo } = toRefs(props);

const isShowModal = ref(false);
const toast = useToast();

const form = ref(
    useForm({
        type: pickAndDrop.value ? 'pick_and_drop' : 'pasuyo',
        pick_and_drop_id: null,
        pasuyo_id: null,
    })
)

const submit = () => {

    if (pickAndDrop.value) {
        form.value.pick_and_drop_id = pickAndDrop.value.id;
    } else if (pasuyo.value) {
        form.value.pasuyo_id = pasuyo.value.id;
    }

    form.value.post(route('delivery.store'), {
        onSuccess: () => {
            isShowModal.value = false;
            toast.success('Delivery accepted successfully!');
        },
        onError: (errors) => {
            toast.error('Failed to accept delivery. Please try again.');
            console.error('Submission errors:', errors);
        },
    });
}

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
                <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">Accept Delivery</h3>
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
                    <form @submit.prevent="submit">
                        <Button :loading="form.processing" type="submit" severity="success">
                            <span>Confirm</span>
                        </Button>
                    </form>
                </div>
            </template>
        </Container>
    </Modal>
</template>
