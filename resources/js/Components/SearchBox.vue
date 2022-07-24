<template>
	<div class="relative flex items-center w-full lg:max-w-min">
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
			v-model="search"
			type="text"
			placeholder="search"
			class="w-full lg:w-auto px-10 border-gray-300 hover:shadow hover:border-transparent focus:border-transparent focus:shadow focus:ring-0 rounded-full"
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
</template>

<script>
import debounce from 'lodash/debounce'
export default {
    props: ['searchQuery'],

    data() {
        return {
            search: this.searchQuery,
            loading: false,
            timeout: '',
        }
    },

    watch: {
        search: debounce(function (value) {
            this.$inertia
                .get(this.$page.url, { search: value, page: 1 }, {
                    preserveState: true,
                    replace: true,
                    onStart: () => {
                        this.timeout = setTimeout(() => {
                            this.loading = true
                        }, 500)
                    },
                    onFinish: () => {
                        this.loading = false
                        clearTimeout(this.timeout)
                    },
                })
        }, 300),
    },

    created() {
        window.events.on('clearedFilters', () => this.search = '')
    },
}
</script>

<style lang="scss" scoped>
</style>
