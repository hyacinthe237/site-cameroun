<template>
  <div id="">

  </div>
</template>
<script>
import { POINT_MARKER_ICON_CONFIG } from '@/constants/mapSettings'

export default {
    props: {
        google: {
            type: Object,
            default: () => {},
            required: true
        },
        map: {
            type: Object,
            default: () => {},
            required: true
        },
        marker: {
            type: Object,
            default: () => {},
            required: true
        }
    },

    mounted() {
        new this.google.maps.Marker({
            position: this.marker.position,
            marker: this.marker,
            map: this.map,
            icon: POINT_MARKER_ICON_CONFIG
        })
    }
}
</script>
<style lang="scss" scoped>
</style>
