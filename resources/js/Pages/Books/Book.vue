<template>
  <Head title="Shop" />
  <img
    :src="data.cover"
    alt="cover"
    class="h-96 md:h-72 lg:h-60 w-full mb-3 object-cover rounded-xl"
  >
  <div class="flex flex-1 flex-col px-1">
    <Link
      :href="'books/' + data.id"
      class="font-semibold line-clamp-2 mb-auto text-lg lg:text-sm"
    >
      {{ data.title }}
      <!-- Strategy design engineering -->
    </Link>
    <div class="flex justify-between items-center mt-3">
      <span class="text-gray-500 mr-3 text-lg lg:text-sm">{{ formatPrice(data.price) }}</span>
      <!-- <button
        @click="addToCart"
        class="font-bold px-4 py-2 rounded-xl text-white min-w-max text-sm"
        :class="isAdded ? 'bg-gray-500 cursor-not-allowed' : 'bg-blue-500'"
        :disabled="isAdded"
      >
        Add to Cart
      </button> -->
      <!-- <div
        @click="addToCart"
        class="cursor-pointer bg-gray-200 border border-gray-300 flex h-10 items-center relative rounded-2xl w-10"
        :class="isAdded ? 'cursor-not-allowed' : ''"
        :disabled="isAdded"
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="h-5 w-10"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"
          />
        </svg>
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="absolute bg-black border-2 border-gray-200 h-4 right-1 rounded-full text-white top-1 w-4"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M12 6v6m0 0v6m0-6h6m-6 0H6"
          />
        </svg>
      </div> -->
      <div
        @click="addToCart"
        class="bg-gradient-to-bl border cursor-pointer flex from-indigo-500 items-center relative rounded-xl text-white to-red-500 h-14 w-14 lg:h-12 lg:w-12"
        :class="isAdded ? 'cursor-not-allowed' : ''"
        :disabled="isAdded"
        dusk="addToCart"
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="h-8 w-12"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="1"
            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"
          />
        </svg>
        <svg
          v-if="!isAdded"
          xmlns="http://www.w3.org/2000/svg"
          class="absolute bg-white right-1.5 top-1.5 rounded-full shadow text-gray-600 h-5 w-5 lg:h-4 lg:w-4"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M12 6v6m0 0v6m0-6h6m-6 0H6"
          />
        </svg>
        <svg
          v-else
          xmlns="http://www.w3.org/2000/svg"
          class="absolute bg-white right-1.5 top-1.5 rounded-full shadow text-gray-600 h-5 w-5 lg:h-4 lg:w-4"
          viewBox="0 0 20 20"
          fill="currentColor"
          stroke="none"
        >
          <path
            fill-rule="evenodd"
            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
            clip-rule="evenodd"
          />
        </svg>
        <!-- <svg
          v-else
          xmlns="http://www.w3.org/2000/svg"
          class="absolute bg-white right-1.5 top-1.5 rounded-full shadow text-gray-600 h-5 w-5 lg:h-4 lg:w-4"
          fill="currentColor"
          viewBox="0 0 24 24"
          stroke="none"
          stroke-width="2"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
          />
        </svg> -->
      </div>
    </div>
  </div>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3'
export default {
    components: {
        Head,
        Link
    },
    
    props: {
        data: {
            type: Object,
            required: true
        }
    },

    data() {
        return {
            isAdded: this.$page.props.cart.some( item => item['id'] === this.data.id ) 
        }
    },

    methods: {
        formatPrice(price){
            return (price / 100).toLocaleString('en-us', {style: 'currency', currency: 'USD'})
        },

        addToCart() {
            // if(this.isAdded) return

            axios.post(`/books/${this.data.id}/cart`)
                .then(() => {
                    this.isAdded = true
                    window.events.emit('cartQtyUpdated')
                    window.flash('Successfully added to Cart')
                })
                .catch(err => console.log(err))
        }
    }
}
</script>