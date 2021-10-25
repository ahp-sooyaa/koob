<template>
  <div
    v-if="show"
    class="bg-gray-100 bottom-0 fixed flex items-center left-0 right-0 top-0"
  >
    <div class="text-center lg:w-2/3 w-full mx-auto mt-8 overflow-auto">
      <h2
        class="text-sm title-font text-gray-500 tracking-widest"
        v-text="'Transaction ID: ' + order.transaction_id"
      />
      <h1 class="text-gray-900 text-3xl title-font font-medium mb-4">
        Thank you for your purchase
      </h1>
    </div>
  </div>
</template>
<script>
export default {
    data() {
        return {
            order: {},
            show: false
        }
    },

    created() {
        window.events.on('thankyou', data => {
            this.order = data.data
            this.show = true
        })
    },
}
</script>