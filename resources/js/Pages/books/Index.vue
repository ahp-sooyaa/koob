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
    <section class="max-w-7xl mx-auto px-6 lg:px-10 my-16 pt-7">
      <search-box />
      <div v-if="booksCount">
        <div v-if="Object.keys(books.data).length">
          <div
            class="grid grid-cols-1 gap-y-5 md:grid-cols-3 lg:grid-cols-5 md:gap-10 my-5"
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
    </section>
  </BreezeNavBarLayout>
</template>

<script>
import BreezeNavBarLayout from '@/Layouts/NavBar'
import Book from './Book'
import SearchBox from '@/Components/SearchBox.vue'
import Paginator from '@/Components/Paginator.vue'

export default {
    components: { 
        BreezeNavBarLayout,
        Book,
        SearchBox,
        Paginator,
    },

    props: {
        books: {
            type: Object,
            required: true
        },
        booksCount: {
            type: Number,
            required: true
        }
        // filters: {
        //     type: Object,
        //     required: true
        // }
    },

    computed: {
        searchQuery() {
            return location.search.match(/search=(\w+)/)[1]
        }
    }
}
</script>