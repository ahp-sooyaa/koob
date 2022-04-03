<template>
  <Head title="Order History" />
  <BreezeNavBarLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Order History
      </h2>
    </template>

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
        <div class="flex items-baseline justify-between mb-5 pt-10">
          <div class="flex items-baseline space-x-3">
            <h1 class="text-2xl">
              Order #{{ order.id }}
            </h1>
            <span>Order placed on {{ formatDate(order.created_at) }}</span>
          </div>
          <Link
            :href="route('orders.show', order.id)"
            class="hover:underline"
          >
            Order Detail
          </Link>
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
          <div class="flex-shrink-0 space-y-3">
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
  </BreezeNavBarLayout>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3'
import BreezeNavBarLayout from '@/Layouts/NavBar'
import moment from 'moment'
export default {
    components: {
        Link,
        Head,
        BreezeNavBarLayout
    },

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