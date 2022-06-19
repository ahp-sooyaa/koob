<template>
	<Head>
		<title>{{ $page.props.user.name }} Setting</title>
		<meta
			head-key="description"
			name="description"
			content="This is profile setting page."
		>
	</Head>

	<BreezeNavBarLayout>
		<template #header>
			<h2 class="flex font-semibold text-xl text-gray-800 leading-tight">
				<Link
					:href="route('profile.index')"
					class="text-gray-500 hover:text-gray-900"
				>
					Profile
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
				<div>Setting</div>
			</h2>
		</template>
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
			<form
				@submit.prevent="form.patch(route('profile.update'))"
				class="px-2 py-10 lg:w-1/2 mx-auto"
			>
				<div class="py-2">
					<div class="relative">
						<label
							for="name"
							class="leading-7 text-sm text-gray-600"
						>Name</label>
						<BreezeInput
							id="name"
							v-model="form.name"
							name="name"
							type="text"
							class="mt-1 block w-full"
							
							autocomplete="name"
						/>
						<BreezeInputError
							v-if="form.errors.name"
							:message="form.errors.name"
						/>
					</div>
				</div>
				<div class="py-2">
					<div class="relative">
						<label
							for="email"
							class="leading-7 text-sm text-gray-600"
						>Email Address</label>
						<BreezeInput
							id="email"
							v-model="form.email"
							name="email"
							type="email"
							class="mt-1 block w-full"
							
							autocomplete="email"
						/>
						<BreezeInputError
							v-if="form.errors.email"
							:message="form.errors.email"
						/>
					</div>
				</div>
				<div class="py-2">
					<div class="relative">
						<label
							for="email"
							class="leading-7 text-sm text-gray-600"
						>Password</label>
						<BreezeInput
							id="password"
							v-model="form.password"
							name="password"
							type="password"
							class="mt-1 block w-full"
							
							autocomplete="password"
						/>
						<BreezeInputError
							v-if="form.errors.password"
							:message="form.errors.password"
						/>
					</div>
				</div>
				<div class="py-2">
					<div class="relative">
						<label
							for="email"
							class="leading-7 text-sm text-gray-600"
						>Password Confirmation</label>
						<BreezeInput
							id="password_confirmation"
							v-model="form.password_confirmation"
							name="password_confirmation"
							type="password"
							class="mt-1 block w-full"
							
							autocomplete="new-password"
						/>
						<BreezeInputError
							v-if="form.errors.password_confirmation"
							:message="form.errors.password_confirmation"
						/>
					</div>
				</div>

				<BreezeButton
					type="submit"
					:disabled="form.processing"
					class="mt-5"
				>
					Update
				</BreezeButton>
			</form>
		</div>
	</BreezeNavBarLayout>
</template>

<script>
import BreezeNavBarLayout from '@/Layouts/NavBar'
import BreezeInput from '@/Components/Input'
import BreezeInputError from '@/Components/InputError'
import BreezeButton from '@/Components/Button'
export default {
    components: {
        BreezeInput,
        BreezeInputError,
        BreezeNavBarLayout,
        BreezeButton
    },

    data() {
        return {
            errors: [],
            form: this.$inertia.form({
                name: null,
                email: null,
                password: null,
                password_confirmation: null
            })
        }
    },
}
</script>

<style lang="scss" scoped>

</style>
