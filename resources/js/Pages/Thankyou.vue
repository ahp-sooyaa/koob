<template>
  <div
    class="min-h-screen bg-gray-50 flex flex-col justify-center items-center"
  >
    <div class="text-center lg:w-2/3 w-full mx-auto mt-32 overflow-auto">
      <h2
        class="text-sm title-font text-gray-700 tracking-widest"
        v-text="'Transaction ID: ' + order.transaction_id"
      />
      <h1 class="text-indigo-600 text-4xl title-font font-bold mb-7">
        Thank you for your purchase
      </h1>
    </div>
    <div class="divide-y-2 lg:w-1/2 w-full">
      <div
        v-for="book in order.books"
        :key="book.id"
        class="w-full"
      >
        <div class="flex my-8">
          <img
            :src="book.cover"
            alt="book cover"
            class="mr-5 w-32"
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
                <span class="font-bold">Quantity</span> <span class="text-gray-700">{{ book.pivot.quantity }}</span>
              </div>
              <div class="pl-3">
                <span class="font-bold">Price</span> <span class="text-gray-700">{{ formatPrice(book.price) }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="w-full">
        <div class="flex w-2/3 ml-auto my-8">
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
      <div class="w-2/3 ml-auto">
        <div class="flex flex-col my-8 space-y-4">
          <div class="flex justify-between">
            <div class="font-semibold">
              Subtotal
            </div> 
            <div class="text-gray-700">
              {{ formatPrice(order.total) }}
            </div>
          </div>
          <div class="flex justify-between">
            <div class="font-semibold">
              Total
            </div> 
            <div class="text-gray-700">
              {{ formatPrice(order.total) }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
    props: ['order'],
    
    methods: {
        formatPrice(price) {
            return (price / 100).toLocaleString('en-US', {style: 'currency', currency: 'USD'})
        }
    }
}
</script>
