<template>
	<SettingSideBarLayout>
		<template #header>
			<h2 class="font-semibold text-xl text-gray-800 leading-tight">
				Address Book
			</h2>
			<p class="text-sm text-gray-500 mt-1">
				Add, delete or manage saved addresses to facilitate buying process.
			</p>
		</template>

		<div class="w-full max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
			<h1 class="mb-5 text-xl">
				Edit Address
			</h1>
			<div class="grid grid-cols-6 gap-5">
				<div class="lg:col-span-6">
					<div class="relative">
						<label
							for="label"
							class="leading-7 text-sm text-gray-600"
						>Address Label</label>
						<BreezeInput
							id="label"
							v-model="editingAddress.label"
							name="label"
							type="text"
							class="mt-1 block w-full"
							required
							autocomplete="label"
						/>
						<BreezeInputError
							:message="errors.label ? errors.label[0] : ''"
						/>
					</div>
				</div>
				<div class="col-span-6 lg:col-span-3">
					<div class="relative">
						<label
							for="building"
							class="leading-7 text-sm text-gray-600"
						>Building No</label>
						<BreezeInput
							id="building"
							v-model="editingAddress.building"
							name="building"
							type="text"
							class="mt-1 block w-full"
							required
							autocomplete="building"
						/>
						<BreezeInputError
							:message="errors.building ? errors.building[0] : ''"
						/>
					</div>
				</div>
				<div class="col-span-6 lg:col-span-3">
					<div class="relative">
						<label
							for="street"
							class="leading-7 text-sm text-gray-600"
						>Street</label>
						<BreezeInput
							id="street"
							v-model="editingAddress.street"
							name="street"
							type="text"
							class="mt-1 block w-full"
							required
							autocomplete="street"
						/>
						<BreezeInputError
							:message="errors.street ? errors.street[0] : ''"
						/>
					</div>
				</div>
				<div class="col-span-6 md:col-span-3 lg:col-span-2">
					<div class="relative">
						<label
							for="state"
							class="leading-7 text-sm text-gray-600"
						>State / Province</label>
						<BreezeInput
							id="state"
							v-model="editingAddress.state"
							name="state"
							type="text"
							class="mt-1 block w-full"
							required
							autocomplete="state"
						/>
						<BreezeInputError
							:message="errors.state ? errors.state[0] : ''"
						/>
					</div>
				</div>
				<div class="col-span-6 md:col-span-3 lg:col-span-2">
					<div class="relative">
						<label
							for="township"
							class="leading-7 text-sm text-gray-600"
						>Township</label>
						<BreezeInput
							id="township"
							v-model="editingAddress.township"
							name="township"
							type="text"
							class="mt-1 block w-full"
							required
							autocomplete="township"
						/>
						<BreezeInputError
							:message="errors.township ? errors.township[0] : ''"
						/>
					</div>
				</div>
				<div class="col-span-6 md:col-span-3 lg:col-span-2">
					<div class="relative">
						<label
							for="city"
							class="leading-7 text-sm text-gray-600"
						>City</label>
						<BreezeInput
							id="city"
							v-model="editingAddress.city"
							name="city"
							type="text"
							class="mt-1 block w-full"
							required
							autocomplete="city"
						/>
						<BreezeInputError
							:message="errors.city ? errors.city[0] : ''"
						/>
					</div>
				</div>
			</div>
			<div class="flex justify-between mt-3">
				<div
					v-if="!isDefault"
					@click="toggleDefault()"
					@keydown.space.prevent="toggleDefault()"
					class="flex items-center space-x-2"
				>
					<span
						class="toggle"
						role="checkbox"
						tabindex="0"
						:aria-checked="editingAddress.default"
					/>
					<label
						class="text-sm text-gray-500"
					>
						Save as default
					</label>
				</div>
    
				<Button
					@click="updateAddress()"
					class="ml-auto max-w-max"
				>
					Save
				</Button>
			</div>
		</div>
	</SettingSideBarLayout>
</template>

<script>
import SettingSideBarLayout from '@/Layouts/SettingSideBar'
import BreezeInputError from '@/Components/InputError'
import BreezeInput from '@/Components/Input'
import Button from '@/Components/Button'

export default {
    components: {
        Button,
        BreezeInputError,
        BreezeInput,
        SettingSideBarLayout,
    },

    props: ['initialAddress'],

    data() {
        return {
            editingAddress: this.initialAddress,
            isDefault: this.initialAddress.default,
            errors: [],
        }
    },

    // computed: {
    //     saveAsDefault() {
    //         return this.editingAddress.default ? 'true' : 'false'
    //     }
    // },

    methods: {
        updateAddress() {
            axios
                .patch(route('addresses.update', this.editingAddress.id), this.editingAddress)
                .then(() => {
                    this.$inertia.get(route('addresses.index'), {}, {
                        onSuccess: () => {
                            window.flash('Successfully saved address.')
                        }
                    })
                })
                .catch(err => this.errors = err.response.data.errors)
        },

        toggleDefault() {
            this.editingAddress.default = !this.editingAddress.default
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
