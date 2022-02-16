import {
    createStore
} from 'vuex'
import Axios from 'axios'

export const store = createStore({
    state() {
        return {
            user: null,
            err: null
        }
    },
    mutations: {
        setUser(state, userData) {
            state.user = userData
        },
        setErr(state, errData) {
            state.err = errData
        }
    },
    actions: {
        async getCurrentUser(context) {
            await Axios.get('/api/user')
                .then(res => {
                    context.commit('setUser', res.data)
                })
                .catch(err => {
                    context.commit('setErr', err.response)
                })
        }
    }
})
