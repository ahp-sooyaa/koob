<template>
  <Head>
    <title>Cart</title>
    <meta
      head-key="description"
      name="description"
      content="This is cart page where all of your cart items can be seen here."
    >
  </Head>
  <Flash />

  <BreezeNavBarLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Shopping Cart
      </h2>
    </template>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 my-12 min-h-96">
      <div v-if="overStockItems.length">
        Some items in your cart are not available right now.
        <div
          v-for="overStockItem in overStockItems"
          :key="overStockItem.id"
        >
          {{ overStockItem.title }}
        </div>
      </div>
      <div
        v-if="cart.length"
        class="
          flex flex-col
          lg:flex-row
          space-y-5
          lg:items-start lg:space-y-0 lg:space-x-10
        "
      >
        <div class="bg-white rounded-2xl p-4 lg:p-8 shadow-md w-full lg:w-2/3">
          <!-- question mark svg -->
          <!-- <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-10 mb-5 text-gray-500 w-10"
            viewBox="0 0 20 20"
            fill="currentColor"
          >
            <path
              fill-rule="evenodd"
              d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
              clip-rule="evenodd"
            />
          </svg> -->
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
                    @change="
                      updateCartQuantity(
                        index,
                        item.user_id ? item.book : item,
                        $event
                      )
                    "
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
                  @click="saveforlater(item.user_id ? item.book_id : item.id)"
                  class="
                    ml-5
                    bg-blue-500
                    px-3
                    py-1.5
                    rounded-md
                    text-white
                    shadow
                    cursor-pointer
                  "
                >
                  Save for later
                </div>
              </div>
              <button
                @click="removeFromCart(index, item.user_id ? item.book : item)"
                class="
                  flex
                  ml-auto
                  text-sm text-gray-500
                  hover:text-gray-800
                  border-0
                  pt-0.5
                  focus:outline-none
                  rounded
                "
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

        <div class="bg-white w-full lg:w-1/3 p-4 lg:p-8 rounded-2xl shadow-md">
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
            <!-- <Link
              :href="route('checkout.index')"
              class="ml-5 bg-blue-500 px-3 py-1.5 rounded-md text-white shadow"
            >
              Checkout
            </Link> -->
            <div
              @click="checkStockForCheckout"
              class="
                ml-5
                bg-blue-500
                px-3
                py-1.5
                rounded-md
                text-white
                shadow
                cursor-pointer
              "
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
      <div class="bg-white rounded-2xl p-4 lg:p-8 shadow-md w-full lg:w-2/3">
        <!-- question mark svg -->
        <!-- <svg
          xmlns="http://www.w3.org/2000/svg"
          class="h-10 mb-5 text-gray-500 w-10"
          viewBox="0 0 20 20"
          fill="currentColor"
        >
          <path
            fill-rule="evenodd"
            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
            clip-rule="evenodd"
          />
        </svg> -->
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
                  @change="
                    updateCartQuantity(
                      index,
                      item.user_id ? item.book : item,
                      $event
                    )
                  "
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
                @click="movetocart(item.user_id ? item.book_id : item.id)"
                class="
                  ml-5
                  bg-blue-500
                  px-3
                  py-1.5
                  rounded-md
                  text-white
                  shadow
                  cursor-pointer
                "
              >
                Move to cart
              </div>
            </div>
            <!-- <button
              @click="removeFromCart(index, item.user_id ? item.book : item)"
              class="
                flex
                ml-auto
                text-sm text-gray-500
                hover:text-gray-800
                border-0
                pt-0.5
                focus:outline-none
                rounded
              "
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
            </button> -->
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
            // right now cart total amount doesn't include delivery fee, later it will add to total
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

            axios.delete(`/books/${item.id}/cart`).then(() => {
                _this.cart.splice(index, 1)

                window.events.emit('cartQtyUpdated')
                window.flash('Successfully deleted from cart')
            })
        },

        updateCartQuantity(index, item, event) {
            let _this = this
            let cartItem = _this.cart[index]

            axios
                .patch(`/books/${item.id}/cart`, { qty: parseInt(event.target.value) })
                .then((res) => {
                    cartItem.quantity = parseInt(event.target.value)
                    window.events.emit('cartQtyUpdated')
                    window.flash(res.data.message)
                })
                .catch((err) => {
                    event.target.value = cartItem.quantity
                    flash(err.response.data.message, 'error')
                })
            // this.$inertia.patch(`/books/${item.id}/cart`, {qty: parseInt(event.target.value)})
        },

        checkStockForCheckout() {
            // this should do with inertia and return inertia::render('Cart') with session
            axios
                .get('cart/check')
                .then(() => this.$inertia.visit('/checkout'))
                .catch((err) => {
                    console.log(err.response.data.overstockitems)
                    this.overStockItems = err.response.data.overstockitems
                })
        },

        saveforlater(id) {
            axios
                .post(`/${id}/saveforlater`)
                .then(() => {
                    flash('successfully moved to save for later.')
                    this.$inertia.get('/cart')
                })
        },

        movetocart(id) {
            axios
                .post(`/${id}/movetocart`)
                .then(() => {
                    flash('successfully moved to cart.')
                    this.$inertia.get('/cart')
                })
        },
    },
}
</script>