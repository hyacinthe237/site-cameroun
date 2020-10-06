<template>
    <GoogleMapLoader :mapConfig="mapConfig" apiKey="yourApiKey" />
        <GoogleMapMarker
            v-for="marker in markers"
            :key="marker.id"
            :marker="marker"
            :google="google"
            :map="map"
        />
        <GoogleMapLine
            v-for="line in lines"
            :key="line.id"
            :path.sync="line.path"
            :google="google"
            :map="map"
        />
    </GoogleMapLoader>
</template>
<script>
import GoogleMapLoader from './GoogleMapLoader'
import { mapSettings } from '@/constants/mapSettings'

export default {
    components: { GoogleMapLoader },

    computed: {
        mapConfig () {
            return {
            ...mapSettings,
                center: { lat: 0, lng: 0 }
            }
        },
    },
}
</script>
