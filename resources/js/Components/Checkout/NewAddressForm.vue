<template>
    <div class="-mx-2 grid sm:grid-cols-2">
        <div class="p-2">
            <div class="relative">
                <label for="label" class="text-sm leading-7 text-gray-600"
                    >Address Label</label
                >
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
        <div class="p-2">
            <div class="relative">
                <label for="building" class="text-sm leading-7 text-gray-600"
                    >Building No</label
                >
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
        <div class="p-2">
            <div class="relative">
                <label for="street" class="text-sm leading-7 text-gray-600"
                    >Street</label
                >
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
        <div class="p-2">
            <div class="relative">
                <label for="state" class="text-sm leading-7 text-gray-600"
                    >State / Province</label
                >
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
        <div class="p-2">
            <div class="relative">
                <label for="township" class="text-sm leading-7 text-gray-600"
                    >Township</label
                >
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
        <div class="p-2">
            <div class="relative">
                <label for="city" class="text-sm leading-7 text-gray-600"
                    >City</label
                >
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
    <div class="mt-3 flex justify-between">
        <div
            v-show="deliveryAddressStore.addresses.length"
            class="inline-flex items-center space-x-2"
            @click="toggleDefault()"
            @keydown.space.prevent="toggleDefault()"
        >
            <span
                class="toggle"
                role="checkbox"
                tabindex="0"
                :aria-checked="saveAsDefault"
            />
            <label class="text-sm text-gray-500"> Save as default </label>
        </div>

        <div class="ml-auto flex space-x-2">
            <button
                v-show="deliveryAddressStore.addresses.length > 0"
                class="inline-flex items-center justify-center rounded-md border border-transparent border-gray-500 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-500 transition duration-150 ease-in-out hover:border-gray-900 hover:text-gray-900"
                @click="deliveryAddressStore.isNewAddress = false"
            >
                Back
            </button>
            <Button
                dusk="saveAddressButton"
                class="max-w-max"
                @click="saveAddress()"
            >
                Save
            </Button>
        </div>
    </div>
</template>

<script>
import Button from "@/Components/Button";
import BreezeInput from "@/Components/Input";
import BreezeInputError from "@/Components/InputError";
import { deliveryAddressStore } from "@/Stores/DeliveryAddressStore";

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
                label: "",
                building: "",
                street: "",
                state: "",
                township: "",
                city: "",
                default: false,
            },
            errors: [],
            paymentProcessing: false,
        };
    },

    computed: {
        saveAsDefault() {
            return this.address.default.toString();
        },
    },

    created() {
        this.address.default = !deliveryAddressStore.addresses.length;
    },

    methods: {
        saveAddress() {
            axios
                .post(route("addresses.store"), this.address)
                .then((res) => {
                    if (!deliveryAddressStore.addresses.length) {
                        deliveryAddressStore.selectedAddress = res.data.address;
                    }
                    deliveryAddressStore.addresses.push(res.data.address);
                    deliveryAddressStore.isNewAddress = false;
                    deliveryAddressStore.isEditAddress = false;
                })
                .catch((err) => (this.errors = err.response.data.errors));
        },

        toggleDefault() {
            this.address.default = !this.address.default;
        },
    },
};
</script>
