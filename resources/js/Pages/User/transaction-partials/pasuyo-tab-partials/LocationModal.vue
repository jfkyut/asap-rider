<script setup>

import { Button } from 'primevue';
import LocationMapModal from '@/Components/LocationMapModal.vue';
import { ref, watch } from 'vue';
import { useCommon } from '@/Composables/common';

defineProps({
    pasuyo: Object,
});

const { getMyLocation } = useCommon();

const isShowModal = ref(false);

const myLocation = ref(null);

const pickUpLocation  = async () => {
    try {
        myLocation.value = await getMyLocation();
        isShowModal.value = true;
        console.log('Location:', myLocation.value);
    } catch (error) {
        console.error('Failed to get location:', error);
        alert('Unable to retrieve your location. Make sure location permissions are enabled.');
    }
}

</script>

<template>
    <Button
        @click="pickUpLocation"
        label="Map"
        severity="info"
        size="small"
        icon="ri-map-pin-line"
        variant="outlined"
    />
    <LocationMapModal
        :coordinates="[
            pasuyo.location_coordinates,
            myLocation
        ]"
        :show="isShowModal"
        :labels="[
            'Pasuyo Location',
            'My Location'
        ]"
        @close="isShowModal = false"
    />
</template>
