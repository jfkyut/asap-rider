<script setup>

import { Button } from 'primevue';
import { ref } from 'vue';
import LocationMapModal from '@/Components/LocationMapModal.vue';

defineProps({
    pickAndDrop: Object,
});

const isShowModal = ref(false);

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
            pickAndDrop?.sender_location_coordinates,
            pickAndDrop?.receiver_location_coordinates
        ]"
        :labels="[
            'Pick-up Location',
            'Drop Location'
        ]"
        :show="isShowModal"
        @close="isShowModal = false"
    />
</template>
