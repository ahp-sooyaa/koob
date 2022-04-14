<template>
  <div class="flex space-x-3">
    <!-- prev page link -->
    <Component
      :is="prevPage.url ? 'Link' : 'span'"
      :href="prevPage.url"
      :class="prevPage.url ? 'cursor-pointer hover:border-gray-700' : 'text-gray-500'"
      preserve-scroll
      class="border flex items-center pl-4 pr-3 py-2 rounded rounded-l-full text-gray-500 text-sm"
    >
      Prev
    </Component>

    <!-- pagination elements -->
    <Link
      v-for="link in pageLinks"
      :key="link.label"
      :href="link.url"
      class="border px-2 rounded hover:border-gray-700 flex items-center"
      :class="link.active ? 'border-gray-700' : ''"
      preserve-scroll
      v-text="link.label"
    />

    <!-- next page link -->
    <Component
      :is="nextPage.url ? 'Link' : 'span'"
      :href="nextPage.url"
      :class="nextPage.url ? 'cursor-pointer hover:border-gray-700' : 'text-gray-500'"
      preserve-scroll
      class="border flex items-center pl-3 pr-4 py-2 rounded rounded-r-full text-gray-500 text-sm"
    >
      Next
    </Component>
  </div>
</template>

<script>
export default {
    props: ['links'],

    // data() {
    //     return {
    //         pageLinks: this.links.slice(1, -1),
    //         prevPage: this.links[0],
    //         nextPage: this.links[this.links.length - 1],
    //     }
    // },

    // watch: {
    //     links(value) {
    //         this.pageLinks = value.slice(1, -1)
    //         this.prevPage = value[0]
    //         this.nextPage = value[value.length - 1]
    //     }
    // }
    computed: {
        pageLinks() {
            return this.links.slice(1, -1)
        },
        prevPage() {
            return this.links[0]
        },
        nextPage() {
            return this.links[this.links.length - 1]
        }
    }
}
</script>

<style lang="scss" scoped>

</style>