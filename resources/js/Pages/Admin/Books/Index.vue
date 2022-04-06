<template>
  <Head title="Admin - Manage Books" />

  <div class="bg-white p-5 shadow">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      Books List
    </h2>
  </div>

  <div class="my-12 mx-5">
    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th
              scope="col"
              class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
            >
              Cover
            </th>
            <th
              scope="col"
              class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
            >
              Title
            </th>
            <th
              scope="col"
              class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
            >
              Author
            </th>
            <th
              scope="col"
              class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
            >
              Price
            </th>
            <th
              scope="col"
              class="relative px-6 py-3"
            >
              <span class="sr-only">Edit</span>
            </th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          <tr
            v-for="book in books"
            :key="book.id"
          >
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="flex items-center">
                <div class="flex-shrink-0 h-20 w-18">
                  <img
                    class="h-20 w-18 rounded-md"
                    alt="book cover"
                    :src="book.cover"
                  >
                </div>
              </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="text-sm text-gray-900">
                {{ book.title }}
              </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
              {{ book.author }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
              {{ book.price }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
              <a
                href="#"
                class="text-indigo-600 hover:text-indigo-900"
              >Edit</a>
            </td>
          </tr>

          <!-- More people... -->
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
import AdminLayout from '@/Layouts/Admin'
import { Head } from '@inertiajs/inertia-vue3'

export default {
    components: {
        Head
    },

    layout: AdminLayout,

    props: ['books']
}
</script>

<style lang="scss" scoped>

</style>