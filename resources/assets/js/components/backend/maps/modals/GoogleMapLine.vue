<template>
  <div id="">

  </div>
</template>
<script>
import { LINE_PATH_CONFIG } from '@/constants/mapSettings'

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
        path: {
            type: Array,
            default: () => [],
            required: true
        }
    },

    mounted() {
        new this.google.maps.Polyline({
            path: this.path,
            map: this.map,
            ...LINE_PATH_CONFIG
        })
    }
}
</script>
