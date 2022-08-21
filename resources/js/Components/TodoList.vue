<script>
    import TodoListItem from "./TodoListItem";
    import VButton from './Button'
    import VInput from './Input'
    import InputError from './InputError'

    export default {
        components: {TodoListItem,VButton,VInput,InputError},
        data() {
            return {
                todos: null,
                projects: null,
                isShowNewTodoForm: false,
                newTodoDescription: "",
                errorMessage: "",
                selectedProject: -1
            }
        },
        mounted() {
            this.loadTodos()
        },
        methods: {
            loadTodos() {
                axios.get('/api/todo')
                    .then(t => {
                        const mapTodos = p => {
                            this.todos = t.data.map(todo => {
                                todo.project_name = p.find(proj => {
                                    return proj.id === todo.project_id
                                }).name;
                                return todo;
                            });
                        };
                        if (!this.projects) {
                            axios.get('/api/project').then(({data: p}) => {
                                mapTodos(p);
                                this.projects = p
                            })
                        }
                        else {
                            mapTodos(this.projects)
                        }
                    })
            },
            deleteTodo(id) {
                axios.delete('/api/todo/' + id).then(resp => {
                    if (resp.data.success) {
                        this.todos = this.todos.filter(x => x.id !== id)
                    }
                })
            },
            projectSelected(evt) {
                this.selectedProject = parseInt(evt.target.value)
            },
            addTodo() {
                if (this.selectedProject === -1) {
                    this.errorMessage = "Please select a project";
                    return;
                }
                else if (!this.newTodoDescription) {
                    this.errorMessage = "Please fill in the description";
                    return;
                }
                else {
                    this.errorMessage = ""
                }
                axios.post('/api/todo', {
                    project_id: this.selectedProject,
                    description: this.newTodoDescription
                }).then(resp => {
                    if (resp.data.success) {
                        this.isShowNewTodoForm = false;
                        this.newTodoDescription = "";
                        this.selectedProject = -1;
                        this.loadTodos()
                    }
                    else {
                        this.errorMessage = resp.data.message
                    }
                })
            }
        }
    }
</script>

<template>
    <h2>
        TODOs:
    </h2>
    <section class="todos">
        <todo-list-item v-for="todo in todos"
                        :description="todo.description"
                        :is_done="todo.is_done"
                        :view_counter="todo.view_counter"
                        :id="todo.id"
                        :project_name="todo.project_name"
                        @deleteTodo="this.deleteTodo"
        />
    </section>
    <section class="todo-form todo-list-item" v-show="this.isShowNewTodoForm">
        <select :class="{'gray-select':this.selectedProject === -1}" @change="this.projectSelected" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
            <option value="-1">Select a project...</option>
            <option v-for="project in this.projects" :value="project.id">{{project.name}}</option>
        </select>
        <div class="description-container">
            <v-input placeholder="TODO description" @update:modelValue="this.newTodoDescription=$event"/>
            <input-error class="" :message="this.errorMessage"/>
        </div>
        <v-button @click="this.addTodo">Save</v-button>
        <v-button @click="this.isShowNewTodoForm=false">Cancel</v-button>
    </section>
    <v-button @click="this.isShowNewTodoForm=true">+</v-button>
</template>

<style>
    .todos {
        margin: 0.5rem 0;
    }
    .todo-form {
        display: flex;
    }
    .gray-select {
        color: gray
    }
    .todo-form option {
        color: black;
    }
    .todo-form option:first-child {
        color: gray;
    }
    .description-container {
        flex-grow: 5;
        display: flex;
        flex-direction: column;
    }
    .description-container input {
        flex-grow: 5;
    }
</style>
