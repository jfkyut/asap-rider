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
                v-model="form.sender_location"
                :options="[
                    'Barangay Poblacion',
                    'Barangay San Isidro',
                    'Barangay Agutaya',
                    'Barangay New Agutaya'
                ]"
                id="sender_location" 
            />
            <label for="sender_location">Sender Location</label>
        </FloatLabel>

        <FloatLabel variant="on">
            <AddLocationModal :form="form" item-key="sender_location_coordinates" />
            <label for="sender_location">Select location from map</label>
        </FloatLabel>
        
        <FloatLabel variant="on">
            <InputText 
                class="w-full" 
                v-model="form.sender_full_name" 
                id="sender_full_name" 
            />
            <label for="sender_full_name">Full Name</label>
        </FloatLabel>
        <FloatLabel variant="on">
            <InputText 
                class="w-full" 
                v-model="form.sender_phone" 
                id="sender_phone" 
            />
            <label for="sender_phone">Phone Number</label>
        </FloatLabel>
        <FloatLabel variant="on">
            <Textarea 
                v-model="form.sender_note" 
                class="w-full"
                id="sender_note" 
                rows="3" 
            />
            <label for="sender_note">Note</label>
        </FloatLabel>
    </div>
</template>