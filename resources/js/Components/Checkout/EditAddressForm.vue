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
		v-if="!isDefaultAddress"
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
		@click="updateAddress()"
		class="mt-5 max-w-max"
	>
		Update & continue
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
            address: deliveryAddressStore.addresses[deliveryAddressStore.editingAddressIndex],
            isDefaultAddress: deliveryAddressStore.addresses[deliveryAddressStore.editingAddressIndex].default,
            errors: [],
            paymentProcessing: false,
        }
    },

    computed: {
        saveAsDefault() {
            return this.address.default ? 'true' : 'false'
        }
    },

    methods: {
        updateAddress() {
            axios
                .patch(route('addresses.update', this.address.id), this.address)
                .then(() => this.deliveryAddressStore.isEditAddress = false)
                .catch(err => this.errors = err.response.data.errors)
        },

        toggleDefault() {
            this.address.default = !this.address.default
        }
    }
}
</script>

<style>
.toggle {
    position: relative;
    display: inline-block;
    flex-shrink: 0;
    border-radius: 9999px;
    cursor: pointer;
    height: 1.5rem;
    width: 3rem;
}
.toggle:focus {
    outline: 0;
    -webkit-box-shadow: 0 0 0 4px rgba(52, 144, 220, 0.5);
    box-shadow: 0 0 0 4px rgba(52, 144, 220, 0.5);
}
.toggle:before {
    display: inline-block;
    border-radius: 9999px;
    height: 100%;
    width: 100%;
    background-color: #dae1e7;
    content: "";
    -webkit-box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
    box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
    -webkit-transition: background-color 0.2s ease;
    transition: background-color 0.2s ease;
}
.toggle[aria-checked="true"]:before {
    background-color: #3490dc;
}
.toggle:after {
    position: absolute;
    top: 0;
    left: 0;
    border-radius: 9999px;
    height: 1.5rem;
    width: 1.5rem;
    background-color: #fff;
    border-width: 1px;
    border-color: #dae1e7;
    -webkit-box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.1);
    box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.1);
    content: "";
    -webkit-transition: -webkit-transform 0.2s ease;
    transition: -webkit-transform 0.2s ease;
    transition: transform 0.2s ease;
    transform: translateX(0);
}
.toggle[aria-checked="true"]:after {
    transform: translateX(1.5rem);
}
</style>
