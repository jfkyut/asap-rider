<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { InputText, Button, FloatLabel } from 'primevue';

const form = useForm({
    name: '',
    email: '',
    phone: '',
    role: 'user',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Register" />

        <template #title>
            Create an account
        </template>

        <form @submit.prevent="submit">
            <div>

                <FloatLabel variant="on">
                    <InputText
                        id="name"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.name"
                        required
                        autofocus
                        autocomplete="name"
                    />
                    <InputLabel for="name" value="Name" />
                </FloatLabel>


                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="mt-4">
                <FloatLabel variant="on">
                    <InputLabel for="email" value="Email" />

                    <InputText
                        id="email"
                        type="email"
                        class="mt-1 block w-full"
                        v-model="form.email"
                        required
                        autocomplete="username"
                    />
                </FloatLabel>

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <FloatLabel variant="on">
                    <InputLabel for="phone" value="Phone (0998-765-4321)" />

                    <InputText
                        id="phone"
                        type="tel"
                        class="mt-1 block w-full"
                        v-model="form.phone"
                        required
                        autocomplete="username"
                    />
                </FloatLabel>

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <FloatLabel variant="on">
                    <InputLabel for="password" value="Password" />

                    <InputText
                        id="password"
                        type="password"
                        class="mt-1 block w-full"
                        v-model="form.password"
                        required
                        autocomplete="new-password"
                    />
                </FloatLabel>

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                

                <FloatLabel variant="on">
                    <InputText
                        id="password_confirmation"
                        type="password"
                        class="mt-1 block w-full"
                        v-model="form.password_confirmation"
                        required
                        autocomplete="new-password"
                    />
                    <InputLabel
                        for="password_confirmation"
                        value="Confirm Password"
                    />
                </FloatLabel>

                <InputError
                    class="mt-2"
                    :message="form.errors.password_confirmation"
                />
            </div>

            <div class="mt-4">
                <Button
                    type="submit"
                    :loading="form.processing"
                    class="w-full"
                >
                    Register
                </Button>

                <div class="mt-2">
                    <Link
                        :href="route('login')"
                        class="ms-auto text-sm font-medium text-fg-brand hover:underline"
                    >
                        Already registered?
                    </Link>
                </div>
            </div>
        </form>
    </GuestLayout>
</template>
