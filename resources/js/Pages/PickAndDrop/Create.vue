<script setup>

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { 
    Stepper, 
    StepItem, 
    Step, 
    StepPanel, 
    Button,
    InputText,
    Textarea,
    Select,
    FloatLabel,
} from 'primevue';
import { onMounted, ref } from 'vue';
import { useToast } from 'vue-toastification';
import Sender from './create-partials/Sender.vue';
import Receiver from './create-partials/Receiver.vue';
import Confirmation from './create-partials/Confirmation.vue';

const page = usePage();
const toast = useToast();
const isLoading = ref(false);

const form = useForm({
    sender_location: '',
    sender_location_coordinates: null,
    sender_full_name: '',
    sender_phone: '',
    sender_note: '',
    receiver_location: '',
    receiver_location_coordinates: null,
    receiver_full_name: '',
    receiver_phone: '',
    receiver_note: '',
    item_description: '',
    status: 'pending',
    payment_method: '',
})

const submit = () => {

    if (isLoading.value) {
        return;
    }

    form.post(route('pick-and-drop.store'), {
        onStart: () => {
            isLoading.value = true;
        },
        onFinish: () => {
            isLoading.value = false;
        },
        onSuccess: () => {
            toast.success('Pick and Drop request submitted successfully!');
            form.reset();
        },
        onError: () => {
            toast.error('There was an error submitting your request. Please check the form for errors.');
        }
    });
}

onMounted(() => {
    setTimeout(() => {
        form.sender_full_name = page.props.auth.user.name || '';
        form.sender_phone = page.props.auth.user.phone || '';
    }, 500);
})

</script>

<template>
    <AuthenticatedLayout>
        <Head title="Request Pick and Drop" />
        <template #header>
            <h2>Request Pick and Drop</h2>
        </template>

        <div class="sm:p-8 max-w-7xl mx-auto">
            <Stepper value="1">
                <StepItem value="1">
                    <Step>Sender</Step>
                    <StepPanel v-slot="{ activateCallback }">
                        <div class="space-y-4">
                            <div class="dark:border-surface-700 rounded bg-surface-50 dark:bg-surface-950 flex-auto flex justify-center items-center font-medium">
                                <Sender :form="form" />
                            </div>
                        </div>
                        <div class="py-6">
                            <Button label="Next" @click="activateCallback('2')" />
                        </div>
                    </StepPanel>
                </StepItem>
                <StepItem value="2">
                    <Step>Receiver</Step>
                    <StepPanel v-slot="{ activateCallback }">
                        <div class="space-y-4">
                            <div class="dark:border-surface-700 rounded bg-surface-50 dark:bg-surface-950 flex-auto flex justify-center items-center font-medium">
                                <Receiver :form="form" />
                            </div>
                        </div>
                        <div class="flex py-6 gap-2">
                            <Button label="Back" severity="secondary" @click="activateCallback('1')" />
                            <Button label="Next" @click="activateCallback('3')" />
                        </div>
                    </StepPanel>
                </StepItem>
                <StepItem value="3">
                    <Step>Item & Payment</Step>
                    <StepPanel v-slot="{ activateCallback }">
                        <div class="space-y-4">
                            <div class="dark:border-surface-700 rounded bg-surface-50 dark:bg-surface-950 flex-auto flex justify-center items-center font-medium">
                                <div class="space-y-4 w-full">
                                    <FloatLabel variant="on">
                                        <Textarea 
                                            id="item_description" 
                                            v-model="form.item_description" 
                                            class="w-full"
                                            auto-resize 
                                        />
                                        <label for="item_description">Item Description</label>
                                    </FloatLabel>
                                    <FloatLabel variant="on">
                                        <Select 
                                            :options="['Cash on Delivery', 'Gcash']" 
                                            class="w-full" 
                                            v-model="form.payment_method" 
                                            id="payment_method" 
                                        />
                                        <label for="payment_method">Payment Method</label>
                                    </FloatLabel>

                                </div>
                            </div>
                        </div>
                        <div class="flex py-6 gap-2">
                            <Button label="Back" severity="secondary" @click="activateCallback('2')" />
                            <Button label="Next" @click="activateCallback('4')" />
                        </div>
                    </StepPanel>
                </StepItem>
                <StepItem value="4">
                    <Step>Confirmation</Step>
                    <StepPanel v-slot="{ activateCallback }">
                        
                        <Confirmation :form="form" />

                        <div class="py-6 flex gap-2">
                            <Button label="Back" severity="secondary" @click="activateCallback('3')" />
                            <Button 
                                label="Submit Request" 
                                @click="submit"
                                :loading="isLoading"
                                class="flex-1"
                                icon="ri-send-plane-2-line"
                            />
                        </div>
                    </StepPanel>
                </StepItem>
            </Stepper>
        </div>
    </AuthenticatedLayout>
</template>