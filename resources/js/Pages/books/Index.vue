<template>
	<div>
		<Head>
			<title>Shop</title>
			<meta
				head-key="description"
				name="description"
				content="This is the shop page"
			>
		</Head>

		<BreezeNavBarLayout>
			<template #header>
				<h2 class="font-semibold text-xl text-gray-800 leading-tight">
					Shop
				</h2>
			</template>
			<section class="max-w-7xl mx-auto px-4 lg:px-10 mb-14 lg:my-16 pt-7">
				<div
					class="flex flex-col lg:flex-row space-y-5 space-x-0 lg:space-y-0 lg:space-x-10"
				>
					<div class="w-full lg:w-1/5">
						<div class="flex justify-between items-baseline mb-4">
							<h1>
								Filters
							</h1>
							<span
								v-show="filters.search || categoryFilter"
								@click="clearFilter"
								class="hover:underline text-gray-500 text-sm cursor-pointer"
							>clear</span>
						</div>

						<h1>Categories</h1>
						<div class="-ml-1 flex flex-nowrap lg:flex-wrap items-baseline overflow-x-auto pb-3 pt-1 lg:space-y-2">
							<div
								@click="categoryFilter = null"
								class="capitalize cursor-pointer bg-white border inline-block px-4 py-1 rounded-2xl shadow text-sm mx-1"
								:class="!categoryFilter ? 'border-blue-400 text-blue-500': 'text-gray-600'"
							>
								all
							</div>
							<div
								v-for="category in categories"
								:key="category.slug"
								@click="categoryFilter = category.slug"
								class="capitalize cursor-pointer bg-white border inline-block px-4 py-1 rounded-2xl shadow text-sm mx-1"
								:class="categoryFilter === category.slug ? 'border-blue-400 text-blue-500': 'text-gray-600'"
							>
								{{ category.name }}
							</div>
						</div>
					</div>
					<div class="w-full lg:w-4/5">
						<div class="flex items-center justify-between lg:flex-row lg:items-center space-x-3">
							<search-box :search-query="filters.search" />
							<sorting :sorting="sorting" />
						</div>
						<div
							v-show="books.total"
							class="text-sm text-gray-600 mt-7"
						>
							Showing {{ books.from }}-{{ books.to }} of {{ books.total }}
						</div>
						<div v-if="Object.keys(books.data).length">
							<div
								class="grid grid-cols-1 gap-y-5 md:grid-cols-3 lg:grid-cols-4 md:gap-10 my-5"
							>
								<div
									v-for="book in books.data"
									:key="book.id"
									class="flex flex-col h-full pb-5 rounded-xl"
								>
									<Book :data="book" />
								</div>
							</div>

							<!-- paginator -->
							<paginator
								v-show="books.total > books.per_page"
								:links="books.links"
							/>
						</div>

						<div
							v-else
							class="grid mt-32 place-content-center text-center"
						>
							<lottie-player
								src="https://assets6.lottiefiles.com/packages/lf20_0s6tfbuc.json"
								background="transparent"
								speed="1"
								style="width: 200px; height: 200px"
								loop
								autoplay
								class="mx-auto"
							/>
							<p>
								No results found for
								<span class="font-bold">{{ categoryFilter }}</span>
								<span v-show="filters.search || categoryFilter"> books </span>
								<span v-show="filters.search">matching </span>
								<span class="font-bold">{{ filters.search }} </span>
								.
							</p>
							<p>Try different keywords or check spelling.</p>
						</div>
					</div>
				</div>
			</section>
		</BreezeNavBarLayout>
	</div>
</template>

<script>
import BreezeNavBarLayout from '@/Layouts/NavBar'
import Book from '@/Pages/Books/Book'
import SearchBox from '@/Components/SearchBox'
import Paginator from '@/Components/Paginator'
import Sorting from '@/Components/Sort'

export default {
    components: {
        BreezeNavBarLayout,
        Book,
        SearchBox,
        Paginator,
        Sorting,
    },

    props: {
        books: {
            type: Object,
            required: true,
        },
        categories: {
            type: Object,
            required: true
        },
        sorting: {
            type: String,
            default: null
        },
        filters: {
            type: Object,
            default: null
        },
    },

    data() {
        return {
            categoryFilter: this.filters.category,
        }
    },

    watch: {
        categoryFilter(value) {
            this.$inertia
                .get(this.$page.url, { category: value, page: 1 }, {
                    preserveState: true,
                })
        },
    },

    methods: {
        clearFilter() {
            this.categoryFilter = null

            this.$inertia
                .get(this.$page.url, {search: null, category: null}, {
                    preserveState: true,
                    onFinish: () => {
                        window.events.emit('clearedFilters')
                    },
                })
        }
    },
}
</script>
