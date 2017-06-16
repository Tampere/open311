<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Services
                        <button @click.prevent="showForm = !showForm"
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
                                            @click.prevent="submitForm"
                                            class="btn btn-primary">
                                            Save new service
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
                            <tr v-for="service in items">
                                <td>{{service.service_code}}</td>
                                <td>{{service.service_name}}</td>
                                <td>{{service.description}}</td>
                                <td>{{service.group}}</td>
                                <td>{{service.keywords | json_to_list}}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button class="btn btn-xs btn-primary">
                                            <i class="glyphicon glyphicon-pencil"></i>
                                        </button>
                                        <button class="btn btn-xs btn-danger">
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
            }
        },

        filters: {
            json_to_list(arg) {

                if(!arg) return '';

                let result = '';
                arg.forEach(item => {
                    result += item.name + ', ';
                });

                return result;
            }
        }
    }
</script>
