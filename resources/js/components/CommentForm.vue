<template>
  <div class="flex-col justify-center">
  <div class="mb-3 xl:w-96">
    <p v-if="errMessage" class="text-red-500">{{ errMessage }}</p>
    <label for="exampleFormControlTextarea1" class="form-label inline-block mb-2 text-gray-700"
      >add comment</label
    >
    <textarea
      class="
        form-control
        block
        w-full
        px-3
        py-1.5
        text-base
        font-normal
        text-gray-700
        bg-white bg-clip-padding
        border border-solid border-gray-300
        rounded
        transition
        ease-in-out
        m-0
        focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none resize-none
      "
      id="exampleFormControlTextarea1"
      rows="3"
      placeholder="Your message" v-model="content"
    ></textarea>
  </div>
  <button type="button" class="bg-gray-700 text-white p-2 rounded float-right" @click="addComment">submit comment</button>
</div>
</template>

<script>
import { ref, onMounted, watch } from 'vue';
import Axios from 'axios';
import { useRouter } from 'vue-router'
import { useStore } from 'vuex';

export default {
  props: {
    currentUser: Object,
    photoId: Number
  },
  setup(props, context) {
    const content = ref('')
    const store = useStore()
    const errMessage = ref('')

    // add new comment
    const addComment = async () => {
      await Axios.post('/api/photos/' + props.photoId + '/add_comment', {
        content: content.value,
        user_id: props.currentUser.id
      })
                 .then( res => {
                   errMessage.value = ''
                   content.value = ''
                 })
                 .catch( err => {
                   console.log(err.response)
                   errMessage.value = err.response.data.errors.content
                 })
    }

    return {
      content, addComment, errMessage
    }
  },
}
</script>
