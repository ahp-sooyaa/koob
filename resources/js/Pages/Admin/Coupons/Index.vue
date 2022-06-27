<template>
	<Head>
		<title>Admin Coupons list</title>
		<meta
			head-key="description"
			name="description"
			content="This is the coupon list page of admin"
		>
	</Head>

	<AdminHeader>
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			Coupons List
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
							Code
						</th>
						<th
							scope="col"
							class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
						>
							Program Name
						</th>
						<th
							scope="col"
							class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider"
						>
							Amount
						</th>
						<!-- <th
                  scope="col"
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                >
                  Type
                </th>
                <th
                  scope="col"
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                >
                  Value
                </th> -->
						<th
							scope="col"
							class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
						>
							Quantity
						</th>
						<th
							scope="col"
							class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
						>
							Applicable On
						</th>
						<th
							scope="col"
							class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
						>
							Expired at
						</th>
						<th
							scope="col"
							class="relative px-6 py-3"
						>
							<span class="sr-only">Edit</span>
						</th>
					</tr>
				</thead>
				<tbody
					v-if="coupons.length"
					class="bg-white divide-y divide-gray-200"
				>
					<tr
						v-for="coupon in coupons"
						:key="coupon.id"
					>
						<td class="px-6 py-4 whitespace-nowrap">
							<div class="text-sm text-gray-900">
								{{ coupon.code }}
							</div>
						</td>
						<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
							{{ coupon.program_name }}
						</td>
						<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">
							{{ coupon.type == 'Percentage' ? `${coupon.value}%` : formatPrice(coupon.value) }}
						</td>
						<!-- <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  {{ coupon.type }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  {{ coupon.value }}
                </td> -->
						<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
							{{ coupon.quantity ?? 'Unlimited' }}
						</td>
						<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
							Coming soon
						</td>
						<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
							{{ coupon.expired_at }}
						</td>
						<td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
							<Link
								:href="route('admin.coupons.edit', coupon.id)"
								class="text-indigo-600 hover:text-indigo-900"
							>
								Edit
							</Link>
						</td>
					</tr>
				</tbody>
				<tbody v-else>
					<tr>
						<td
							colspan="7"
							class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center"
						>
							No Coupons
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

    mixins: [format],

    layout: AdminLayout,

    props: ['coupons']
}
</script>

<style lang="scss" scoped>

</style>
