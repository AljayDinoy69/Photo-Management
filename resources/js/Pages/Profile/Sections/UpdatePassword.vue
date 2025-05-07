<script setup>
import Container from '../../../Components/Container.vue'
import InputField from '../../../Components/InputField.vue'
import Title from '../../../Components/Title.vue'
import PrimaryBtn from '../../../Components/PrimaryBtn.vue'
import ErrorMessages from '../../../Components/ErrorMessages.vue'
import SessionMessages from '../../../Components/SessionMessages.vue'
import { useForm } from '@inertiajs/vue3'

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',    
});

const submit = () => {
    form.put(route('profile.password'), {
        onSuccess: () => form.reset(),
        onError: () => form.reset(),
        preserveScroll: true,
    });
};

</script>

<template>
    <Container class="mb-6">
        <div class="mb-6">
            <Title>Update Password</Title>
            <p>Update your account's password to enchance security.</p>
        </div>

        <ErrorMessages :errors="form.errors"/>

        <form @submit.prevent="submit" class="space-y-6">
            <InputField
                label="Current Password"
                icon="fa-key"
                class="w-1/2"
                type="password"
                v-model="form.current_password"
            />

            <InputField
                label="New Password"
                icon="fa-lock"
                class="w-1/2"
                type="password"
                v-model="form.password"
            />

            <InputField
                label="Confirm New Password"
                icon="fa-lock-open"
                class="w-1/2"
                type="password"
                v-model="form.password_confirmation"
            />

            <p v-if="form.recentlySuccessful" class="text-green-500 font-medium">Password succesfully updated!</p>

            <PrimaryBtn :disabled="form.processing">Save</PrimaryBtn>
        </form>
    </Container>
</template>
