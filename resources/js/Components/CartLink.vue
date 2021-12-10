<template>
  <component
    :is="component"
    :href="route('cart.index')"
    :active="route().current('cart.index')"
  >
    <svg
      xmlns="http://www.w3.org/2000/svg"
      class="h-6 w-6"
      fill="none"
      viewBox="0 0 24 24"
      stroke="currentColor"
    >
      <path
        stroke-linecap="round"
        stroke-linejoin="round"
        stroke-width="2"
        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"
      />
    </svg>
    <span
      class="bg-blue-500 flex font-bold items-center ml-2 px-2 py-1 rounded-full shadow text-white text-xs"
    >
      {{ cartItemsCount }}
    </span>
  </component>
</template>

<script>
import BreezeNavLink from '@/Components/NavLink'
import BreezeResponsiveNavLink from '@/Components/ResponsiveNavLink.vue'
export default {
    components: {
        BreezeNavLink,
        BreezeResponsiveNavLink
    },

    props: {
        responsive: {
            type: Boolean
        }
    },

    data(){
        return {
            cartItemsCount: this.$page.props.cart ? Object.keys(this.$page.props.cart).length : 0,
            component: this.responsive ? 'BreezeResponsiveNavLink' : 'BreezeNavLink'
        }
    },

    created() {
        window.events.on('added', () => this.cartItemsCount++)
        window.events.on('removed', () => this.cartItemsCount--)
    }
}
</script>

<style lang="scss" scoped>

</style>