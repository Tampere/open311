<template>
    <div class="field has-addons">
        <div class="control">
            <input class="input" type="text" size="85" :value="apikey" disabled>
        </div>
        <div class="control">
            <button class="button is-primary" v-clipboard="apikey" @success="copied" @error="cantCopy">
                Copy
            </button>
        </div>
        <div class="control">
            <button class="button is-success" @click="regenerateApiKey">
                Regenerate API key
            </button>
        </div>
    </div>
</template>

<script>
export default {
    props: ['data'],

    data() {
        return {
            apikey: this.data,
        }
    },

    methods: {
        regenerateApiKey() {
            axios.post('client/key')
                .then(response => {
                    this.apikey = response.data;
                    flash('API key regenerated.');
                });
        },

        copied() {
            flash('Copied to clipboard.');
        },

        cantCopy() {
            flash('Can\'t copy, back to ctrl+c for you...');
        }
    }

}
</script>
