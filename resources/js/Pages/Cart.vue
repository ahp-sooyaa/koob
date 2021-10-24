<template>
  <Flash />

  <BreezeNavBarLayout>
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-7">
      <div v-if="cart.length">
        <Link :href="route('checkout.index')" class="ml-3">Checkout</Link>
        <table class="table-auto w-full text-left whitespace-no-wrap">
          <thead>
            <tr>
              <th
                class="
                  px-4
                  py-3
                  title-font
                  tracking-wider
                  text-gray-900 text-sm
                  bg-gray-200
                  rounded-tl rounded-bl
                "
              >
                Item
              </th>
              <th
                class="
                  px-4
                  py-3
                  title-font
                  tracking-wider
                  text-gray-900 text-sm
                  bg-gray-200
                "
              >
                Quantity
              </th>
              <th
                class="
                  px-4
                  py-3
                  title-font
                  tracking-wider
                  text-gray-900 text-sm
                  bg-gray-200
                "
              >
                Price
              </th>
              <th
                class="
                  px-4
                  py-3
                  title-font
                  tracking-wider
                  text-gray-900 text-sm
                  bg-gray-200
                "
              >
                SubTotal Price
              </th>
              <th class="px-4 py-3 title-font tracking-wider text-gray-900 text-sm bg-gray-200 rounded-tr rounded-br">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(item, index) in cart" :key="item.id">
              <td class="p-4" v-text="item.title"></td>
              <td class="p-4" v-text="item.quantity"></td>
              <td class="p-4" v-text="formatPrice(item.price)"></td>
              <td class="p-4" v-text="formatPrice(item.price * item.quantity)"></td>
              <td class="w-10">
                  <button
                      class="flex ml-auto text-sm text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded"
                      @click="removeFromCart(index)"
                  >Remove</button>
              </td>
            </tr>
            <tr>
              <td class="col-span-2 p-4 font-bold">Total Amount</td>
              <td class="p-4 font-bold" v-text="cartQuantity"></td>
              <td class="w-10"></td>
              <td class="p-4 font-bold" v-text="cartTotal"></td>
              <td class="w-10"></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div v-else>
        <p>There is no items in cart!</p>
        <Link :href="route('books.index')">Continue Shopping</Link>
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
        formatPrice(price) {
            return (price / 100).toLocaleString("en-US", {style: "currency", currency: "USD"});
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

    computed: {
      cartQuantity() {
        let totalQty = 0;
        for (const key in this.cart) {
          totalQty += this.cart[key].quantity;
        }
        return totalQty;
      },
      cartTotal() {
        let amount = 0;
        for (const key in this.cart) {
          amount += this.cart[key].quantity * this.cart[key].price;
        }
        return this.formatPrice(amount);
      },
    }
};
</script>

<style lang="scss" scoped>
</style>