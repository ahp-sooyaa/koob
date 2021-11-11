<template>
  <Head title="Admin - Manage Books list" />

  {{ book.title }}
  <img
    :src="book.cover"
    alt="book cover"
  >
</template>

<script>
import AdminLayout from '@/Layouts/Admin'
import { Head } from '@inertiajs/inertia-vue3'

export default {
    components: {
        Head
    },
    layout: AdminLayout,
    props: ['book']
}
</script>

<style lang="scss" scoped>

</style>