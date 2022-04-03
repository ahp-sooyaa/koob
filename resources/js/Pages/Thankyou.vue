<template>
  <div
    class="min-h-screen bg-gray-50 flex flex-col justify-center items-center"
  >
    <div class="text-center lg:w-2/3 w-full mx-auto overflow-auto">
      <h2
        class="text-sm title-font text-gray-700 tracking-widest"
        v-text="'Transaction ID: ' + order.transaction_id"
      />
      <h1 class="bg-clip-text bg-gradient-to-r font-bold from-blue-500 inline-block mb-7 text-4xl text-transparent title-font to-red-500">
        Thank you for your purchase
      </h1>
    </div>
  </div>
</template>
<script>
export default {
    props: ['order'],
}
</script>
