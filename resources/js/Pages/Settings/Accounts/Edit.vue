<template>
	<Head>
		<title>Account Setting</title>
		<meta
			head-key="description"
			name="description"
			content="This is account setting page."
		>
	</Head>

	<SettingSideBarLayout>
		<template #header>
			<h2 class="font-semibold text-xl text-gray-800 leading-tight">
				Manage Account
			</h2>
			<p class="text-sm text-gray-500 mt-1">
				Update your username, email or password.
			</p>
		</template>
		
		<div class="w-full max-w-xl lg:max-w-4xl lg:mx-auto px-4 sm:px-6 lg:px-8">
			<form
				@submit.prevent="updateProfile"
				class="px-2 py-10 lg:w-2/3"
			>
				<h1 class="mb-5 text-xl">
					Personal information
				</h1>
				<div class="relative max-w-max mb-5">
					<img
						v-if="!profilePhotoPreview"
						:src="$page.props.auth.user.profile_photo_url"
						alt="avatar"
						class="object-cover w-32 h-32 rounded-full"
					>
					<img
						v-else
						:src="profilePhotoPreview"
						alt="avatar"
						class="object-cover w-32 h-32 rounded-full"
					>
					<input
						ref="photo"
						@change="selectedProfilePhoto($event)"
						type="file"
						class="hidden"
						accept="image/*"
					>
					<button
						@click="$refs.photo.click()"
						type="button"
						class="-bottom-3 -translate-x-1/2 absolute bg-gray-700 hover:bg-gray-500 shadow left-1/2 px-4 py-1 rounded-lg text-gray-300 text-xs transform tracking-widest"
					>
						Edit
					</button>
				</div>
				<BreezeInputError
					v-if="profileForm.errors.profile_photo"
					:message="profileForm.errors.profile_photo"
				/>
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
				class="px-2 py-10 lg:w-2/3"
			>
				<h1 class="mb-5 text-xl">
					Update Password
				</h1>
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
	</SettingSideBarLayout>
</template>

<script>
import SettingSideBarLayout from '@/Layouts/SettingSideBar'
import BreezeInput from '@/Components/Input'
import BreezeInputError from '@/Components/InputError'
import BreezeButton from '@/Components/Button'
export default {
    components: {
        BreezeInput,
        BreezeInputError,
        SettingSideBarLayout,
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
            profilePhotoName: '',
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

        selectedProfilePhoto(e) {
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
