<template>
<main class="grid place-items-center bg-gray-100">
  <section class="flex flex-col md:flex-row gap-11 py-10 px-5 bg-white rounded-md shadow-lg lg:w-3/4">
    <div class="text-indigo-500 flex flex-col justify-between lg:w-1/2 h-80">
        <img v-if="photo.path == 'dammy.jpg'" src="/images/dammy.jpg" alt="dammy" class="object-cover w-full h-full"><img v-else :src="photo.path" alt="photo" class="object-cover w-full h-full">
      <div>
        <small class="text-md text-gray-700">Posted by {{ userName }}</small>
      </div>
    </div>
    <div>
      <div class="mb-3">
      <span v-if="isLiked == ''" class="border bg-white py-1 px-2 rounded cursor-pointer" @click="likePhoto(currentUser.id)"><fa icon="heart" class="text-red-500 mr-2" />{{ likes }}</span>
      <span v-else class="border bg-white py-1 px-2 rounded cursor-pointer" @click="unlikePhoto(currentUser.id)"><fa icon="heart" class="text-red-500 mr-2" />{{ likes }}</span>
</div>
      <h3 class="text-xl font-semibold lg:mb-7"><fa icon="comment" class="mr-2" />Comments</h3>
<div class="font-sans flex items-center justify-start bg-blue-darker w-full pb-8">
                <div v-if="comments.length != 0" class="overflow-hidden bg-white w-full leading-normal">
                    <div v-for="comment in comments" :key="comment" class="block group hover:bg-blue p-4 border-b">
                        <p class="font-bold text-lg mb-1 text-black">{{ comment.user.name}}</p>
                        <p class="text-grey-darker mb-2">{{ comment.content }}</p>
                    </div>
                </div>
                <p v-else>No comment yet.</p>
            </div>
      <div v-if="currentUser.length != 0" class="lg:flex gap-0.5 mt-4">
        <CommentForm :currentUser="currentUser" :photoId="photoId" />
      </div>
    </div>
  </section>
</main>
</template>

<script>
import { ref, onMounted, watch } from 'vue';
import Axios from 'axios';
import Like from './Like.vue';
import CommentForm from './CommentForm.vue';
import { useStore } from 'vuex';

export default {
  components: {
    Like, CommentForm
  },
  props: {
    id: String
  },
  setup(props) {
    const currentUser = ref([])
    const photoId = ref('')
    const isLiked = ref()
    const photo = ref([])
    const comments = ref([])
    const userName = ref('')
    const store = useStore()
    const likes = ref()

    photoId.value = props.id

    // get current user
    const getCurrentUser = async () => {
      await store.dispatch('getCurrentUser')
      currentUser.value = store.state.user
      checkLiked(currentUser.value.id)
    }

    // check if current user like this photo
    const checkLiked = async (currentUserId) => {
      await Axios.get('/api/users/' + currentUserId + '/photos/' + photoId.value + '/check')
          .then(res => {
            isLiked.value = res.data
            console.log(res.data);
          })
          .catch(err => {
              console.log(err.response)
          })
    }

    // get number of likes each photo
    const getLikes = async () => {
      await store.dispatch('like/getLikes', photoId.value)
      likes.value = store.state.like.likes
    }

    // get photo detail
    const getPhotoDetail = async () => {
       await Axios.get('/api/photos/' + photoId.value)
                  .then( res => {
                    getLikes()
                    photo.value = res.data[0]
                    userName.value = res.data[0].user.name
                  })
                  .catch( err => {
                    console.log(err.response)
                  })
    }

    // get all comments that belong to this photo
    const getComments = async () => {
      await store.dispatch('getComments', photoId.value)
      comments.value = store.state.comments
    }

    // show alert if no user logged in
    const showAlert = (id) => {
      if(typeof id == 'undefined'){
        alert('ログインしてください')
        return false;
      }
    }

    // like photo
    const likePhoto = async (currentUserId) => {
      showAlert(currentUserId)
      await Axios.post('/api/users/' + currentUserId + '/photos/' + photoId.value + '/like')
                  .then(res => {
                    checkLiked(currentUserId)
                     getLikes()
                  })
                  .catch(err => {
                      console.log(err.response)
                  })
    }

    // unlike photo
    const unlikePhoto = async (currentUserId) => {
      showAlert(currentUserId)
      await Axios.delete('/api/users/' + currentUserId + '/photos/' + photoId.value + '/unlike')
                  .then(res => {
                    checkLiked(currentUserId)
                     getLikes()
                  })
                  .catch(err => {
                      console.log(err.response)
                  })
    }

    onMounted(() => {
      getCurrentUser()
      getPhotoDetail()
      getComments()
    })

    watch(() => props.id, () => {
      getCurrentUser()
      getPhotoDetail()
      getComments()
    })

    // watch(() => comments.value, () => {
    //   getComments()
    // })

    return {
      photo, likes, comments, userName, photoId, currentUser, likePhoto, unlikePhoto, isLiked
    }
  },
}
</script>
