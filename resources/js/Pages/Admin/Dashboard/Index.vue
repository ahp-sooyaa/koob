<template>
  <Head>
    <title>Admin dashboard</title>
    <meta
      head-key="description"
      name="description"
      content="This is admin dashboard of koob!"
    >
  </Head>

  <div class="bg-white p-5 shadow">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      Dashboard
    </h2>
  </div>

  <div class="mt-10 mx-5">
    main content from main branch
  </div>
</template>

<script>
import AdminLayout from '@/Layouts/Admin'

export default {
    layout: AdminLayout
}
</script>
