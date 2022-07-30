<template>
	<Head>
		<title>Admin Order Detail</title>
		<meta
			head-key="description"
			name="description"
			content="This is the order detail page of admin"
		>
	</Head>

	<AdminHeader>
		<h2 class="flex items-center space-x-2 font-semibold text-xl text-gray-800 leading-tight">
			<!-- Edit Order #{{ order.id }} -->
			<Link
				:href="route('admin.orders.index')"
				class="text-gray-500 hover:text-gray-900"
			>
				Orders List
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
			Order #{{ order.id }}
		</h2>
	</AdminHeader>

	<div class="px-5 my-12">
		<span class="text-gray-500">Order Date: </span>
		<span class="text-gray-700">{{ formatDate(order.created_at) }}</span>

		<div class="flex gap-12 mt-5">
			<div class="w-3/4 shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
				<table class="min-w-full divide-y divide-gray-200">
					<thead class="bg-gray-50">
						<tr>
							<th
								scope="col"
								class="whitespace-nowrap px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
							>
								Item
							</th>
							<th
								scope="col"
								class="whitespace-nowrap px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
							>
								Qty
							</th>
							<th
								scope="col"
								class="whitespace-nowrap px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider"
							>
								Price
							</th>
							<th
								scope="col"
								class="whitespace-nowrap px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider"
							>
								SubTotal Amount
							</th>
						</tr>
					</thead>
					<tbody
						class="bg-white divide-y divide-gray-200"
					>
						<tr
							v-for="book in order.books"
							:key="book.id"
						>
							<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
								<div class="flex items-center gap-5">
									<img
										:src="book.cover_url"
										alt="book cover"
										class="h-20 w-69 rounded-md"
									>
									{{ book.title }}
								</div>
							</td>
							<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
								{{ book.pivot.quantity }}
							</td>
							<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">
								{{ formatPrice(book.price) }}
							</td>
							<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">
								{{ subTotal(book.price, book.pivot.quantity) }}
							</td>
						</tr>
					</tbody>
				</table>
			</div>

			<div class="w-1/4">
				<h1 class="text-lg font-semibold capitalize">
					order summary
				</h1>
				<div class="flex flex-col my-8 space-y-3">
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
</template>

<script>
import AdminLayout from '@/Layouts/Admin'
import AdminHeader from '@/Components/AdminHeader'
import format from '@/mixins/format'

export default {
    components: {
        AdminHeader,
    },

    mixins: [ format ],

    layout: AdminLayout,

    props: ['order', 'success'],

    methods: {
        subTotal(price, qty) {
            return this.formatPrice(price * qty)
        }
    }
}
</script>

<style lang="scss" scoped>
</style>
