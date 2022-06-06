<template>
  <Head>
    <title>Cart</title>
    <meta
      head-key="description"
      name="description"
      content="This is cart page where all of your cart items can be seen here."
    >
  </Head>

  <BreezeNavBarLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Shopping Cart
      </h2>
      <div
        v-if="Object.keys(overStockItems).length"
        class="bg-red-200 mt-2 px-5 py-3 rounded text-red-500"
      >
        Some items in your cart are not available right now and automatically move to save for later.
        <div
          v-for="overStockItem in overStockItems"
          :key="overStockItem.id"
          class="font-semibold text-sm"
        >
          {{ overStockItem.title }}
        </div>
      </div>
    </template>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 my-12 min-h-96">
      <div
        v-if="cart.length"
        class="bg-white divide-x flex flex-col lg:flex-row lg:items-start lg:space-x-10 lg:space-y-0 rounded-2xl shadow-md space-y-5"
      >
        <div class="lg:p-8 lg:w-2/3 p-4 w-full">
          <ul class="space-y-10">
            <li
              v-for="(item, index) in cart"
              :key="item.id"
              class="flex space-x-5 items-start"
            >
              <img
                src="/images/cover.png"
                :alt="item.title + '\'s cover image'"
                class="h-40"
              >
              <div class="flex-1 space-y-3">
                <h1>{{ item.title }}</h1>
                <div class="flex items-center space-x-5">
                  <select
                    @change="updateCartQuantity(index, item, $event)"
                    class="rounded-2xl shadow-md cursor-pointer"
                    name="quantity"
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
                  <span class="font-semibold">
                    {{ formatPrice(item.price) }}
                  </span>
                </div>

                <div
                  v-if="$page.props.auth.user"
                  @click="saveforlater(item.id)"
                  class="bg-blue-500 cursor-pointer inline-block px-3 py-1.5 rounded-md shadow text-white text-xs"
                >
                  Save for later
                </div>
              </div>
              <button
                @click="removeFromCart(index, item)"
                class="flex ml-auto text-sm text-gray-500 hover:text-gray-800 border-0 pt-0.5 focus:outline-none rounded"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  class="h-5 w-5"
                  viewBox="0 0 20 20"
                  fill="currentColor"
                >
                  <path
                    fill-rule="evenodd"
                    d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                    clip-rule="evenodd"
                  />
                </svg>
              </button>
            </li>
          </ul>
        </div>

        <div class="lg:p-8 lg:w-1/3 p-4 w-full">
          <div
            v-if="message"
            class="bg-gray-100 px-4 py-2 rounded-lg mb-5"
          >
            {{ message }}
          </div>
          <h1 class="capitalize text-xl font-semibold mb-5">
            cart summary
          </h1>
          <div class="divide-y space-y-5">
            <div class="space-y-3">
              <div class="flex justify-between">
                <span class="text-gray-500">SubTotal</span>
                <span>{{ cartTotal }}</span>
              </div>
              <div class="flex justify-between">
                <span class="text-gray-500">Delivery Fee</span>
                <span>Free</span>
              </div>
            </div>
            <div class="flex justify-between pt-5">
              <span class="text-gray-500">Total</span>
              <span>{{ cartTotal }}</span>
            </div>
          </div>
          <div class="flex items-center justify-end mt-5">
            <Link
              :href="route('books.index')"
              class="text-gray-500 hover:text-gray-900"
            >
              Continue Shopping
            </Link>
            <div
              @click="checkStockForCheckout"
              class="ml-5 bg-blue-500 px-3 py-1.5 rounded-md text-white shadow cursor-pointer"
              dusk="checkout"
            >
              Checkout
            </div>
          </div>
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
          style="width: 200px; height: 200px"
          loop
          autoplay
          class="mx-auto"
        />
        <p class="mb-3 text-gray-700">
          There is no items in cart!
        </p>
        <Link
          :href="route('books.index')"
          class="bg-blue-500 px-3 py-2.5 rounded-2xl text-white shadow"
        >
          Continue Shopping
        </Link>
      </div>

      <!-- save for later section -->
      <div
        v-if="saveforlaterItems.length"
        class="mt-10 bg-white rounded-2xl p-4 lg:p-8 shadow-md w-full"
      >
        <h1 class="font-semibold leading-tight mb-5 text-gray-800 text-xl">
          Save for later
        </h1>
        <ul class="space-y-10">
          <li
            v-for="(item, index) in saveforlaterItems"
            :key="item.id"
            class="flex space-x-5 items-start"
          >
            <img
              src="/images/cover.png"
              :alt="item.title + '\'s cover image'"
              class="h-40"
            >
            <div class="flex-1 space-y-3">
              <h1>{{ item.title }}</h1>
              <div class="flex items-center space-x-5">
                <select
                  @change="updateCartQuantity(index, item, $event)"
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
                <span class="font-semibold">
                  {{ formatPrice(item.price) }}
                </span>
              </div>

              <div
                @click="movetocart(item.id)"
                class="bg-blue-500 cursor-pointer inline-block px-3 py-1.5 rounded-md shadow text-white text-xs"
              >
                Move to cart
              </div>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </BreezeNavBarLayout>
</template>

<script>
import BreezeNavBarLayout from '@/Layouts/NavBar'
import axios from 'axios'
import format from '@/mixins/format'

export default {
    components: {
        BreezeNavBarLayout,
    },

    mixins: [format],

    props: ['message', 'cart', 'saveforlaterItems'],

    data() {
        return {
            overStockItems: '',
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
        removeFromCart(index, item) {
            let _this = this

            axios.delete(route('cart.destroy', item.id))
                .then(() => {
                    _this.cart.splice(index, 1)

                    window.events.emit('cartQtyUpdated')
                    window.flash('Successfully deleted from cart')
                })
        },

        updateCartQuantity(index, item, event) {
            let _this = this
            let cartItem = _this.cart[index]

            axios
                .patch(route('cart.update', item.id), {
                    qty: parseInt(event.target.value),
                })
                .then(() => {
                    cartItem.quantity = parseInt(event.target.value)

                    window.events.emit('cartQtyUpdated')
                    // window.flash(res.data.message)
                    window.flash('Successfully updated quantity.')
                })
                .catch((err) => {
                    event.target.value = cartItem.quantity
                    window.flash(err.response.data.message, 'error')
                })
        },

        checkStockForCheckout() {
            axios.get(route('cart.checkStockForCheckout'))
                .then(() => this.$inertia.get(route('checkout.index')))
                .catch((err) => {
                    this.$inertia.reload({
                        onFinish: () => {
                            this.overStockItems = err.response.data.overStockItems
                        }
                    })
                })
        },

        saveforlater(id) {
            axios.post(route('saveforlater', id))
                .then(() => {
                    this.$inertia.reload({
                        onFinish: () => {
                            window.events.emit('cartQtyUpdated')
                            window.flash('Successfully moved to save for later.')
                        }
                    })
                })
        },

        movetocart(id) {
            axios.post(route('movetocart', id))
                .then(() => {
                    this.$inertia.reload({
                        onFinish: () => {
                            window.events.emit('cartQtyUpdated')
                            window.flash('Successfully moved to cart.')
                        }
                    })
                })
        },
    },
}
</script>
