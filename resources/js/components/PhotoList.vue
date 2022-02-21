<template>
<div>
    <button v-if="currentUser" class="p-2 pl-5 pr-5 bg-transparent border-2 border-gray-500 text-gray-500 rounded-lg hover:bg-gray-500 hover:text-gray-100 focus:border-4 focus:border-gray-300 ml-5" @click="isActive = !isActive"> <fa icon="plus" class="mr-2" />Submit a Photo</button>

    <PhotoForm :isActive="isActive" :currentUser="currentUser" />

<div class="flex flex-wrap justify-evenly items-center mt-10 lg:w-5/6 gap-2 mx-auto">
	<div v-for="photo in photos" :key="photo" class="item w-1/4 h-40 border-2 relative cursor-pointer" @mouseover="isLayerActive(photo.id)" @mouseout="isLayerInactive(photo.id)">
  <img v-if="photo.path == 'dammy.jpg'" src="images/dammy.jpg" alt="dammy" class="object-fill h-full w-full"><img v-else :src="photo.path" alt="photo" class="object-fill h-full w-full">
  <div class="hidden" :id="`layer${photo.id}`">
  <router-link :to="{ name: 'photo-detail', params: { id: photo.id }}">
  <div class="absolute top-0 left-0 w-full h-full opacity-60" style="background-color: rgba(55,65,81, 0.7)"></div>
  </router-link>
    <Like :photoId="photo.id" :currentUser="currentUser" />
    <span class="absolute bottom-2 left-2 text-white font-bold">{{ photo.user.name }}</span>
  </div>
</div>
</div>
<Pagination :pagination="pagination" />
</div>
</template>

<script>
import { ref, onMounted, watch } from 'vue';
import Axios from 'axios';
import { useStore } from 'vuex';
import PhotoForm from './PhotoForm.vue';
import Like from './Like.vue';
import Pagination from './Pagination.vue';

export default {
  components: {
    PhotoForm, Like, Pagination
  },
  props: {
    page: Number
  },
  setup(props) {
    const photos = ref([])
    const currentUser = ref()
    const store = useStore()
    const pagination = ref({})
    let isActive = ref(false)

    // get current user
    const getCurrentUser = async () => {
      await store.dispatch('getCurrentUser')
      currentUser.value = store.state.user
    }

    // get all photos
    const getAllPhotos = async () => {
      await Axios.get('/api/photos/?page=' + props.page)
                 .then( res => {
                   pagination.value = res.data
                   photos.value = res.data.data
                 })
                 .catch( err => {
                   console.log(err.response.data)
                 })
    }

    // when mouseover event occur
    const isLayerActive = (id) => {
      document.getElementById('layer' + id).classList.remove('hidden');
    }

    // when mouseout event occur
    const isLayerInactive = (id) => {
      document.getElementById('layer' + id).classList.add('hidden');
    }

    onMounted(() => {
      getCurrentUser()
      getAllPhotos()
    })

    // get photos when query is changed
    watch(() => props.page, (to, from) => {
      getAllPhotos()
    })

    return {
      photos, pagination, currentUser, isActive, isLayerActive, isLayerInactive
    }
  },
}
</script>
