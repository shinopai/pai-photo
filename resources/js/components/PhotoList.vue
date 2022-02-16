<template>
<div>
    <button v-if="currentUser" class="p-2 pl-5 pr-5 bg-transparent border-2 border-gray-500 text-gray-500 rounded-lg hover:bg-gray-500 hover:text-gray-100 focus:border-4 focus:border-gray-300 ml-5" @click="isActive = !isActive"> <fa icon="plus" class="mr-2" />Submit a Photo</button>

    <PhotoForm :isActive="isActive" :currentUser="currentUser" />

<div class="flex flex-wrap justify-evenly items-center mt-10 lg:w-5/6 gap-2 mx-auto">
	<div v-for="photo in photos" :key="photo" class="item w-1/4 h-40 border-2"><img v-if="photo.path == 'dammy.jpg'" src="images/dammy.jpg" alt="dammy" class="object-fill h-full w-full"><img v-else :src="photo.path" alt="dammy" class="object-fill h-full w-full">
</div>
</div>
</div>
</template>

<script>
import { ref, onMounted } from 'vue';
import Axios from 'axios';
import { useStore } from 'vuex';
import PhotoForm from './PhotoForm.vue';

export default {
  components: {
    PhotoForm
  },
  setup() {
    const photos = ref([])
    const currentUser = ref()
    const store = useStore()
    let isActive = ref(false)

    // get current user
    const getCurrentUser = async () => {
      await store.dispatch('getCurrentUser')
      currentUser.value = store.state.user
    }

    // get all photos
    const getAllPhotos = async () => {
      await Axios.get('/api/photos')
                 .then( res => {
                   photos.value = res.data.data
                   console.log(photos.value);
                 })
                 .catch( err => {
                   console.log(err.response.data)
                 })
    }

    onMounted(() => {
      getCurrentUser()
      getAllPhotos()
    })

    return {
      photos, currentUser, isActive
    }
  },
}
</script>
