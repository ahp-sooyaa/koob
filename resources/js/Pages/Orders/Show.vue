<template>
  <Head>
    <title>Order Detail</title>
    <meta
      head-key="description"
      name="description"
      content="This is the order detail page."
    >
  </Head>

  <BreezeNavBarLayout>
    <template #header>
      <h2 class="flex items-center space-x-2 font-semibold text-xl text-gray-800 leading-tight">
        <Link
          :href="route('orders.index')"
          class="text-gray-500 hover:text-gray-900"
        >
          Order History
        </Link> 
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="h-6 w-6 text-gray-400"
          viewBox="0 0 20 20"
          fill="currentColor"
        >
          <path
            fill-rule="evenodd"
            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
            clip-rule="evenodd"
          />
        </svg>
        <div>Order Details</div>
      </h2>
    </template>

    <div class="container mx-auto divide-y-2 lg:w-1/2 mt-12 mb-16 p-4">
      <div class="flex items-baseline space-x-3">
        <h1 class="text-2xl font-semibold mb-5">
          Order #{{ order.id }}
        </h1>
        <span>{{ order.status == 0 ? 'Shipping' : 'Delivered on ' + formatDate(order.updated_at) }}</span>
      </div>
      <div
        v-for="book in order.books"
        :key="book.id"
        class="w-full"
      >
        <div class="flex flex-col lg:flex-row space-y-5 my-8">
          <img
            :src="book.cover"
            alt="book cover"
            class="mr-5 w-52 lg:w-32"
          >
          <div class="flex flex-col">
            <div class="flex-1">
              <h1 class="mb-1 font-bold text-lg">
                {{ book.title }}
              </h1>
              <p class="max-w-xl text-gray-700 tracking-wide">
                {{ book.excerpt }}
              </p>
            </div>
            <div class="flex w-full divide-x">
              <div class="mr-3">
                <span class="text-gray-600">Quantity</span> <span class="font-bold">{{ book.pivot.quantity }}</span>
              </div>
              <div class="pl-3">
                <span class="text-gray-600">Price</span> <span class="font-bold">{{ formatPrice(book.price) }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="w-full">
        <div class="flex w-full lg:w-2/3 ml-auto my-8">
          <div class="flex-1">
            <div class="font-semibold mb-2">
              Shipping address
            </div>
            <div class="text-gray-700">
              <div>{{ order.address }}</div>
              <div>{{ order.city }}</div>
              <div>{{ order.state }}, {{ order.zip_code }}</div>
            </div>
          </div>
          <div class="flex-1">
            <div class="font-semibold mb-2">
              Billing address
            </div>

            <div class="text-gray-700">
              <div>Kristin Watson</div>
              <div>7363 Cynthia Pass</div>
              <div>Toronto, ON N3Y 4H8</div>
            </div>
          </div>
        </div>
      </div>
      <div class="w-full lg:w-2/3 ml-auto">
        <div class="flex flex-col my-8 space-y-4">
          <div class="flex justify-between">
            <div class="text-gray-700">
              Subtotal
            </div> 
            <div class="font-semibold">
              {{ formatPrice(order.total) }}
            </div>
          </div>
          <div class="flex justify-between">
            <div class="text-gray-700">
              Delivery Fee
            </div> 
            <div class="font-semibold">
              Free
            </div>
          </div>
          <div class="flex justify-between">
            <div class="text-gray-700">
              Total
            </div> 
            <div class="font-semibold">
              {{ formatPrice(order.total) }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </BreezeNavBarLayout>
</template>

<script>
import BreezeNavBarLayout from '@/Layouts/NavBar'
import format from '@/mixins/format'

export default {
    components: {
        BreezeNavBarLayout
    },

    mixins: [ format ],

    props: ['order'],
}
</script>

<style lang="scss" scoped>
</style>