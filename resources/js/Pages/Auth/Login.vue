<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { InputText, Button, FloatLabel } from 'primevue';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    role: 'user',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Login" />

        <template #title>
            Log in to your account
            </template>

        <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit">
            <div>

                <FloatLabel variant="on">
                    <InputText
                        id="email"
                        type="email"
                        class="mt-1 block w-full"
                        v-model="form.email"
                        required
                        autofocus
                        autocomplete="username"
                    />
                    <InputLabel for="email" value="Email" />
                </FloatLabel>


                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">

                <FloatLabel variant="on">
                    <InputText
                        id="password"
                        type="password"
                        class="mt-1 block w-full"
                        v-model="form.password"
                        required
                        autocomplete="current-password"
                    />
                    <InputLabel for="password" value="Password" />
                </FloatLabel>


                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4 flex">
                <label class="flex items-center">
                    <Checkbox name="remember" v-model:checked="form.remember" />
                    <span class="ms-2 text-sm text-gray-600 dark:text-gray-400"
                        >Remember me</span
                    >
                </label>
                <Link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="ms-auto text-sm font-medium text-fg-brand hover:underline"
                >
                    Forgot your password?
                </Link>
            </div>

            <div class="mt-4">
                <Button
                    type="submit"
                    class="w-full uppercase"
                    :loading="form.processing"
                >
                    Login
                </Button>
                <div class="mt-2">
                    <Link
                        v-if="canResetPassword"
                        :href="route('register')"
                        class="ms-auto text-sm font-medium text-fg-brand hover:underline"
                    >
                        Create an account
                    </Link>
                </div>
            </div>
        </form>
    </GuestLayout>
</template>
