<template>
  <div
    class="min-h-screen bg-gray-50 flex flex-col justify-center items-center"
  >
    <div class="text-center lg:w-2/3 w-full mx-auto mt-8 overflow-auto">
      <h2
        class="text-sm title-font text-gray-500 tracking-widest"
        v-text="'Transaction ID: ' + order.transaction_id"
      />
      <h1 class="text-gray-900 text-4xl title-font font-bold mb-7">
        Thank you for your purchase
      </h1>
    </div>
    <div class="divide-y-2 lg:w-1/2 w-full">
      <div
        v-for="book in order.books"
        :key="book.id"
        class="w-full"
      >
        <div class="flex my-5">
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
              <p class="max-w-xl text-gray-500 tracking-wide">
                {{ book.excerpt }}
              </p>
            </div>
            <div class="flex w-full divide-x">
              <div class="mr-3">
                <span class="font-bold">Quantity</span> <span class="text-gray-500">{{ book.pivot.quantity }}</span>
              </div>
              <div class="pl-3">
                <span class="font-bold">Price</span> <span class="text-gray-500">{{ formatPrice(book.price) }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="w-full">
        <div class="flex w-2/3 ml-auto my-5">
          <div class="flex-1">
            shipping address

            Paduak pin Street
            yangon 201345
            blah blah
          </div>
          <div class="flex-1">
            billing address

            Paduak pin Street
            yangon 201345
            blah blah
          </div>
        </div>
      </div>
      <div class="w-2/3 ml-auto">
        <div class="flex flex-col">
          <div class="flex justify-between">
            <div>sub total</div> 
            <div>12.39</div>
          </div>
          <div class="flex justify-between">
            <div>total</div> 
            <div>26.19</div>
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