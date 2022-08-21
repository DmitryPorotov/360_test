<script>
    import ProjectsListItem from "./ProjectsListItem";
    import VButton from './Button'
    import VInput from './Input'
    import InputError from './InputError'
    export default {
        components: {ProjectsListItem, VButton, VInput, InputError},
        data() {
            return {
                projects: [],
                isShowNewProjectForm: false,
                newProjectName: "",
                errorMessage: ""
            }
        },
        mounted() {
            this.getProjects()
        },
        methods: {
            addProject() {
                axios.post('/api/project', {
                    name: this.newProjectName
                })
                .then(resp => {
                    if(resp.data.success) {
                        this.isShowNewProjectForm = false
                        this.getProjects()
                    }
                    else {
                        this.errorMessage = resp.data.message
                    }
                })
            },
            getProjects() {
                axios.get('/api/project').then(
                    data => this.projects = data.data
                )
            }
        }
    }
</script>

<template>
    <h2>
        Projects:
    </h2>
    <section class="projects">
        <projects-list-item v-for="project in projects">
            {{project.name}}
        </projects-list-item>
        <projects-list-item v-show="isShowNewProjectForm">
            <div class="name-container">
                <v-input placeholder="New project name" @update:modelValue="this.newProjectName=$event"/>
                <input-error class="" :message="this.errorMessage"/>
            </div>
            <v-button @click="this.addProject">Save</v-button>&nbsp;
            <v-button @click="this.isShowNewProjectForm=false">Cancel</v-button>
        </projects-list-item>
    </section>
    <v-button @click="this.isShowNewProjectForm=true">+</v-button>
</template>

<style>
    .projects {
        margin: 0.5rem 0;
    }
    .project-list-item .name-container {
        margin-right: 0.5rem;
        display: flex;
        flex-direction: column;
        flex-grow: 5;
    }

</style>
