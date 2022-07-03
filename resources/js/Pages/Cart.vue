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
				v-if="overStockItems.length"
				class="border border-red-200 mt-2 px-5 py-3 ring ring-inset ring-red-50 rounded text-red-500"
			>
				<h1 class="font-semibold">
					{{ overStockItems.length }} items in your cart has changed quantity to maximum available quantity.
				</h1>
				<p class="text-sm">
					Items in your Shopping Cart will always reflect the most recent price and stock quantity.
				</p>
				<div
					v-for="overStockItem in overStockItems"
					:key="overStockItem.id"
					class="list-item text-sm"
				>
					{{ overStockItem.title }}
				</div>
			</div>
		</template>
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 my-12 min-h-96">
			<div
				v-if="cart.length"
				class="bg-white flex flex-col lg:flex-row lg:space-y-0 rounded-2xl shadow-md space-y-5"
			>
				<div class="lg:p-8 lg:w-2/3 p-4 w-full border-r">
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
							<div class="flex-1 flex flex-col items-start">
								<h1>{{ item.title }}</h1>
								<div class="flex items-center space-x-5 mt-3">
									<select
										@change="updateCartQuantity( index, item, $event )"
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
									@click="saveforlater(index, item)"
									class="mt-auto hover:bg-gray-50 hover:shadow-none border cursor-pointer inline-block px-3 py-1.5 rounded-md shadow text-xs"
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

				<div
					class="sticky self-start top-36 lg:p-8 lg:w-1/3 p-4 w-full"
				>
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
						<Link
							:href="route('checkout.index')"
							class="bg-gray-700 border cursor-pointer flex hover:shadow-none items-center justify-center ml-4 px-5 py-3 rounded-xl shadow-md text-sm text-white"
						>
							Checkout
						</Link>
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
					class="bg-gray-700 border cursor-pointer hover:shadow-none inline-block items-center max-w-max px-5 py-3 rounded-xl shadow-md text-sm text-white"
				>
					Continue Shopping
				</Link>
			</div>

			<!-- save for later section -->
			<div
				v-if="saveforlaterItems.length"
				class="mt-10 bg-white rounded-2xl p-4 lg:p-8 shadow-md w-full"
			>
				<h1
					class="text-gray-800 font-semibold leading-tight mb-5 text-xl"
				>
					Save for later
				</h1>
				<ul class="space-y-10">
					<li
						v-for="(item, index) in saveforlaterItems"
						:key="item.id"
						class="flex space-x-5"
					>
						<img
							src="/images/cover.png"
							:alt="item.title + '\'s cover image'"
							class="h-40"
						>
						<div class="flex-1 flex flex-col items-start">
							<h1>{{ item.title }}</h1>
							<div class="flex items-center space-x-5 mt-3">
								<!--								<select-->
								<!--									@change="updateCartQuantity(index, item, $event)"-->
								<!--									class="rounded-2xl shadow-md cursor-pointer"-->
								<!--								>-->
								<!--									<option-->
								<!--										v-for="qty in 10"-->
								<!--										:key="qty"-->
								<!--										:value="qty"-->
								<!--										:selected="item.quantity == qty"-->
								<!--									>-->
								<!--										{{ qty }}-->
								<!--									</option>-->
								<!--								</select>-->
								<span class="font-semibold">
									{{ formatPrice(item.price) }}
								</span>
							</div>

							<div
								v-cloak
								v-if="isInStockItem(item.id)"
								@click="movetocart(index, item)"
								class="hover:bg-gray-50 hover:shadow-none mt-auto border cursor-pointer inline-block px-3 py-1.5 rounded-md shadow text-xs"
							>
								Move to cart
							</div>
							<div
								v-else
								class="text-sm text-gray-500 mt-3"
							>
								This item is no longer available.
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
            overStockItems: [],
            filterSaveForLater: [],
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

    created() {
        this.checkStockForCheckout()
    },

    methods: {
        isInStockItem(id) {
            if (this.filterSaveForLater) {
                return this.filterSaveForLater.some((item) => {
                    return item.id === id
                })
            }
        },

        removeFromCart(index, item) {
            let _this = this

            axios.delete(route('cart.destroy', item.id)).then(() => {
                _this.cart.splice(index, 1)

                window.events.emit('cartQtyUpdated')
                window.flash('Successfully removed from cart')
            })
        },

        updateCartQuantity(index, item, event) {
            let _this = this
            let cartItem = _this.cart[index]

            axios.patch(route('cart.update', item.id), {
                qty: parseInt(event.target.value),
            })
                .then(() => {
                    cartItem.quantity = parseInt(event.target.value)

                    window.events.emit('cartQtyUpdated')
                    window.flash('Successfully updated quantity.')
                })
                .catch((err) => {
                    event.target.value = cartItem.quantity
                    window.flash(err.response.data.message, 'error')
                })
        },

        checkStockForCheckout() {
            axios.get(route('cart.checkStockForCheckout'))
                .then((res) => {
                    this.$inertia.reload({
                        onFinish: () => {
                            this.overStockItems = res.data.overStockItems
                            this.filterSaveForLater = res.data.filterSaveForLater
                            window.events.emit('cartQtyUpdated')
                        },
                    })
                })
        },

        saveforlater(index, item) {
            let _this = this

            axios.post(route('saveforlater', item.id)).then(() => {
                _this.cart.splice(index, 1)
                _this.saveforlaterItems.push(item)

                window.events.emit('cartQtyUpdated')
                window.flash('Successfully moved to save for later.')
            })
        },

        movetocart(index, item) {
            let _this = this

            axios.post(route('movetocart', item.id)).then(() => {
                _this.saveforlaterItems.splice(index, 1)
                _this.cart.push(item)

                window.events.emit('cartQtyUpdated')
                window.flash('Successfully moved to cart.')
            })
        },
    },
}
</script>
