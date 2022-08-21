<script>
    import Checkbox from './Checkbox'
    import Dropdown from './Dropdown'
    import VButton from './Button'
    export default {
        components: {Checkbox,Dropdown,VButton},
        props: {
            id: {type: Number, required: true},
            description: { type:String, required: true },
            is_done: { type: Boolean, default: false },
            view_counter: {type: Number, required: true},
            project_name: {type: String, required: true}
        },
        methods: {
            deleteTodo() {
                this.$emit('deleteTodo', this.id)
            },
            updateChecked(evt) {
                axios.put(`/api/todo/${this.id}`, {
                    is_done: evt
                })
            }
        }
    }
</script>

<template>
    <div class="todo-list-item">
        <label>
            <checkbox :checked="this.is_done" @update:checked="this.updateChecked"/>&nbsp;
            <span>{{description}}</span>
        </label>
        <div>
            From project: {{project_name}}
        </div>
        <div>
            Viewed {{view_counter}} times
        </div>
        <div style="position: relative">
            <dropdown width="80">
                <template #trigger>
                    <button>&times;</button>
                </template>
                <template #content>
                    <div class="before-delete">
                        <div>
                            Are sure you want to delete TODO: {{description}}?
                        </div>
                        <div>
                            <v-button @click="deleteTodo" style="background-color: red">Delete</v-button>&nbsp;
                            <v-button>Cancel</v-button>
                        </div>
                    </div>
                </template>
            </dropdown>

        </div>
    </div>
</template>

<style>
    .todo-list-item {
        padding: 1rem;
        border-radius: 4px;
        background-color: #ddd;
        display: flex;
        gap: 0.8rem;
    }
    .todo-list-item > label {
        flex-grow: 5;
    }
    .todo-list-item:not(:last-child) {
        margin-bottom: .2rem;
    }
    .before-delete {
        padding: 1rem;
        z-index: 200;
        position:relative;
        width:300px;
    }
</style>
