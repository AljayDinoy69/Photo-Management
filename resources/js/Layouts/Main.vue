<script setup>
import { ref, computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import { switchTheme } from '../theme';
import NavLink from '../Components/NavLink.vue';

const page = usePage(); 
const user = computed(() => page.props.auth.user); 

const show = ref(false);
</script>

<template>
    <div v-show="show" @click="show = false" class="fixed inset-0 z-40"></div>
    <header class="bg-slate-800 text-white">
        <nav class="p-6 mx-auto max-w-screen-lg flex items-center justify-between">

            <div class="flex items-center space-x-6">
                <h1 class="text-2xl font-bold"> D.Squared</h1>
                <NavLink routeName="home" componentName="Home"><i class="fa fa-house"></i> Home</NavLink>
            </div>

            <div class="flex items-center space-x-6">
                
                <div v-if="user" class="relative">
                    <div @click="show = !show" class="flex items-center gap-2 px-3 py-1 rounded-lg hover:bg-slate-700 cursor-pointer">
                        <p>{{ user.name }}</p>
                        <i class="fa-solid fa-sort-down"></i>
                    </div>

                    <div v-show="show" @click="show=false" class="absolute z-50 top-16 right-0 bg-slate-800 text-white rounded-lg border-slate-100 border overflow-hidden w-40">
                        <Link :href="route('listing.create')" class="block w-full px-6 py-3 hover:bg-slate-700 text-left"><i class="fa fa-user"></i> New Listing</Link>
                        <Link :href="route('profile.edit')" class="block w-full px-6 py-3 hover:bg-slate-700 text-left"><i class="fa fa-user"></i> Profile</Link>
                        <Link :href="route('dashboard')" class="block w-full px-6 py-3 hover:bg-slate-700 text-left"><i class="fa fa-house-user"></i> Dashboard</Link>
                        <Link :href="route('logout')" method="post" as="button" class="block w-full px-6 py-3 hover:bg-slate-700 text-left"><i class="fa fa-right-from-bracket"></i> Logout</Link>
                    </div>
                </div>

                <div v-else class="space-x-6">
                    <NavLink routeName="login" componentName="Auth/Login">Login</NavLink>
                    <NavLink routeName="register" componentName="Auth/Register">Register</NavLink>
                </div>

                <button
                    @click="switchTheme"
                    class="hover:bg-slate-700 w-6 h-6 grid place-items-center rounded-full hover:outline outline-1 outline-white"
                >
                    <i class="fa-solid fa-moon"></i>
                </button>
            </div>
        </nav>
    </header>

    <main class="p-6 mx-auto max-w-screen-lg">
        <slot />
    </main>
</template>
