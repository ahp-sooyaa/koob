<template>
  <BreezeNavBarLayout>
    <Flash />
    <section class="max-w-7xl mx-auto px-6 lg:px-10 my-16 pt-7">
      <h1 class="font-bold mb-3 text-gray-500 text-xl">
        All Books
      </h1>
      <div class="grid grid-cols-1 gap-y-5 md:grid-cols-3 lg:grid-cols-5 md:gap-10">
        <div
          v-for="book in books"
          :key="book.id"
          class="bg-white flex flex-col h-full pb-5 rounded-xl shadow"
        >
          <Book :data="book" />
        </div>
      </div>
    </section>
  </BreezeNavBarLayout>
</template>

<script>
import BreezeNavBarLayout from '@/Layouts/NavBar'
import Book from './Book'
export default {
    components: { 
        BreezeNavBarLayout,
        Book,
    },

    props: {
        books: {
            type: Object,
            required: true
        }
    }
}
</script>