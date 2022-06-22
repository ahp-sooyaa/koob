<template>
	<Head>
		<title>Admin Orders List</title>
		<meta
			head-key="description"
			name="description"
			content="This is the orders list page of admin"
		>
	</Head>

	<AdminHeader>
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			Orders List
		</h2>
	</AdminHeader>

	<div class="my-12 mx-5">
		<div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
			<table class="min-w-full divide-y divide-gray-200">
				<thead class="bg-gray-50">
					<tr>
						<th
							scope="col"
							class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
						>
							ID
						</th>
						<th
							scope="col"
							class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
						>
							Customer Name
						</th>
						<th
							scope="col"
							class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
						>
							Customer Email
						</th>
						<th
							scope="col"
							class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider"
						>
							Total Amount
						</th>
						<th
							scope="col"
							class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
						>
							Status
						</th>
						<th
							scope="col"
							class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
						>
							Placed Order At
						</th>
						<th
							scope="col"
							class="relative px-6 py-3"
						>
							<span class="sr-only">Action</span>
						</th>
					</tr>
				</thead>
				<tbody
					v-if="orders.length"
					class="bg-white divide-y divide-gray-200"
				>
					<tr
						v-for="order in orders"
						:key="order.id"
					>
						<td class="px-6 py-4 whitespace-nowrap">
							<div class="text-sm text-gray-900">
								{{ order.id }}
							</div>
						</td>
						<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
							{{ order.user.name }}
						</td>
						<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
							{{ order.user.email }}
						</td>
						<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">
							{{ formatPrice(order.total) }}
						</td>
						<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
							{{ order.status == 0 ? 'shipping' : 'delivered' }}
						</td>
						<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
							{{ formatDate(order.created_at) }}
						</td>
						<td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
							<Link
								:href="route('admin.orders.edit', order)"
								class="text-indigo-600 hover:text-indigo-900"
							>
								Edit
							</Link>
							<Link
								:href="route('admin.orders.show', order)"
								class="ml-2 text-indigo-600 hover:text-indigo-900"
							>
								View
							</Link>
						</td>
					</tr>
				</tbody>
				<tbody v-else>
					<tr
						class="px-6 py-4 whitespace-nowrap"
					>
						<td colspan="7">
							No orders to show
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</template>

<script>
import AdminLayout from '@/Layouts/Admin'
import AdminHeader from '@/Components/AdminHeader'
import format from '@/mixins/format'

export default {
    components: { AdminHeader },

    mixins: [ format ],

    layout: AdminLayout,

    props: ['orders'],
}
</script>

<style lang="scss" scoped>

</style>
