<template>
	<div class="flex lg:flex-row justify-between min-w-max lg:w-auto items-baseline space-x-0 lg:space-x-3">
		<dropdown align="right">
			<template #trigger>
				<span class="inline-flex rounded-md">
					<button
						type="button"
						class="inline-flex items-center px-3 py-2 border border-transparent text-sm
                        leading-4 font-medium rounded-md text-gray-500 bg-white
                        hover:text-gray-700 focus:outline-none transition ease-in-out
                        duration-150"
					>
						Sort by {{ sortedLabel }}
						<svg
							class="ml-2 -mr-0.5 h-4 w-4"
							xmlns="http://www.w3.org/2000/svg"
							viewBox="0 0 20 20"
							fill="currentColor"
						>
							<path
								fill-rule="evenodd"
								d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
								clip-rule="evenodd"
							/>
						</svg>
					</button>
				</span>
			</template>

			<template #content>
				<div
					@click="sort = 'price,asc'"
					class="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out cursor-pointer"
					:class="sort === 'price,asc' ? 'text-blue-500': ''"
				>
					Price (Low to High)
				</div>
				<div
					@click="sort = 'price,desc'"
					class="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out cursor-pointer"
					:class="sort === 'price,desc' ? 'text-blue-500': ''"
				>
					Price (High to Low)
				</div>
				<div
					@click="sort = 'created_at,asc'"
					class="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out cursor-pointer"
					:class="sort === 'created_at,asc' ? 'text-blue-500': ''"
				>
					Newest Books
				</div>
				<div
					@click="sort = 'created_at,desc'"
					class="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out cursor-pointer"
					:class="sort === 'created_at,desc' ? 'text-blue-500': ''"
				>
					Oldest Books
				</div>
			</template>
		</dropdown>
	</div>
</template>

<script>
import Dropdown from './Dropdown.vue'
export default {
    components: { Dropdown },

    props: ['sorting'],

    data() {
        return {
            sort: this.sorting,
        }
    },

    computed: {
        sortedLabel() {
            return {
                'price,asc': 'Price (Low to High)',
                'price,desc': 'Price (High to Low)',
                'created_at,asc': 'Newest Books',
                'created_at,desc': 'Oldest Books',
            }[this.sort.toString()]
        },
    },

    watch: {
        sort(value) {
            this.$inertia
                .get(this.$page.url, { sort: value }, {
                    preserveState: true,
                })
        },
    }
}
</script>

<style lang="scss" scoped>

</style>
