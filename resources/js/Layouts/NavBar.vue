<template>
  <div>
    <div class="flex flex-col min-h-screen bg-gray-100">
      <nav class="bg-white border-b border-gray-100">
        <!-- Primary Navigation Menu -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="flex justify-between h-16">
            <div class="flex">
              <!-- Logo -->
              <div class="flex-shrink-0 flex items-center">
                <Link :href="route('dashboard')">
                  <BreezeApplicationLogo class="block h-9 w-auto" />
                </Link>
              </div>

              <!-- Navigation Links -->
              <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                <BreezeNavLink 
                  v-if="$page.props.auth.user" 
                  :href="route('dashboard')" 
                  :active="route().current('dashboard')"
                >
                  Dashboard
                </BreezeNavLink>
                <BreezeNavLink 
                  :href="route('books.index')" 
                  :active="route().current('books.index')"
                >
                  Shop
                </BreezeNavLink>
                <CartLink :responsive="false" />
              </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6">
              <!-- Settings Dropdown -->
              <div
                v-if="$page.props.auth.user"
                class="ml-3 relative"
              >
                <BreezeDropdown
                  align="right"
                  width="48"
                >
                  <template #trigger>
                    <span class="inline-flex rounded-md">
                      <button
                        type="button"
                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
                      >
                        {{ $page.props.auth.user.name }}

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
                    <BreezeDropdownLink
                      :href="route('logout')"
                      method="post"
                      as="button"
                    >
                      Log Out
                    </BreezeDropdownLink>
                  </template>
                </BreezeDropdown>
              </div>
                        
              <template v-else>
                <div class="flex space-x-3">
                  <Link
                    :href="route('login')"
                    :active="route().current('login')"
                    class="text-sm hover:text-gray-700 text-gray-500"
                  >
                    Log in
                  </Link>
                  <Link
                    :href="route('register')"
                    :active="route().current('register')"
                    class="text-sm hover:text-gray-700 text-gray-500"
                  >
                    Register
                  </Link>
                </div>
              </template>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
              <button
                @click="showingNavigationDropdown = ! showingNavigationDropdown"
                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"
              >
                <svg
                  class="h-6 w-6"
                  stroke="currentColor"
                  fill="none"
                  viewBox="0 0 24 24"
                >
                  <path
                    :class="{'hidden': showingNavigationDropdown, 'inline-flex': ! showingNavigationDropdown }"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M4 6h16M4 12h16M4 18h16"
                  />
                  <path
                    :class="{'hidden': ! showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M6 18L18 6M6 6l12 12"
                  />
                </svg>
              </button>
            </div>
          </div>
        </div>

        <!-- Responsive Navigation Menu -->
        <div
          :class="{'block': showingNavigationDropdown, 'hidden': ! showingNavigationDropdown}"
          class="sm:hidden"
        >
          <div v-if="$page.props.auth.user">
            <div class="pt-2 pb-3 space-y-1">
              <BreezeResponsiveNavLink
                :href="route('dashboard')"
                :active="route().current('dashboard')"
              >
                Dashboard
              </BreezeResponsiveNavLink>
              <BreezeResponsiveNavLink
                :href="route('books.index')"
                :active="route().current('books.index')"
              >
                Shop
              </BreezeResponsiveNavLink>
              <CartLink :responsive="true" />
            </div>

            <!-- Responsive Settings Options -->
            <div class="pt-4 pb-1 border-t border-gray-200">
              <div class="px-4">
                <div class="font-medium text-base text-gray-800">
                  {{ $page.props.auth.user.name }}
                </div>
                <div class="font-medium text-sm text-gray-500">
                  {{ $page.props.auth.user.email }}
                </div>
              </div>

              <div class="mt-3 space-y-1">
                <BreezeResponsiveNavLink
                  :href="route('logout')"
                  method="post"
                  as="button"
                >
                  Log Out
                </BreezeResponsiveNavLink>
              </div>
            </div>
          </div>

          <div
            v-else
            class="pt-4 pb-1 border-t border-gray-200"
          >
            <div class="px-4">
              <BreezeResponsiveNavLink
                :href="route('login')"
                :active="route().current('login')"
              >
                Log in
              </BreezeResponsiveNavLink>
              <BreezeResponsiveNavLink
                :href="route('register')"
                :active="route().current('register')"
              >
                Register
              </BreezeResponsiveNavLink>
            </div>
          </div>
        </div>
      </nav>

      <!-- Page Heading -->
      <header
        v-if="$slots.header"
        class="bg-white shadow"
      >
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
          <slot name="header" />
        </div>
      </header>

      <!-- Page Content -->
      <main class="flex-1">
        <slot />
      </main>

      <!-- page Footer -->
      <footer class="py-6 mt-6 w-5/6 border-t border-gray-300 mx-auto text-center text-gray-700 text-sm">
        &copy; 2021 Koob. All rights reserved.
      </footer>
    </div>
  </div>
</template>

<script>
import BreezeApplicationLogo from '@/Components/ApplicationLogo.vue'
import BreezeDropdown from '@/Components/Dropdown.vue'
import BreezeDropdownLink from '@/Components/DropdownLink.vue'
import BreezeNavLink from '@/Components/NavLink.vue'
import BreezeResponsiveNavLink from '@/Components/ResponsiveNavLink.vue'
import { Link } from '@inertiajs/inertia-vue3'
import CartLink from '@/Components/CartLink'

export default {
    components: {
        BreezeApplicationLogo,
        BreezeDropdown,
        BreezeDropdownLink,
        BreezeNavLink,
        BreezeResponsiveNavLink,
        Link,
        CartLink
    },

    data() {
        return {
            showingNavigationDropdown: false,
        }
    },
}
</script>
