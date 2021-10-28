<template>
  <BreezeNavBarLayout>
    <Flash />
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-7">
      <section>
        <h1 class="font-bold mb-3 text-gray-500 text-xl">
          All Books
        </h1>
        <div class="grid grid-cols-5 gap-4">
          <div
            v-for="book in books"
            :key="book.id"
            class="flex flex-col"
          >
            <Book :data="book" />
          </div>
        </div>
      </section>
    </main>
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