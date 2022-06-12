<template>
  <div class="relative flex items-center w-full lg:max-w-min">
    <svg
      xmlns="http://www.w3.org/2000/svg"
      viewBox="0 0 20 20"
      fill="currentColor"
      class="absolute h-5 left-3 text-gray-400 w-5"
    >
      <path
        fill-rule="evenodd"
        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
        clip-rule="evenodd"
      />
    </svg>
    <input
      v-model="search"
      type="text"
      placeholder="search"
      class="w-full lg:w-auto px-10 border-gray-300 hover:shadow hover:border-transparent focus:border-transparent focus:shadow focus:ring-0 rounded-full"
    >
    <img
      v-if="loading"
      src="/images/tail-spin.svg"
      alt="loading svg"
      class="absolute h-5 right-3 w-5"
    >
  </div>
</template>

<script>
import debounce from 'lodash/debounce'
export default {
    props: ['searchQuery'],

    data() {
        return {
            search: this.searchQuery,
            loading: false,
        }
    },

    watch: {
        search: debounce(function (value) {
            this.$inertia
                .get(this.$page.url.replace(/search=(\w+)/, ''), { search: value, page: '' }, {
                    preserveState: true,
                    replace: true,
                    onStart: () => {
                        this.loading = true
                    },
                    onFinish: () => {
                        this.loading = false
                    },
                })
        }, 300),
    },

    created() {
        window.events.on('clearedFilters', () => this.search = '')
    },
}
</script>

<style lang="scss" scoped>
</style>