<template>
	<Head title="Register" />

	<BreezeValidationErrors class="mb-4" />

	<div class="flex items-center mb-3 space-x-2 text-gray-700">
		<svg
			xmlns="http://www.w3.org/2000/svg"
			class="h-5 w-5"
			viewBox="0 0 20 20"
			fill="currentColor"
		>
			<path
				fill-rule="evenodd"
				d="M18 8a6 6 0 01-7.743 5.743L10 14l-1 1-1 1H6v2H2v-4l4.257-4.257A6 6 0 1118 8zm-6-4a1 1 0 100 2 2 2 0 012 2 1 1 0 102 0 4 4 0 00-4-4z"
				clip-rule="evenodd"
			/>
		</svg>
		<h1 class="font-bold text-lg uppercase">
			Register
		</h1>
	</div>

	<form @submit.prevent="submit">
		<div>
			<BreezeLabel
				for="name"
				value="Name"
			/>
			<BreezeInput
				id="name"
				v-model="form.name"
				type="text"
				class="mt-1 block w-full"
				required
				autofocus
				autocomplete="name"
			/>
		</div>

		<div class="mt-4">
			<BreezeLabel
				for="email"
				value="Email"
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
				for="password"
				value="Password"
			/>
			<BreezeInput
				id="password"
				v-model="form.password"
				type="password"
				class="mt-1 block w-full"
				required
				autocomplete="new-password"
			/>
		</div>

		<div class="mt-4">
			<BreezeLabel
				for="password_confirmation"
				value="Confirm Password"
			/>
			<BreezeInput
				id="password_confirmation"
				v-model="form.password_confirmation"
				type="password"
				class="mt-1 block w-full"
				required
				autocomplete="new-password"
			/>
		</div>

		<div class="flex items-center justify-end mt-4">
			<Link
				:href="route('login')"
				class="underline text-sm text-gray-600 hover:text-gray-900"
			>
				Already registered?
			</Link>

			<BreezeButton
				class="ml-4"
				:class="{ 'opacity-25': form.processing }"
				:disabled="form.processing"
			>
				Register
			</BreezeButton>
		</div>
	</form>
</template>

<script>
import BreezeButton from '@/Components/Button.vue'
import BreezeFullPageLayout from '@/Layouts/FullPage.vue'
import BreezeInput from '@/Components/Input.vue'
import BreezeLabel from '@/Components/Label.vue'
import BreezeValidationErrors from '@/Components/ValidationErrors.vue'
import { Head, Link } from '@inertiajs/inertia-vue3'

export default {

    components: {
        BreezeButton,
        BreezeInput,
        BreezeLabel,
        BreezeValidationErrors,
        Head,
        Link,
    },
    layout: BreezeFullPageLayout,

    data() {
        return {
            form: this.$inertia.form({
                name: '',
                email: '',
                password: '',
                password_confirmation: '',
                terms: false,
            })
        }
    },

    methods: {
        submit() {
            this.form.post(this.route('register'), {
                onFinish: () => this.form.reset('password', 'password_confirmation'),
            })
        }
    }
}
</script>
