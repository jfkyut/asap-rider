<script setup>
import { onMounted, ref, toRefs } from 'vue';

const props = defineProps({
    coordinates: {
        type: Array,
        default: () => null,
    }
})

const { coordinates } = toRefs(props);

const center = ref(coordinates.value || [119.28242077814251, 10.5183862756608]);
const projection = ref('EPSG:4326');
const zoom = ref(10);

const layerList = ref([]);
const map = ref(null);

const jawgLayer = ref(null);
const satellite = ref(null);
const terrain = ref(null);

const emit = defineEmits(['mapClick']);

onMounted(() => {
    layerList.value.push(jawgLayer.value.tileLayer);
    layerList.value.push(satellite.value.tileLayer);
    layerList.value.push(terrain.value.tileLayer);

    // Setup map click handler
    if (map.value?.map) {
        map.value.map.on('click', (event) => {
            emit('mapClick', event.coordinate);
        });
    }
})

</script>

<template>
    <OlMap 
        ref="map" 
        style="min-width: 150px; height: 400px;"
        :loadTilesWhileAnimating="true"
        :loadTilesWhileInteracting="true"
    >
        <OlView 
            ref="view"
            :center="center" 
            :zoom="zoom" 
            :projection="projection" 
        />
        

        <ol-tile-layer ref="satellite" title="Satellite">
            <ol-source-xyz
                crossOrigin="anonymous"
                url="https://api.maptiler.com/maps/hybrid-v4/{z}/{x}/{y}.jpg?key=89l0WeFyko0hOSnezK2x"
            />
        </ol-tile-layer>

        <ol-tile-layer ref="jawgLayer" title="JAWG">
            <ol-source-xyz
                crossOrigin="anonymous"
                url="https://c.tile.jawg.io/jawg-terrain/{z}/{x}/{y}.png?access-token=9QWHp8FVOujnLDHXZGlml5yIisJOKoy55DOcjFpdXQWvBZeAce662c8rD0rKSBcT"
            />
        </ol-tile-layer>

        <ol-tile-layer ref="terrain" title="Terrain">
            <ol-source-xyz
                crossOrigin="anonymous"
                url="https://c.tile.jawg.io/jawg-dark/{z}/{x}/{y}.png?access-token=9QWHp8FVOujnLDHXZGlml5yIisJOKoy55DOcjFpdXQWvBZeAce662c8rD0rKSBcT"
            />
        </ol-tile-layer>

        <ol-tile-layer ref="terrain" title="Terrain">
            <ol-source-xyz
                crossOrigin="anonymous"
                url="https://c.tile.jawg.io/jawg-streets/{z}/{x}/{y}.png?access-token=9QWHp8FVOujnLDHXZGlml5yIisJOKoy55DOcjFpdXQWvBZeAce662c8rD0rKSBcT"
            />
        </ol-tile-layer>

        <OlTileLayer>
            <OlSourceOSM />
        </OlTileLayer>

        <ol-zoom-to-extent-control 
            tipLabel="Fit to San Vicente" 
            :extent="[119.20, 10.45, 119.36, 10.58]"
        />

        <OlFullScreenControl />
        

        <ol-layer-switcher-image-control v-if="layerList.length > 0" />

        <slot name="control-bar" />

        <slot />
    </OlMap>
</template>
