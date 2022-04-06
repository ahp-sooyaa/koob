<template>
  <div class="flex flex-row min-h-screen">
    <div class="flex-none bg-gray-900 w-64 text-white">
      <div class="h-full flex flex-col p-6">
        <div class="text-center">
          <div class="text-base">
            {{ $page.props.auth.user.name }}
          </div>

          <div class="text-sm text-gray-400">
            {{ $page.props.auth.user.email }}
          </div> 
        </div>

        <div class="flex-1 flex flex-col mt-8">
          <div class="flex-1">
            <Link
              :href="route('admin.dashboard')"
              class="py-2 block hover:text-white"
              :class="[route().current('admin.dashboard') ? 'text-white' : 'text-gray-400']"
            >
              Dashboard
            </Link>
            
            <AdminDropDown
              align="right"
              width="48"
            >
              <template #trigger>
                <span class="rounded-md">
                  <button
                    type="button"
                    class="inline-flex justify-between duration-150 ease-in-out focus:outline-none font-medium leading-4 py-2 text-left hover:text-white transition w-full"
                    :class="[$page.url.startsWith('/admin/books') ? 'text-white' : 'text-gray-400']"
                  >
                    Manage Books

                    <svg
                      class="ml-2 -mr-0.5 h-4 w-4"
                      xmlns="http://www.w3.org/2000/svg"
                      viewBox="0 0 20 20"
                      fill="currentColor"
                    >
                      <path
                        fill-rule="evenodd"
                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                        clip-rule="evenodd"
                      />
                    </svg>
                  </button>
                </span>
              </template>

              <template #content>
                <Link
                  :href="route('admin.books.index')"
                  class="block border-l-2 duration-150 ease-in-out focus:outline-none leading-5 px-4 py-2 text-left text-sm transition w-full hover:text-white hover:border-white"
                  :class="[$page.component == 'Admin/Books/Index' ? 'text-white border-white' : 'text-gray-500 border-gray-500']"
                >
                  Books list
                </Link>
                <Link
                  :href="route('admin.books.create')"
                  class="block border-l-2 duration-150 ease-in-out focus:outline-none leading-5 px-4 py-2 text-left text-sm transition w-full hover:text-white hover:border-white"
                  :class="[$page.component == 'Admin/Books/Create' ? 'text-white border-white' : 'text-gray-500 border-gray-500']"
                >
                  Create Books
                </Link>
                
                <!-- <Link
                  :href="route('admin.books.show')"
                  class="block border-l-2 duration-150 ease-in-out focus:outline-none leading-5 px-4 py-2 text-left text-sm transition w-full"
                  :class="[$page.component == 'Admin/Books/Show' ? 'text-white border-white' : 'text-gray-500 border-gray-500']"
                >
                  Show Books
                </Link> -->
              </template>
            </AdminDropDown>

            <AdminDropDown
              align="right"
              width="48"
            >
              <template #trigger>
                <span class="rounded-md">
                  <button
                    type="button"
                    class="inline-flex justify-between duration-150 ease-in-out focus:outline-none font-medium leading-4 py-2 text-left hover:text-white transition w-full"
                    :class="[$page.url.startsWith('/admin/orders') ? 'text-white' : 'text-gray-400']"
                  >
                    Manage Orders

                    <svg
                      class="ml-2 -mr-0.5 h-4 w-4"
                      xmlns="http://www.w3.org/2000/svg"
                      viewBox="0 0 20 20"
                      fill="currentColor"
                    >
                      <path
                        fill-rule="evenodd"
                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                        clip-rule="evenodd"
                      />
                    </svg>
                  </button>
                </span>
              </template>

              <template #content>
                <Link
                  :href="route('admin.orders.index')"
                  class="block border-l-2 duration-150 ease-in-out focus:outline-none leading-5 px-4 py-2 text-left text-sm transition w-full hover:text-white hover:border-white"
                  :class="[$page.component == 'Admin/Orders/Index' ? 'text-white border-white' : 'text-gray-500 border-gray-500']"
                >
                  Orders
                </Link>
              </template>
            </AdminDropDown>
          </div>
          
          <Link
            :href="route('logout')"
            method="post"
            as="button"
            class="py-2 block text-left"
          >
            LogOut
          </Link>
        </div>
      </div>
    </div>
    <div class="flex-1 bg-gray-50">
      <slot />
    </div>
  </div>
</template>

<script>
import AdminDropDown from '@/Pages/Admin/AdminDropDown'
import { Link } from '@inertiajs/inertia-vue3'
export default {
    components: {
        AdminDropDown,
        Link
    }
}
</script>

<style lang="scss" scoped>

</style>