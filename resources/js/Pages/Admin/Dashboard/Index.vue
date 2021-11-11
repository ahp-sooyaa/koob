<template>
  <Head title="Admin Dashboard" />

  <div class="bg-white p-5 shadow">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      Dashboard
    </h2>
  </div>

  <div class="mt-10 mx-5">
    main content
  </div>
</template>

<script>
import { Head } from '@inertiajs/inertia-vue3'
import AdminLayout from '@/Layouts/Admin'

export default {
    components: {
        Head
    },
    layout: AdminLayout
}
</script>
