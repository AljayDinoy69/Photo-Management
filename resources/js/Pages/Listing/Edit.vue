<script setup>
import Container from '@/Components/Container.vue';
import Title from '@/Components/Title.vue';
import InputField from '@/Components/InputField.vue';
import TextArea from '@/Components/TextArea.vue';
import ImageUpload from '@/Components/ImageUpload.vue';
import PrimaryBtn from '@/Components/PrimaryBtn.vue';
import ErrorMessages from '@/Components/ErrorMessages.vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({ listing: Object });

const form = useForm({
    title: props.listing.title,
    desc: props.listing.desc,
    tags: props.listing.tags,
    email: props.listing.email,
    link: props.listing.link,
    image: null,
    _method: 'PUT',

})
</script>

<template>
    <Head title="- Edit Image" />

    <Container>
        <div class="mb-6">
            <Title>Edit Image</Title>
        </div>

        <ErrorMessages :errors="form.errors"/>

        <form @submit.prevent="form.post(route('listing.update', listing.id))"
        class="grid grid-cols-2 gap-6">

        <div class="space-y-6">
            <InputField 
                label="Title"
                icon="fa-solid fa-heading"
                placeholder="My new listing"
                v-model="form.title"
            />

            <InputField 
                label="Tags (Separated with commas)"
                icon="fa-solid fa-tag"
                placeholder="one, two, three"
                v-model="form.tags"
            />

            <TextArea 
                label="Description"
                icon="fa-solid fa-file-lines"
                placeholder="My new listing description"
                v-model="form.desc"
            />
        </div>

        <div class="space-y-6">
            <InputField 
                label="Email"
                icon="fa-solid fa-at"
                placeholder="example@email.com"
                v-model="form.email"
            />

            <InputField 
                label="Link"
                icon="fa-solid fa-link"
                placeholder="https://example.com"
                v-model="form.link"
            />

            <ImageUpload 
               @image="(e) => form.image = e" :listingImage="listing.image"
            />
        </div>

        <div>
            <PrimaryBtn :disabled="form.processing" type="submit">
                Update Image
            </PrimaryBtn>
        </div>

        </form>
    </Container>
</template>