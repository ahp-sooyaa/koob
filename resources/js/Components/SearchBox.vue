<template>
  <div class="relative flex items-center max-w-min">
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
      class="
        px-10
        border-gray-300
        hover:shadow hover:border-transparent
        focus:border-transparent focus:shadow focus:ring-0
        rounded-full
      "
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
    data() {
        return {
            search: location.search.match(/search=(\w+)/)
                ? location.search.match(/search=(\w+)/)[1]
                : '',
            loading: false,
        }
    },

    watch: {
        // wait 300milliseconds after user stop typing to search the result
        search: debounce(function (value) {
            let data = value ? { search: value, page: '' } : {}

            this.$inertia
                .get(this.$page.url.split('?')[0], data, {
                    preserveState: true,
                    replace: true,
                    onStart: visit => {
                        console.log(`Starting a visit to ${visit.url}`)
                        this.loading = true
                    },
                    onFinish: visit => {
                        console.log(`Finished a visit to ${visit.url}`)
                        this.loading = false
                    },
                })
        }, 300),
    },
}
</script>

<style lang="scss" scoped>
</style>