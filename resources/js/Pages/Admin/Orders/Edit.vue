<template>
	<Head>
		<title>Admin Order Edit</title>
		<meta
			head-key="description"
			name="description"
			content="This is the order edit page of admin"
		>
	</Head>

	<AdminHeader>
		<h2 class="flex items-center space-x-2 font-semibold text-xl text-gray-800 leading-tight">
			<!-- Edit Order #{{ order.id }} -->
			<Link
				:href="route('admin.orders.index')"
				class="text-gray-500 hover:text-gray-900"
			>
				Orders List
			</Link>
			<svg
				xmlns="http://www.w3.org/2000/svg"
				class="h-6 w-6 text-gray-400"
				viewBox="0 0 20 20"
				fill="currentColor"
			>
				<path
					fill-rule="evenodd"
					d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
					clip-rule="evenodd"
				/>
			</svg>
			Edit Order #{{ order.id }}
		</h2>
	</AdminHeader>

	<div
		v-if="Object.keys($page.props.errors).length > 0"
		class="bg-red-100 border-2 border-red-200 mt-5 mx-5 px-10 py-5 rounded-2xl"
	>
		<BreezeValidationErrors />
	</div>
	<!-- <div
			v-if="$page.props.flash.message"
			class="bg-white border border-black mt-5 mx-auto px-5 py-3 rounded-2xl shadow-md w-1/2"
		>
			{{ $page.props.flash.message }}
		</div> -->

	<form
		@submit.prevent="submit"
		class="px-5 pt-10 w-2/3 mx-auto"
	>
		<progress
			v-if="form.progress"
			:value="form.progress.percentage"
			max="100"
		>
			{{ form.progress.percentage }}%
		</progress>

		<div class="mt-4">
			<BreezeLabel
				for="name"
				value="name"
			/>
			<BreezeInput
				id="name"
				v-model="form.name"
				type="text"
				class="mt-1 block w-full"
				required
				autocomplete="title"
			/>
		</div>

		<div class="mt-4">
			<BreezeLabel
				for="email"
				value="email"
			/>
			<BreezeInput
				id="email"
				v-model="form.email"
				type="email"
				class="mt-1 block w-full"
				required
				autocomplete="username"
			/>
		</div>

		<div class="mt-4">
			<BreezeLabel
				for="total amount"
				value="total amount"
			/>
			<BreezeInput
				id="total amount"
				v-model="form.total"
				type="number"
				class="mt-1 block w-full"
				required
				autocomplete="author"
			/>
		</div>

		<div class="mt-4">
			<BreezeLabel
				for="status"
				value="status"
			/>
			<select
				id="status"
				v-model="form.status"
				name="status"
				class="rounded-2xl mt-1"
			>
				<option value="0">
					Shipping
				</option>
				<option value="1">
					Delivered
				</option>
			</select>
			<!-- <BreezeInput
            id="status"
            v-model="form.status"
            type="number"
            class="mt-1 block w-full"
            required
            autocomplete="price"
          /> -->
		</div>

		<div class="mt-4">
			<BreezeLabel
				for="created_at"
				value="order placed at"
			/>
			<BreezeInput
				id="created_at"
				v-model="form.created_at"
				type="text"
				class="mt-1 block w-full"
				required
				autocomplete="price"
			/>
		</div>

		<div class="flex items-center justify-start mt-4">
			<BreezeButton
				:class="{ 'opacity-25': form.processing }"
				:disabled="form.processing"
			>
				Edit
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
import flatpickr from 'flatpickr'

export default {
    components: {
        AdminHeader,
        BreezeButton,
        BreezeInput,
        BreezeLabel,
        BreezeValidationErrors,
    },

    layout: AdminLayout,

    props: ['order', 'success'],

    data() {
        return {
            form: this.$inertia.form({
                name: this.order.user.name,
                email: this.order.user.email,
                total: this.order.total,
                status: this.order.status,
                created_at: this.order.created_at,
            }),
            flatpickrConfig: {
                enableSeconds: true,
                enableTime: true,
                altInput: true,
                dateFormat: 'Y-m-d H:i:S',
                altFormat: 'F j, Y h:i:s K',
                minDate: 'today',
            },
        }
    },

    mounted() {
        flatpickr('#created_at', this.flatpickrConfig)
    },

    methods: {
        submit() {
            this.form.patch(route('admin.orders.update', this.order.id), {
                onSuccess: () => window.flash('Successfully Updated')
            })
        },
    },
}
</script>

<style lang="scss" scoped>
</style>
