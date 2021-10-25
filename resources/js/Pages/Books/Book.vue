<template>
  <div class="h-full">
    <div class="bg-white shadow flex h-72 items-center justify-center mb-3 rounded-2xl">
      <img
        :src="data.cover"
        alt="cover"
        class="h-4/5 w-5/6"
      >
    </div>
    <div class="mx-auto w-5/6">
      <h1 class="text-lg font-semibold">
        {{ data.title }}
      </h1>
      <div class="flex justify-center items-center">
        <span class="font-bold mr-3 text-xl">${{ data.price }}</span>
        <button
          class="bg-blue-500 font-bold px-4 py-2 rounded-xl text-white"
          @click="addToCart"
        >
          Add to Cart
        </button>
      </div>
    </div>
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
    methods: {
        addToCart() {
            axios.post(`books/${this.data.id}/cart`)
                .catch(err => console.log(err))
                .then(() => {
                    window.events.emit('added')
                    window.flash('Successfully added to Cart')
                })
        }
    }
}
</script>