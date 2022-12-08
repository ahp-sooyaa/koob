<template>
	<Head>
		<title>Admin books list</title>
		<meta
			head-key="description"
			name="description"
			content="This is the book list page of admin"
		>
	</Head>

	<AdminHeader>
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			Books List
		</h2>
	</AdminHeader>

	<div class="my-12 mx-5">
		<div class="shadow overflow-x-auto border-b border-gray-200 sm:rounded-lg mb-5">
			<table class="min-w-full divide-y divide-gray-200">
				<thead class="bg-gray-50">
					<tr>
						<th
							scope="col"
							class="whitespace-nowrap px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
						>
							Cover
						</th>
						<th
							scope="col"
							class="whitespace-nowrap px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
						>
							Title
						</th>
						<th
							scope="col"
							class="whitespace-nowrap px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
						>
							Excerpt
						</th>
						<th
							scope="col"
							class="whitespace-nowrap px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
						>
							Author
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
							Stock Count
						</th>
						<th
							scope="col"
							class="relative px-6 py-3"
						>
							<span class="sr-only">Action</span>
						</th>
					</tr>
				</thead>
				<tbody class="bg-white divide-y divide-gray-200">
					<tr
						v-for="book in books.data"
						:key="book.id"
					>
						<td class="px-6 py-4 whitespace-nowrap">
							<div class="flex items-center">
								<div class="flex-shrink-0 h-20 w-18">
									<img
										class="h-20 w-69 rounded-md object-cover"
										alt="book cover"
										:src="book.cover_url"
										loading="lazy"
									>
								</div>
							</div>
						</td>
						<td class="px-6 py-4 whitespace-nowrap">
							<div class="text-sm text-gray-900">
								{{ book.title }}
							</div>
						</td>
						<td class="px-6 py-4 text-sm text-gray-500">
							<div class="line-clamp-2">
								{{ book.excerpt }}
							</div>
						</td>
						<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
							{{ book.author }}
						</td>
						<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">
							{{ formatPrice(book.price) }}
						</td>
						<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">
							{{ book.stock_count }}
						</td>
						<td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
							<Link
								:href="route('admin.books.edit', book.id)"
								class="text-indigo-600 hover:text-indigo-900"
							>
								Edit
							</Link>
							<!--							<Link-->
							<!--								:href="route('admin.books.destroy', book.id)"-->
							<!--								class="text-indigo-600 hover:text-indigo-900"-->
							<!--								method="delete"-->
							<!--								as="button"-->
							<!--							>-->
							<!--								Delete-->
							<!--							</Link>-->
							<button @click="confirmDelete(book.id)">
								Delete
							</button>
						</td>
					</tr>
				</tbody>
			</table>
		</div>

		<paginator :links="books.links" />
	</div>
</template>

<script>
import format from '@/mixins/format'
import AdminLayout from '@/Layouts/Admin'
import AdminHeader from '@/Components/AdminHeader'
import Paginator from '@/Components/Paginator.vue'

export default {
    components: { Paginator, AdminHeader },

    mixins: [ format ],

    layout: AdminLayout,

    props: ['books'],

    methods: {
        confirmDelete(id) {
            if (confirm('Are you sure to delete this book?')) {
                this.$inertia.delete(route('admin.books.destroy', id))
            }
        },
    }
}
</script>

<style lang="scss" scoped>

</style>
