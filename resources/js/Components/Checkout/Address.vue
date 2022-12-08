<template>
	<div class="flex justify-between items-center mb-2">
		<h1 class="font-semibold tracking-wide">
			{{ addressItem.label }}
		</h1>
		
		<svg v-if="isSelected" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
			<path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" />
		</svg>
		<svg v-else xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
			<path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
		</svg>
	</div>
	<p class="text-sm text-gray-600">
		{{ addressItem.building }}, {{ addressItem.street }}, {{ addressItem.township }}, {{ addressItem.city }}, {{ addressItem.state }}
	</p>
	<div class="flex justify-end mt-auto">
		<!-- <button
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
		</button> -->
		<svg v-if="paymentProcessing" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-8">
			<path d="M3 10a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zM8.5 10a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zM15.5 8.5a1.5 1.5 0 100 3 1.5 1.5 0 000-3z" />
		</svg>
		<Dropdown v-else align="right">
			<template #trigger>
				<button class="hover:bg-gray-200 hover:shadow rounded-lg focus:bg-gray-200">
  					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-8">
						<path d="M3 10a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zM8.5 10a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zM15.5 8.5a1.5 1.5 0 100 3 1.5 1.5 0 000-3z" />
					</svg>
				</button>
			</template>
			<template #content>
				<DropdownLink @click="deliveryAddressStore.editAddress(index)" as="button" class="flex gap-1.5 items-center">
					<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
						<path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
					</svg>

					Edit
				</DropdownLink>
				<DropdownLink class="flex gap-1.5 items-center text-red-400">
					<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
						<path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
					</svg>

					Delete
				</DropdownLink>
			</template>
		</Dropdown>
	</div>
</template>

<script>
import { deliveryAddressStore } from '@/Stores/DeliveryAddressStore'
import Dropdown from '@/Components/Dropdown';
import DropdownLink from '@/Components/DropdownLink';

export default {
	components: { 
		Dropdown,
		DropdownLink,
	},

    props: ["addressItem", "index", 'paymentProcessing'],

    data() {
        return {
            deliveryAddressStore,
        };
    },
    
	computed: {
		isSelected() {
			return this.deliveryAddressStore.selectedAddress.id === this.addressItem.id
		}
	}
}
</script>
