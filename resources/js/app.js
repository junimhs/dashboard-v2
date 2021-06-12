require('./bootstrap');
import Vue from 'vue'
import { createInertiaApp } from '@inertiajs/inertia-vue'
import { InertiaProgress } from '@inertiajs/progress'

InertiaProgress.init()

createInertiaApp({
    resolve: name => require(`./pages/${name}`),
    setup({ el, app, props }) {
        new Vue({
            render: h => h(app, props),
        }).$mount(el)
    },
})
