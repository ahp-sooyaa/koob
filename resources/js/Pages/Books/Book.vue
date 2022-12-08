<template>
	<!-- <div class="bg-gray-200 mb-5 p-5 rounded-2xl"> -->
		<img
			:src="data.cover_url"
			:alt="data.title + '\'s cover image'"
			class="object-cover w-44 mx-auto mb-5 shadow-xl h-56"
		>
	<!-- </div> -->
	<div class="flex flex-1 flex-col px-1">
		<Link
			:href="'books/' + data.slug"
			class="font-semibold line-clamp-2 text-lg lg:text-sm hover:underline"
		>
			{{ data.title }}
		</Link>
		<div class="mt-2 mb-auto text-gray-500 mr-3 text-lg lg:text-sm">
			{{ formatPrice(data.price) }}
		</div>
		<div
			v-if="data.stock_count"
			class="flex justify-between mt-3 space-x-3"
		>
			<div
				@click="buyNow"
				class="bg-gray-700 border cursor-pointer flex flex-1 hover:shadow-none items-center justify-center px-5 rounded-xl shadow-md text-sm text-white"
			>
				Buy Now
			</div>
			<div
				@click="addToCart"
				class="bg-gray-200 border cursor-pointer flex h-14 hover:shadow-none items-center lg:h-11 lg:w-12 relative rounded-xl shadow w-14"
				dusk="addToCart"
			>
				<svg
					xmlns="http://www.w3.org/2000/svg"
					class="h-8 w-12"
					fill="none"
					viewBox="0 0 24 24"
					stroke="currentColor"
				>
					<path
						stroke-linecap="round"
						stroke-linejoin="round"
						stroke-width="1"
						d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"
					/>
				</svg>
				<svg
					v-if="!isAdded"
					xmlns="http://www.w3.org/2000/svg"
					class="absolute bg-white right-1.5 top-1.5 rounded-full shadow text-gray-600 h-5 w-5 lg:h-4 lg:w-4"
					fill="none"
					viewBox="0 0 24 24"
					stroke="currentColor"
				>
					<path
						stroke-linecap="round"
						stroke-linejoin="round"
						stroke-width="2"
						d="M12 6v6m0 0v6m0-6h6m-6 0H6"
					/>
				</svg>
				<svg
					v-else
					xmlns="http://www.w3.org/2000/svg"
					class="absolute bg-white right-1.5 top-1.5 rounded-full shadow text-gray-600 h-5 w-5 lg:h-4 lg:w-4"
					viewBox="0 0 20 20"
					fill="currentColor"
					stroke="none"
				>
					<path
						fill-rule="evenodd"
						d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
						clip-rule="evenodd"
					/>
				</svg>
			</div>
		</div>
		<div
			v-else
			class="bg-gray-200 py-3 rounded-xl text-center text-gray-400 text-sm"
		>
			Out of stock
		</div>
	</div>
</template>

<script>
import format from '@/mixins/format'

export default {
    mixins: [ format ],

    props: {
        data: {
            type: Object,
            required: true
        }
    },

    data() {
        return {
            isAdded: this.$page.props.cart.some( item => {
                return item['id'] === this.data.id
            })
        }
    },

    methods: {
        addToCart() {
            axios
                .post(route('cart.store', this.data.id))
                .then((res) => {
                    this.isAdded = true
                    window.events.emit('cartQtyUpdated')
                    window.flash(res.data.message)
                })
                .catch(err => window.flash(err.response.data.message, 'error'))
        },

        buyNow() {
            this.$inertia.post(route('buyNow.store', this.data.id))
        }
    }
}
</script>
