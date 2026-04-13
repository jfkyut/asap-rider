<script setup>

import { Button } from 'primevue';
import Modal from './Modal.vue';
import Container from './Container.vue';
import { onMounted, ref, toRefs, watch } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { useToast } from 'vue-toastification';
import { useDistance } from '@/Composables/distance';

const props = defineProps({
    pickAndDrop: Object,
    pasuyo: Object,
})

const { pickAndDrop, pasuyo } = toRefs(props);
const { fetchDistance, isLoadingDistance } = useDistance();

const isShowModal = ref(false);
const toast = useToast();
const isCalculatingDistance = ref(false);

const form = ref(
    useForm({
        type: pickAndDrop.value ? 'pick_and_drop' : 'pasuyo',
        pick_and_drop_id: null,
        pasuyo_id: null,
        distance_travelled: 0,
    })
)

const calculateAndSetDistance = async () => {
    isCalculatingDistance.value = true;
    
    try {
        let distance = 0;

        if (pickAndDrop.value) {
            // For pick and drop, distance is from sender to receiver
            distance = await fetchDistance(
                pickAndDrop.value.sender_location_coordinates,
                pickAndDrop.value.receiver_location_coordinates
            );
        } else if (pasuyo.value) {
            // For pasuyo, distance is from location to landmark (shopping area)
            distance = await fetchDistance(
                pasuyo.value.location_coordinates,
                pasuyo.value.landmark_location_coordinates
            );
        }

        if (distance !== null) {
            form.value.distance_travelled = parseFloat(distance.toFixed(2));
        }
    } catch (error) {
        console.error('Error calculating distance:', error);
        toast.error('Failed to calculate distance');
    } finally {
        isCalculatingDistance.value = false;
    }
}

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

watch(isShowModal, async (isShowModalValue) => {
    if (isShowModalValue) {
        await calculateAndSetDistance();
    }
})

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
                <div class="space-y-4">
                    <p class="text-sm text-zinc-900 dark:text-white">
                        Are you sure you want to accept the delivery for
                        <span class="font-semibold">
                            {{ pickAndDrop ? pickAndDrop.receiver_full_name : pasuyo.full_name }}
                        </span
                        >?
                    </p>
                    <div v-if="isCalculatingDistance" class="bg-blue-50 dark:bg-blue-900/20 p-3 rounded-lg border border-blue-200 dark:border-blue-800">
                        <p class="text-xs text-zinc-600 dark:text-zinc-400 flex items-center gap-2">
                            <i class="ri-loader-4-line animate-spin"></i>
                            Calculating distance...
                        </p>
                    </div>
                    <div v-else-if="form.distance_travelled > 0" class="bg-green-50 dark:bg-green-900/20 p-3 rounded-lg border border-green-200 dark:border-green-800">
                        <p class="text-xs font-semibold text-green-900 dark:text-green-200">📍 Distance: {{ form.distance_travelled }} km</p>
                    </div>
                </div>
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
