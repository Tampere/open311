<template>
    <tr>
        <td><input title="Select" type="checkbox" @change="emitChange" v-model="selected"></td>
        <td>{{data.created_at | formatTimestamp('DD.MM.YYYY HH:mm') }}</td>
        <td>
            <a :href="url">{{data.title}}</a>
        </td>
        <td>{{data.description | truncate(30) }}</td>
        <td>
            <span v-tooltip="'Requests in pending state are not shown on API'" class="label" :class="data.status === 'pending' ? 'label-info' : 'label-primary'">
                {{data.status}}
            </span>
        </td>
        <td>
            <button @click="destroy" class="btn btn-danger btn-xs">Delete request</button>
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
        window.events.$on('set-all-selected', () => {
           this.selected = true;
        });

        window.events.$on('set-all-deselected', () => {
           this.selected = false;
        });
    },

    methods: {
        emitChange() {
            this.$emit(this.selected ? 'selected' : 'deselected', {id: this.data.service_request_id});
        },

        destroy() {
            if(confirm('Are you sure you want to destroy this request?')) {
                axios.delete('/requests/' + this.data.service_request_id);
                this.$emit('update-required');
            }
        }
    }
}
</script>

<style scoped>

</style>