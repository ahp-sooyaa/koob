<template>
	<div class="flex items-center text-gray-500">
		<svg
			@click="openModal"
			xmlns="http://www.w3.org/2000/svg"
			class="h-5 w-5 cursor-pointer"
			fill="none"
			viewBox="0 0 24 24"
			stroke="currentColor"
			stroke-width="2"
		>
			<path
				stroke-linecap="round"
				stroke-linejoin="round"
				d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
			/>
		</svg>
	</div>

	<div
		v-show="showModal"
		@click="showModal = false"
		class="fixed inset-0 z-50 bg-black bg-opacity-50 backdrop-filter backdrop-blur-sm"
	/>
	<!--	<div-->
	<!--		v-show="showModal"-->
	<!--		class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8"-->
	<!--	>-->
	<div
		v-show="showModal"
		class="lg:w-full max-w-2xl absolute z-50 left-5 right-5 lg:left-1/2 lg:transform lg:-translate-x-1/2 top-10 bg-white p-5 rounded-2xl shadow"
	>
		<div class="relative flex items-center">
			<img
				v-if="loading"
				src="/images/tail-spin.svg"
				alt="loading svg"
				class="absolute h-5 left-3 w-5"
			>
			<svg
				v-else
				xmlns="http://www.w3.org/2000/svg"
				viewBox="0 0 20 20"
				fill="currentColor"
				class="absolute h-5 left-3 text-gray-400 w-5"
			>
				<path
					fill-rule="evenodd"
					d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
					clip-rule="evenodd"
				/>
			</svg>

			<input
				ref="search"
				v-model="search"
				type="text"
				placeholder="Press '/' anywhere to search"
				class="w-full px-10 border-gray-300 focus:border-gray-500 focus:ring-0 rounded-full"
			>

			<svg
				v-if="search"
				@click="search = ''"
				xmlns="http://www.w3.org/2000/svg"
				class="absolute h-5 right-3 text-gray-400 w-5 cursor-pointer hover:text-gray-700"
				fill="none"
				viewBox="0 0 24 24"
				stroke="currentColor"
				stroke-width="2"
			>
				<path
					stroke-linecap="round"
					stroke-linejoin="round"
					d="M6 18L18 6M6 6l12 12"
				/>
			</svg>
		</div>

		<div
			class="mt-5"
		>
			<h1>Relevant Results</h1>
			<div
				v-cloak
				v-if="result.length"
				class="mt-3 space-y-3"
			>
				<a
					v-for="book in result"
					:key="book.slug"
					:href="'books/' + book.slug"
					class="flex items-center"
				>
					<img
						:src="book.cover_url"
						:alt="book.title + '\'s cover'"
						class="flex-none h-20 w-16 rounded"
					>
					<div class="ml-3">
						<h1 class="line-clamp-1 tracking-wide">
							{{ book.title }}
						</h1>
						<p class="text-gray-500 text-sm">
							{{ book.author }}
						</p>
					</div>
				</a>
			</div>
			<div
				v-else
				class="mt-3 text-sm text-gray-500"
			>
				Sorry, we couldn't find any matching your search query!
			</div>
		</div>
	</div>
<!--	</div>-->
</template>

<script>
import debounce from 'lodash/debounce'
export default {
    data() {
        return {
            timeout: '',
            showModal: false,
            loading: false,
            search: '',
            result: [],
        }
    },

    watch: {
        search: debounce(function(value) {
            // if (value.trim() === '') return

            this.timeout = setTimeout(() => {
                this.loading = true
            }, 500)

            axios.get(route('search'), {
                params: {
                    searchQuery: value
                }
            }).then((response) => {
                this.result = response.data
                this.loading = false
                clearTimeout(this.timeout)
            })
        }, 300)
    },

    created() {
        window.addEventListener('keydown', event => {
            if (event.key === '/') {
                event.preventDefault()

                this.openModal()
            }

            if (event.key === 'Escape') {
                this.showModal = false
            }
        })
    },

    methods: {
        async fetchResults() {
            await axios.get(route('search'))
                .then((response) => {
                    this.result = response.data
                })
        },

        openModal() {
            if(!this.search) {
                this.fetchResults()
            }

            this.showModal = true
            this.$nextTick(() => this.$refs.search.focus())
        }
    }
}
</script>
