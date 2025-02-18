<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-6">
                <div id="todo-container" class="p-3">
                    <section style="text-align: center" id="todo-header" class="mt-3">
                        <h3 class="text-center">TodoList Web App</h3>
                        <p >This is a test project for cmplejaymedia</p>
                    </section>
                    <section id="todo-errors">
                        <!-- Display Validation Errors -->
                        <div v-if="createTodoForm.errors.length > 0" class="alert alert-warning alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                <li v-for="(error, index) in createTodoForm.errors" :key="index">{{ error }}</li>
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>

                        <!-- Success Message for Created Todo -->
                        <div v-if="createTodoForm.isCreated" class="alert alert-success alert-dismissible fade show" role="alert">
                            Todo item created successfully.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>

                        <!-- Success Message for Updated Todo -->
                        <div v-if="editTodoForm.isUpdated" class="alert alert-success alert-dismissible fade show" role="alert">
                            Todo item updated successfully.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </section>

                    <section id="add-todo-form" class="my-3">
                        <form @submit.prevent="addTodo" class="mb-3">
                            <div class="input-group">
                                <input
                                    v-model="createTodoForm.name"
                                    v-on:keyup.enter="addTodo"
                                    minlength="10"
                                    maxlength="50"
                                    placeholder="Tell me what you want to do"
                                    type="text"
                                    class="form-control"
                                    required
                                >
                                <button v-if="createTodoForm.isSubmitting" class="btn btn-primary" type="button" disabled>
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    Loading...
                                </button>
                                <button v-else class="btn btn-primary">Add</button>
                            </div>
                            <small class="form-text text-warning">Minimum text length is 10</small>
                        </form>

                    </section>
                    <section id="todo-actions"></section>
                    <section id="todo-list">
                        <ul class="list-group">
                            <!-- Loading Spinner -->
                            <div v-if="todos.isLoading" class="text-center py-3">
                                <div class="spinner-border" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>

                            <!-- Todo Items -->
                            <li v-if="!todos.isLoading && todos.data.length > 0"
                                v-for="todo in todos.data" :key="todo.uuid"
                                class="list-group-item">

                                <div class="d-flex justify-content-between align-items-center">
                                    <span>{{ todo.name }}</span>
                                    <div>
                                        <a href="#" class="text-success me-2" @click.prevent="showEditTodoForm(todo)">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>
                                        <a href="#" class="text-danger" @click.prevent="destroy(todo)">
                                            <i class="fa fa-trash-o"></i> Delete
                                        </a>
                                    </div>
                                </div>

                                <div class="d-flex w-100 justify-content-between mt-1">
                                    <small class="text-muted">Created</small>
                                    <small class="text-muted">{{ todo.created_at }}</small>
                                </div>
                            </li>

                            <!-- No Todo Items Found -->
                            <li v-if="!todos.isLoading && todos.data.length === 0"
                                class="list-group-item list-group-item-warning text-center">
                                No todo items found.
                            </li>
                        </ul>
                    </section>

                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="editTodoItemModal" tabindex="-1" role="dialog" aria-labelledby="editTodoItemModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editTodoItemModalLabel">Update TodoItem</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <section id="edit-todo-errors" class="mb-3">
                            <div v-if="editTodoForm.errors.length > 0" class="alert alert-warning alert-dismissible fade show" role="alert">
                                <span v-for="(error, index) in editTodoForm.errors" :key="index">{{ error }}</span>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </section>
                        <section id="edit-todo">
                            <form>
                                <div class="input-group">
                                    <input
                                        v-model="editTodoForm.name"
                                        @keyup.enter="updateTodo"
                                        minlength="10" maxlength="50"
                                        placeholder="Enter todo name and press enter"
                                        type="text"
                                        class="form-control"
                                    />
                                    <button v-if="editTodoForm.isSubmitting" class="btn btn-primary" type="button" disabled>
                                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                        Loading...
                                    </button>
                                    <button v-else @click.prevent="updateTodo" class="btn btn-success">Update</button>
                                </div>
                                <small class="form-text text-warning">Minimum text length is 10</small>
                            </form>

                        </section>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'TodoList',
        data() {
            return {
                todos: {
                    isLoading: false,
                    data: []
                },
                createTodoForm: {
                    isSubmitting: false,
                    isCreated: false,
                    name: undefined,
                    errors: []
                },
                editTodoForm: {
                    isSubmitting: false,
                    isUpdated: false,
                    uuid: undefined,
                    name: undefined,
                    errors: []
                },
                error: undefined
            }
        },
        mounted() {
            this.loadTodos();
        },
        methods: {
            showEditTodoForm(todo) {
                this.editTodoForm.name = todo.name;
                this.editTodoForm.uuid = todo.uuid;
                $('#editTodoItemModal').modal('show');
            },
            /**
             * Loads todos
             */
            loadTodos() {
                // update loader to loading
                this.todos.isLoading = true;

                axios.get('/todos')
                .then((response) => {
                    this.todos.data = response.data;
                })
                .catch((error) => {
                    //TODO: update with your logic on how to handle this error.
                    console.log(error.message);
                    this.error = 'Unable to load todos. View log for more information';
                })
                .finally(() => {
                    // disable loader
                    this.todos.isLoading = false;
                })
            },

            /**
             * Create a TodoItem.
             * Uses payload in the this.createTodoForm param
             */
            addTodo() {
                // update loader to loading
                this.createTodoForm.isSubmitting = true;
                this.createTodoForm.name = this.createTodoForm.name.toLowerCase();
                // Use can use this as the payload.
                // const todoData = { name: this.createTodoForm.name };
                axios.post('/todos', this.createTodoForm)
                .then((response) => {
                    this.createTodoForm.errors = [];
                    this.createTodoForm.name = undefined;
                    this.createTodoForm.isCreated = true;
                    this.loadTodos();
                })
                .catch((error) => {
                    /**
                     * Check for form validation error. Laravel return http code 422
                     * _ lodash is already loaded by laravel. check resources/js/bootstrap.js
                     */
                    if (error.response && error.response.status === 422) {
                        this.createTodoForm.errors = _.flatten(_.toArray(error.response.data.errors));
                    } else {
                        //TODO: update with your logic on how to handle this error.
                        console.log(error.message);
                        this.error = 'Unable to add todo. View log for more information';
                    }
                })
                .finally(() => {
                    // disable loader
                    this.createTodoForm.isSubmitting = false;
                })
            },
            /**
             * Updates a TodoItem
             *
             */
            updateTodo() {
                // update loader to loading
                this.editTodoForm.isSubmitting = true;
                //this.createTodoForm.name = this.createTodoForm.name.toLowerCase();
                // Use can use this as the payload.
                // const todoData = { name: this.createTodoForm.name };
                axios.put(`/todos/${this.editTodoForm.uuid}`, this.editTodoForm)
                    .then((response) => {
                        $('#editTodoItemModal').modal('hide');
                        this.editTodoForm.name = undefined;
                        this.editTodoForm.uuid = undefined;
                        this.editTodoForm.isUpdated = true;
                        this.loadTodos();
                    })
                    .catch((error) => {
                        /**
                         * Check for form validation error. Laravel return http code 422
                         * _ lodash is already loaded by laravel. check resources/js/bootstrap.js
                         */
                        if (error.response && error.response.status === 422) {
                            this.editTodoForm.errors = _.flatten(_.toArray(error.response.data.errors));
                        } else {
                            //TODO: update with your logic on how to handle this error.
                            console.log(error.message);
                            this.error = 'Unable to update todo. View log for more information';
                        }
                    })
                .finally(() => {
                    // disable loader
                    this.editTodoForm.isSubmitting = false;
                })
            },
            /**
             * Deletes a TodoItem
             * @param todoItem
             */
            destroy(todoItem) {
                // Use can use this as the payload.
                // const todoData = { name: this.createTodoForm.name };
                axios.delete(`/todos/${todoItem.uuid}`)
                    .then((response) => {
                        this.loadTodos();
                    })
                    .catch((error) => {
                        //TODO: update with your logic on how to handle this error.
                        console.log(error.message);
                        this.error = 'Unable to delete todo. View log for more information';
                    })
            }
        }
    }
</script>
