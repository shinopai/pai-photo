import {
    createApp
} from 'vue'
import router from './lib/router'
import {
    store
} from './modules/store'
import App from './components/App.vue'
import {
    library
} from '@fortawesome/fontawesome-svg-core'
import {
    faPlus,
    faHeart,
    faComment
} from '@fortawesome/free-solid-svg-icons'
import {
    FontAwesomeIcon
} from '@fortawesome/vue-fontawesome'

library.add(faPlus, faHeart, faComment)

const app = createApp(App)
app.component('fa', FontAwesomeIcon)
app.use(router)
app.use(store)
app.mount('#pai-photo')
