<template>
    <div class="alert alert-success alert-flash" role="alert" v-show="show">
        {{body}}
    </div>
</template>
<style scoped>
    .alert {
        padding: 15px;
        margin-bottom: 20px;
        border: 1px solid transparent;
        border-radius: 4px;
    }

    .alert-success {
        color: #3c763d;
        background-color: #dff0d8;
        border-color: #d6e9c6;
    }

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

        mounted() {
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

                this.hide();
            },

            hide() {
                setTimeout(() => {
                    this.show = false;
                }, 3000);
            }
        }
    }
</script>
