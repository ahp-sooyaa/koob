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
				v-if="cartItems.length"
				class="bg-white flex flex-col lg:flex-row lg:space-y-0 lg:rounded-2xl shadow-md space-y-5 -mx-4 lg:-mx-0"
			>
				<div class="lg:p-8 lg:w-2/3 p-4 w-full lg:border-r">
					<ul class="space-y-10">
						<li
							v-for="(item, index) in cartItems"
							:key="item.id"
							class="flex space-x-5"
						>
							<img
								:src="item.cover_url"
								:alt="item.title + '\'s cover image'"
								class="w-24 h-32 lg:h-40 lg:w-32 object-cover"
							>
							<div class="flex-1 flex flex-col items-start">
								<Link
									:href="route('books.show', item.slug)"
									class="line-clamp-2"
								>
									{{ item.title }}
								</Link>
								<div class="flex items-center space-x-5 mt-3">
									<select
										@change="updateCartQuantity( index, item, $event )"
										class="rounded-2xl shadow-md cursor-pointer text-xs"
										name="quantity"
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

								<div
									v-if="$page.props.auth.user"
									@click="saveForLater(index, item)"
									class="mt-5 hover:bg-gray-50 hover:shadow-none border cursor-pointer inline-block px-3 py-1.5 rounded-md shadow text-xs"
								>
									Save for later
								</div>
							</div>
							<!-- <button
								@click="removeFromCart(index, item)"
								class="flex ml-auto text-sm text-red-500 hover:text-red-800 border-0 pt-0.5 focus:outline-none rounded"
							> -->
							<svg
								@click="removeFromCart(index, item)"
								xmlns="http://www.w3.org/2000/svg"
								class="h-5 w-5 text-sm text-red-500 hover:text-red-800 cursor-pointer flex-shrink-0"
								viewBox="0 0 20 20"
								fill="currentColor"
							>
								<path
									fill-rule="evenodd"
									d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
									clip-rule="evenodd"
								/>
							</svg>
							<!-- </button> -->
						</li>
					</ul>
				</div>

				<div
					class="sticky self-start top-36 lg:p-8 lg:w-1/3 p-4 w-full"
				>
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
							dusk="checkout"
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
				class="flex flex-col items-center"
			>
				<!-- <lottie-player
					src="https://assets6.lottiefiles.com/packages/lf20_0s6tfbuc.json"
					background="transparent"
					speed="1"
					style="width: 200px; height: 200px"
					loop
					autoplay
					class="mx-auto"
				/> -->
				<img
					src="/images/empty-cart.svg"
					alt="Empty Cart svg"
					class="w-52 h-52"
				>

				<h1 class="mt-8 text-xl font-bold text-gray-900 tracking-wide">
					Your Cart is Empty
				</h1>
				<p class="text-sm text-gray-500 mb-5 mt-1 w-72 text-center">
					Looks like you haven't added anything to your cart yet
				</p>
				<Link
					:href="route('books.index')"
				>
					<BreezeButton>
						Continue Shopping
					</BreezeButton>
				</Link>
			</div>

			<!-- save for later section -->
			<div
				v-if="allSavedItems.length"
				class="mt-10 bg-white -mx-4 lg:-mx-0 lg:rounded-2xl p-4 lg:p-8 shadow-md"
			>
				<div class="flex items-center mb-5">
					<h1
						class="text-gray-800 font-semibold leading-tight text-xl mr-2"
					>
						Save for later
					</h1>
					<div class="relative">
						<svg
							@mouseover="showToolTip = true"
							@mouseleave="showToolTip = false"
							xmlns="http://www.w3.org/2000/svg"
							fill="none"
							viewBox="0 0 24 24"
							stroke-width="1.5"
							stroke="currentColor"
							class="w-5 h-5 cursor-pointer text-gray-500 hover:text-gray-700"
						>
							<path
								stroke-linecap="round"
								stroke-linejoin="round"
								d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z"
							/>
						</svg>
						<div
							v-show="showToolTip"
							class="absolute bg-gray-700 bottom-5 transform -translate-x-1/2 lg:translate-x-0 lg:left-0 origin-bottom-left px-4 rounded text-sm text-white w-72 py-2"
						>
							If your cart items are out of stock, they will automatically move to save for later list.
						</div>
					</div>
				</div>

				<ul class="space-y-10">
					<li
						v-for="(item, index) in allSavedItems"
						:key="item.id"
						class="flex space-x-5"
					>
						<img
							:src="item.cover_url"
							:alt="item.title + '\'s cover image'"
							class="w-24 h-32 lg:h-40 lg:w-32 object-cover"
						>
						<div class="flex-1 flex flex-col items-start">
							<Link
								:href="route('books.show', item.slug)"
								class="hover:underline line-clamp-2"
							>
								{{ item.title }}
							</Link>
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
								@click="moveToCart(index, item)"
								class="hover:bg-gray-50 hover:shadow-none mt-auto border cursor-pointer inline-block px-3 py-1.5 rounded-md shadow text-xs"
							>
								Move to cart
							</div>
							<div
								v-else
								class="text-sm text-gray-500 mt-3"
							>
								This item is no longer available. Out of Stock.
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
import BreezeButton from '@/Components/Button'
import axios from 'axios'
import format from '@/mixins/format'

export default {
    components: {
        BreezeNavBarLayout,
        BreezeButton,
    },

    mixins: [format],

    props: ['cartItems', 'allSavedItems', 'overStockItems', 'availableSavedItems'],

    data() {
        return {
            showToolTip: false,
        }
    },

    computed: {
        cartQuantity() {
            let totalQty = 0
            for (const key in this.cartItems) {
                totalQty += this.cartItems[key].quantity
            }

            return totalQty
        },
        cartTotal() {
            let amount = 0
            for (const key in this.cartItems) {
                amount += this.cartItems[key].quantity * this.cartItems[key].price
            }

            return this.formatPrice(amount)
        },
    },

    methods: {
        isInStockItem(id) {
            if (this.availableSavedItems) {
                return this.availableSavedItems.some((item) => {
                    return item.id === id
                })
            }
        },

        removeFromCart(index, item) {
            let _this = this

            axios
                .delete(route('cart.destroy', item.id))
                .then((res) => {
                    _this.cartItems.splice(index, 1)

                    window.events.emit('cartQtyUpdated')
                    window.flash(res.data.message)
                })
        },

        updateCartQuantity(index, item, event) {
            let _this = this
            let cartItem = _this.cartItems[index]

            axios
                .patch(route('cart.update', item.id), {
                    qty: parseInt(event.target.value),
                })
                .then((res) => {
                    cartItem.quantity = parseInt(event.target.value)

                    window.events.emit('cartQtyUpdated')
                    window.flash(res.data.message)
                })
                .catch((err) => {
                    event.target.value = cartItem.quantity
                    window.flash(err.response.data.message, 'error')
                })
        },

        saveForLater(index, item) {
            let _this = this

            axios
                .post(route('saveForLater.store', item.id))
                .then((res) => {
                    _this.cartItems.splice(index, 1)
                    _this.allSavedItems.push(item)
                    _this.availableSavedItems.push(item)

                    window.events.emit('cartQtyUpdated')
                    window.flash(res.data.message)
                })
        },

        moveToCart(index, item) {
            let _this = this

            axios
                .post(route('moveToCart', item.id))
                .then((res) => {
                    _this.allSavedItems.splice(index, 1)
                    _this.cartItems.push(item)

                    window.events.emit('cartQtyUpdated')
                    window.flash(res.data.message)
                })
        },
    },
}
</script>
