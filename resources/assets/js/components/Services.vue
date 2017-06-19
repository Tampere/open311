<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Services
                        <button @click.prevent="showForm = !showForm; editing = false"
                            class="btn btn-link pull-right">
                            Add a new service
                            <i class="glyphicon glyphicon-plus-sign"></i>
                        </button>
                    </div>

                    <div class="panel-body">

                        <div v-show="showForm">
                            <form class="form-horizontal">
                                <div class="form-group" :class="{'has-error' : errors.service_code}">
                                    <label for="service_code" class="col-sm-2 control-label">Service code</label>
                                    <div class="col-sm-10">
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="service_code"
                                            v-model="service_code"
                                            @keydown="errors.service_code = null"
                                        >
                                        <span class="help-block" v-if="errors.service_code">
                                            {{ errors.service_code[0] }}
                                        </span>
                                    </div>
                                </div>

                                <div class="form-group" :class="{'has-error' : errors.service_name}">
                                    <label for="service_name" class="col-sm-2 control-label">Name</label>
                                    <div class="col-sm-10">
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="service_name"
                                            v-model="service_name"
                                            @keydown="errors.service_name = null"
                                        >
                                        <span class="help-block" v-if="errors.service_name">
                                            {{ errors.service_name[0] }}
                                        </span>
                                    </div>
                                </div>

                                <div class="form-group" :class="{'has-error' : errors.description}">
                                    <label for="description" class="col-sm-2 control-label">Description</label>
                                    <div class="col-sm-10">
                                        <textarea
                                            class="form-control"
                                            id="description"
                                            v-model="description"
                                            @keydown="errors.description = null"
                                        ></textarea>
                                        <span class="help-block" v-if="errors.description">
                                            {{ errors.description[0] }}
                                        </span>
                                    </div>
                                </div>

                                <div class="form-group" :class="{'has-error' : errors.group}">
                                    <label for="group" class="col-sm-2 control-label">Group</label>
                                    <div class="col-sm-10">
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="group"
                                            v-model="group"
                                            @keydown="errors.group = null"
                                        >
                                        <span class="help-block" v-if="errors.group">
                                            {{ errors.group[0] }}
                                        </span>
                                    </div>
                                </div>

                                <div class="form-group" :class="{'has-error' : errors.keywords}">
                                    <label for="keywords" class="col-sm-2 control-label">Keywords <small>comma separated</small></label>
                                    <div class="col-sm-10">
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="keywords"
                                            v-model="keywords"
                                            @keydown="errors.keywords = null"
                                        >
                                        <span class="help-block" v-if="errors.keywords">
                                            {{ errors.keywords[0] }}
                                        </span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button
                                            @click.prevent="resetAndClose"
                                            class="btn btn-default">Reset & close
                                        </button>
                                        <button
                                            v-if="!editing"
                                            @click.prevent="submitForm"
                                            class="btn btn-primary"
                                        >
                                            Save new service
                                        </button>
                                        <button
                                            v-if="editing"
                                            @click.prevent="submitEditForm"
                                            class="btn btn-primary"
                                        >
                                            Save changes to service
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th nowrap="nowrap">Service code</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Group</th>
                                <th>Keywords</th>
                                <th width="80px;">&nbsp;</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(service, index) in items">
                                <td>{{service.service_code}}</td>
                                <td>{{service.service_name}}</td>
                                <td>{{service.description}}</td>
                                <td>{{service.group}}</td>
                                <td>{{service.keywords | json_to_list}}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button
                                            class="btn btn-xs btn-primary"
                                            @click.prevent="editService(service, index)"
                                        >
                                            <i class="glyphicon glyphicon-pencil"></i>
                                        </button>
                                        <button
                                            class="btn btn-xs btn-danger"
                                            @click.prevent="removeService(service, index)"
                                        >
                                            <i class="glyphicon glyphicon-trash"></i>
                                        </button>
                                    </div>

                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {

        data() {
            return {
                items: [],
                showForm: false,
                editing: false,
                service_code_to_edit: '',
                index_to_edit: 0,

                service_code: '',
                service_name: '',
                description: '',
                group: '',
                keywords: '',

                errors: [],
            };
        },

        mounted() {
            this.fetchServices();
        },

        methods: {
            fetchServices() {
                axios.get('services')
                    .then(response => {
                        this.items = response.data;
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },

            resetAndClose() {
                this.showForm = false;
                this.reset();
            },

            reset() {
                this.service_code = '';
                this.service_name = '';
                this.description = '';
                this.group = '';
                this.keywords = '';
            },

            submitForm() {
                axios.post('services', {
                    service_code: this.service_code,
                    service_name: this.service_name,
                    description: this.description,
                    group: this.group,
                    keywords: this.keywords,
                }).then(response => {
                    this.resetAndClose();
                    flash("Service added");
                    this.items.push(response.data);
                }).catch(error => {
                    this.errors = error.response.data;
                });
            },

            submitEditForm() {
                axios.put('services/' + this.service_code_to_edit, {
                    service_code: this.service_code,
                    service_name: this.service_name,
                    description: this.description,
                    group: this.group,
                    keywords: this.keywords,
                }).then(response => {
                    this.resetAndClose();
                    flash("Service modifications saved");
                    this.items[this.index_to_edit] = response.data;

                }).catch(error => {
                    this.errors = error.response.data;
                });
            },

            removeService(service, index) {
                axios.delete('services/' + service.service_code)
                    .then(response => {
                        this.items.splice(index, 1);
                        flash(response.data.message);
                }).catch(error => {
                    console.log(error);
                });
            },

            editService(service, index) {
                this.service_code = service.service_code;
                this.service_name = service.service_name;
                this.description = service.description;
                this.group = service.group;

                if(!service.keywords) {
                    this.keywords = '';
                } else if(typeof service.keywords === 'string') {
                    this.keywords = service.keywords;
                } else {
                    let result = '';
                    service.keywords.forEach(item => {
                        result += item.name + ', ';
                    });
                    this.keywords = result;
                }

                this.service_code_to_edit = service.service_code;
                this.index_to_edit = index;
                this.editing = true;
                this.showForm = true;
            },
        },

        filters: {
            json_to_list(arg) {

                if(!arg) return '';
                if(typeof arg === 'string') return arg;

                let result = '';
                arg.forEach(item => {
                    result += item.name + ', ';
                });

                return result;
            }
        }
    }
</script>
