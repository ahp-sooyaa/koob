<template>
  <Head>
    <title>Shop</title>
    <meta
      head-key="description"
      name="description"
      content="This is the shop page"
    >
  </Head>
  <Flash />

  <BreezeNavBarLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Shop
      </h2>
    </template>
    <section class="flex space-x-10 max-w-7xl mx-auto px-6 lg:px-10 my-16 pt-7">
      <div class="w-1/5">
        <h1 class="block mb-5">
          Filters by categories
        </h1>

        <div class="space-y-2 -ml-1">
          <div
            v-for="category in categories"
            :key="category.id"
            @click="filter = {category_id: category.id}"
            class="cursor-pointer bg-white border inline-block px-4 py-1 rounded-2xl shadow text-gray-600 text-sm mx-1"
            :class="isFiltered('category_id', category.id) ? 'text-blue-500': ''"
          >
            {{ category.name }}
          </div>
        </div>
      </div>
      <div class="w-4/5">
        <div class="flex items-center justify-between mb-10">
          <search-box />
          <!-- {{ filters }} -->
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
                  <!-- {{ $page.props.auth.user.name }} -->
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
              <!-- <div @click="sorting = {created_at: 1}">
                newest
              </div>
              <div @click="sorting = {created_at: -1}">
                oldest
              </div> -->
              <!-- <div @click="sorting = 'price,1'">
                price low to high
              </div>
              <div @click="sorting = 'price,-1'">
                price high to low
              </div> -->
            </template>
          </dropdown>
        </div>
        <div v-if="booksCount">
          <div v-if="Object.keys(books.data).length">
            <div
              class="
                grid grid-cols-1
                gap-y-5
                md:grid-cols-3
                lg:grid-cols-4
                md:gap-10
                my-5
              "
            >
              <div
                v-for="book in books.data"
                :key="book.id"
                class="flex flex-col h-full pb-5 rounded-xl"
              >
                <Book :data="book" />
              </div>
            </div>

            <!-- paginator -->
            <paginator :links="books.links" />
          </div>

          <div v-else>
            <p>No results found for "{{ searchQuery }}"</p>
            <p>Try different keywords or check spelling.</p>
          </div>
        </div>

        <div
          v-else
          class="text-center"
        >
          Woah Woah, someone forgot to add books data to database? <br>
          Check database please.
        </div>
      </div>
    </section>
  </BreezeNavBarLayout>
</template>

<script>
import BreezeNavBarLayout from '@/Layouts/NavBar'
import Book from './Book'
import SearchBox from '@/Components/SearchBox.vue'
import Paginator from '@/Components/Paginator.vue'
import Dropdown from '@/Components/Dropdown.vue'

export default {
    components: {
        BreezeNavBarLayout,
        Book,
        SearchBox,
        Paginator,
        Dropdown,
    },

    props: {
        books: {
            type: Object,
            required: true,
        },
        booksCount: {
            type: Number,
            required: true,
        },
        categories: {
            type: Object,
            required: true
        },
        sorting: {
            type: Object,
            default: null
        },
        filters: {
            type: Object,
            default: null
        }
    },

    data() {
        return {
            loading: false,
            sort: '',
            filter: '',
        }
    },

    computed: {
        searchQuery() {
            return location.search.match(/search=(\w+)/) ? location.search.match(/search=(\w+)/)[1] : ''
        },
    },

    watch: {
        sort(value) {
            let data = value ? { sort: value } : {}
            this.$inertia
                .get(this.$page.url, data, {
                    preserveState: true,
                })
        },
        filter(value) {
            let url = this.isFiltered(Object.keys(value), Object.values(value))
                ? this.$page.url.replace(/&?(filter\[\w+\]=\w+)/, '') 
                : this.$page.url
            let data = value ? { filter: value } : {}
            this.$inertia
                .get(url, data, {
                    preserveState: true,
                })
        }
    },

    methods: {
        isSorted(column, direction) {
            return this.sorting ? this.sorting[column] == direction : ''
            // return column in this.sorting (this is so cool when checking key exist in array)
        },
        isFiltered(column, value) {
            return this.filters ? this.filters[column] == value : ''
        }
        // applyFilter(filter) {
        //     console.log(filter)
        //     this.filters = filter
        // }
    },
}
</script>