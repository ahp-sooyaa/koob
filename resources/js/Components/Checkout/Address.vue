<template>
	<h1 class="font-semibold tracking-wide">
		{{ addressItem.label }}
	</h1>
	<p class="text-sm text-gray-600">
		{{ addressItem.building }}, {{ addressItem.street }}, {{ addressItem.township }}, {{ addressItem.city }}, {{ addressItem.state }}
	</p>
	<div class="flex justify-between mt-4">
		<button
			@click="deliveryAddressStore.selectedAddress = addressItem"
			class="active:bg-gray-900 bg-gray-800 border border-transparent duration-150 ease-in-out focus:border-gray-900 focus:outline-none focus:shadow-outline-gray font-semibold hover:bg-gray-700 inline-flex items-center justify-center px-4 py-2 rounded-md text-white text-xs tracking-widest transition"
		>
			use this address
		</button>
		<button
			@click="deliveryAddressStore.editAddress(index)"
			class="active:border-gray-900 border border-gray-800 duration-150 ease-in-out focus:border-gray-900 focus:outline-none focus:shadow-outline-gray font-semibold hover:border-gray-500 inline-flex items-center justify-center px-4 py-2 rounded-md text-gray-800 text-xs tracking-widest transition"
		>
			edit
		</button>
	</div>
</template>

<script>
import { deliveryAddressStore } from '@/Stores/DeliveryAddressStore'

export default {
    props: ['addressItem', 'index'],

    data() {
        return {
            deliveryAddressStore,
        }
    }
}
</script>
