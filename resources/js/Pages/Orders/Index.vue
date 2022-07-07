<template>
	<Head>
		<title>Order History</title>
		<meta
			head-key="description"
			name="description"
			content="This is the order history page"
		>
	</Head>

	<BreezeNavBarLayout>
		<template #header>
			<h2 class="font-semibold text-xl text-gray-800 leading-tight">
				Order History
			</h2>
		</template>

		<!-- orders list -->
		<div
			class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 mt-12 mb-16"
		>
			<div v-if="ordersCount">
				<search-box :search-query="search" />
			</div>
			<div v-if="orders.data.length">
				<div class="divide-y space-y-10">
					<div
						v-for="order in orders.data"
						:key="order.id"
						class="space-y-5"
					>
						<div class="flex lg:items-baseline justify-between mb-5 pt-10">
							<div class="flex flex-col lg:flex-row items-baseline lg:space-x-3">
								<h1 class="text-2xl">
									Order #{{ order.id }}
								</h1>
								<span>Order placed on {{ formatDate(order.created_at) }}</span>
							</div>
							<Link
								:href="route('orders.show', order.id)"
								class="hover:underline"
							>
								Order Detail
							</Link>
						</div>
						<Link
							v-for="(book) in order.books"
							:key="book.id"
							:href="route('books.show', book.id)"
							class="-m-5 flex hover:bg-white hover:shadow items-start justify-between px-5 py-3 rounded-md space-x-5 group"
						>
							<div class="flex space-x-5">
								<img
									:src="book.cover"
									alt="book cover"
									class="h-36"
								>
								<div>
									<div
										class="group-hover:underline"
										v-text="book.title"
									/>
									<!-- <div
                  class=""
                  v-text="book.pivot.quantity"
                /> -->
									<div
										class="font-semibold"
										v-text="formatPrice(book.price)"
									/>

									<!-- mobile buy again & shop similar button -->
									<div class="block lg:hidden flex-shrink-0 space-y-3 mt-5">
										<div
											@click="buyAgain(book.id)"
											class="bg-blue-500 border-0 capitalize cursor-pointer flex focus:outline-none hover:bg-blue-400 justify-center px-6 py-2 rounded text-sm text-white"
										>
											buy again
										</div>
										<div class="border capitalize cursor-pointer flex focus:outline-none hover:border-gray-700 justify-center px-6 py-2 rounded text-sm">
											shop similar
										</div>
									</div>
								</div>
							</div>
							<div class="hidden lg:block flex-shrink-0 space-y-3">
								<div
									@click="buyAgain(book.id)"
									class="bg-blue-500 border-0 capitalize cursor-pointer flex focus:outline-none hover:bg-blue-400 justify-center px-6 py-2 rounded text-sm text-white"
								>
									buy again
								</div>
								<div class="border capitalize cursor-pointer flex focus:outline-none hover:border-gray-700 justify-center px-6 py-2 rounded text-sm">
									shop similar
								</div>
							</div>
						</Link>
					</div>
				</div>
				<paginator
					:links="orders.links"
					class="mt-5"
				/>
			</div>
			<div
				v-if="!ordersCount || !orders.data.length"
				class="text-center pb-16"
			>
				<lottie-player
					src="https://assets6.lottiefiles.com/packages/lf20_0s6tfbuc.json"
					background="transparent"
					speed="1"
					style="width: 200px; height: 200px;"
					loop
					autoplay
					class="mx-auto"
				/>
				<div v-if="!ordersCount">
					<p class="mb-3 text-gray-700">
						You didn't order anything!
					</p>
					<Link
						:href="route('books.index')"
						class="bg-blue-500 px-3 py-1.5 rounded-md text-white shadow"
					>
						Continue Shopping
					</Link>
				</div>
				<div v-if="search && !orders.data.length">
					<p class="mb-3 text-gray-700">
						No results found for <span class="font-bold">"{{ search }}"</span>
					</p>
					<p>Try different keywords or check spelling.</p>
				</div>
			</div>
		</div>
		<!-- end of orders list -->
	</BreezeNavBarLayout>
</template>

<script>
import BreezeNavBarLayout from '@/Layouts/NavBar'
import SearchBox from '@/Components/SearchBox'
import Paginator from '@/Components/Paginator'
import format from '@/mixins/format'

export default {
    components: {
        BreezeNavBarLayout,
        SearchBox,
        Paginator
    },

    mixins: [ format ],

    props: ['orders', 'ordersCount', 'search'],

    computed: {
        totalOrderCount() {
            return this.orders.length
        }
    },

    methods: {
        buyAgain(id) {
            axios.post(route('cart.store', id))
                .then(() => {
                    window.events.emit('cartQtyUpdated')
                    this.$inertia.visit('/checkout')
                })
                .catch(err => flash(err.response.data.message, 'error'))
        }
    }
}
</script>

<style lang="scss" scoped>
</style>
