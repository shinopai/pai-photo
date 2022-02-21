<template>
<main class="grid place-items-center bg-gray-100">
  <section class="flex flex-col md:flex-row gap-11 py-10 px-5 bg-white rounded-md shadow-lg w-3/4">
    <div class="text-indigo-500 flex flex-col justify-between w-1/2 h-80">
        <img v-if="photo.path == 'dammy.jpg'" src="/images/dammy.jpg" alt="dammy" class="object-cover w-full h-full"><img v-else :src="photo.path" alt="photo" class="object-cover w-full h-full">
      <div>
        <small class="text-md text-gray-700">Posted by {{ userName }}</small>
      </div>
    </div>
    <div>
      <div class="mb-3">
      <span v-if="isLiked" class="border bg-white py-1 px-2 rounded cursor-pointer" @click="unlikePhoto"><fa icon="heart" class="text-red-500 mr-2" />{{ likes }}</span>
      <span v-else class="border bg-white py-1 px-2 rounded cursor-pointer" @click="likePhoto"><fa icon="heart" class="text-red-500 mr-2" />{{ likes }}</span>
</div>
      <h3 class="text-xl font-semibold mb-7"><fa icon="comment" class="mr-2" />Comments</h3>
<div class="font-sans flex items-center justify-start bg-blue-darker w-full pb-8">
                <div v-if="comments.length != 0" class="overflow-hidden bg-white w-full leading-normal">
                    <div v-for="comment in comments" :key="comment" class="block group hover:bg-blue p-4 border-b">
                        <p class="font-bold text-lg mb-1 text-black">{{ comment.user.name}}</p>
                        <p class="text-grey-darker mb-2">{{ comment.content }}</p>
                    </div>
                </div>
                <p v-else>No comment yet.</p>
            </div>
      <div v-if="currentUser.length != 0" class="flex gap-0.5 mt-4">
        <CommentForm :currentUser="currentUser" :photoId="photoId" />
      </div>
      <div v-else>コメントするにはログインしてください</div>
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
    const photo = ref([])
    const comments = ref([])
    const userName = ref('')
    const currentUser = ref([])
    const photoId = ref('')
    const store = useStore()
    const likes = ref()

    // get current user
    const getCurrentUser = async () => {
      await store.dispatch('getCurrentUser')
      currentUser.value = store.state.user
    }

    // get photo detail
    const getPhotoDetail = async () => {
       await Axios.get('/api/photos/' + props.id)
                  .then( res => {
                    getLikes(props.id)
                    photo.value = res.data[0]
                    userName.value = res.data[0].user.name
                    photoId.value = props.id
                  })
                  .catch( err => {
                    console.log(err.response)
                  })
    }

    // get all comments that belong to this photo
    const getComments = async () => {
      await store.dispatch('getComments', props.id)
      comments.value = store.state.comments
    }

    // get number of likes each photo
    const getLikes = async (photoId) => {
      await store.dispatch('getLikes', photoId);
      likes.value = store.state.likes
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

    watch(() => comments.value, () => {
      getComments()
    })

    return {
      photo, likes, comments, userName, photoId, currentUser
    }
  },
}
</script>
