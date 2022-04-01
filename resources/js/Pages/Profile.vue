<template>
  <Head title="profile" />
  <div class="bg-white mt-16 pb-10 pt-12 shadow">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-center space-x-5">
        <img
          src="/images/cover.png"
          alt="profile image"
          class="rounded-3xl h-40 w-40"
        >
        <div>
          <h1 class="text-3xl mb-2">
            <!-- Aung Htet Paing -->
            {{ $page.props.auth.user.name }}
          </h1>
          <p class="text-gray-500 mb-7">
            <!-- apaing894@gmail.com -->
            {{ $page.props.auth.user.email }}
          </p>
          <Link
            :href="route('books.index')"
            class="border hover:border-gray-700 px-4 py-1.5 rounded-2xl text-sm"
          >
            Edit
          </Link>
        </div>
      </div>

      <!-- dashboard stats -->
      <div class="flex justify-center mt-16 space-x-10">
        <div class="relative w-40 text-center border flex flex-col p-5 rounded-lg">
          <svg
            class="fill-current text-gray-500 h-16 w-16 mx-auto absolute -top-8 left-1/2 transform -translate-x-1/2 bg-white border rounded-full p-3"
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 20 20"
            fill="currentColor"
          >
            <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" />
          </svg>
          <p class="text-2xl font-bold mb-2 mt-5">
            0
          </p>
          <p class="leading-tight text-gray-700 text-sm">
            Total Purchased <br> Books
          </p>
        </div>
        <div class="relative w-40 text-center border flex flex-col p-5 rounded-lg">
          <svg
            class="fill-current text-gray-500 h-16 w-16 mx-auto absolute -top-8 left-1/2 transform -translate-x-1/2 bg-white border rounded-full p-3"
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 20 20"
            fill="currentColor"
          >
            <path
              fill-rule="evenodd"
              d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"
              clip-rule="evenodd"
            />
          </svg>
          <p class="text-2xl font-bold mb-2 mt-5">
            0
          </p>
          <p class="leading-tight text-gray-700 text-sm">
            Total Spent <br> Amount
          </p>
        </div>
        <div class="relative w-40 text-center border flex flex-col p-5 rounded-lg">
          <svg
            class="fill-current text-gray-500 h-16 w-16 mx-auto absolute -top-8 left-1/2 transform -translate-x-1/2 bg-white border rounded-full p-3"
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 20 20"
            fill="currentColor"
          >
            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
            <path
              fill-rule="evenodd"
              d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z"
              clip-rule="evenodd"
            />
          </svg>
          <p class="text-2xl font-bold mb-2 mt-5">
            {{ totalOrderCount }}
          </p>
          <p class="leading-tight text-gray-700 text-sm">
            Total <br> Orders
          </p>
        </div>
        <div class="relative w-40 text-center border flex flex-col p-5 rounded-lg">
          <svg
            class="fill-current text-gray-500 h-16 w-16 mx-auto absolute -top-8 left-1/2 transform -translate-x-1/2 bg-white border rounded-full p-3"
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 20 20"
            fill="currentColor"
          >
            <path
              fill-rule="evenodd"
              d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
              clip-rule="evenodd"
            />
          </svg>
          <p class="text-2xl font-bold mb-2 mt-5">
            0
          </p>
          <p class="leading-tight text-gray-700 text-sm">
            Pending <br> Orders
          </p>
        </div>
      </div>
    </div>
  </div>

  <!-- links -->
  <div class="z-20 shadow bg-white border-b border-black flex justify-center pt-6 rounded-b-2xl space-x-10 sticky top-16 mb-16">
    <Link
      :href="route('books.index')"
      class="border-b-2 border-blue-500 px-3 py-1.5"
    >
      My Orders
    </Link>
    <Link
      :href="route('books.index')"
      class="text-gray-500 hover:text-gray-700 px-3 py-1.5"
    >
      My Wishs
    </Link>
  </div>

  <!-- orders list -->
  <div
    v-if="orders.length"
    class="divide-y space-y-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-16"
  >
    <div
      v-for="order in orders"
      :key="order.id"
      class="max-w-2xl mx-auto space-y-5"
    >
      <div class="flex items-baseline space-x-3 mb-5 pt-10">
        <h1 class="text-2xl">
          Order #{{ order.id }}
        </h1>
        <span>Order placed on {{ formatDate(order.created_at) }}</span>
      </div>
      <div
        v-for="(book) in order.books"
        :key="book.id"
        class="flex items-start space-x-5 justify-between"
      >
        <div class="flex space-x-5">
          <img
            :src="book.cover"
            alt="book cover"
            class="h-36"
          >
          <div>
            <div
              class=""
              v-text="book.title"
            />
            <!-- <div
              class=""
              v-text="book.pivot.quantity"
            /> -->
            <div
              class="font-semibold"
              v-text="formatPrice(book.price)"
            />
          </div>
        </div>
        <div class="space-y-3">
          <div class="bg-blue-500 border-0 capitalize cursor-pointer flex focus:outline-none hover:bg-blue-400 justify-center px-6 py-2 rounded text-sm text-white">
            buy again
          </div>
          <div class="border capitalize cursor-pointer flex focus:outline-none hover:border-gray-700 justify-center px-6 py-2 rounded text-sm">
            shop similar
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- end of orders list -->

  <div
    v-else
    class="text-center pb-16"
  >
    <lottie-player
      src="https://assets6.lottiefiles.com/packages/lf20_0s6tfbuc.json"
      background="transparent"
      speed="1"
      style="width: 200px; height: 200px;"
      loop
      autoplay
      class="mx-auto"
    />
    <p class="mb-3 text-gray-700">
      You didn't order anything!
    </p>
    <Link
      :href="route('books.index')"
      class="bg-blue-500 px-3 py-1.5 rounded-md text-white shadow"
    >
      Continue Shopping
    </Link>
  </div>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3'
import BreezeNavBarLayout from '@/Layouts/NavBar'
import moment from 'moment'

export default {
    components: {
        Link,
        Head
    },

    layout: BreezeNavBarLayout,

    props: ['orders'],

    computed: {
        totalOrderCount() {
            return this.orders.length
        }
    },

    methods: {
        formatPrice(price) {
            return (price / 100).toLocaleString('en-US', {style: 'currency', currency: 'USD'})
        },
        formatDate(value) {
            return moment(value).format('MMM D, Y')
        }
    }
}
</script>

<style lang="scss" scoped>

</style>