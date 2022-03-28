<template>
  <Flash />

  <BreezeNavBarLayout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 my-16 pt-7">
      <div
        v-if="cart.length"
        class="overflow-x-auto"
      >
        <Link
          :href="$page.props.urlPrev"
          class="ml-3"
        >
          Back
        </Link>
        <Link
          :href="route('checkout.index')"
          class="ml-3"
        >
          Checkout
        </Link>
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
                  class="flex ml-auto text-sm text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded"
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
      </div>

      <div v-else>
        <p>There is no items in cart!</p>
        <Link :href="route('books.index')">
          Continue Shopping
        </Link>
      </div>
    </div>
  </BreezeNavBarLayout>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3'
import BreezeNavBarLayout from '@/Layouts/NavBar'
import axios from 'axios'

export default {
    components: {
        Link,
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