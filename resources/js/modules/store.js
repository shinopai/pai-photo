import {
    createStore
} from 'vuex'
import Axios from 'axios'

export const store = createStore({
    modules: {
        like: {
            namespaced: true,
            state: () => {
                return {
                    likes: null,
                    err: null,
                }
            },
            mutations: {
                setLikes(state, likesData) {
                    state.likes = likesData
                },
                setErr(state, errData) {
                    state.err = errData
                }
            },
            actions: {
                async getLikes(context, photoId) {
                    await Axios.get('/api/photos/' + photoId + '/likes')
                        .then(res => {
                            context.commit('setLikes', res.data)
                        })
                        .catch(err => {
                            context.commit('setErr', err.response)
                        })
                }
            }
        }
    },
    state: () => {
        return {
            user: null,
            likes: null,
            comments: null,
            err: null
        }
    },
    mutations: {
        setUser(state, userData) {
            state.user = userData
        },
        setLikes(state, likesData) {
            state.likes = likesData
        },
        setComments(state, commentsData) {
            state.comments = commentsData
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
        },
        async getLikes(context, photoId) {
            await Axios.get('/api/photos/' + photoId + '/likes')
                .then(res => {
                    context.commit('setLikes', res.data)
                })
                .catch(err => {
                    context.commit('setErr', err.response)
                })
        },
        async getComments(context, photoId) {
            await Axios.get('/api/photos/' + photoId + '/comments')
                .then(res => {
                    context.commit('setComments', res.data)
                })
                .catch(err => {
                    context.commit('setErr', err.response)
                })
        },
    }
})
