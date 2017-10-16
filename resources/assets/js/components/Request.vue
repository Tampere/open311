<template>
    <tr>
        <td><input title="Select" type="checkbox" v-model="selected"></td>
        <td>{{data.created_at | formatTimestamp('DD.MM.YYYY HH:mm') }}</td>
        <td>
            <a :href="url">{{data.title}}</a>
        </td>
        <td>{{data.description | truncate(30) }}</td>
        <td>
            <span v-tooltip="'Pending requests do now show on the requests listing'" class="label" :class="data.status === 'pending' ? 'label-info' : 'label-primary'">
                {{data.status}}
            </span>
        </td>
        <td>
            <button class="btn btn-danger btn-xs">Delete request</button>
        </td>
    </tr>
</template>

<script>
export default {
    props: ['data'],

    data() {
        return {
            selected: false
        }
    },

    computed: {
        url() {
            return '/requests/' + this.data.service_request_id;
        }
    },

    created() {
        this.$on('toggle-select', () => {
            alert("EVENT");
           this.selected = !this.selected;
        });
    }
}
</script>

<style scoped>

</style>