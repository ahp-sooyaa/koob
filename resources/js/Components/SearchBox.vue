<template>
  <div class="flex items-center mb-5">
    <input
      v-model="search"
      type="text"
      placeholder="search"
      class="rounded-2xl"
    >
  </div>
</template>

<script>
import debounce from 'lodash/debounce'
export default {
    data() {
        return {
            search: location.search.match(/search=(\w+)/) ? location.search.match(/search=(\w+)/)[1] : '',
        }
    },

    watch: {
        // wait 500milliseconds after user stop typing to search the result
        search: debounce(function(value) {
            let data = value ? { search: value } : {}

            this.$inertia.get(this.$page.url.split('?')[0], data, {
                preserveState: true,
                replace: true,
            })
        }, 300)
    },
}
</script>

<style lang="scss" scoped>

</style>