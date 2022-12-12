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
			<h1 class="text-sm text-gray-700">
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
					<p class="mb-3 text-gray-700">
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

		<!-- <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 mb-16 pt-7">
			similar books
		</section> -->

		<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 mb-16 pt-7">
			<div class="flex border-b-2 pb-2 text-lg space-x-10 text-gray-400 tracking-wide mb-10">
				<h1 
					@click="activeTab = 'details'" 
					class="hover:text-gray-900 border-b-2 border-transparent hover:border-gray-900 pb-2 -mb-2.5 cursor-pointer transition duration-300 ease-in-out"
					:class="{'text-gray-900 border-gray-900': activeTab === 'details'}"	
				>
					Details
				</h1>
				<h1 
					@click="activeTab = 'reviews'" 
					class="hover:text-gray-900 border-b-2 border-transparent hover:border-gray-900 pb-2 -mb-2.5 cursor-pointer transition duration-300 ease-in-out"
					:class="{'text-gray-900 border-gray-900': activeTab === 'reviews'}"		
				>
					Reviews
				</h1>
			</div>
			<div v-show="activeTab === 'details'" class="space-y-5 w-1/4">
				<div class="flex justify-between items-center space-x-2">
					<span class="text-gray-500">Publisher</span>
					<div class="flex-1 border-t mt-1"></div>
					<span>Manager FeedWise</span>
				</div>
				<div class="flex justify-between items-center space-x-2">
					<span class="text-gray-500">Year of publishing</span>
					<div class="flex-1 border-t mt-1"></div>
					<span>2015</span>
				</div>
				<div class="flex justify-between items-center space-x-2">
					<span class="text-gray-500">No of pages</span>
					<div class="flex-1 border-t mt-1"></div>
					<span>100</span>
				</div>
				<div class="flex justify-between items-center space-x-2">
					<span class="text-gray-500">ISBN</span>
					<div class="flex-1 border-t mt-1"></div>
					<span>2544365629</span>
				</div>
				<div class="flex justify-between items-center space-x-2">
					<span class="text-gray-500">Format</span>
					<div class="flex-1 border-t mt-1"></div>
					<span>Online Book, Paper Book</span>
				</div>
			</div>
			<div v-show="activeTab === 'reviews'" class="flex space-x-20">
				<ReviewList :reviewList="reviews" :ratings="ratings"></ReviewList>
			</div>
		</section>
	</BreezeNavBarLayout>
</template>

<script>
import BreezeNavBarLayout from '@/Layouts/NavBar'
import format from '@/mixins/format'
import Button from '@/Components/Button'
import ReviewList from '@/Components/ReviewList'

export default {
    components: {
        Button,
        BreezeNavBarLayout,
		ReviewList,
    },

    mixins: [ format ],

    // layout: BreezeNavBarLayout,

    props: ['book', 'previousPurchasedOrder', 'reviews', 'ratings'],

    data() {
        return {
            quantity: 1,
            initialQuantity: 1,
            isAdded: this.$page.props.cart.some(
                (item) => item['id'] === this.book.id
            ),
			activeTab: 'reviews',
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
