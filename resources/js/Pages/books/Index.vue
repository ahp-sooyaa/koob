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
    <section class="flex flex-col lg:flex-row space-y-5 space-x-0 lg:space-y-0 lg:space-x-10 max-w-7xl mx-auto px-4 lg:px-10 mb-14 lg:my-16 pt-7">
      <div class="w-full lg:w-1/5">
        <div class="flex justify-between items-baseline mb-4">
          <h1 class="block">
            Filters by categories
          </h1>
          <span
            @click="clearFilter"
            class="hover:underline text-gray-500 text-sm cursor-pointer"
          >clear</span>
        </div>

        <div class="-ml-1 flex flex-nowrap lg:flex-wrap items-baseline overflow-x-auto pb-3 pt-1 lg:space-y-2">
          <div
            @click="filter = {category_id: ''}"
            class="cursor-pointer bg-white border inline-block px-4 py-1 rounded-2xl shadow text-sm mx-1"
            :class="filters == null || isFiltered('category_id', null) ? 'text-blue-500': 'text-gray-600'"
          >
            all
          </div>
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
      <div class="w-full lg:w-4/5">
        <div class="flex items-center justify-between lg:flex-row lg:items-center space-x-3">
          <search-box />
          <sorting :sorting="sorting" />
        </div>
        <div v-if="booksCount">
          <div v-if="Object.keys(books.data).length">
            <div
              class="grid grid-cols-1 gap-y-5 md:grid-cols-3 lg:grid-cols-4 md:gap-10 my-5"
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
import SearchBox from '@/Components/SearchBox'
import Paginator from '@/Components/Paginator'
import Sorting from '@/Components/Sort'

export default {
    components: {
        BreezeNavBarLayout,
        Book,
        SearchBox,
        Paginator,
        Sorting,
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
            filter: '',
        }
    },

    computed: {
        searchQuery() {
            return location.search.match(/search=(\w+)/) ? location.search.match(/search=(\w+)/)[1] : ''
        },
    },

    watch: {
        filter(value) {
            let data = (value && !this.isFiltered(Object.keys(value), Object.values(value))) 
                ? { filter: value, page: '' } 
                : {  }

            this.$inertia
                .get(this.$page.url, data, {
                    preserveState: true,
                })
        }
    },

    methods: {
        isFiltered(column, value) {
            return this.filters ? this.filters[column] == value : false
        },
        clearFilter() {
            let url = this.$page.url.replace(/&?(filter\[\w+\]=\w+)+/g, '')
            url = this.searchQuery ? url.replace(/&?(search=\w+)/, '') : url

            this.$inertia
                .get(url, {}, {
                    preserveState: true,
                    onFinish: () => {
                        window.events.emit('clearedFilters')
                    },
                })
        }
    },
}
</script>