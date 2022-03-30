<template>
  <Head title="Cart" />
  <Flash />

  <BreezeNavBarLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Shopping Cart
      </h2>
    </template>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 my-16 pt-7 min-h-96">
      <div
        v-if="cart.length"
        class="overflow-x-auto"
      >
        <table class="table-auto w-full whitespace-no-wrap">
          <thead>
            <tr>
              <th class="text-left px-4 py-3 title-font tracking-wider text-gray-900 text-sm bg-gray-200 rounded-tl rounded-bl">
                Item
              </th>
              <th
                class="text-left px-4 py-3 title-font tracking-wider text-gray-900 text-sm bg-gray-200"
              >
                Quantity
              </th>
              <th
                class="text-right px-4 py-3 title-font tracking-wider text-gray-900 text-sm bg-gray-200"
              >
                Price
              </th>
              <th class="text-right px-4 py-3 title-font tracking-wider text-gray-900 text-sm bg-gray-200">
                SubTotal Price
              </th>
              <th class="px-4 py-3 title-font tracking-wider text-gray-900 text-sm bg-gray-200 rounded-tr rounded-br">
                Actions
              </th>
            </tr>
          </thead>
          <tbody class="divide-y">
            <tr
              v-for="(item, index) in cart"
              :key="item.id"
            >
              <td
                class="text-left p-4"
                v-text="item.title"
              />
              <td
                class="p-4"
              >
                <!-- <input
                  ref="input"
                  v-model="item.quantity"
                  @change="updateCartQuantity(item.quantity, item.id)"
                  class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                  type="number"
                  min="1"
                > -->
                <select
                  @change="updateCartQuantity(index, item.user_id ? item.book : item, $event)"
                  class="rounded-2xl shadow-md cursor-pointer"
                >
                  <option
                    v-for="qty in 10"
                    :key="qty"
                    :value="qty"
                    :selected="item.quantity == qty"
                  >
                    {{ qty }}
                  </option>
                </select>
              </td>
              <td
                class="text-right p-4"
                v-text="formatPrice(item.price)"
              />
              <td
                class="text-right p-4"
                v-text="formatPrice(item.price * item.quantity)"
              />
              <td class="w-10">
                <button
                  @click="removeFromCart(index, item.user_id ? item.book : item)"
                  class="flex ml-auto text-sm text-gray-500 hover:text-gray-800 border-0 py-2 px-6 focus:outline-none rounded"
                >
                  Remove
                </button>
              </td>
            </tr>
            
            <tr>
              <td class="col-span-2 p-4 font-bold">
                Total
              </td>
              <td
                class="p-4 font-bold"
                v-text="cartQuantity"
              />
              <td />
              <td
                class="p-4 font-bold text-right"
                v-text="cartTotal"
              />
              <td />
            </tr>
          </tbody>
        </table>
        <div class="flex items-center justify-end mt-5">
          <Link
            :href="$page.props.urlPrev"
            class="ml-3"
          >
            Go Back
          </Link>
          <Link
            :href="route('checkout.index')"
            class="ml-3 bg-blue-500 px-3 py-1.5 rounded-md text-white shadow"
          >
            Process to Checkout
          </Link>
        </div>
      </div>

      <div
        v-else
        class="text-center"
      >
        <lottie-player
          src="https://assets6.lottiefiles.com/packages/lf20_0s6tfbuc.json"
          background="transparent"
          speed="1"
          style="width: 200px; height: 200px;"
          loop
          autoplay
          class="mx-auto"
        />
        <p class="mb-3 text-gray-700">
          There is no items in cart!
        </p>
        <Link
          :href="route('books.index')"
          class="bg-blue-500 px-3 py-1.5 rounded-md text-white shadow"
        >
          Continue Shopping
        </Link>
      </div>
    </div>
  </BreezeNavBarLayout>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3'
import BreezeNavBarLayout from '@/Layouts/NavBar'
import axios from 'axios'

export default {
    components: {
        Link,
        Head,
        BreezeNavBarLayout,
    },

    props: {
        cart: {
            type: Array,
            required: true
        }
    },

    computed: {
        cartQuantity() {
            let totalQty = 0
            for (const key in this.cart) {
                totalQty += this.cart[key].quantity
            }

            return totalQty
        },
        cartTotal() {
            let amount = 0
            for (const key in this.cart) {
                amount += this.cart[key].quantity * this.cart[key].price
            }
            
            return this.formatPrice(amount)
        },
    },

    methods: {
        formatPrice(price) {
            return (price / 100).toLocaleString('en-US', {style: 'currency', currency: 'USD'})
        },
        
        removeFromCart(index, item) {
            let _this = this

            axios.delete(`/books/${item.id}/cart`)
                .then(() => {
                    _this.cart.splice(index, 1)

                    window.events.emit('cartQtyUpdated')
                    window.flash('Successfully deleted from cart')
                })
        },

        updateCartQuantity(index, item, event){
            let _this = this
            let cartItem = _this.cart[index]

            axios.patch(`/books/${item.id}/cart`, {qty: parseInt(event.target.value)})
                .then(res => {
                    // this.$page.props.cart[index].quantity = parseInt(event.target.value)
                    cartItem.quantity = parseInt(event.target.value)
                    window.events.emit('cartQtyUpdated')
                    window.flash(res.data.message)
                })
                .catch(err => {
                    // event.target.value = this.$page.props.cart[index].quantity
                    event.target.value = cartItem.quantity
                    flash(err.response.data.message, 'error')
                })
        }
    }
}
</script>