import './bootstrap';

import { createApp, h } from 'vue'
import { createInertiaApp,Head,Link } from '@inertiajs/vue3'
import Layout from '@shared/Layout.vue'

/* import font awesome icon component */
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

createInertiaApp({
  resolve: name => {
    const pages = import.meta.glob('./Pages/**/*.vue', { eager: true });

    let page = pages[`./Pages/${name}.vue`]
    if (page.default.layout === undefined) {

        page.default.layout = Layout
    }
    return page

  },
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .component('Link',Link)
      .component("Head",Head)
      .component("Layout",Layout)
      .component('font-awesome-icon', FontAwesomeIcon)
      .mount(el)
  },
})
