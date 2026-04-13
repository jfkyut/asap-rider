import axios from 'axios';
import { ref } from 'vue';

export const useDistance = () => {
    const OPEN_ROUTE_SERVICE_KEY = import.meta.env.VITE_OPEN_ROUTE_SERVICE_KEY || '';

    const isLoadingDistance = ref(false);

    const parseCoordinates = (coord) => {
        if (typeof coord === 'string') {
            return coord.split(',').map(c => parseFloat(c.trim()));
        }
        return coord;
    };

    const fetchDistance = async (...coordinatesArgs) => {
        // Handle both fetchDistance(coord1, coord2, coord3...) and fetchDistance([coord1, coord2, coord3...])
        let coordinates = coordinatesArgs;
        
        // If first argument is an array, use that as coordinates
        if (coordinatesArgs.length === 1 && Array.isArray(coordinatesArgs[0])) {
            coordinates = coordinatesArgs[0];
        }

        // Filter out null/undefined values
        coordinates = coordinates.filter(coord => coord !== null && coord !== undefined);

        if (coordinates.length < 2) {
            return null;
        }

        try {
            isLoadingDistance.value = true;

            const parsedCoordinates = coordinates.map(coord => parseCoordinates(coord));

            // Validate all coordinates have at least 2 values (lat, lon)
            if (parsedCoordinates.some(coord => !coord || coord.length < 2)) {
                return null;
            }

            const response = await axios.post(
                'https://api.openrouteservice.org/v2/directions/driving-car/geojson',
                {
                    coordinates: parsedCoordinates
                },
                {
                    headers: {
                        'Authorization': OPEN_ROUTE_SERVICE_KEY,
                        'Content-Type': 'application/json',
                    }
                }
            );

            if (response.data.features && response.data.features.length > 0) {
                const properties = response.data.features[0].properties;
                if (properties && properties.summary) {
                    // Convert meters to kilometers
                    return (properties.summary.distance || 0) / 1000;
                }
            }

            return null;
        } catch (error) {
            console.error('Error fetching distance:', error);
            return null;
        } finally {
            isLoadingDistance.value = false;
        }
    };

    return {
        fetchDistance,
        isLoadingDistance,
    };
};
