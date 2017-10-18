<template>
    <ul class="list-group" v-if="data.length > 0">
        <li
            class="list-group-item"
            v-for="update in data"
            :key="update.id"
        >
            <h4 class="list-group-item-heading">
                {{update.user.name}}
                <small>on {{update.updated_at | formatTimestamp('DD.MM.YYYY HH:mm')}}</small>
            </h4>
            <p class="list-group-item-text">
                <strong>Arvo oli:</strong>{{update.old_value}}<br>
                <strong>Arvo on:</strong>{{update.new_value}}
            </p>
        </li>
    </ul>
</template>

<script>
export default {
    props: ['request'],

    data() {
        return {
            data: []
        }
    },

    created() {
        this.fetchData();
        window.events.$on('update', () => {
            this.fetchData();
        });
    },

    methods: {
        fetchData() {
            axios.get('/requests/' + this.request.service_request_id + '/activity')
                .then(response => {
                    this.data = response.data;
                });
        }
    }
}
</script>

<style scoped>

</style>