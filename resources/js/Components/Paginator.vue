<template>
  <div class="flex justify-between lg:space-x-3">
    <!-- prev page link -->
    <Component
      :is="prevPage.url ? 'Link' : 'span'"
      :href="prevPage.url"
      :class="prevPage.url ? 'cursor-pointer hover:border-gray-700' : 'text-gray-500'"
      preserve-scroll
      class="border flex items-center px-3 rounded-lg text-gray-500 text-sm"
    >
      Prev
    </Component>

    <div class="flex space-x-3">
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
    </div>

    <!-- next page link -->
    <Component
      :is="nextPage.url ? 'Link' : 'span'"
      :href="nextPage.url"
      :class="nextPage.url ? 'cursor-pointer hover:border-gray-700' : 'text-gray-500'"
      preserve-scroll
      class="border flex items-center px-3 rounded-lg text-gray-500 text-sm"
    >
      Next
    </Component>
  </div>
</template>

<script>
export default {
    props: ['links'],

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