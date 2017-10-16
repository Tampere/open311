<template>
    <div>
        <table class="table">
            <thead>
            <tr>
                <th><input title="Select all" @click="toggleSelectAll()" type="checkbox"></th>
                <th>Created at</th>
                <th>Title</th>
                <th>Description</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            </thead>

            <tbody>
                <request
                        v-for="request in requests.data"
                        :key="request.service_request_id"
                        :data="request"
                        v-if="requests.data.length > 0">
                </request>

                <tr v-if="requests.data.length === 0">
                    <td colspan="6"><em>No pending or open requests</em></td>
                </tr>
            </tbody>
        </table>

        <button class="btn btn-danger" disabled>Poista valitut</button>

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

            axios.get('?page=' + page)
                .then(response => {
                    this.requests = response.data;
            });
        },

        toggleSelectAll() {
            this.$emit('toggle-select');
        }
    }
}
</script>

<style scoped>
.table {
    background: #fff;
}
</style>