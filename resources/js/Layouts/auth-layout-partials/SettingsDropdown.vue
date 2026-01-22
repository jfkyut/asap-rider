<script setup>

import { Button, Tab, ToggleSwitch } from 'primevue';
import { ref } from 'vue';
import Modal from '@/Components/Modal.vue';
import Container from '@/Components/Container.vue';
import { Link } from '@inertiajs/vue3';
import { storeToRefs } from 'pinia';
import { useTheme } from '@/Stores/theme';

const isShowModal = ref(false);

const { currentTheme, toggleTheme } = useTheme();

</script>

<template>
    <Tab class="flex-1" @click="isShowModal = true">
        <div class="w-full flex flex-col items-center justify-center">
            <i class="ri-settings-3-line"></i>
            <span class="text-xs mt-1">Settings</span>
        </div>
    </Tab>

    <Modal
        :show="isShowModal"
        @close="isShowModal = false"
        max-width="4xl"
    >
        <Container>
            <template #header>
                <div class="flex items-center justify-between">
                    <header>
                        <h3 class="text-xl font-semibold text-zinc-900 dark:text-white">
                            <i class="ri-settings-3-line"></i>
                            Settings
                        </h3>
                    </header>
                    <div class="gap-2 items-center flex">
                        <Button
                            label="Close"
                            icon="ri-close-line"
                            severity="secondary"
                            variant="outlined"
                            @click="isShowModal = false"
                        />
                    </div>
                </div>
            </template>
            <template #body>
                <div class="space-y-3">
                    <div>
                        <h4 class="text-sm font-semibold text-zinc-600 dark:text-zinc-400 mb-2 uppercase tracking-wide">Account</h4>
                        <ul class="space-y-2">
                            <li>
                                <Link 
                                    href="/profile"
                                    class="flex items-center gap-3 px-3 py-2 rounded-lg text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors"
                                >
                                    <i class="ri-user-line text-lg w-5"></i>
                                    <span>Profile Settings</span>
                                </Link>
                            </li>
                            <li>
                                <div class="flex items-center justify-between gap-3 px-3 py-2 rounded-lg text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors">
                                    <div class="flex gap-3 items-center">
                                        <i class="ri-moon-line text-lg w-5"></i>
                                        <span>Dark</span>
                                    </div>
                                    <ToggleSwitch v-model="currentTheme" @change="toggleTheme" />
                                </div>
                            </li>
                        </ul>
                    </div>
                    <hr class="border-zinc-200 dark:border-zinc-700" />
                    <ul class="space-y-2">
                        <li>
                            <Link 
                                href="/logout"
                                class="flex items-center gap-3 px-3 py-2 rounded-lg text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors w-full"
                                method="post"
                                as="button"
                            >
                                <i class="ri-logout-box-line text-lg w-5"></i>
                                <span>Logout</span>
                            </Link>
                        </li>
                    </ul>
                </div>
            </template>
        </Container>
    </Modal>
</template>