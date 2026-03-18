<script setup>
import { ref, onMounted } from 'vue';
import Modal from './Modal.vue';
import Container from './Container.vue';
import { Button } from 'primevue';

const showModal = ref(false);
const accepted = ref(false);

onMounted(() => {
    // Check if terms have been accepted before
    const termsAccepted = localStorage.getItem('termsAccepted');
    if (!termsAccepted) {
        showModal.value = true;
    }
});

const acceptTerms = () => {
    localStorage.setItem('termsAccepted', 'true');
    accepted.value = true;
    showModal.value = false;
    // Optionally emit to parent if needed
    // emit('accepted');
};
</script>

<template>
    <Modal :show="showModal" @close="showModal = false" :closeable="false">
        <Container>
            <template #header>
                <h2 class="text-lg font-medium text-gray-900 dark:text-white">
                    Terms and Conditions
                </h2>
            </template>

            <template #body>
                <div class="text-sm text-gray-600 dark:text-gray-200 space-y-4 max-h-64 overflow-y-auto">
                    <p>
                        You can now book an errand or pasuyo with us in just a few simple steps. Simply provide the basic information for the items you would like us to get for you.
                    </p>
                    <p>
                        How It Works: Since the exact cost of the goods is not known beforehand, the final rate will be reflected in the order details once the rider has completed the purchase.
                    </p>
                    <p>
                        Please refer to the details below:
                    </p>
                    <p>
                        Delivery Fee: PHP 15 per and below 1 KM
                    </p>
                </div>
            </template>

            <template #footer>
                <div class="flex justify-end">
                    <Button
                        label="Accept Terms"
                        @click="acceptTerms"
                    />
                </div>
            </template>
        </Container>
    </Modal>
</template>