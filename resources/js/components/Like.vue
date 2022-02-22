<template>
<div>
      <span v-if="typeof isLiked == 'number'" class="absolute top-2 right-2 bg-white py-1 px-2 rounded cursor-pointer" @click="unlikePhoto"><fa icon="heart" class="text-red-500 mr-2" />{{ likes }}</span>
      <span v-else class="absolute top-2 right-2 bg-white py-1 px-2 rounded cursor-pointer" @click="likePhoto"><fa icon="heart" class="text-red-500 mr-2" />{{ likes }}</span>
</div>
</template>

<script>
import { ref, onMounted } from 'vue'
import Axios from 'axios'
import { useStore } from 'vuex';

export default {
  props: {
    photoId: Number,
    currentUser: Object
  },
  setup(props) {
    const photoId = props.photoId
    const currentUserId = props.currentUser.id
    const likes = ref()
    const isLiked = ref()
    const store = useStore()

    // get number of this photo's likes
    const getLikes = async () => {
      await store.dispatch('like/getLikes', photoId)
      likes.value = store.state.like.likes
    }

    // check if current user like this photo
    const checkLiked = async () => {
      await Axios.get('/api/users/' + currentUserId + '/photos/' + photoId + '/check')
          .then(res => {
            isLiked.value = res.data
          })
          .catch(err => {
              console.log(err.response)
          })
    }

    // show alert if no user logged in
    const showAlert = () => {
      if(typeof currentUserId != 'number'){
        alert('ログインしてください')
        return false;
      }
    }

    // like photo
    const likePhoto = () => {
      showAlert()
      Axios.post('/api/users/' + currentUserId + '/photos/' + photoId + '/like')
           .then( res => {
             checkLiked()
             getLikes()
           })
           .catch( err => {
             console.log(err.response)
           })
    }

    // unlike photo
    const unlikePhoto = () => {
      showAlert()
      Axios.delete('/api/users/' + currentUserId + '/photos/' + photoId + '/unlike')
           .then( res => {
             checkLiked()
             getLikes()
           })
           .catch( err => {
             console.log(err.response)
           })
    }

    onMounted(() => {
      checkLiked()
      getLikes()
    })

    return {
      likes, isLiked, likePhoto, unlikePhoto
    }
  },
}
</script>
