<template>
	<ul class="flex pl-0 list-none justify-center rounded my-10">
		<li v-if="pagination.prev_page_url != null" class="relative block py-2 px-3 leading-tight bg-white border border-gray-300 text-gray-700 border-r-0 ml-0 rounded-l hover:bg-gray-200"><a class="page-link" href="#">Prev</a></li>
		<li v-for="n in pagination.last_page" :key="n" class="relative block py-2 px-3 leading-tight bg-white border border-gray-300 text-gray-700 border-r-0 hover:bg-gray-200" :class="{'bg-gray-300' : pagination.current_page == n}"><router-link :to="{ path: '/', query: { page: n }}" class="page-link" :class="{'pointer-events-none' : pagination.current_page == n}">{{ n }}</router-link></li>
		<li v-if="pagination.next_page_url != null" class="relative block py-2 px-3 leading-tight bg-white border border-gray-300 text-gray-700 rounded-r hover:bg-gray-200"><router-link :to="{ path: '/', query: { page: pagination.current_page + 1 } }" class="page-link">Next</router-link></li>
	</ul>
</template>

<script>
import { ref, watch } from 'vue'

export default {
  props: {
    pagination: Object
  },
  setup(props) {
  watch(() => props.pagination, (to, from) => {
    console.log(props.pagination)
  })

  return {

  }
  },
}
</script>
