<template>
  <div
    class="w-full"
  >
    <div class="lg:w-2/3 w-full mx-auto mt-8 overflow-auto">
      <Link :href="route('books.index')">
        Continue Shopping
      </Link>
      <Link
        :href="route('cart.index')"
        class="ml-3"
      >
        Cart
      </Link>
      <table class="table-auto border-b w-full text-left whitespace-no-wrap">
        <thead>
          <tr>
            <th
              class="px-4 py-3 title-font tracking-wider text-gray-900 text-sm bg-gray-200 rounded-tl rounded-bl"
            >
              Item
            </th>
            <th
              class="px-4 py-3 title-font tracking-wider text-gray-900 text-sm bg-gray-200"
            >
              Quantity
            </th>
            <th
              class="px-4 py-3 title-font tracking-wider text-gray-900 text-sm bg-gray-200"
            >
              Price
            </th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="item in cart"
            :key="item.id"
          >
            <td
              class="p-4"
              v-text="item.title"
            />
            <td
              class="p-4"
              v-text="item.quantity"
            />
            <td
              class="p-4"
              v-text="formatPrice(item.price * item.quantity)"
            />
          </tr>
          <tr>
            <td class="col-span-2 p-4 font-bold">
              Total Amount
            </td>
            <td
              class="p-4 font-bold"
              v-text="cartQuantity"
            />
            <td
              class="p-4 font-bold"
              v-text="formatPrice(cartTotal)"
            />
          </tr>
        </tbody>
      </table>
    </div>
    <div class="lg:w-2/3 w-full mx-auto mt-8">
      <div class="flex flex-wrap -mx-2 mt-8">
        <div class="p-2 w-1/3">
          <div class="relative">
            <label
              for="first_name"
              class="leading-7 text-sm text-gray-600"
            >First Name</label>
            <input
              id="first_name"
              v-model="customer.first_name"
              type="text"
              name="first_name"
              class="w-full bg-gray-100 rounded border border-gray-300 focus:border-indigo-500 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
              :disabled="paymentProcessing"
            >
          </div>
        </div>
        <div class="p-2 w-1/3">
          <div class="relative">
            <label
              for="last_name"
              class="leading-7 text-sm text-gray-600"
            >Last Name</label>
            <input
              id="last_name"
              v-model="customer.last_name"
              type="text"
              name="last_name"
              class="w-full bg-gray-100 rounded border border-gray-300 focus:border-indigo-500 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
              :disabled="paymentProcessing"
            >
          </div>
        </div>
        <div class="p-2 w-1/3">
          <div class="relative">
            <label
              for="email"
              class="leading-7 text-sm text-gray-600"
            >Email Address</label>
            <input
              id="email"
              v-model="customer.email"
              type="email"
              name="email"
              class="w-full bg-gray-100 rounded border border-gray-300 focus:border-indigo-500 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
              :disabled="paymentProcessing"
            >
          </div>
        </div>
      </div>
      <div class="flex flex-wrap -mx-2 mt-4">
        <div class="p-2 w-1/3">
          <div class="relative">
            <label
              for="address"
              class="leading-7 text-sm text-gray-600"
            >Street Address</label>
            <input
              id="address"
              v-model="customer.address"
              type="text"
              name="address"
              class="w-full bg-gray-100 rounded border border-gray-300 focus:border-indigo-500 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
              :disabled="paymentProcessing"
            >
          </div>
        </div>
        <div class="p-2 w-1/3">
          <div class="relative">
            <label
              for="city"
              class="leading-7 text-sm text-gray-600"
            >City</label>
            <input
              id="city"
              v-model="customer.city"
              type="text"
              name="city"
              class="w-full bg-gray-100 rounded border border-gray-300 focus:border-indigo-500 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
              :disabled="paymentProcessing"
            >
          </div>
        </div>
        <div class="p-2 w-1/6">
          <div class="relative">
            <label
              for="state"
              class="leading-7 text-sm text-gray-600"
            >State</label>
            <input
              id="state"
              v-model="customer.state"
              type="email"
              name="state"
              class="w-full bg-gray-100 rounded border border-gray-300 focus:border-indigo-500 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
              :disabled="paymentProcessing"
            >
          </div>
        </div>
        <div class="p-2 w-1/6">
          <div class="relative">
            <label
              for="zip_code"
              class="leading-7 text-sm text-gray-600"
            >Zip Code</label>
            <input
              id="zip_code"
              v-model="customer.zip_code"
              type="email"
              name="zip_code"
              class="w-full bg-gray-100 rounded border border-gray-300 focus:border-indigo-500 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
              :disabled="paymentProcessing"
            >
          </div>
        </div>
      </div>
      <div class="flex flex-wrap -mx-2 mt-4">
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
      <div class="p-2 w-full">
        <button
          @click="processPayment"
          class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg"
          :class="!cart.length ? 'cursor-not-allowed' : ''"
          :disabled="paymentProcessing || !cart.length"
          v-text="paymentProcessing ? 'Processing' : 'Pay Now'"
        />
      </div>
    </div>
  </div>
</template>
<script>
import { Link } from '@inertiajs/inertia-vue3'
import { loadStripe } from '@stripe/stripe-js'
export default {
    components: {
        Link,
    },

    data() {
        return {
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
            return amount
        },
    },
    async mounted() {
        this.stripe = await loadStripe(process.env.MIX_STRIPE_KEY)
        const elements = this.stripe.elements()
        this.cardElement = elements.create('card', {
            classes: {
                base: 'bg-gray-100 rounded border border-gray-300 focus:border-indigo-500 text-base outline-none text-gray-700 p-3 leading-8 transition-colors duration-200 ease-in-out',
            },
        })
        this.cardElement.mount('#card-element')
    },
    methods: {
        formatPrice(price) {
            return (price / 100).toLocaleString('en-US', {style: 'currency', currency: 'USD'})
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
                console.error(error)
            } else {
                this.customer.payment_method_id = paymentMethod.id
                this.customer.amount = this.cartTotal
                this.customer.cart = JSON.stringify(this.$page.props.cart)
                axios
                    .post('/checkout', this.customer)
                    .then((response) => {
                        this.paymentProcessing = false
                        this.$inertia.get('/thankyou/' + response.data.id)
                        // console.log(response.data)
                    })
                    .catch((error) => {
                        this.paymentProcessing = false
                        console.error(error)
                    })
            }
        },
    },
}
</script>