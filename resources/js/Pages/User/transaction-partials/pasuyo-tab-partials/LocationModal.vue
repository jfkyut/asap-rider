<script setup>

import { Button } from 'primevue';
import LocationMapModal from '@/Components/LocationMapModal.vue';
import { ref, watch } from 'vue';

defineProps({
    pasuyo: Object,
});

const isShowModal = ref(false);

const myLocation = ref(null);

function getLocation() {

    console.log('I am being called.');


    if (navigator.geolocation) {
        // Geolocation is supported, proceed to get position
        navigator.geolocation.getCurrentPosition((position) => {
            myLocation.value = {
                latitude: position.coords.latitude,
                longitude: position.coords.longitude,
            };
        }, (error) => {
            console.error("Error getting location: ", error);
            alert("Unable to retrieve your location.");
        });
    } else {
        // Geolocation is not supported
        alert("Geolocation is not supported by this browser.");
    }
}

watch(isShowModal, (isShowModal) => {
    if (isShowModal) {
        getLocation();

        console.log(myLocation.value);

    }
});

</script>

<template>
    <Button
        @click="isShowModal = true"
        label="View on Map"
        severity="info"
        size="small"
        variant="outlined"
    />
    <LocationMapModal
        :coordinates="[
            pasuyo.location_coordinates
        ]"
        :show="isShowModal"
        :labels="[
            'Pasuyo Location'
        ]"
        @close="isShowModal = false"
    />
</template>
