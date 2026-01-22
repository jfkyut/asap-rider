<script setup>

import { FloatLabel, InputText, Select, Button, Textarea } from 'primevue';
import Modal from '@/Components/Modal.vue';
import { ref, Text } from 'vue';
import Map from '@/Components/Map.vue';
import AddLocationModal from '@/Components/AddLocationModal.vue';


defineProps({
    form: Object,
});

</script>

<template>
    <div class="flex flex-col h-auto">
        <div class="dark:border-surface-700 rounded bg-surface-50 dark:bg-surface-950 flex-auto flex justify-center items-center font-medium">
            <div class="space-y-2 w-full">
                
                <FloatLabel variant="on">
                    <InputText 
                        id="full_name" 
                        v-model="form.full_name" 
                        class="w-full" 
                        required 
                    />
                    <label for="full_name">Full Name</label>
                </FloatLabel>
                <FloatLabel variant="on">
                    <InputText 
                        id="phone" 
                        v-model="form.phone" 
                        class="w-full" 
                        required 
                    />
                    <label for="phone">Phone Number</label>
                </FloatLabel>
                <FloatLabel variant="on">
                    <Select 
                        v-model="form.location"
                        class="w-full"
                        :options="[
                            'Barangay Poblacion',
                            'Barangay San Isidro',
                            'Barangay Agutaya',
                            'Barangay New Agutaya'
                        ]"
                        required
                    />
                    <label for="location">Location</label>
                </FloatLabel>
                <FloatLabel variant="on">
                    <AddLocationModal :form="form" item-key="location_coordinates" />
                    <label for="location">Select location from map</label>
                </FloatLabel>
                <FloatLabel variant="on">
                    <Textarea 
                        id="note" 
                        v-model="form.note" 
                        class="w-full" 
                        auto-resize
                    />
                    <label for="note">Note (Optional)</label>
                </FloatLabel>
            </div>
        </div>
    </div>
</template>