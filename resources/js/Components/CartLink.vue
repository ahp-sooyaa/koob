<template>
    <component
        :is="component"
        v-cloak
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
            class="flex items-center rounded-full bg-gray-800 px-2 py-1 text-xs font-bold text-white shadow"
            dusk="cartItemsCount"
        >
            {{ cartItemsCount }}
        </span>
    </component>
</template>

<script>
import BreezeNavLink from "@/Components/NavLink";
import BreezeResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";
import axios from "axios";
export default {
    components: {
        BreezeNavLink,
        BreezeResponsiveNavLink,
    },

    props: {
        responsive: {
            type: Boolean,
        },
    },

    data() {
        return {
            cartItemsCount: 0,
            component: this.responsive
                ? "BreezeResponsiveNavLink"
                : "BreezeNavLink",
        };
    },

    watch: {
        "$page.props.cart": {
            handler() {
                this.calculateCartTotalQuantity(this.$page.props.cart);
            },
            deep: true,
        },
    },

    created() {
        this.fetchCartItemsCount();
        window.events.on("cartQtyUpdated", this.fetchCartItemsCount);
    },

    methods: {
        fetchCartItemsCount() {
            axios.get(route("cart.index")).then((res) => {
                this.calculateCartTotalQuantity(res.data.cartItems);
            });
        },

        calculateCartTotalQuantity(cart) {
            let totalQty = 0;

            for (let key in cart) {
                totalQty += cart[key].quantity;
            }

            this.cartItemsCount = totalQty;
        },
    },
};
</script>

<style scoped></style>
