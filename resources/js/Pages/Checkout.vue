<template>
	<BreezeNavBarLayout>
		<Head title="Checkout" />

		<template #header>
			<h2 class="font-semibold text-xl text-gray-800 leading-tight">
				Checkout
			</h2>
		</template>
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 mb-16 mt-12">
			<div class="flex flex-col-reverse lg:flex-row lg:space-x-16">
				<div class="lg:w-1/2 w-full mx-auto">
					<h1 class="text-xl font-semibold">
						Contact Information
					</h1>
					<div class="lg:flex flex-wrap -mx-2">
						<div class="p-2 lg:w-1/2">
							<div class="relative">
								<label
									for="contact_name"
									class="leading-7 text-sm text-gray-600"
								>Name</label>
								<BreezeInput
									id="contact_name"
									v-model="customer.contact_name"
									name="contact_name"
									type="text"
									class="mt-1 block w-full"
									required
									autocomplete="contact_name"
									:disabled="paymentProcessing"
								/>
								<BreezeInputError
									:message="errors.contact_name ? errors.contact_name[0] : ''"
								/>
							</div>
						</div>
						<div class="p-2 lg:w-1/2">
							<div class="relative">
								<label
									for="contact_email"
									class="leading-7 text-sm text-gray-600"
								>Email Address</label>
								<BreezeInput
									id="contact_email"
									v-model="customer.contact_email"
									name="contact_email"
									type="email"
									class="mt-1 block w-full"
									required
									autocomplete="contact_email"
									:disabled="paymentProcessing"
								/>
								<BreezeInputError
									:message="errors.contact_email ? errors.contact_email[0] : ''"
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
									name="address"
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
									name="city"
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
									name="state"
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
									name="zip_code"
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
						class="bg-gray-700 border cursor-pointer flex hover:shadow-none items-center justify-center mt-5 px-5 py-3 rounded-xl shadow-md text-sm text-white w-full"
						dusk="paynow"
						:class="paymentProcessing || !products.length ? 'cursor-not-allowed bg-gray-400' : ''"
						:disabled="paymentProcessing || !products.length"
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
				<div class="bg-white rounded-2xl p-4 lg:p-8 shadow-md w-full lg:w-1/2 mb-12 lg:mb-0">
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
							v-for="(item, index) in products"
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
								<div class="flex items-center flex-1 space-x-5">
									<select
										@change="updateCartQuantity(index, item, $event)"
										class="rounded-2xl shadow-md cursor-pointer"
									>
										<option
											v-for="qty in 10"
											:key="qty"
											:value="qty"
											:selected="item.quantity === qty"
										>
											{{ qty }}
										</option>
									</select>
									<span class="font-semibold">
										{{ formatPrice(item.price) }}
									</span>
								</div>
							</div>
							<button
								@click="removeFromCart(index, item)"
								class="ml-auto text-sm text-gray-500 hover:text-gray-800 border-0 pt-0.5 focus:outline-none rounded self-start"
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
								<span class="font-semibold">
									<span
										v-if="coupon"
										class="text-gray-500"
									>
										{{ coupon.type === "Percentage" ? `(-${coupon.value}%)` : `(-$${coupon.value})` }}
									</span>
									{{ formatPrice(cartTotal) }}
								</span>
							</div>
							<div class="flex justify-between">
								<span class="text-gray-500">Delivery Fee</span>
								<span class="font-semibold">Free</span>
							</div>
							<div
								v-if="!coupon"
								class="flex items-center justify-between relative"
							>
								<input
									v-model="code"
									type="text"
									placeholder="coupon"
									class="rounded-2xl w-full focus:ring-0 focus:border-black"
								>
								<div
									@click="applyCoupon"
									class="absolute bg-gray-800 px-7 py-2 right-0 rounded-2xl"
									:class="code ? 'cursor-pointer text-gray-100' : 'opacity-50 cursor-default text-gray-500'"
								>
									Apply
								</div>
							</div>
							<div
								v-else
								class="flex justify-between bg-gray-100 py-2 px-3 -mx-3 rounded-lg"
							>
								<div class="text-gray-500">
									Coupon <span class="font-semibold">({{ coupon.code }})</span>
								</div>
								<div
									@click="removeCoupon"
									class="cursor-pointer text-gray-500 hover:text-gray-700"
								>
									<svg
										xmlns="http://www.w3.org/2000/svg"
										class="h-5 w-5"
										viewBox="0 0 20 20"
										fill="currentColor"
									>
										<path
											fill-rule="evenodd"
											d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
											clip-rule="evenodd"
										/>
									</svg>
								</div>
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
import { loadStripe } from '@stripe/stripe-js'
import BreezeNavBarLayout from '@/Layouts/NavBar'
import BreezeInputError from '@/Components/InputError'
import BreezeInput from '@/Components/Input'
import format from '@/mixins/format'

