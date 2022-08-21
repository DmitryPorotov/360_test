<script setup>
    import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
    import { Head } from '@inertiajs/inertia-vue3';

    import VButton from '../Components/Button.vue'
</script>

<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="nav-buttons">
                            <a href="#/projects"><v-button type="button">All projects</v-button></a>
                            <a href="#/todos"><v-button type="button">All TODOs</v-button></a>
                        </div>
                        <component :is="currentView" />
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<style>
    .nav-buttons {
        margin-bottom: 1rem;
    }
    .nav-buttons a {
        margin-right: 1rem;
    }
</style>

<script>

    import ProjectsList from "../Components/ProjectsList";
    import TodoList from "../Components/TodoList";

    const routes = {
        '/projects': ProjectsList,
        '/todos': TodoList
    }

    export default {
        data() {
            return {
                currentPath: window.location.hash
            }
        },
        computed: {
            currentView() {
                return routes[this.currentPath.slice(1) || '/']
            }
        },
        mounted() {
            window.addEventListener('hashchange', () => {
                this.currentPath = window.location.hash
            })
        }
    }
</script>
