import Vue from 'vue'
import 'bootstrap'
import { BootstrapVue } from 'bootstrap-vue'

Vue.use(BootstrapVue)

const files = require.context('./', true, /\.vue$/i)
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

/* eslint-disable no-new */
new Vue({
  el: '#app'
})
