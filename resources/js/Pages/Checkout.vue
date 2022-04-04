<template>
  <Flash />

  <BreezeNavBarLayout>
    <Head title="Checkout" />

    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Checkout
      </h2>
    </template>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 mb-16 mt-12">
      <div class="flex space-x-16">
        <div class="lg:w-1/2 w-full mx-auto">
          <h1 class="text-xl font-semibold">
            Contact Information
          </h1>
          <div class="lg:flex flex-wrap -mx-2">
            <div class="p-2 lg:w-1/3">
              <div class="relative">
                <label
                  for="first_name"
                  class="leading-7 text-sm text-gray-600"
                >First Name</label>
                <BreezeInput
                  id="first_name"
                  v-model="customer.first_name"
                  type="text"
                  class="mt-1 block w-full"
                  required
                  autofocus
                  autocomplete="first_name"
                  :disabled="paymentProcessing"
                />
                <BreezeInputError
                  :message="errors.first_name ? errors.first_name[0] : ''"
                />
              </div>
            </div>
            <div class="p-2 lg:w-1/3">
              <div class="relative">
                <label
                  for="last_name"
                  class="leading-7 text-sm text-gray-600"
                >Last Name</label>
                <BreezeInput
                  id="last_name"
                  v-model="customer.last_name"
                  type="text"
                  class="mt-1 block w-full"
                  required
                  autocomplete="last_name"
                  :disabled="paymentProcessing"
                />
                <BreezeInputError
                  :message="errors.last_name ? errors.last_name[0] : ''"
                />
              </div>
            </div>
            <div class="p-2 lg:w-1/3">
              <div class="relative">
                <label
                  for="email"
                  class="leading-7 text-sm text-gray-600"
                >Email Address</label>
                <BreezeInput
                  id="email"
                  v-model="customer.email"
                  type="email"
                  class="mt-1 block w-full"
                  required
                  autocomplete="email"
                  :disabled="paymentProcessing"
                />
                <BreezeInputError
                  :message="errors.email ? errors.email[0] : ''"
                />
              </div>
            </div>
          </div>

          <h1 class="text-xl font-semibold mt-5">
            Delivery Address
          </h1>
          <div class="lg:flex flex-wrap -mx-2">
            <div class="p-2 lg:w-full">
              <div class="relative">
                <label
                  for="address"
                  class="leading-7 text-sm text-gray-600"
                >Address</label>
                <BreezeInput
                  id="address"
                  v-model="customer.address"
                  type="text"
                  class="mt-1 block w-full"
                  required
                  autocomplete="address"
                  :disabled="paymentProcessing"
                />
                <BreezeInputError
                  :message="errors.address ? errors.address[0] : ''"
                />
              </div>
            </div>
            <div class="p-2 lg:w-2/4">
              <div class="relative">
                <label
                  for="city"
                  class="leading-7 text-sm text-gray-600"
                >City</label>
                <BreezeInput
                  id="city"
                  v-model="customer.city"
                  type="text"
                  class="mt-1 block w-full"
                  required
                  autocomplete="city"
                  :disabled="paymentProcessing"
                />
                <BreezeInputError
                  :message="errors.city ? errors.city[0] : ''"
                />
              </div>
            </div>
            <div class="p-2 sm:w-1/2 lg:w-1/4">
              <div class="relative">
                <label
                  for="state"
                  class="leading-7 text-sm text-gray-600"
                >State / Province</label>
                <BreezeInput
                  id="state"
                  v-model="customer.state"
                  type="text"
                  class="mt-1 block w-full"
                  required
                  autocomplete="state"
                  :disabled="paymentProcessing"
                />
                <BreezeInputError
                  :message="errors.state ? errors.state[0] : ''"
                />
              </div>
            </div>
            <div class="p-2 sm:w-1/2 lg:w-1/4">
              <div class="relative">
                <label
                  for="zip_code"
                  class="leading-7 text-sm text-gray-600"
                >Zip Code</label>
                <BreezeInput
                  id="zip_code"
                  v-model="customer.zip_code"
                  type="text"
                  class="mt-1 block w-full"
                  required
                  autocomplete="zip_code"
                  :disabled="paymentProcessing"
                />
                <BreezeInputError
                  :message="errors.zip_code ? errors.zip_code[0] : ''"
                />
              </div>
            </div>
          </div>

          <h1 class="text-xl font-semibold mt-5">
            Payment Detail
          </h1>
          <div class="flex flex-wrap -mx-2">
            <div class="p-2 w-full">
              <div class="relative">
                <label
                  for="card-element"
                  class="leading-7 text-sm text-gray-600"
                >Credit Card Info</label>
                <div id="card-element" />
              </div>
            </div>
          </div>

          <button
            @click="processPayment"
            class="
              bg-indigo-500 focus:outline-none hover:bg-indigo-600 mt-8
              px-8 py-2 rounded flex justify-center text-lg text-white w-full
            "
            dusk="paynow"
            :class="paymentProcessing || !cart.length || isThereAnyOverStockCount ? 'cursor-not-allowed bg-indigo-600' : ''"
            :disabled="paymentProcessing || !cart.length || isThereAnyOverStockCount"
          >
            <span v-if="!paymentProcessing">Pay Now</span>
            <svg
              v-else
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 512 512"
              class="w-7 h-7 text-white fill-current animate-spin"
            >
              <path
                d="M304 48C304 74.51 282.5 96 256 96C229.5 96 208 74.51 208 48C208 21.49 229.5 0 256 0C282.5 0 304 21.49 304 48zM304 464C304 490.5 282.5 512 256 512C229.5 512 208 490.5 208 464C208 437.5 229.5 416 256 416C282.5 416 304 437.5 304 464zM0 256C0 229.5 21.49 208 48 208C74.51 208 96 229.5 96 256C96 282.5 74.51 304 48 304C21.49 304 0 282.5 0 256zM512 256C512 282.5 490.5 304 464 304C437.5 304 416 282.5 416 256C416 229.5 437.5 208 464 208C490.5 208 512 229.5 512 256zM74.98 437C56.23 418.3 56.23 387.9 74.98 369.1C93.73 350.4 124.1 350.4 142.9 369.1C161.6 387.9 161.6 418.3 142.9 437C124.1 455.8 93.73 455.8 74.98 437V437zM142.9 142.9C124.1 161.6 93.73 161.6 74.98 142.9C56.24 124.1 56.24 93.73 74.98 74.98C93.73 56.23 124.1 56.23 142.9 74.98C161.6 93.73 161.6 124.1 142.9 142.9zM369.1 369.1C387.9 350.4 418.3 350.4 437 369.1C455.8 387.9 455.8 418.3 437 437C418.3 455.8 387.9 455.8 369.1 437C350.4 418.3 350.4 387.9 369.1 369.1V369.1z"
              />
            </svg>
          </button>
        </div>

        <!-- order summary -->
        <div class="bg-white rounded-2xl p-8 shadow-md w-full lg:w-1/2">
          <div
            v-if="message"
            class="bg-gray-100 px-4 py-2 rounded-lg mb-5"
          >
            {{ message }}
          </div>
          <h1 class="capitalize text-xl font-semibold mb-5">
            Order Summary
          </h1>
          <ul class="space-y-10">
            <li
              v-for="(item, index) in cart"
              :key="item.id"
              class="flex space-x-5"
            >
              <img
                src="/images/cover.png"
                :alt="item.title + '\'s cover image'"
                class="h-40"
              >
              <div class="flex-1 flex flex-col space-y-3">
                <h1>{{ item.title }}</h1>
                <div class="flex-1 space-x-5">
                  <select
                    @change="
                      updateCartQuantity(
                        index,
                        item.user_id ? item.book : item,
                        $event
                      )
                    "
                    class="rounded-2xl shadow-md cursor-pointer"
                    :class="item.quantity > item.book.stock_count ? 'border-red-500 text-red-500' : ''"
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
                  <span class="font-semibold">{{
                    formatPrice(item.price)
                  }}</span>
                </div>
                <div class="text-gray-400">
                  {{ item.quantity > item.book.stock_count ? "This is exceeding over stock count" : '' }}
                </div>
              </div>
              <button
                @click="removeFromCart(index, item.user_id ? item.book : item)"
                class="
                  ml-auto text-sm text-gray-500 hover:text-gray-800 
                  border-0 pt-0.5 focus:outline-none rounded self-start
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
          <div class="divide-y space-y-5 mt-10">
            <div class="space-y-3">
              <div class="flex justify-between">
                <span class="text-gray-500">SubTotal</span>
                <span class="font-semibold">{{ formatPrice(cartTotal) }}</span>
              </div>
              <div class="flex justify-between">
                <span class="text-gray-500">Delivery Fee</span>
                <span class="font-semibold">Free</span>
              </div>
            </div>
            <div class="flex justify-between pt-5">
              <span class="text-gray-500">Total</span>
              <span class="font-semibold">{{ formatPrice(cartTotal) }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </BreezeNavBarLayout>
</template>
<script>
import { Head } from '@inertiajs/inertia-vue3'
import { loadStripe } from '@stripe/stripe-js'
import BreezeNavBarLayout from '@/Layouts/NavBar'
import BreezeInputError from '@/Components/InputError'
import BreezeInput from '@/Components/Input'
export default {
    components: {
        Head,
        BreezeNavBarLayout,
        BreezeInputError,
        BreezeInput,
    },

    props: ['message'],

    data() {
        return {
            errors: [],
            stripe: {},
            cardElement: {},
            customer: {
                first_name: '',
                last_name: '',
                email: '',
                address: '',
                city: '',
                state: '',
                zip_code: '',
            },
            paymentProcessing: false,
            // disableCheckout: this.paymentProcessing || !Object.keys(this.cart).length || this.isThereAnyOverStockCount
        }
    },

    computed: {
        cart() {
            return this.$page.props.cart
        },

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
            return amount // don't format this with formatPrice(), it will cause error with stripe 'invalid interger $10.00'
        },

        isThereAnyOverStockCount() {
            return this.cart.some((item) => item.quantity > item.book.stock_count)
        }
    },

    async mounted() {
        this.stripe = await loadStripe(process.env.MIX_STRIPE_KEY)
        const elements = this.stripe.elements()
        this.cardElement = elements.create('card', {
            classes: {
                base: 'bg-white border border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm p-3',
            },
        })
        this.cardElement.mount('#card-element')
    },

    methods: {
        formatPrice(price) {
            return (price / 100).toLocaleString('en-US', {
                style: 'currency',
                currency: 'USD',
            })
        },
      
        updateCartQuantity(index, item, event){
            let _this = this
            let cartItem = _this.cart[index]

            axios.patch(`/books/${item.id}/cart`, {qty: parseInt(event.target.value)})
                .then(res => {
                    cartItem.quantity = parseInt(event.target.value)
                    window.events.emit('cartQtyUpdated')
                    window.flash(res.data.message)
                })
                .catch(err => {
                    event.target.value = cartItem.quantity
                    flash(err.response.data.message, 'error')
                })
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

        async processPayment() {
            this.paymentProcessing = true
            const { paymentMethod, error } = await this.stripe.createPaymentMethod(
                'card',
                this.cardElement,
                {
                    billing_details: {
                        name: this.customer.first_name + ' ' + this.customer.last_name,
                        email: this.customer.email,
                        address: {
                            line1: this.customer.address,
                            city: this.customer.city,
                            state: this.customer.state,
                            postal_code: this.customer.zip_code,
                        },
                    },
                }
            )
            if (error) {
                this.paymentProcessing = false
            } else {
                this.customer.payment_method_id = paymentMethod.id
                this.customer.amount = this.cartTotal
                this.customer.cart = JSON.stringify(this.$page.props.cart)
                axios
                    .post(route('orders.store', this.customer))
                    .then((response) => {
                        this.paymentProcessing = false
                        this.$inertia.get('/thankyou/' + response.data.id)
                    })
                    .catch((error) => {
                        this.paymentProcessing = false
                        this.errors = error.response.data.errors
                        console.log(error.response.data.errors)
                    })
            }
        },
    },
}
</script>