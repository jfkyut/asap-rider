<script setup>

import Modal from './Modal.vue';
import Map from './Map.vue';
import { ref, computed, watch, toRefs } from 'vue';
import Overlay from 'ol/Overlay';
import axios from 'axios';

const props = defineProps({
    coordinates: {
        type: Array,
        default: () => [],
    },
    show: {
        type: Boolean,
        default: () => false,
    },
    labels: {
        type: Array,
        default: () => [],
    },
})

const { coordinates, show, labels } = toRefs(props);

const vectorSource = ref(null);
const visibleLabels = ref(new Set());
const isLoadingRoute = ref(false);
const routeCoordinates = ref([]);
const routeDistance = ref(null);
const routeDuration = ref(null);

const OPEN_ROUTE_SERVICE_KEY = import.meta.env.VITE_OPEN_ROUTE_SERVICE_KEY || '';

const parsedCoordinates = computed(() => {
    if (!coordinates.value || coordinates.value.length === 0) return [];
    return coordinates.value.map(coord => {
        if (typeof coord === 'string') {
            return coord.split(',').map(c => parseFloat(c.trim()));
        }
        return coord;
    });
})

watch(() => show.value, (newVal) => {
    if (newVal) {
        // Show all labels by default when modal opens
        visibleLabels.value = new Set(parsedCoordinates.value.map((_, i) => i));
    } else {
        visibleLabels.value.clear();
    }
})

const toggleLabel = (index) => {
    if (visibleLabels.value.has(index)) {
        visibleLabels.value.delete(index);
    } else {
        visibleLabels.value.add(index);
    }
}

const isLabelVisible = (index) => {
    return visibleLabels.value.has(index);
}

watch(show, (show) => {
    if (show) {
        isLoadingRoute.value = true;

        // If there are exactly two coordinates, fetch route data
        if (parsedCoordinates.value.length >= 2) {

            axios.post('https://api.openrouteservice.org/v2/directions/driving-car/geojson', {
                coordinates: parsedCoordinates.value
            }, {
                headers: {
                    'Authorization': OPEN_ROUTE_SERVICE_KEY,
                    'Content-Type': 'application/json',
                }
            }).then(response => {
                const routeGeoJSON = response.data;
                // Extract route coordinates from the geometry
                if (routeGeoJSON.features && routeGeoJSON.features.length > 0) {
                    const geometry = routeGeoJSON.features[0].geometry;
                    const properties = routeGeoJSON.features[0].properties;
                    if (geometry.type === 'LineString') {
                        routeCoordinates.value = geometry.coordinates;
                    }
                    // Extract distance and duration from properties
                    if (properties) {
                        routeDistance.value = (properties.summary?.distance || 0) / 1000; // Convert to km
                        routeDuration.value = Math.round((properties.summary?.duration || 0) / 60); // Convert to minutes
                    }
                }
                console.log(routeGeoJSON);

            }).catch(error => {
                console.error('Error fetching route data:', error);
            }).finally(() => {
                isLoadingRoute.value = false;
            });
        } else {
            isLoadingRoute.value = false;
        }
    }
})

</script>

<template>
    <Modal
        max-width="4xl"
        :show="show"
        @close="$emit('close')"
    >
        <Map
            :coordinates="parsedCoordinates.length > 0 ? parsedCoordinates[0] : null"
        >
            <ol-vector-layer>
                <ol-source-vector ref="vectorSource">
                    <!-- Route Line -->
                    <ol-feature v-if="routeCoordinates.length > 0">
                        <ol-geom-line-string :coordinates="routeCoordinates" />
                        <ol-style>
                            <ol-style-stroke color="#3b82f6" :width="3" />
                        </ol-style>
                    </ol-feature>

                    <!-- Location Points -->
                    <ol-feature
                        v-for="(coordinates, index) in parsedCoordinates"
                        :key="index"
                        v-if="coordinates"
                    >
                        <ol-geom-point :coordinates="coordinates" />
                        <ol-style>
                            <ol-style-circle :radius="8">
                                <ol-style-fill color="rgba(59, 130, 246, 0.8)" />
                                <ol-style-stroke color="#1e40af" :width="2" />
                            </ol-style-circle>
                        </ol-style>
                    </ol-feature>
                </ol-source-vector>
            </ol-vector-layer>

            <!-- Clickable toggle button at each marker -->
            <ol-overlay
                v-for="(coordinates, index) in parsedCoordinates"
                :key="`toggle-${index}`"
                :position="coordinates"
                positioning="center-center"
            >
                <button
                    @click.stop="toggleLabel(index)"
                    class="w-3 h-3 bg-blue-500 hover:bg-blue-600 rounded-full flex items-center justify-center text-white text-xs font-bold cursor-pointer"
                    title="Click to toggle label"
                >
                    +
                </button>
            </ol-overlay>

            <!-- Popups for each location -->
            <ol-overlay
                v-for="(coordinates, index) in parsedCoordinates"
                v-show="isLabelVisible(index)"
                :key="`popup-${index}`"
                :position="coordinates"
                positioning="center-bottom"
                :offset="[8, -40]"
            >
                <div
                    class="bg-white px-3 py-2 rounded-es-none rounded-lg shadow-lg border border-gray-300 cursor-pointer hover:bg-gray-50"
                    @click.stop="toggleLabel(index)"
                >
                    <p class="text-xs font-semibold text-gray-800">
                        {{ labels[index] || `Location ${index + 1}` }}
                    </p>
                </div>
            </ol-overlay>

            <!-- Distance Display -->
            <ol-overlay
                v-if="routeCoordinates.length > 0 && routeDistance"
                :position="routeCoordinates[Math.floor(routeCoordinates.length / 2)]"
                positioning="center-center"
                :offset="[0, -50]"
            >
                <div
                    class="bg-gray-700 text-white px-4 py-2 rounded-lg shadow-lg font-semibold text-sm whitespace-nowrap"
                >
                    <span>📍 {{ routeDistance.toFixed(2) }} km</span>
                </div>
            </ol-overlay>

        </Map>
    </Modal>
</template>
