<template>
    <div>
        <table class="table">
            <thead>
            <tr>
                <th><input title="Select all" @click="toggleSelectAll" type="checkbox" v-model="selectingAll"></th>
                <th>Created at</th>
                <th>Title</th>
                <th>Description</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            </thead>

            <tbody>
                <request
                        v-if="requests.data.length > 0"
                        v-for="request in requests.data"
                        :key="request.service_request_id"
                        :data="request"
                        @update-required="getResults"
                        @selected="addToSelected"
                        @deselected="removeFromSelected">
                </request>

                <tr v-if="requests.data.length === 0">
                    <td colspan="6"><em>No pending or open requests</em></td>
                </tr>
            </tbody>
        </table>

        <button
                class="btn btn-danger"
                :disabled="selectedRequests.length === 0"
                @click="deleteAll">
            Delete selected requests
        </button>

        <p class="text-muted"><em>Showing {{requests.data.length}} out of {{requests.total}} pending or open requests</em></p>

        <pagination :data="requests" v-on:pagination-change-page="getResults"></pagination>
    </div>
</template>

<script>
import Request from './Request.vue'
export default {
    components: {
        Request
    },

    data() {
        return {
            requests: {
                data: {}
            },
            selectedRequests: [],
            selectingAll: false
        }
    },

    created() {
        this.getResults();
    },

    methods: {
        getResults(page) {
            if (typeof page === 'undefined') {
                page = 1;
            }

            this.requests = {
                data: {}
            };

            this.selectedRequests = [];
            this.selectingAll = false;

            axios.get('?page=' + page)
                .then(response => {
                    this.requests = response.data;
            });
        },

        toggleSelectAll() {
            if(!this.selectingAll) {
                this.selectingAll = true;
                window.events.$emit('set-all-selected');
                this.selectedRequests = [];
                this.requests.data.forEach(request => {
                    this.selectedRequests.push(request.service_request_id);
                });
            } else {
                this.selectingAll = false;
                this.selectedRequests = [];
                window.events.$emit('set-all-deselected');
            }
        },

        addToSelected(data) {
            this.selectedRequests.push(data.id);
        },

        removeFromSelected(data) {
            let index = this.selectedRequests.indexOf(data.id);
            if(index > -1) {
                this.selectedRequests.splice(index, 1);
            }
            this.selectingAll = false;
        },

        deleteAll() {
            if(confirm('Are you sure you want to destroy all selected request?')) {
                axios.post('/delete-requests', {ids: this.selectedRequests})
                    .then((response) => {
                        console.log(response);
                    });

                this.getResults();
            }
        }
    }
}
</script>

<style scoped>
.table {
    background: #fff;
}
</style>