<template>
  <div class="bg-white shadow flex h-72 items-center justify-center mb-3 rounded-2xl">
    <img
      :src="data.cover"
      alt="cover"
      class="h-4/5 w-5/6"
    >
  </div>
  <h1 class="flex-1 line-clamp-2 text-md text-center font-bold mb-2">
    {{ data.title }}
  </h1>
  <div class="flex justify-center items-center">
    <span class="font-semibold mr-3 text-md">{{ formatPrice(data.price) }}</span>
    <span class="font-semibold mr-3 text-md">{{ $page.props.cart.id }}</span>
    <button
      @click="addToCart"
      class="font-bold px-4 py-2 rounded-xl text-white"
      :class="isAdded ? 'bg-gray-500 cursor-not-allowed' : 'bg-blue-500'"
      :disabled="isAdded"
    >
      Add to Cart
    </button>
  </div>
</template>

<script>
export default {
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
            axios.post(`books/${this.data.id}/cart`)
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