export default {
    components: {
        BreezeNavBarLayout,
        BreezeInputError,
        BreezeInput,
    },

    mixins: [ format ],

    props: ['message', 'appliedCoupon', 'checkoutMode'],

    data() {
        return {
            products: [],
            errors: [],
            stripe: {},
            cardElement: {},
            customer: {
                contact_name: this.$page.props.auth.user?.name,
                contact_email: this.$page.props.auth.user?.email,
                address: '',
                city: '',
                state: '',
                zip_code: '',
            },
            paymentProcessing: false,
            code: '',
            coupon: this.appliedCoupon,
        }
    },

    computed: {
        cart() {
            return this.$page.props.cart
        },

        buyNow() {
            return this.$page.props.buyNow
        },

        cartQuantity() {
            let totalQty = 0
            for (const key in this.products) {
                totalQty += this.products[key].quantity
            }
            return totalQty
        },

        cartTotal() {
            let amount = 0
            for (const key in this.products) {
                amount += this.products[key].quantity * this.products[key].price
            }
            if(this.coupon) {
                amount = (this.coupon.type === 'Percentage')
                    ? amount - (amount * (this.coupon.value / 100))
                    : 100 * ((amount / 100) - this.coupon.value)
            }

            return Math.round(amount) // don't format this with formatPrice(), it will cause error with stripe 'invalid integer $10.00'
        },
    },

    created() {
        this.products = (this.checkoutMode === 'cart' ? this.cart : this.buyNow)
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
        updateCartQuantity(index, item, event){
            let cartItem = this.products[index]
            let routeName = this.checkoutMode === 'cart' ? 'cart.update' : 'buyNow.update'

            axios
                .patch(route(routeName, item.id), {qty: parseInt(event.target.value)})
                .then(res => {
                    cartItem.quantity = parseInt(event.target.value)
                    window.events.emit('cartQtyUpdated')
                    window.flash(res.data.message)
                })
                .catch(err => {
                    event.target.value = cartItem.quantity
                    window.flash(err.response.data.message, 'error')
                })
        },

        removeFromCart(index, item) {
            if(this.checkoutMode === 'cart') {
                axios
                    .delete(route('cart.destroy', item.id))
                    .then(() => {
                        if (Object.keys(this.products).length === 1) {
                            this.$inertia.get(route('books.index'), {}, {
                                onSuccess: () => {
                                    window.events.emit('cartQtyUpdated')
                                    window.flash('Successfully deleted from cart')
                                }
                            })
                        } else {
                            this.products.splice(index, 1)

                            window.events.emit('cartQtyUpdated')
                            window.flash('Successfully deleted from cart')
                        }
                    })
            } else {
                this.$inertia.delete(route('buyNow.destroy', item.id))
            }
        },

        async processPayment() {
            this.paymentProcessing = true
            const { paymentMethod, error } = await this.stripe.createPaymentMethod(
                'card',
                this.cardElement,
                {
                    billing_details: {
                        name: this.customer.contact_name,
                        email: this.customer.contact_email,
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
                this.customer.cart = JSON.stringify(this.products)
                axios
                    .post(route('orders.store'), this.customer)
                    .then((response) => {
                        this.paymentProcessing = false
                        this.$inertia.get(route('checkout.thankYou', response.data.id))
                    })
                    .catch((error) => {
                        this.paymentProcessing = false
                        this.errors = error.response.data.errors
                    })
            }
        },

        applyCoupon() {
            if (!this.code || this.code.trim() === null) return

            axios
                .post(route('coupons.store'), {code: this.code})
                .then(res => {
                    this.coupon = res.data.coupon
                    window.flash(res.data.message)
                })
                .catch(err => window.flash(err.response.data.message, 'error'))
        },

        removeCoupon() {
            axios
                .delete(route('coupons.destroy'))
                .then(() => {
                    this.code = ''
                    this.coupon = ''
                })
        },
    },
}
</script>
