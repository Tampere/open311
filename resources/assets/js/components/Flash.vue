<template>
    <div class="alert alert-success alert-flash" role="alert" v-show="show">
        <strong>Success!</strong> {{body}}
    </div>
</template>
<style>
    .alert-flash {
        position: fixed;
        bottom: 25px;
        right: 25px;
    }
</style>
<script>
    export default {

        props: ['message'],

        data() {
            return {
                body: '',
                show: false,
            };
        },

        created() {
            if(this.message) {
                this.flash(this.message);
            }

            window.events.$on('flash', message => {
                this.flash(message);
            });
        },

        methods: {
            flash(message) {
                this.body = message;
                this.show = true;
            },

            hide() {
                setTimeout(() => {
                    this.show = false;
                }, 3000);
            }
        }
    }
</script>
