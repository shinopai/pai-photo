<template>
  <div v-if="isActive" class="wrapper px-2 w-full">
         <form
            action=""
            class="max-w-sm bg-gray-100 px-3 py-5 rounded shadow-lg my-10 m-auto" @submit.prevent="submitPhoto(photo)" enctype="multipart/form-data"
         >
            <div class="flex flex-col space-y-3">
               <div
                  class="flex items-center bg-white border border-gray-100 rounded px-2"
               >
                  <input
                     type="file"
                     class="w-full py-2 px-1 placeholder-indigo-400 outline-none placeholder-opacity-50"
                     autocomplete="off" @change="onFileChange"
                  />
               </div>
               <output class="form_output" v-if="preview">
                <img :src="preview" alt="">
              </output>
               <button
                  type="submit"
                  class="text-white bg-indigo-500 px-4 py-2 rounded"
               >
                  Submit
               </button>
            </div>
         </form>
      </div>
</template>

<script>
import { ref } from 'vue';
import Axios from 'axios';
import { useRouter } from 'vue-router';

Axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
};

export default {
  props: {
    isActive: Boolean,
    currentUser: Object
  },
  setup(props) {
    const preview = ref()
    const photo = ref()
    const router = useRouter()

    // reset preview
    const reset = () => {
      preview.value = ''
      photo.value = ''
    }

    // execute when file is active on form
    const onFileChange = (e) => {
      if(e.target.files.length == 0){
        reset()
        return false;
      }

      if(! e.target.files[0].type.match('image.*')){
        reset()
        return flase;
      }

      const reader = new FileReader();

      reader.onload = (e) => {
        preview.value = e.target.result
      }

      reader.readAsDataURL(e.target.files[0])

      photo.value = e.target.files[0]
    }

    // submit new photo
    const submitPhoto = async (photo) => {
      const formData = new FormData()
      formData.append('path', photo)
      formData.append('user_id', props.currentUser.id)
      await Axios.post('/api/photos', formData)
                 .then( res => {
                   console.log(res.data);
                   const latestId = res.data
                   reset()
                   router.push('/photos/' + latestId)
                 })
                 .catch( err => {
                   console.log(err.response);
                 })
    }

    return {
      onFileChange, preview, photo, submitPhoto
    }
  },
}
</script>
