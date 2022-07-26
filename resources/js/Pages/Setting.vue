<template>
	<Head>
		<title>{{ $page.props.auth.user.name }} Setting</title>
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
					:href="route('profile.show', $page.props.auth.user.name)"
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
				@submit.prevent="updateProfile"
				class="px-2 py-10 lg:w-1/2 mx-auto"
			>
				<div class="relative max-w-max mb-5">
					<img
						v-show="!profilePhotoPreview"
						:src="$page.props.auth.user.profile_photo_url"
						alt="avatar"
						class="object-cover w-32 h-32 rounded-full"
					>
					<img
						v-show="profilePhotoPreview"
						:src="profilePhotoPreview"
						alt="avatar"
						class="object-cover w-32 h-32 rounded-full"
					>
					<input
						ref="photo"
						@change="changedProfilePhoto($event)"
						type="file"
						class="hidden"
					>
					<button
						@click="$refs.photo.click()"
						type="button"
						class="-bottom-3 -translate-x-1/2 absolute bg-blue-200 border hover:border-blue-400 left-1/2 px-2 py-0.5 rounded-lg text-blue-600 text-sm transform"
					>
						Edit
					</button>
					<BreezeInputError
						v-if="profileForm.errors.profile_photo"
						:message="profileForm.errors.profile_photo"
					/>
				</div>
				<div class="py-2">
					<div class="relative">
						<label
							for="name"
							class="leading-7 text-sm text-gray-600"
						>Name</label>
						<BreezeInput
							id="name"
							v-model="profileForm.name"
							name="name"
							type="text"
							class="mt-1 block w-full"

							autocomplete="name"
						/>
						<BreezeInputError
							v-if="profileForm.errors.name"
							:message="profileForm.errors.name"
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
							v-model="profileForm.email"
							name="email"
							type="email"
							class="mt-1 block w-full"

							autocomplete="email"
						/>
						<BreezeInputError
							v-if="profileForm.errors.email"
							:message="profileForm.errors.email"
						/>
					</div>
				</div>

				<BreezeButton
					type="submit"
					:class="{ 'opacity-25 cursor-default': profileForm.processing || !profileForm.isDirty }"
					:disabled="profileForm.processing || !profileForm.isDirty"
					class="mt-5"
				>
					Update
				</BreezeButton>
			</form>
			<form
				@submit.prevent="updatePassword"
				class="px-2 py-10 lg:w-1/2 mx-auto"
			>
				<div class="py-2">
					<div class="relative">
						<label
							for="email"
							class="leading-7 text-sm text-gray-600"
						>Current Password</label>
						<BreezeInput
							id="current_password"
							v-model="passwordForm.current_password"
							name="current_password"
							type="password"
							class="mt-1 block w-full"
							autocomplete="current_password"
						/>
						<BreezeInputError
							v-if="passwordForm.errors.current_password"
							:message="passwordForm.errors.current_password"
						/>
					</div>
				</div><div class="py-2">
					<div class="relative">
						<label
							for="email"
							class="leading-7 text-sm text-gray-600"
						>New Password</label>
						<BreezeInput
							id="password"
							v-model="passwordForm.password"
							name="password"
							type="password"
							class="mt-1 block w-full"
							autocomplete="password"
						/>
						<BreezeInputError
							v-if="passwordForm.errors.password"
							:message="passwordForm.errors.password"
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
							v-model="passwordForm.password_confirmation"
							name="password_confirmation"
							type="password"
							class="mt-1 block w-full"
							autocomplete="password"
						/>
						<BreezeInputError
							v-if="passwordForm.errors.password_confirmation"
							:message="passwordForm.errors.password_confirmation"
						/>
					</div>
				</div>

				<BreezeButton
					type="submit"
					:class="{ 'opacity-25 cursor-default': passwordForm.processing || !passwordForm.isDirty }"
					:disabled="passwordForm.processing || !passwordForm.isDirty"
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
            profileForm: this.$inertia.form({
                name: this.$page.props.auth.user.name,
                email: this.$page.props.auth.user.email,
                profile_photo: ''
            }),
            passwordForm: this.$inertia.form({
                current_password: '',
                password: '',
                password_confirmation: ''
            }),
            profilePhotoPreview: '',
            profilePhotoName: ''
        }
    },

    methods: {
        updateProfile() {
            this.profileForm.post(route('profile.update', {_method: 'patch'}))
        },

        updatePassword() {
            this.passwordForm.patch(route('profile-password.update'), {
                preserveScroll: true,
                onSuccess: () => this.passwordForm.reset()
            })
        },

        changedProfilePhoto(e) {
            this.profileForm.profile_photo = e.target.files[0]
            this.profilePhotoName = this.$refs.photo.files[0].name
            const reader = new FileReader()
            reader.onload = (e) => {
                this.profilePhotoPreview = e.target.result
            }
            reader.readAsDataURL(this.$refs.photo.files[0])
        }
    }
}
</script>

<style lang="scss" scoped>

</style>
