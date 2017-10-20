<template>
    <div style="height: 200px;">
        <v-map :zoom="zoom" :center="center" @l-contextmenu="setMarker">
            <v-tilelayer url="http://{s}.tile.osm.org/{z}/{x}/{y}.png"></v-tilelayer>
            <v-marker v-if="showMarker" :lat-lng="center"></v-marker>
        </v-map>
    </div>
</template>

<script>
export default {
    props: ['position'],

    data() {
        return {
            coords: this.postition
        }
    },

    computed: {
        center() {
            if(!this.position) return [0, 0];

            return this.position.split(",");
        },

        showMarker() {
            return !! this.position;
        },

        zoom() {
            if(!this.position) return 3;
            return 15;
        }
    },

    methods: {
        setMarker(e) {
            if(confirm('Varmista uuden koordinaatin määrittäminen')) {
                this.coords = e.latlng.lat + ", " + e.latlng.lng;
                this.$emit('updated', this.coords);
            }
        }
    }
}
</script>

<style scoped>
    @import "~leaflet/dist/leaflet.css";

    .vue2leaflet-map {
        height: 200px;
    }
</style>