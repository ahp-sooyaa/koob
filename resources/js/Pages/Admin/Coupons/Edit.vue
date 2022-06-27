<template>
	<Head>
		<title>Admin Coupons Edit</title>
		<meta
			head-key="description"
			name="description"
			content="This is the coupon edit page of admin"
		>
	</Head>

	<AdminHeader>
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			Edit Coupons
		</h2>
	</AdminHeader>

	<BreezeValidationErrors class="w-1/2 mx-auto bg-red-100 border-2 border-red-200 mt-5 px-10 py-5 rounded-2xl" />

	<form
		@submit.prevent="submit"
		class="w-1/2 mx-auto px-5 pt-10"
	>
		<div>
			<BreezeLabel
				for="code"
				value="code"
			/>
			<div class="flex space-x-3">
				<BreezeInput
					id="code"
					v-model="form.code"
					type="text"
					class="mt-1 block w-full"
					autocomplete="code"
				/>
				<button
					@click="generateCouponCode"
					type="button"
				>
					Generate
				</button>
			</div>
		</div>

		<div class="mt-4">
			<BreezeLabel
				for="program_name"
				value="program name"
			/>
			<BreezeInput
				id="program_name"
				v-model="form.program_name"
				type="text"
				class="mt-1 block w-full"
				autocomplete="program_name"
			/>
		</div>

		<div class="mt-4">
			<div>Choose Coupon Type</div>

			<label
				for="percentage"
				class="mr-1.5"
			>Percentage</label>
			<input
				id="percentage"
				v-model="form.type"
				type="radio"
				value="Percentage"
				class="mr-3"
			>

			<label
				for="fixed"
				class="mr-1.5"
			>Fixed</label>
			<input
				id="fixed"
				v-model="form.type"
				type="radio"
				value="Fixed"
			>
		</div>

		<div class="mt-4">
			<BreezeLabel
				for="value"
				value="value"
			/>
			<BreezeInput
				id="value"
				v-model="form.value"
				type="text"
				class="mt-1 block w-full"
				autocomplete="value"
			/>
		</div>

		<div class="mt-4">
			<BreezeLabel
				for="quantity"
				value="quantity"
			/>
			<BreezeInput
				id="quantity"
				v-model="form.quantity"
				type="number"
				class="mt-1 block w-full"
				autocomplete="quantity"
			/>
		</div>

		<div class="mt-4">
			<BreezeLabel
				for="expired_at"
				value="expired_at"
			/>
			<BreezeInput
				id="expired_at"
				v-model="form.expired_at"
				type="text"
				class="mt-1 block w-full"
				autocomplete="expired_at"
			/>
		</div>

		<div class="flex items-center justify-start mt-4">
			<BreezeButton
				:class="{ 'opacity-25 cursor-default': form.processing || !form.isDirty }"
				:disabled="form.processing || !form.isDirty"
			>
				Update
			</BreezeButton>
		</div>
	</form>
</template>

<script>
import AdminLayout from '@/Layouts/Admin'
import AdminHeader from '@/Components/AdminHeader'
import BreezeButton from '@/Components/Button'
import BreezeInput from '@/Components/Input'
import BreezeLabel from '@/Components/Label'
import BreezeValidationErrors from '@/Components/ValidationErrors'

export default {
    components: {
        AdminHeader,
        BreezeButton,
        BreezeInput,
        BreezeLabel,
        BreezeValidationErrors
    },

    layout: AdminLayout,

    props: ['coupon'],

    data() {
        return {
            form: this.$inertia.form({
                code: this.coupon.code,
                program_name: this.coupon.program_name,
                type: this.coupon.type,
                value: this.coupon.value,
                quantity: this.coupon.quantity,
                expired_at: this.coupon.expired_at,
            })
        }
    },

    methods: {
        submit() {
            this.form.post(route('admin.coupons.update', {coupon: this.coupon.id, _method: 'patch'}))
        },

        generateCouponCode() {
            this.form.code = Math.random().toString(36).substr(2, 9)
        }
    }
}
</script>

<style scoped>

</style>
