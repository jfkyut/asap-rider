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
            pickAndDrop?.receiver_location_coordinates
        ]"
        :show="isShowModal"
        @close="isShowModal = false"
    />
</template>
