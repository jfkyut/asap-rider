<script setup>

import { InputText, Button } from 'primevue';
import Modal from './Modal.vue';
import { ref, toRefs } from 'vue';
import Map from './Map.vue';
import Container from './Container.vue';

const props = defineProps({
    form: Object,
    itemKey: {
        type: String,
        default: () => 'coordinates',
    }
})

const { form, itemKey } = toRefs(props);

const isShowModal = ref(false);
const isShowConfirmationModal = ref(false);
const pickedCoordinate = ref(null);
const drawingEnabled = ref(false);
const vectorSourceComponent = ref(null);

const handleDrawEnd = (event) => {
    const feature = event.feature;
    const geometry = feature.getGeometry();
    const coordinates = geometry.getCoordinates();
    
    pickedCoordinate.value = coordinates;
    form.value[itemKey.value] = coordinates.join(', ');
    
    console.log('Point drawn at:', pickedCoordinate.value);

    toggleDrawing(false);

    setTimeout(() => {
        isShowConfirmationModal.value = true;
    }, 1000);
};

const toggleDrawing = (active) => {
    drawingEnabled.value = active;
};

</script>

<template>
    <InputText 
        v-model="form[itemKey]"
        class="w-full"
        @click="isShowModal = true"
        readonly
    />

    <Modal
        max-width="4xl"
        :show="isShowModal"
        @close="isShowModal = false"
    >
        <Map>
            <ol-vector-layer>
                <ol-source-vector ref="vectorSourceComponent" projection="EPSG:4326" />

                <ol-interaction-draw
                    v-if="drawingEnabled && vectorSourceComponent"
                    :source="vectorSourceComponent.source"
                    type="Point"
                    @drawend="handleDrawEnd"
                />

                <ol-feature v-if="form[itemKey]">
                    <ol-geom-point :coordinates="form[itemKey]" />
                    <ol-style>
                        <ol-style-circle :radius="8">
                            <ol-style-fill color="rgba(59, 130, 246, 0.8)" />
                            <ol-style-stroke color="#1e40af" :width="2" />
                        </ol-style-circle>
                    </ol-style>
                </ol-feature>
            </ol-vector-layer>

            <template #control-bar>
                <ol-control-bar>
                    <ol-toggle-control
                        className="edit"
                        title="Draw Point to pick coordinates"
                        @toggle="toggleDrawing"
                        html="<i class='ri-map-pin-2-line'></i>"
                    />
                    <ol-print-dialog-control />
                </ol-control-bar>
            </template>
        </Map>
    </Modal>

    <Modal
        :show="isShowConfirmationModal"
        @close="isShowConfirmationModal = false"
    >
        <Container>
            <template #header>
                <div class="flex items-center gap-3">
                    <div class="flex items-center justify-center w-10 h-10 rounded-full bg-green-100 dark:bg-green-900/30">
                        <i class="ri-check-line text-xl text-green-600 dark:text-green-400"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-zinc-900 dark:text-white">Location Confirmed</h2>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400">Coordinate saved successfully</p>
                    </div>
                </div>
            </template>
            <template #body>
                <div class="space-y-4">
                    <!-- Coordinates Display -->
                    <div class="p-4 rounded-lg bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800">
                        <p class="text-xs font-semibold text-zinc-600 dark:text-zinc-400 mb-2">COORDINATES</p>
                        <p class="text-sm font-mono text-green-700 dark:text-green-300">{{ form[itemKey] }}</p>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-3 justify-end pt-4 border-t border-zinc-200 dark:border-zinc-700">
                        <button
                            @click="isShowConfirmationModal = false"
                            class="px-4 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 bg-zinc-100 dark:bg-zinc-800 rounded-lg hover:bg-zinc-200 dark:hover:bg-zinc-700 transition-colors"
                        >
                            Back to Map
                        </button>
                        <button
                            @click="() => { isShowConfirmationModal = false; isShowModal = false; }"
                            class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 transition-colors"
                        >
                            Done
                        </button>
                    </div>
                </div>
            </template>
        </Container>
    </Modal>
</template>