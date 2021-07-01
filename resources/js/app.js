require('./bootstrap');

require('alpinejs');

import Vue from 'vue'

const vueAppEls = document.querySelectorAll('[data-vue-app]')
vueAppEls.forEach(vueAppEl => {
    const app = require(`./components/${vueAppEl.dataset.vueApp}.vue`)
    const props = vueAppEl.dataset.props ? JSON.parse(vueAppEl.dataset.props) : []
    new Vue({
        render: h => h(app.default, { props }),
    }).$mount(vueAppEl)
})
