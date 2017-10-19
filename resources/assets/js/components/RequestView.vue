<template>
    <div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    {{data.title}} <small>({{data.service_request_id}})</small>
                    <small>lisätty {{data.created_at | formatTimestamp('DD.MM.YYYY HH:mm') }}</small>
                </h3>
            </div>

            <div class="panel-body">
                    <button class="btn btn-primary" @click="approve" v-if="data.status === 'pending'">Hyväksy palaute</button>
                    <button class="btn btn-danger" @click="destroy">Poista palaute</button>

                <table class="table">
                    <thead>
                    <tr>
                        <th>Avain</th>
                        <th>Arvo</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th scope="row">Service request id</th>
                        <td>{{data.service_request_id}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Otsikko</th>
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
                        <th scope="row">Kuvaus</th>
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
                                v-show="editDescription">
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
                        <th scope="row">Sijainti</th>
                        <td><strong>Osoite: </strong>{{data.address_string}} <strong>Postinumero: </strong>{{data.zip_code}} <strong>Geo: </strong>{{data.location}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Lisääjä</th>
                        <td><strong>Nimi: </strong>{{data.first_name}} {{data.last_name}} <strong>Email: </strong>{{data.email}} <strong>Puhelin: </strong>{{data.phone}}</td>
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
                            <div class="btn-group" role="group" style="float: right">
                                <button
                                        class="btn btn-xs btn-danger"
                                        @click="clearMediaUrl">
                                    <i class="glyphicon glyphicon-trash"></i>
                                </button>
                            </div>
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
                        <td><strong>Palautteen hallinta</strong></td>
                    </tr>
                    <tr>
                        <th scope="row">Palvelun nimi</th>
                        <td>{{data.service.service_name}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Vastuuosasto</th>
                        <td>{{data.agency_responsible}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Tila</th>
                        <td>
                            <div class="btn-group" role="group">
                                <button
                                        type="button"
                                        class="btn"
                                        @click="updateStatus('pending')"
                                        :class="data.status === 'pending' ? 'btn-danger' : 'btn-default'"
                                >
                                    Odottaa
                                </button>
                                <button
                                        type="button"
                                        class="btn"
                                        @click="updateStatus('open')"
                                        :class="data.status === 'open' ? 'btn-primary' : 'btn-default'"
                                >
                                    Avoin
                                </button>
                                <button
                                        type="button"
                                        class="btn"
                                        @click="updateStatus('closed')"
                                        :class="data.status === 'closed' ? 'btn-primary' : 'btn-default'"
                                >
                                    Suljettu
                                </button>
                            </div>
                            <p v-show="data.status === 'pending'">
                                <em>Odottavat palautteet eivät näy rajapinnassa.</em>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Tilaviesti</th>
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
            original_description: this.request.description,
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
            if(this.data.description.length === 0) {
                alert('Palautteen kuvaus ei voi olla tyhjä.');
                this.data.description = this.original_description;
                return;
            }
            this.update({description: this.data.description});
            this.editDescription = false;
        },

        updateStatusNotes() {
            this.update({status_notes: this.data.status_notes});
            this.editStatusNotes = false;
        },

        clearStatusNotes() {
            if(confirm('Haluatko varmasti poistaa palautteen status -tiedon?')) {
                this.update({status_notes: ''});
                this.data.status_notes = '';
            }
        },

        clearMediaUrl() {
            if(confirm('Haluatko varmasti poistaa tämän kentän palautteesta?')) {
                this.update({media_url: ''});
                this.data.media_url = '';
            }
        },

        clearTitle() {
            if(confirm('Haluatko varmasti poistaa tämän kentän palautteesta?')) {
                this.update({title: ''});
                this.data.title = '';
            }
        },

        deleteImage(photo) {
            if(confirm('Haluatko varmasti poistaa tämän kuvan?')) {
                axios.delete('/images/' + photo.id)
                    .then(response => {
                        window.flash(response.data);

                        let index = this.data.photos.indexOf(photo);
                        this.data.photos.splice(index, 1);
                    });
            }
        },

        destroy() {
            if(confirm('Haluatko varmasti poistaa tämän palautteen?')) {
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