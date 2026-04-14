<script setup>

import { Button, FloatLabel, Select, InputText } from 'primevue';
import Modal from '@/Components/Modal.vue';
import { ref, toRefs, watch } from 'vue';
import Container from '@/Components/Container.vue';
import { useForm } from '@inertiajs/vue3';
import { useToast } from 'vue-toastification';
import { useCommon } from '@/Composables/common';

const props = defineProps({
    delivery: Object,
});

const { delivery } = toRefs(props);

const isShowModal = ref(false);
const toast = useToast();
const submitButtonRef = ref(null);
const { setFiles } = useCommon();

const travelPerKm = ref(15);

const form = ref(
    useForm({
        _method: 'put',
        status: null,
        bill_amount: null,
        distance_travelled: null,
        total_payment: null,
        proofs: []
    })
)

const submit = (delivery) => {

    form.value.post(route('delivery.update', delivery.id), {
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
            form.value.distance_travelled = delivery.value.distance_travelled;
            form.value.bill_amount = delivery.value.bill_amount;

            console.log(delivery.value);
            
            form.value.total_payment = delivery.value.total_payment;
        }, 300);
    }
});

watch(() => form.value, (form) => {
    if (form.distance_travelled !== null) {
        const distanceInKm = form.distance_travelled / 1;
        const travelCost = (travelPerKm.value * distanceInKm);
        
        // For pasuyo, add bill_amount to travel cost; for pick_and_drop, just use travel cost
        if (delivery.value.type === 'pasuyo' && form.bill_amount !== null) {
            const calculatedTotal = (parseFloat(form.bill_amount) + travelCost).toFixed(2);
            form.total_payment = parseFloat(calculatedTotal);
        } else {
            const calculatedTotal = travelCost.toFixed(2);
            form.total_payment = parseFloat(calculatedTotal);
        }
    } else {
        form.total_payment = null;
    }
}, { 
    deep: true,
    immediate: true, 
});

</script>

<template>
    <Button
        @click="isShowModal = true"
        size="small"
    >
        <i class="ri-edit-line"></i>
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
                        <Button
                            size="small"
                            :loading="form.processing"
                            @click="submitButtonRef.click()"
                            severity="success"
                        >
                            <span class="text-xs">Update</span>
                        </Button>
                    </div>
                </div>
            </template>
            <template #body>
                <form @submit.prevent="submit(delivery)">
                    <div class="space-y-4">
                        <FloatLabel variant="on">
                            <Select
                                name="status"
                                :options="[
                                    { label: 'Accepted', value: 'accepted' },
                                    { label: 'In Progress', value: 'in_progress' },
                                    { label: 'To Pay', value: 'to_pay' },
                                    { label: 'Completed', value: 'completed' },
                                ]"
                                option-label="label"
                                option-value="value"
                                v-model="form.status"
                                class="w-full"
                            />
                            <label for="status">Status</label>
                        </FloatLabel>

                        <FloatLabel variant="on">
                            <InputText
                                readonly
                                name="distance_travelled"
                                type="number"
                                step="0.01"
                                v-model="form.distance_travelled"
                                class="w-full"
                            />
                            <label for="distance_travelled">Distance (km)</label>
                        </FloatLabel>
                        <FloatLabel v-if="delivery.type === 'pasuyo' && form.status === 'to_pay'" variant="on">
                            <InputText
                                name="bill_amount"
                                type="number"
                                step="0.10"
                                v-model="form.bill_amount"
                                class="w-full"
                            />
                            <label for="bill_amount">Bill Payment (₱)</label>
                        </FloatLabel>
                        <FloatLabel variant="on">
                            <InputText
                                name="total_payment"
                                type="number"
                                step="0.10"
                                v-model="form.total_payment"
                                class="w-full"
                                readonly
                            />
                            <label for="total_payment">Total Payment (₱)</label>
                        </FloatLabel>
                        <FloatLabel variant="on" v-if="delivery?.type === 'pasuyo' && form.status === 'to_pay'">
                            <InputText
                                type="file"
                                name="proofs"
                                step="0.10"
                                placeholder="file"
                                class="w-full"
                                @change="(e) => setFiles(e, (files) => form.proofs = files)"
                                multiple
                                required
                            />
                            <label for="proofs">Proof of Payment</label>
                        </FloatLabel>
                    </div>
                    <button type="submit" class="sr-only" ref="submitButtonRef"></button>
                </form>

            </template>
            <!-- <template #footer>
                <div class="flex justify-end items-center gap-2">
                    <Button
                        severity="secondary"
                        size="small"
                        variant="outlined"
                        @click="isShowModal = false"
                    >
                        <span>Cancel</span>
                    </Button>

                </div>
            </template> -->
        </Container>
    </Modal>
</template>
