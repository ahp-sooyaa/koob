<template>
  <BreezeNavBarLayout>
    <Flash />
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 my-16 pt-7">
      <div class="flex justify-center">
        <img
          :src="book.cover"
          alt="book_cover"
        >
        <div class="ml-8 w-1/2">
          <h1 class="font-bold mb-1 text-4xl tracking-tight">
            {{ book.title }}
          </h1>
          <div class="font-semibold mb-3 text-2xl text-gray-900">
            {{ formatPrice(book.price) }}
          </div>
          <p class="mb-3 text-gray-600">
            {{ book.excerpt }}
          </p>
          <div class="flex">
            <select
              id="qty"
              v-model="quantity"
              name="qty"
              class="mr-3"
            >
              <option
                v-for="qty in 10"
                :key="qty"
                :value="qty"
              >
                {{ qty }}
              </option>
            </select>
            <button
              @click="addToCart"
              class="w-60 font-bold px-4 py-2 rounded-xl text-white"
              :class="isAdded ? 'bg-gray-500 cursor-not-allowed' : 'bg-blue-500'"
              :disabled="isAdded"
            >
              Add to Cart
            </button>
          </div>
        </div>
      </div>
    </section>
  </BreezeNavBarLayout>
</template>

<script>
import Flash from '@/Components/FlashNoti'
import BreezeNavBarLayout from '@/Layouts/NavBar'
export default {
    components: {
        Flash,
        BreezeNavBarLayout
    },

    props: {
        book: {
            type: Object,
            required: true
        }
    },

    data(){
        return {
            quantity: 1,
            isAdded: this.$page.props.cart.some( item => item['id'] === this.book.id )
        }
    },

    methods: {
        formatPrice(price) {
            return (price / 100).toLocaleString('en-US', {style: 'currency', currency: 'USD'})
        },

        addToCart() {
            axios.post(`/books/${this.book.id}/cart`, { qty: this.quantity})
                .catch(err => console.log(err))
                .then(() => {
                    this.isAdded = true
                    window.events.emit('added')
                    window.flash('Successfully added to Cart')
                })
        }
    }
}
</script>

<style lang="scss" scoped>

</style>