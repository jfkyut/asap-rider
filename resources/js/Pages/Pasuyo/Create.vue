<script setup>

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { 
    Stepper, 
    StepItem, 
    Step, 
    StepPanel, 
    Button,
    InputText,
    Textarea,
    Select,
    MultiSelect,
    FloatLabel,
} from 'primevue';
import { onMounted, ref } from 'vue';
import { usePage } from '@inertiajs/vue3';
import BasicInformation from './create-partials/BasicInformation.vue';
import Content from './create-partials/Content.vue';
import Confirmation from './create-partials/Confirmation.vue';
import { useToast } from 'vue-toastification';

const page = usePage();
const toast = useToast();
const isLoading = ref(false);

const form = useForm({
    location: '',
    location_coordinates: null,
    full_name: '',
    phone: '',
    note: '',
    content: '',
    budget: '',
    status: 'pending',
    payment_method: '',
    attachments: [],
});

const submit = () => {

    if (isLoading.value) {
        return;
    }

    form.post(route('pasuyo.store'), {
        onStart: () => {
            isLoading.value = true;
        },
        onFinish: () => {
            isLoading.value = false;
        },
        onSuccess: () => {
            toast.success('Pasuyo request submitted successfully!');
            form.reset();
        },
        onError: () => {
            toast.error('There was an error submitting your request. Please check the form for errors.');
        }
    });
};

onMounted(() => {
    setTimeout(() => {
        form.full_name = page.props.auth.user.name || '';
        form.phone = page.props.auth.user.phone || '';
        
        const firstInput = document.getElementById('full_name');
        if (firstInput) {
            firstInput.focus();
        }

    }, 300);
})

</script>

<template>

    <AuthenticatedLayout>
        <Head title="Pasuyo" />

        <template #header>
            Pasuyo, Pabili ATBP.
        </template>

        <div class="sm:p-8 max-w-7xl mx-auto">

            <Stepper value="1">
                <StepItem value="1">
                    <Step>Receiver Details</Step>
                    <StepPanel v-slot="{ activateCallback }">
                        <BasicInformation :form="form" />
                        <div class="py-6">
                            <Button label="Next" @click="activateCallback('2')" />
                        </div>
                    </StepPanel>
                </StepItem>
                <StepItem value="2">
                    <Step>Content</Step>
                    <StepPanel v-slot="{ activateCallback }">
                        <Content :form="form" />
                        <div class="flex py-6 gap-2">
                            <Button label="Back" severity="secondary" @click="activateCallback('1')" />
                            <Button label="Next" @click="activateCallback('3')" />
                        </div>
                    </StepPanel>
                </StepItem>
                <StepItem value="3">
                    <Step>Confirmation</Step>
                    <StepPanel v-slot="{ activateCallback }">
                        
                        <Confirmation :form="form" />

                        <div class="py-6 flex gap-2">
                            <Button label="Back" severity="secondary" @click="activateCallback('2')" />
                            <Button 
                                @click="submit"
                                label="Submit Request" 
                                :loading="form.processing"
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