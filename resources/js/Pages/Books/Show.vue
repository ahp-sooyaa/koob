<template>
	<Head>
		<title>Book Detail</title>
		<meta
			head-key="description"
			name="description"
			content="This is the book detail page"
		>
	</Head>

	<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 my-16 pt-7">
		<div
			v-if="previousPurchasedOrder"
			class="bg-white inline-block mb-5 px-5 py-3 rounded-2xl shadow"
		>
			<h1>
				You have previously purchased this book. See
				<Link
					:href="route('orders.show', previousPurchasedOrder.id)"
					class="hover:text-gray-800 underline"
				>
					order detail
				</Link>
			</h1>
		</div>
		<div class="flex justify-start">
			<img
				:src="book.cover"
				alt="book_cover"
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
						class="mr-3 rounded-2xl"
					>
						<option
							v-for="qty in 10"
							:key="qty"
							:value="qty"
						>
							{{ qty }}
						</option>
					</select>
					<button
						@click="addToCart"
						class="w-60 font-bold px-4 py-2 rounded-xl text-white"
						:class="
							isAdded ? 'bg-gray-500 cursor-not-allowed' : 'bg-blue-500'
						"
						:disabled="isAdded"
						v-text="isAdded ? 'Added to Cart' : 'Add to Cart'"
					/>
				</div>
			</div>
		</div>
	</section>
</template>

<script>
import BreezeNavBarLayout from '@/Layouts/NavBar'
import format from '@/mixins/format'

export default {
    mixins: [ format ],

    layout: BreezeNavBarLayout,

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
                .then(() => {
                    this.isAdded = true
                    window.events.emit('cartQtyUpdated')
                    window.flash('Successfully added to Cart')
                })
                .catch((err) => console.log(err))
        },

        updateCartQuantity(book, event){
            if (book.available_stock_count < parseInt(event.target.value)) {
                this.quantity = this.initialQuantity
                window.flash(`Quantity is exceeding over stock. Available quantity(${book.available_stock_count})`, 'error')
            } else {
                this.initialQuantity = this.quantity
                window.events.emit('cartQtyUpdated')
                window.flash('Successfully Updated')
            }
        },
    },
}
</script>

<style lang="scss" scoped>
</style>
