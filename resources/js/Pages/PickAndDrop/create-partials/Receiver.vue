<script setup>

import { FloatLabel, InputText, Textarea, Select } from 'primevue';
import AddLocationModal from '@/Components/AddLocationModal.vue';

defineProps({
    form: Object,
});

</script>

<template>
    <div class="space-y-4 w-full">
        <FloatLabel variant="on">
            <Select 
                class="w-full" 
                v-model="form.receiver_location"
                :options="[
                    'Barangay Poblacion',
                    'Barangay San Isidro',
                    'Barangay Agutaya',
                    'Barangay New Agutaya'
                ]"
                id="receiver_location" 
            />
            <label for="receiver_location">Receiver Location</label>
        </FloatLabel>
        <FloatLabel variant="on">
            <AddLocationModal :form="form" item-key="receiver_location_coordinates" />
            <label for="receiver_location">Select location from map</label>
        </FloatLabel>
        <FloatLabel variant="on">
            <InputText 
                class="w-full" 
                v-model="form.receiver_full_name" 
                id="receiver_full_name" 
            />
            <label for="receiver_full_name">Full Name</label>
        </FloatLabel>
        <FloatLabel variant="on">
            <InputText 
                class="w-full" 
                v-model="form.receiver_phone" 
                id="receiver_phone" 
            />
            <label for="receiver_phone">Phone Number</label>
        </FloatLabel>
        <FloatLabel variant="on">
            <Textarea 
                v-model="form.receiver_note" 
                class="w-full"
                id="receiver_note" 
                rows="3" 
            />
            <label for="receiver_note">Note</label>
        </FloatLabel>
    </div>
</template>