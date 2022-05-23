<template>
  <div class="flex lg:flex-row justify-between min-w-max lg:w-auto items-baseline space-x-0 lg:space-x-3">
    <dropdown align="right">
      <template #trigger>
        <span class="inline-flex rounded-md">
          <button
            type="button"
            class="
                inline-flex items-center px-3 py-2 border border-transparent text-sm
                leading-4 font-medium rounded-md text-gray-500 bg-white
                hover:text-gray-700 focus:outline-none transition ease-in-out
                duration-150
              "
          >
            <span
              v-if="sorting ? Object.keys(sorting).length : 0"
              class="bg-gray-100 px-1 rounded mr-2"
            >{{ sorting ? Object.keys(sorting).length : 0 }}</span>
            Sort by

            <svg
              class="ml-2 -mr-0.5 h-4 w-4"
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 20 20"
              fill="currentColor"
            >
              <path
                fill-rule="evenodd"
                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                clip-rule="evenodd"
              />
            </svg>
          </button>
        </span>
      </template>

      <template #content>
        <div
          @click="sort = { price: 'asc' }"
          class="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out cursor-pointer"
          :class="isSorted('price', 'asc') ? 'text-blue-500': ''"
        >
          price low to high
        </div>
        <div
          @click="sort = { price: 'desc' }"
          :class="isSorted('price', 'desc') ? 'text-blue-500': ''"
          class="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out cursor-pointer"
        >
          price high to low
        </div>
        <div
          @click="sort = { created_at: 'asc' }"
          :class="isSorted('created_at', 'asc') ? 'text-blue-500': ''"
          class="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out cursor-pointer"
        >
          newest
        </div>
        <div
          @click="sort = { created_at: 'desc' }"
          class="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out cursor-pointer"
          :class="isSorted('created_at', 'desc') ? 'text-blue-500': ''"
        >
          oldest
        </div>
      </template>
    </dropdown>
  </div>
</template>

<script>
import Dropdown from './Dropdown.vue'
export default {
    components: { Dropdown },

    props: ['sorting'],

    data() {
        return {
            sort: '',
        }
    },

    watch: {
        sort(value) {
            let url = this.isSorted(Object.keys(value), Object.values(value))
                ? this.$page.url.replace(/&?(sort\[\w+\]=\w+)/, '') 
                : this.$page.url
            let data = (value && !this.isSorted(Object.keys(value), Object.values(value))) ? { sort: value } : {}
            this.$inertia
                .get(url, data, {
                    preserveState: true,
                })
        },
    },

    methods: {
        isSorted(column, direction) {
            return this.sorting ? this.sorting[column] == direction : false
            // return column in this.sorting (this is so cool when checking key exist in array)
        },
    }
}
</script>

<style lang="scss" scoped>

</style>