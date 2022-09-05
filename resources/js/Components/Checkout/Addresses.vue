<template>
	<div class="flex justify-between mt-5">
		<h1 class="text-xl font-semibold">
			Delivery Address
		</h1>
		<Button
			@click="deliveryAddressStore.isNewAddress = true"
		>
			add new address
		</Button>
	</div>

	<div
		v-if="!deliveryAddressStore.addresses.length || deliveryAddressStore.isNewAddress || deliveryAddressStore.isEditAddress"
	>
		<button @click="deliveryAddressStore.isNewAddress = false, deliveryAddressStore.isEditAddress = false">
			Back
		</button>

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
			class="cursor-pointer hover:shadow inline-block p-3 rounded-md"
			:class="deliveryAddressStore.selectedAddress.id === addressItem.id ? 'border border-gray-500 bg-white' : 'bg-gray-200'"
		>
			<Address
				:address-item="addressItem"
				:index="index"
			/>
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
        }
    }
}
</script>
