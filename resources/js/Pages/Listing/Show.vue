<script setup>

import Container from '@/Components/Container.vue'
import { Link, router } from '@inertiajs/vue3';

const props = defineProps({
    listing: Object,
    user: Object,
    canModify: Boolean,
});

const deleteListing = () => {
    if (confirm('Are you sure you want to delete this image?')) {
        router.delete(route('listing.destroy', props.listing.id), {
        });
    }
}

</script>

<template>
    <Head title="- Listing Details"/>
   <Container class="flex gap-4">
    <div class="w-1/4 rounded-md overflow-hidden">
        <img :src="listing.image ? `/storage/${listing.image}` : '/storage/images/listing/default.jpg'"
        class="w-full h-full object-cover object-center" alt="">
    </div>

    <div class="w-3/4">

        <!-- listing info -->
         <div class="mb-6">
            <div class="flex items-end justify-between mb-2">
                <p class="text-slate-400 w-full border-b">Image Details</p>

                <div v-if="canModify" class="pl-4 flex items-center gap-4">
                    <Link :href="route('listing.edit', listing.id)" class="bg-green-500 rounded-md text-white px-6 py-2 
                    hover:outline outline-green-500 outline-offset-2">Edit</Link>

                    <button @click="deleteListing" class="bg-red-500 rounded-md text-white px-6 py-2 
                    hover:outline outline-red-500 outline-offset-2" type="button">Delete</button>
                </div>
            </div>

            <h3 class="text-2xl font-bold mb-2">{{ listing.title }}</h3>
            <p class="text-slate-500">{{ listing.desc }}</p>
         </div>

         <div class="mb-6">
                <p class="text-slate-400 w-full border-b">Contact Info</p>

                <div v-if="listing.email" class="flex items-center gap-2 text-slate-300 mb-2 pt-4">
                    <i class="fa-solid fa-at"></i>
                    <p>Email:</p>
                    <a :href="`mailto:${listing.email}`" class="text-link">
                        {{ listing.email }}
                    </a>
                </div>

                <div v-if="listing.link" class="flex items-center gap-2 text-slate-300 mb-2">
                    <i class="fa-solid fa-link"></i>
                    <p>External Link:</p>
                    <a :href="listing.link" target="_blank" class="text-link">
                        {{ listing.link }}
                    </a>
                </div>

                <div class="flex items-center gap-2 text-slate-300 mb-2">
                    <i class="fa-solid fa-user"></i>
                    <p>Listed By:</p>
                    <Link :href="route('home', { user_id: user.id})" class="text-link">{{ user.name }}</Link>
                </div>
            </div>
             
            <div v-if="listing.tags" class="mb-6">
                <p class="text-slate-400 w-full border-b mb-2">Tags</p>

                <div class="flex items-center gap-3">
                    <div v-for="tag in listing.tags.split(',')" :key="tag">

                        <Link
                        :href="route('home', { tag })"
                        class="bg-slate-500 text-white px-2 py-px rounded-full 
                        hover:bg-slate-700 dark:hover:bg-salte-900">
                        {{ tag }}
                        </Link>
                    </div>
                </div>
            </div>
        </div>
   </Container>
</template>