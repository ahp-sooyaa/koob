<template>
	<!-- <div class="flex justify-between"> -->
		<h1 class="text-xl font-semibold text-gray-800">
			Choose Delivery Address
		</h1>
		<!-- <p class="mb-5 text-gray-500 text-sm">Choose delivery address</p> -->
		<!-- <Button
			@click="deliveryAddressStore.isNewAddress = true"
			:class="deliveryAddressStore.isNewAddress || !deliveryAddressStore.addresses.length ? 'hidden' : 'block'"
		>
			add new address
		</Button> -->
	<!-- </div> -->

	<div
		v-if="!deliveryAddressStore.addresses.length || deliveryAddressStore.isNewAddress || deliveryAddressStore.isEditAddress"
	>
		<!-- <button
			@click="deliveryAddressStore.isNewAddress = false, deliveryAddressStore.isEditAddress = false"
			:class="deliveryAddressStore.isEditAddress || deliveryAddressStore.isNewAddress ? 'block' : 'hidden'"
		>
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
				<path fill-rule="evenodd" d="M7.793 2.232a.75.75 0 01-.025 1.06L3.622 7.25h10.003a5.375 5.375 0 010 10.75H10.75a.75.75 0 010-1.5h2.875a3.875 3.875 0 000-7.75H3.622l4.146 3.957a.75.75 0 01-1.036 1.085l-5.5-5.25a.75.75 0 010-1.085l5.5-5.25a.75.75 0 011.06.025z" clip-rule="evenodd" />
			</svg>
		</button> -->

		<NewAddressForm v-if="deliveryAddressStore.isNewAddress || !deliveryAddressStore.addresses.length" />
		<EditAddressForm v-else />
	</div>

	<div
		v-else
		class="gap-4 grid grid-cols-2 mt-2"
	>
		<div
			v-for="(addressItem, index) in deliveryAddressStore.addresses"
			:key="addressItem.id"
			:class="[{'border border-gray-500': deliveryAddressStore.selectedAddress.id === addressItem.id}, {'cursor-pointer hover:shadow': !paymentProcessing}, baseClasses]"
			@click="selectDeliveryAddress(addressItem)"
		>
			<Address
				:address-item="addressItem"
				:index="index"
				:payment-processing="paymentProcessing"
			/>
		</div>

		<div 
			@click="showNewAddressForm" 
			class="bg-gray-200 border border-gray-400 text-sm rounded-md p-3 text-gray-500 border-dashed flex justify-center items-center h-32 gap-2"
			:class="{'cursor-pointer hover:border-gray-500 hover:text-gray-600': !paymentProcessing}"
		>
			<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
				<path stroke-linecap="round" stroke-linejoin="round" d="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 002.25-2.25V6a2.25 2.25 0 00-2.25-2.25H6A2.25 2.25 0 003.75 6v2.25A2.25 2.25 0 006 10.5zm0 9.75h2.25A2.25 2.25 0 0010.5 18v-2.25a2.25 2.25 0 00-2.25-2.25H6a2.25 2.25 0 00-2.25 2.25V18A2.25 2.25 0 006 20.25zm9.75-9.75H18a2.25 2.25 0 002.25-2.25V6A2.25 2.25 0 0018 3.75h-2.25A2.25 2.25 0 0013.5 6v2.25a2.25 2.25 0 002.25 2.25z" />
			</svg>

			new address
		</div>
	</div>
</template>

<script>
import {deliveryAddressStore} from '@/Stores/DeliveryAddressStore'
import Address from '@/Components/Checkout/Address'
import NewAddressForm from '@/Components/Checkout/NewAddressForm'
import EditAddressForm from '@/Components/Checkout/EditAddressForm'
import Button from '@/Components/Button'

export default {
    components: {
        Button,
        EditAddressForm,
        NewAddressForm,
        Address,
    },

    props: ['paymentProcessing'],

    data() {
        return {
            deliveryAddressStore,
			baseClasses: 'inline-block p-3 rounded-md bg-white flex flex-col',
        }
    },

    created() {
        this.fetchDeliveryAddresses()
    },

    methods: {
        fetchDeliveryAddresses() {
            axios
                .get(route('addresses.index'))
                .then(res => {
                    deliveryAddressStore.addresses = res.data.addresses
                    deliveryAddressStore.selectedAddress = res.data.addresses.find(address => address.default)
                })
        },

		showNewAddressForm() {
			if (this.paymentProcessing) return

			deliveryAddressStore.isNewAddress = true
		},

		selectDeliveryAddress(address) {
			if (this.paymentProcessing) return

			deliveryAddressStore.selectedAddress = address
		}
    },
}
</script>
