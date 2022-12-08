<template>
	<Head>
		<title>Order Detail</title>
		<meta
			head-key="description"
			name="description"
			content="This is the order detail page."
		>
	</Head>

	<SettingSideBarLayout>
		<template #header>
			<!-- <h2 class="flex items-center space-x-2 font-semibold text-xl text-gray-800 leading-tight">
				<Link
					:href="route('orders.index')"
					class="text-gray-500 hover:text-gray-900"
				>
					Order History
				</Link>
				<svg
					xmlns="http://www.w3.org/2000/svg"
					class="h-6 w-6 text-gray-400"
					viewBox="0 0 20 20"
					fill="currentColor"
				>
					<path
						fill-rule="evenodd"
						d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
						clip-rule="evenodd"
					/>
				</svg>
				Order Details
			</h2> -->
			<h2 class="font-semibold text-xl text-gray-800 leading-tight">
				Order Detail
			</h2>
			<p class="text-sm text-gray-500 mt-1">
				Check your order #{{order.id}} detail.
			</p>
		</template>

		<!-- <div class="w-full max-w-4xl mx-auto divide-y-2 mt-12 mb-16 p-4"> -->
		<div class="w-full max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pt-10 mb-16">
			<div class="w-2/3">
				<div class="flex items-baseline space-x-3">
					<h1 class="text-2xl font-semibold mb-5">
						Order #{{ order.id }}
					</h1>
					<span
						class="px-1.5 rounded text-sm"
						:class="order.status === 0 ? 'bg-yellow-500 text-yellow-50' : 'bg-green-500 text-green-50'"
					>
						{{ order.status === 0 ? 'Shipping' : 'Delivered on ' + formatDate(order.updated_at) }}
					</span>
				</div>
				<div
					v-for="book in order.books"
					:key="book.id"
					class="w-full"
				>
					<div class="flex flex-col lg:flex-row space-y-5 lg:space-y-0 my-8">
						<img
							:src="book.cover_url"
							alt="book cover"
							class="mr-5 w-24 h-32 lg:w-28 lg:h-36"
						>
						<div class="flex flex-col">
							<div class="flex-1">
								<h1 class="mb-1 font-bold text-lg">
									{{ book.title }}
								</h1>
								<p class="max-w-xl text-gray-700 tracking-wide">
									{{ book.excerpt }}
								</p>
							</div>
							<div class="flex items-center mt-5">
								{{ formatPrice(book.price) }}
								<svg
									xmlns="http://www.w3.org/2000/svg"
									class="h-3 w-3 text-gray-400"
									viewBox="0 0 20 20"
									fill="currentColor"
								>
									<path
										fill-rule="evenodd"
										d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
										clip-rule="evenodd"
									/>
								</svg>
								{{ book.pivot.quantity }}
							</div>
						</div>
					</div>
				</div>
				<div class="w-full">
					<div class="flex space-x-3 w-full lg:w-2/3 ml-auto my-8">
						<div class="flex-1">
							<div class="font-semibold mb-2">
								Shipping address
							</div>
							<div class="text-gray-700">
								<div>{{ order.address.building }}</div>
								<div>{{ order.address.street }}</div>
								<div>{{ order.address.township }}, {{ order.address.city }}</div>
							</div>
						</div>
						<div class="flex-1">
							<div class="font-semibold mb-2">
								Billing address
							</div>

							<div class="text-gray-700">
								<div>{{ order.address.building }}</div>
								<div>{{ order.address.street }}</div>
								<div>{{ order.address.township }}, {{ order.address.city }}</div>
							</div>
						</div>
					</div>
				</div>
				<div class="w-full lg:w-2/3 ml-auto">
					<div class="flex flex-col my-8 space-y-4">
						<div class="flex justify-between">
							<div class="text-gray-700">
								Subtotal
							</div>
							<div class="font-semibold">
								{{ formatPrice(order.total) }}
							</div>
						</div>
						<div class="flex justify-between">
							<div class="text-gray-700">
								Delivery Fee
							</div>
							<div class="font-semibold">
								Free
							</div>
						</div>
						<div class="flex justify-between">
							<div class="text-gray-700">
								Total
							</div>
							<div class="font-semibold">
								{{ formatPrice(order.total) }}
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</SettingSideBarLayout>
</template>

<script>
import SettingSideBarLayout from '@/Layouts/SettingSideBar'
import format from '@/mixins/format'

export default {
    components: {
        SettingSideBarLayout
    },

    mixins: [ format ],

    props: ['order'],
}
</script>

<style lang="scss" scoped>
</style>
