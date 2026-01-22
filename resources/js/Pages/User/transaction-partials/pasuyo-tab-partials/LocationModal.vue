<script setup>

import { Button } from 'primevue';
import LocationMapModal from '@/Components/LocationMapModal.vue';
import { ref } from 'vue';

defineProps({
    pasuyo: Object,
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
            pasuyo.location_coordinates
        ]"
        :show="isShowModal"
        :labels="[
            'Pasuyo Location'
        ]"
        @close="isShowModal = false"
    />
</template>
