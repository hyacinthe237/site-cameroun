
import globalMixins from './mixins/global'
import swal from './plugins/swal'
import toastr from './plugins/toastr'
// import VueGoogleMap from 'vue2-google-maps'

require('./bootstrap')
require('./ui')

window.Vue = require('vue')
window.eventBus = new Vue()

Vue.use(swal)
Vue.use(toastr)

// Vue.use(VueGoogleMap, {
//   load: {
//     key: 'AIzaSyBs3PrvdiQRO9l436VQ6hecvQE3-wv1ppE',
//     libraries: "places"
//   }
// })

// Vue.component('maps', require('./components/backend/maps/maps'))

const app = new Vue({
    el: '#app'
});
