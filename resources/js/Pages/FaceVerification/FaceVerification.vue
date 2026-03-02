<script setup>

import { ref } from 'vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Button } from 'primevue';
import { useForm, Head, router } from '@inertiajs/vue3';
import { useToast } from 'vue-toastification';

const videoRef = ref(null);
const canvasRef = ref(null);
const isVideoActive = ref(false);
const capturedImage = ref(null);
const capturedImageFile = ref(null);
const currentStream = ref(null);
const toast = useToast();

const form = useForm({
    face_image: null,
});

const startFaceVerification = async () => {
    try {
        if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
            const stream = await navigator.mediaDevices.getUserMedia({
                video: {
                    width: { ideal: 1280 },
                    height: { ideal: 720 }
                }
            });

            currentStream.value = stream;
            videoRef.value.srcObject = stream;
            isVideoActive.value = true;
        } else {
            alert("Camera not supported in this browser.");
        }
    } catch (err) {
        console.error("Error accessing webcam: ", err);
        alert("Unable to access camera. Please check permissions.");
    }
};

const capturePhoto = () => {
    if (videoRef.value && canvasRef.value) {
        const context = canvasRef.value.getContext('2d');
        const video = videoRef.value;

        canvasRef.value.width = video.videoWidth;
        canvasRef.value.height = video.videoHeight;

        context.drawImage(video, 0, 0, video.videoWidth, video.videoHeight);

        // Convert canvas to blob and create File object
        canvasRef.value.toBlob((blob) => {
            const file = new File([blob], `face-verification-${Date.now()}.jpg`, { type: 'image/jpeg' });
            capturedImageFile.value = file;

            // Also create a preview URL from the blob
            capturedImage.value = URL.createObjectURL(blob);

            console.log(capturedImageFile.value);
        }, 'image/jpeg', 0.95);
    }
};

const stopCamera = () => {
    if (currentStream.value) {
        currentStream.value.getTracks().forEach(track => track.stop());
        currentStream.value = null;
        isVideoActive.value = false;
    }
    if (capturedImage.value) {
        URL.revokeObjectURL(capturedImage.value);
        capturedImage.value = null;
        capturedImageFile.value = null;
    }
};

const retakePhoto = () => {
    if (capturedImage.value) {
        URL.revokeObjectURL(capturedImage.value);
    }
    capturedImage.value = null;
    capturedImageFile.value = null;
    startFaceVerification();
};

const submitPhoto = async () => {
    if (!capturedImageFile.value) {
        alert("No photo captured to submit.");
        return;
    }

    form.face_image = capturedImageFile.value;

    form.post(route('face-verification.store'), {
        onSuccess: () => {
            toast.success("Face verification photo submitted successfully!");
            stopCamera();
        },
        onError: (errors) => {
            console.error("Submission error: ", errors);
            toast.error("Failed to submit photo. Please try again.");
        }
    });
};

</script>

<template>
    <Head title="Face Verification" />

    <GuestLayout>
        <div class="mx-auto">
            <h1 class="text-3xl font-bold mb-2">Face Verification</h1>
            <p class="text-gray-600 mb-6">Capture a clear photo of your face for verification</p>

            <!-- Video Stream Section -->
            <div v-if="!capturedImage" class="max-w-md mx-auto">
                <div class="bg-gray-900 rounded-lg overflow-hidden mb-6">
                    <video
                        ref="videoRef"
                        class="w-full aspect-video object-cover"
                        autoplay
                        playsinline
                        muted
                    ></video>
                </div>

                <div class="space-y-3">
                    <Button
                        v-if="!isVideoActive"
                        @click="startFaceVerification"
                        class="w-full"
                        label="Start Camera"
                        severity="info"
                    />
                    <Button
                        v-if="isVideoActive"
                        @click="capturePhoto"
                        class="w-full"
                        label="Capture Photo"
                        severity="success"
                    />
                    <Button
                        v-if="isVideoActive"
                        @click="stopCamera"
                        class="w-full"
                        label="Cancel"
                        severity="secondary"
                    />
                </div>
            </div>

            <!-- Captured Image Preview Section -->
            <div v-else class="max-w-md mx-auto">
                <div class="bg-gray-100 rounded-lg overflow-hidden mb-6">
                    <img
                        :src="capturedImage"
                        alt="Captured face"
                        class="w-full aspect-video object-cover"
                    />
                </div>

                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                    <p class="text-sm text-blue-800">
                        ✓ Photo captured successfully. You can now use this image for verification.
                    </p>
                </div>

                <div class="space-y-3">
                    <Button
                        @click="retakePhoto"
                        class="w-full"
                        label="Retake Photo"
                        severity="secondary"
                    />
                    <Button
                        @click="submitPhoto"
                        class="w-full"
                        label="Submit"
                        severity="success"
                    />
                </div>
            </div>

            <div class="my-2">
                <Button
                    @click="router.post(route('logout'))"
                    severity="danger"
                    variant="outlined"
                    class="w-full"
                    label="Log Out"
                />
            </div>

            <!-- Hidden Canvas for Image Capture -->
            <canvas ref="canvasRef" class="hidden"></canvas>
        </div>
    </GuestLayout>
</template>
