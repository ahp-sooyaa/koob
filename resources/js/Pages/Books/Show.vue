<template>
	<Head>
		<title>Book Detail</title>
		<meta
			head-key="description"
			name="description"
			content="This is the book detail page"
		>
	</Head>

	<BreezeNavBarLayout>
		<template
			v-if="previousPurchasedOrder"
			#header
		>
			<!-- <h2 class="font-semibold text-xl text-gray-800 leading-tight">
				Shop
			</h2> -->
			<h1>
				You have previously purchased this book. See
				<Link
					:href="route('orders.show', previousPurchasedOrder.id)"
					class="hover:text-gray-900 transform hover:translate-y-20 underline"
				>
					order detail
				</Link>
			</h1>
		</template>

		<section
			class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 mb-16 pt-7"
			:class="{'mt-16': !previousPurchasedOrder}"
		>
			<!-- <div
				v-if="previousPurchasedOrder"
				class="text-gray-700 text-sm bg-white inline-block mb-5 px-5 py-3 rounded-2xl shadow"
			>
				<h1>
					You have previously purchased this book. See
					<Link
						:href="route('orders.show', previousPurchasedOrder.id)"
						class="hover:text-gray-900 transform hover:translate-y-20 underline"
					>
						order detail
					</Link>
				</h1>
			</div> -->
			<div class="flex justify-start">
				<img
					:src="book.cover_url"
					alt="book_cover"
					class="w-72 h-96 object-cover"
				>
				<div class="ml-8 w-1/2">
					<h1 class="font-bold mb-1 text-4xl tracking-tight">
						{{ book.title }}
					</h1>
					<div class="font-semibold mb-3 text-2xl text-gray-900">
						{{ formatPrice(book.price) }}
					</div>
					<p class="mb-3 text-gray-600">
						{{ book.excerpt }}
					</p>
					<div class="flex">
						<select
							id="qty"
							v-model="quantity"
							@change="updateCartQuantity(book, $event)"
							name="qty"
							class="mr-3 rounded-2xl text-xs"
						>
							<option
								v-for="qty in 10"
								:key="qty"
								:value="qty"
							>
								{{ qty }}
							</option>
						</select>
						<Button
							@click="addToCart"
							:disabled="isAdded"
							:class="{'cursor-default opacity-50': isAdded}"
						>
							{{ isAdded ? 'Added' : 'Add' }} to Cart
						</Button>
					</div>
				</div>
			</div>
		</section>
	</BreezeNavBarLayout>
</template>

<script>
import BreezeNavBarLayout from '@/Layouts/NavBar'
import format from '@/mixins/format'
import Button from '@/Components/Button'

export default {
    components: {
        Button,
        BreezeNavBarLayout,
    },

    mixins: [ format ],

    // layout: BreezeNavBarLayout,

    props: ['book', 'previousPurchasedOrder'],

    data() {
        return {
            quantity: 1,
            initialQuantity: 1,
            isAdded: this.$page.props.cart.some(
                (item) => item['id'] === this.book.id
            ),
        }
    },

    methods: {
        addToCart() {
            axios
                .post(route('cart.store', this.book.id), { qty: this.quantity })
                .then((res) => {
                    this.isAdded = true
                    window.events.emit('cartQtyUpdated')
                    window.flash(res.data.message)
                })
                .catch((err) => window.flash(err.response.data.message, 'error'))
        },

        updateCartQuantity(book, event){
            if (book.stock_count < parseInt(event.target.value)) {
                this.quantity = this.initialQuantity
                window.flash(`Quantity is exceeding over stock. Available quantity(${book.stock_count})`, 'error')
            } else {
                this.initialQuantity = this.quantity
            }
        },
    },
}
</script>

<style lang="scss" scoped>
</style>
