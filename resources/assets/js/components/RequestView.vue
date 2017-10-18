<template>
    <div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    {{data.title}} <small>({{data.service_request_id}})</small>
                    <small>submitted {{data.created_at | formatTimestamp('DD.MM.YYYY HH:mm') }}</small>
                </h3>
            </div>

            <div class="panel-body">
                    <button class="btn btn-primary" @click="approve" v-if="data.status === 'pending'">Approve request</button>
                    <button class="btn btn-danger" @click="destroy">Destroy request</button>

                <table class="table">
                    <thead>
                    <tr>
                        <th>Key</th>
                        <th>Value</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th scope="row">Service request id</th>
                        <td>{{data.service_request_id}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Title</th>
                        <td>
                            <span class="editable" @click="editTitle = true" v-show="!editTitle">
                                {{data.title}}
                            </span>
                            <input
                                type="text"
                                v-model="data.title"
                                v-show="editTitle"
                                v-on:keyup.enter="updateTitle">
                            <div class="btn-group" role="group" style="float: right">
                                <button
                                    v-if="!editTitle"
                                    class="btn btn-xs btn-primary"
                                    @click="editTitle = true">
                                    <i class="glyphicon glyphicon-pencil"></i>
                                </button>
                                <button
                                    v-if="editTitle"
                                    class="btn btn-xs btn-primary"
                                    @click="updateTitle">
                                    <i class="glyphicon glyphicon-floppy-disk"></i>
                                </button>
                                <button
                                    class="btn btn-xs btn-danger"
                                    @click="clearTitle">
                                    <i class="glyphicon glyphicon-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Description</th>
                        <td>
                            <span class="editable" @click="editDescription = true" v-show="!editDescription">
                                {{data.description}}
                            </span>
                            <textarea
                                name="description"
                                id="description"
                                cols="90"
                                rows="5"
                                v-model="data.description"
                                v-show="editDescription"
                                v-on:keyup.enter="updateDescription">
                            </textarea>
                            <div class="btn-group" role="group" style="float: right">
                                <button
                                    v-if="editDescription"
                                    class="btn btn-xs btn-primary"
                                    @click="updateDescription">
                                    <i class="glyphicon glyphicon-floppy-disk"></i>
                                </button>
                                <button
                                    v-if="!editDescription"
                                    class="btn btn-xs btn-primary"
                                    @click="editDescription = true">
                                    <i class="glyphicon glyphicon-pencil"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Location</th>
                        <td><strong>Address: </strong>{{data.address_string}} <strong>Zip: </strong>{{data.zip_code}} <strong>Geo: </strong>{{data.location}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Submitted by</th>
                        <td><strong>Name: </strong>{{data.first_name}} {{data.last_name}} <strong>Email: </strong>{{data.email}} <strong>Phone: </strong>{{data.phone}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Media url</th>
                        <td>
                            <span
                                class="editable"
                                v-if="data.media_url"
                                v-tooltip="{ html: 'tooltipContent' }"
                            >
                                {{data.media_url}}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Media urls</th>
                        <td>
                            <div
                                v-if="data.photos"
                                v-for="photo in data.photos"
                                :key="photo.id">
                                <img
                                    :src="'/storage/'+photo.filename"
                                    :alt="photo.filename"
                                    width="150">
                                <div class="btn-group" role="group" style="float: right">
                                    <button
                                            class="btn btn-xs btn-danger"
                                            @click="deleteImage(photo)">
                                        <i class="glyphicon glyphicon-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr class="segment">
                        <th scope="row"></th>
                        <td><strong>Specify response to request</strong></td>
                    </tr>
                    <tr>
                        <th scope="row">Service name</th>
                        <td>{{data.service.service_name}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Agency responsible</th>
                        <td>{{data.agency_responsible}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Status</th>
                        <td>
                            <div class="btn-group" role="group">
                                <button
                                        type="button"
                                        class="btn"
                                        @click="updateStatus('pending')"
                                        :class="data.status === 'pending' ? 'btn-danger' : 'btn-default'"
                                >
                                    Pending
                                </button>
                                <button
                                        type="button"
                                        class="btn"
                                        @click="updateStatus('open')"
                                        :class="data.status === 'open' ? 'btn-primary' : 'btn-default'"
                                >
                                    Open
                                </button>
                                <button
                                        type="button"
                                        class="btn"
                                        @click="updateStatus('closed')"
                                        :class="data.status === 'closed' ? 'btn-primary' : 'btn-default'"
                                >
                                    Closed
                                </button>
                            </div>
                            <p v-show="data.status === 'pending'">
                                <em>Requests in pending state are not shown on the API.</em>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Status notes</th>
                        <td>
                            <span class="editable" @click="editStatusNotes = true" v-show="!editStatusNotes">
                                {{data.status_notes}}
                            </span>
                            <textarea
                                    name="status_notes"
                                    id="status_notes"
                                    cols="90"
                                    rows="5"
                                    v-model="data.status_notes"
                                    v-show="editStatusNotes"
                                    v-on:keyup.enter="updateStatusNotes">
                                </textarea>
                            <div class="btn-group" role="group" style="float: right">
                                <button
                                        v-if="editStatusNotes"
                                        class="btn btn-xs btn-primary"
                                        @click="updateStatusNotes">
                                    <i class="glyphicon glyphicon-floppy-disk"></i>
                                </button>
                                <button
                                        v-if="!editStatusNotes"
                                        class="btn btn-xs btn-primary"
                                        @click="editStatusNotes = true">
                                    <i class="glyphicon glyphicon-pencil"></i>
                                </button>
                                <button
                                        class="btn btn-xs btn-danger"
                                        @click="clearStatusNotes">
                                    <i class="glyphicon glyphicon-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <div id="tooltipContent">
                    <p>
                        <img :src="data.media_url" alt="data.title" width="640" height="480">
                    </p>
                </div>
            </div>
        </div>
        <request-updates :request="request"></request-updates>
    </div>
</template>

<script>
import RequestUpdates from './RequestUpdates.vue';
export default {
    props: ['request'],

    components: {
        RequestUpdates
    },

    data() {
        return {
            data: this.request,
            editTitle: false,
            editDescription: false,
            editStatusNotes: false,
        }
    },

    methods: {
        update(data) {
            axios.patch('/requests/' + this.data.service_request_id, data)
                .then((response) => {
                    flash(response.data);
                });

            window.events.$emit('update');
        },

        approve() {
            this.data.status = 'open';
            this.update({status: 'open'});
        },

        updateStatus(state) {
            this.data.status = state;
            this.update({status: state});
        },

        updateTitle() {
            this.update({title: this.data.title});
            this.editTitle = false;
        },

        updateDescription() {
            this.update({description: this.data.description});
            this.editDescription = false;
        },

        updateStatusNotes() {
            this.update({status_notes: this.data.status_notes});
            this.editStatusNotes = false;
        },

        clearStatusNotes() {
            this.update({status_notes: ''});
            this.data.status_notes = '';
        },

        clearTitle() {
            this.update({title: ''});
            this.data.title = '';
        },

        deleteImage(photo) {
            if(confirm('Are you sure you want to destroy this image?')) {
                axios.delete('/images/' + photo.id)
                    .then(response => {
                        window.flash(response.data);

                        let index = this.data.photos.indexOf(photo);
                        this.data.photos.splice(index, 1);
                    });
            }
        },

        destroy() {
            if(confirm('Are you sure you want to destroy this request?')) {
                axios.delete('/requests/' + this.data.service_request_id)
                    .then((response) => {
                        window.flash(response.data)
                    });
            }
        }
    }
}
</script>

<style scoped>
.editable {
    color: #2a88bd;
    border-bottom: 1px dotted #2a88bd;
}

    .segment {
        background-color: #98cbe8;
    }
</style>