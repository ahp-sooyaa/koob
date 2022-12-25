<template>
	<Head>
		<title>Order History</title>
		<meta
			head-key="description"
			name="description"
			content="This is the order history page"
		>
	</Head>

	<SettingSideBarLayout>
		<template #header>
			<h2 class="font-semibold text-xl text-gray-800 leading-tight">
				Orders & Returns
			</h2>
			<p class="text-sm text-gray-500 mt-1">
				Manage your orders, view their progress or return products.
			</p>
		</template>

		<!-- orders list -->
		<div
			class="w-full lg:max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pt-10 mb-16"
		>
			<div v-if="ordersCount">
				<search-box
					:search-query="search"
					placeholder="Search by order id or book title..."
					classes="w-full rounded-lg"
				/>
			</div>
			<div v-if="orders.data.length">
				<div class="divide-y space-y-10">
					<div
						v-for="order in orders.data"
						:key="order.id"
						class="space-y-5"
					>
						<div class="flex flex-col lg:flex-row lg:items-baseline justify-between mb-5 pt-8 space-y-3 lg:space-y-0">
							<div class="flex flex-col lg:flex-row items-baseline lg:space-x-3">
								<h1 class="font-semibold text-md lg:text-2xl">
									Order #{{ order.id }}
								</h1>
								<div class="text-sm text-gray-500">
									Order placed {{ formatDate(order.created_at) }}
								</div>
							</div>
							<div class="flex items-end divide-x divide-gray-400 space-x-5 text-sm text-gray-800">
								<Link
									:href="route('orders.show', order.id)"
									class="hover:underline"
								>
									Order Detail
								</Link>
								<!-- <Link
									:href="route('orders.show', order.id)"
									class="hover:underline pl-5"
								>
									Order Again
								</Link> -->
							</div>
						</div>
						<div class="divide-y">
							<div
								v-for="(book, index) in order.books"
								:key="book.id"
								class="flex items-start justify-between space-x-5"
								:class="index !== 0 ? 'mt-3 pt-3' : ''"
							>
								<div class="flex space-x-5 w-full">
									<Link
										:href="route('books.show', book.slug)"
										class="flex-none w-24 h-32 lg:w-28 lg:h-36"
									>
										<img
											:src="book.cover_url"
											alt="book cover"
											class="object-cover w-full h-full"
										>
									</Link>
									<div class="flex-1">
										<Link
											:href="route('books.show', book.slug)"
											class="hover:underline"
										>
											{{ book.title }}
										</Link>
										<div
											class="font-semibold"
											v-text="formatPrice(book.price)"
										/>

										<!-- mobile buy again & shop similar button -->
										<div class="block sm:hidden flex-shrink-0 space-y-3 mt-5">
											<BreezeButton
												@click="buyAgain(book.id)"
												type="button"
												class="w-full"
											>
												Buy again
											</BreezeButton>
											<BreezeButtonOutline
												@click="addToCart(book.id)"
												type="button"
												class="w-full"
											>
												Add to Cart
											</BreezeButtonOutline>
										</div>
									</div>
								</div>
								<div class="hidden sm:flex flex-col flex-shrink-0 space-y-3">
									<BreezeButton
										@click="buyAgain(book.id)"
										type="button"
									>
										Buy again
									</BreezeButton>
									<BreezeButtonOutline
										@click="addToCart(book.id)"
										type="button"
									>
										Add to Cart
									</BreezeButtonOutline>
								</div>
							</div>
						</div>
					</div>
				</div>
				<paginator
					:links="orders.links"
					class="mt-5"
				/>
			</div>
			<div
				v-if="!ordersCount || !orders.data.length"
				class="text-center py-10"
			>
				<div
					v-if="!ordersCount"
					class="flex flex-col items-center"
				>
					<img
						src="/images/no-order.svg"
						alt="No Order svg"
						class="w-52 h-52"
					>
					<h1 class="mt-8 text-xl font-bold text-gray-900 tracking-wide">
						No Orders Yet
					</h1>
					<p class="text-sm text-gray-500 mb-5 mt-1 w-72 text-center">
						Please make your first purchase and come back here
					</p>
					<Link :href="route('books.index')">
						<BreezeButton>
							Continue Shopping
						</BreezeButton>
					</Link>
				</div>
				<div
					v-if="search && !orders.data.length"
					class="flex flex-col items-center"
				>
					<img
						src="/images/not-found.svg"
						alt="Not Found svg"
						class="w-52 h-52"
					>
					
					<h1 class="mt-8 text-xl font-bold text-gray-900 tracking-wide">
						Result Not Found
					</h1>
					<p class="text-sm text-gray-500 mb-5 mt-1 w-72">
						Please try again with different keywords or check spelling
					</p>
				</div>
			</div>
		</div>
		<!-- end of orders list -->
	</SettingSideBarLayout>
</template>

<script>
import SettingSideBarLayout from '@/Layouts/SettingSideBar'
import SearchBox from '@/Components/SearchBox'
import Paginator from '@/Components/Paginator'
import format from '@/mixins/format'
import BreezeButton from '@/Components/Button'
import BreezeButtonOutline from '@/Components/ButtonOutline'

export default {
    components: {
        SettingSideBarLayout,
        BreezeButton,
        BreezeButtonOutline,
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
        addToCart(id) {
            axios
                .post(route('cart.store', id))
                .then((res) => {
                    window.events.emit('cartQtyUpdated')
                    window.flash(res.data.message)
                })
                .catch(err => flash(err.response.data.message, 'error'))
        },

        buyAgain(id) {
            this.$inertia.post(route('buyNow.store', id))
        },
    }
}
</script>

<style lang="scss" scoped>
</style>
