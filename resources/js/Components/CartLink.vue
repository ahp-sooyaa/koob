<template>
  <component
    :is="component"
    :href="route('cart.index')"
    :active="route().current('cart.index')"
  >
    Cart
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