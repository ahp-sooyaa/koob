<template>
	<div class="lg:flex flex-wrap -mx-2">
		<div class="p-2 lg:w-full">
			<div class="relative">
				<label
					for="label"
					class="leading-7 text-sm text-gray-600"
				>Address Label</label>
				<BreezeInput
					id="label"
					v-model="address.label"
					name="label"
					type="text"
					class="mt-1 block w-full"
					required
					autocomplete="label"
					:disabled="paymentProcessing"
				/>
				<BreezeInputError
					:message="errors.label ? errors.label[0] : ''"
				/>
			</div>
		</div>
		<div class="p-2 lg:w-1/2">
			<div class="relative">
				<label
					for="building"
					class="leading-7 text-sm text-gray-600"
				>Building No</label>
				<BreezeInput
					id="building"
					v-model="address.building"
					name="building"
					type="text"
					class="mt-1 block w-full"
					required
					autocomplete="building"
					:disabled="paymentProcessing"
				/>
				<BreezeInputError
					:message="errors.building ? errors.building[0] : ''"
				/>
			</div>
		</div>
		<div class="p-2 lg:w-1/2">
			<div class="relative">
				<label
					for="street"
					class="leading-7 text-sm text-gray-600"
				>Street</label>
				<BreezeInput
					id="street"
					v-model="address.street"
					name="street"
					type="text"
					class="mt-1 block w-full"
					required
					autocomplete="street"
					:disabled="paymentProcessing"
				/>
				<BreezeInputError
					:message="errors.street ? errors.street[0] : ''"
				/>
			</div>
		</div>
		<div class="p-2 sm:w-1/2 lg:w-1/3">
			<div class="relative">
				<label
					for="state"
					class="leading-7 text-sm text-gray-600"
				>State / Province</label>
				<BreezeInput
					id="state"
					v-model="address.state"
					name="state"
					type="text"
					class="mt-1 block w-full"
					required
					autocomplete="state"
					:disabled="paymentProcessing"
				/>
				<BreezeInputError
					:message="errors.state ? errors.state[0] : ''"
				/>
			</div>
		</div>
		<div class="p-2 sm:w-1/2 lg:w-1/3">
			<div class="relative">
				<label
					for="township"
					class="leading-7 text-sm text-gray-600"
				>Township</label>
				<BreezeInput
					id="township"
					v-model="address.township"
					name="township"
					type="text"
					class="mt-1 block w-full"
					required
					autocomplete="township"
					:disabled="paymentProcessing"
				/>
				<BreezeInputError
					:message="errors.township ? errors.township[0] : ''"
				/>
			</div>
		</div>
		<div class="p-2 lg:w-1/3">
			<div class="relative">
				<label
					for="city"
					class="leading-7 text-sm text-gray-600"
				>City</label>
				<BreezeInput
					id="city"
					v-model="address.city"
					name="city"
					type="text"
					class="mt-1 block w-full"
					required
					autocomplete="city"
					:disabled="paymentProcessing"
				/>
				<BreezeInputError
					:message="errors.city ? errors.city[0] : ''"
				/>
			</div>
		</div>
	</div>
	<div
		v-show="deliveryAddressStore.addresses.length"
		@click="toggleDefault()"
		@keydown.space.prevent="toggleDefault()"
		class="flex items-center space-x-2"
	>
		<label
			class="text-sm text-gray-500"
		>Save as default</label>
		<span
			class="toggle"
			role="checkbox"
			tabindex="0"
			:aria-checked="saveAsDefault"
		/>
	</div>

	<Button
		@click="saveAddress()"
		class="mt-5 max-w-max"
	>
		Save & continue
	</Button>
</template>

<script>
import BreezeInputError from '@/Components/InputError'
import BreezeInput from '@/Components/Input'
import { deliveryAddressStore } from '@/Stores/DeliveryAddressStore'
import Button from '@/Components/Button'

export default {
    components: {
        Button,
        BreezeInputError,
        BreezeInput,
    },

    data() {
        return {
            deliveryAddressStore,
            address: {
                label: '',
                building: '',
                street: '',
                state: '',
                township: '',
                city: '',
                default: false,
            },
            errors: [],
            paymentProcessing: false,
        }
    },

    computed: {
        saveAsDefault() {
            return this.address.default.toString()
        }
    },

    created() {
        this.address.default = ! this.deliveryAddressStore.addresses.length
    },

    methods: {
        saveAddress() {
            axios
                .post(route('addresses.store'), this.address)
                .then(res => {
                    this.deliveryAddressStore.addresses.push(res.data.address)
                    this.deliveryAddressStore.selectedAddress = res.data.address
                    this.deliveryAddressStore.isNewAddress = false
                    this.deliveryAddressStore.isEditAddress = false
                })
                .catch(err => this.errors = err.response.data.errors)
        },

        toggleDefault() {
            this.address.default = !this.address.default
        }
    }
}
</script>
