<template>
	<Head title="Log in" />

	<BreezeValidationErrors class="mb-4" />

	<div
		v-if="status"
		class="mb-4 font-medium text-sm text-green-600"
	>
		{{ status }}
	</div>

	<div class="flex items-center justify-between mb-3 text-gray-700">
		<div class="flex items-center space-x-2">
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
				Log In
			</h1>
		</div>
		<div
			v-if="isLocal"
			class="flex space-x-2"
		>
			<Link
				:href="route('loginAsAdmin')"
				class="text-sm underline"
			>
				Login as admin
			</Link>
			<Link
				:href="route('loginAsUser')"
				class="text-sm underline"
			>
				Login as user
			</Link>
		</div>
	</div>

	<form @submit.prevent="submit">
		<div>
			<BreezeLabel
				for="email"
				value="Email"
			/>
			<BreezeInput
				id="email"
				v-model="form.email"
				name="email"
				type="email"
				class="mt-1 block w-full"
				required
				autofocus
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
				name="password"
				type="password"
				class="mt-1 block w-full"
				required
				autocomplete="current-password"
			/>
		</div>

		<div class="block mt-4">
			<label class="flex items-center">
				<BreezeCheckbox
					v-model:checked="form.remember"
					name="remember"
				/>
				<span class="ml-2 text-sm text-gray-600">Remember me</span>
			</label>
		</div>

		<div class="flex items-center justify-end mt-4">
			<Link
				v-if="canResetPassword"
				:href="route('password.request')"
				class="underline text-sm text-gray-600 hover:text-gray-900"
			>
				Forgot your password?
			</Link>

			<BreezeButton
				class="ml-4"
				:class="{ 'opacity-25': form.processing }"
				:disabled="form.processing"
				dusk="login-button"
			>
				Log in
			</BreezeButton>
		</div>
	</form>

	<div class="flex items-center justify-center my-5">
		<hr class="flex-1">
		<span class="inline-block px-4 text-center">Or</span>
		<hr class="flex-1">
	</div>
	<div class="flex justify-center items-center space-x-5">
		<div class="text-sm text-gray-800">
			New User ?
		</div>
		<Link
			:href="route('register')"
			class="underline text-sm text-gray-600 hover:text-gray-900"
		>
			Create an account
		</Link>
	</div>
</template>

<script>
import BreezeButton from '@/Components/Button.vue'
import BreezeCheckbox from '@/Components/Checkbox.vue'
import BreezeFullPageLayout from '@/Layouts/FullPage.vue'
import BreezeInput from '@/Components/Input.vue'
import BreezeLabel from '@/Components/Label.vue'
import BreezeValidationErrors from '@/Components/ValidationErrors.vue'
import { Head, Link } from '@inertiajs/inertia-vue3'

export default {

    components: {
        BreezeButton,
        BreezeCheckbox,
        BreezeInput,
        BreezeLabel,
        BreezeValidationErrors,
        Head,
        Link,
    },
    layout: BreezeFullPageLayout,

    props: {
        canResetPassword: Boolean,
        status: {
            type: String,
            required: true
        },
        isLocal: Boolean,
    },

    data() {
        return {
            form: this.$inertia.form({
                email: '',
                password: '',
                remember: false
            })
        }
    },

    methods: {
        submit() {
            this.form.post(this.route('login'), {
                onFinish: () => this.form.reset('password'),
            })
        }
    }
}
</script>
