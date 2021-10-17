<template>
  <Flash />

  <BreezeNavBarLayout>
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-7">
      <h1 class="font-bold mb-3 text-gray-500 text-xl">View Cart</h1>
      <div v-if="cart.length">
        <div v-for="(item, index) in cart">
          {{ item.title }} qty = 3 {{ number_format(item.price) }}
          {{ item.price * 3 }}
          <button @click="removeFromCart(index)">&times</button>
        </div>
        <Link :href="route('books.index')">Continue Shopping</Link>
      </div>
      <div v-else>
        <p>There is no items in cart!</p>
      </div>
    </main>
  </BreezeNavBarLayout>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";
import BreezeApplicationLogo from "@/Components/ApplicationLogo";
import BreezeNavBarLayout from "@/Layouts/NavBar";
export default {
    components: {
        Link,
        BreezeApplicationLogo,
        BreezeNavBarLayout
    },

    props: {
        cart: Array,
    },

    methods: {
        number_format(price) {
            return (price / 100).toFixed(2);
        },
        
        removeFromCart(index) {
            let _this = this;
            let item = this.cart[index];

            axios.delete(`/books/${item.id}/cart`).then(() => {
                _this.cart.splice(index, 1);

                window.events.emit("removed");
                flash("Successfully deleted from cart");
            });
        }
    },
};
</script>

<style lang="scss" scoped>
</style>