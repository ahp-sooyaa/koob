<template>
	<Head>
		<title>Admin book create</title>
		<meta
			head-key="description"
			name="description"
			content="This is the book create page of admin"
		>
	</Head>

	<AdminHeader>
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			Create Book
		</h2>
	</AdminHeader>

	<BreezeValidationErrors class="w-1/2 mx-auto bg-red-100 border-2 border-red-200 mt-5 px-10 py-5 rounded-2xl" />

	<form
		@submit.prevent="submit"
		class="px-5 py-10 max-w-2xl"
	>
		<div class="flex space-x-10">
			<div>
				<select
					id="category_id"
					v-model="form.category_id"
					name="category_id"
					class="rounded-2xl text-sm"
				>
					<option
						disabled
						value=""
						selected
					>
						Select Categories
					</option>
					<option
						v-for="category in categories"
						:key="category.id"
						:value="category.id"
					>
						{{ category.name }}
					</option>
				</select>
				<div class="mt-4">
					<input
						ref="coverPhoto"
						@change="selectedCoverPhoto($event)"
						type="file"
						class="hidden"
					>
					<button
						v-if="!coverPhotoPreview"
						@click="$refs.coverPhoto.click()"
						type="button"
						class="bg-gray-200 border border-dashed border-gray-500 rounded-lg h-64 w-52 grid place-content-center text-gray-500 hover:text-gray-700 cursor-pointer hover:border-gray-700"
					>
						<svg
							xmlns="http://www.w3.org/2000/svg"
							class="h-10 w-10 mx-auto"
							viewBox="0 0 20 20"
							fill="currentColor"
						>
							<path
								fill-rule="evenodd"
								d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z"
								clip-rule="evenodd"
							/>
						</svg>
						<h1 class="text-sm px-5">
							Select book cover photo to upload
						</h1>
					</button>
					<div
						v-else
						@mouseenter="showCoverPhotoEdit = true"
						@mouseleave="showCoverPhotoEdit = false"
						class="h-64 w-52 relative"
					>
						<img
							:src="coverPhotoPreview"
							alt="cover photo"
							class="object-cover rounded-lg border shadow w-full h-full"
						>
						<button
							v-show="showCoverPhotoEdit"
							@click="$refs.coverPhoto.click()"
							type="button"
							class="absolute backdrop-blur bg-gradient-to-b from-transparent via-gray-700 to-transparent border border-dashed border-gray-900 cursor-pointer grid h-full place-content-center rounded-lg text-white top-0 w-full"
						>
							<svg
								xmlns="http://www.w3.org/2000/svg"
								class="h-10 w-10 mx-auto"
								viewBox="0 0 20 20"
								fill="currentColor"
							>
								<path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
							</svg>
							<h1 class="text-sm px-5">
								Select book cover photo to upload
							</h1>
						</button>
					</div>
					<h1 class="text-xs mt-3 text-gray-700">
						{{ coverPhotoName }}
					</h1>
				</div>
				<progress
					v-if="form.progress"
					:value="form.progress.percentage"
					max="100"
				>
					{{ form.progress.percentage }}%
				</progress>
			</div>

			<div class="flex-1">
				<div class="mt-0">
					<BreezeLabel
						for="title"
						value="title"
					/>
					<BreezeInput
						id="title"
						v-model="form.title"
						type="text"
						class="mt-1 block w-full"
						autocomplete="title"
					/>
				</div>

				<div class="mt-4">
					<BreezeLabel
						for="excerpt"
						value="excerpt"
					/>
					<BreezeInput
						id="excerpt"
						v-model="form.excerpt"
						type="text"
						class="mt-1 block w-full"
						autocomplete="username"
					/>
				</div>

				<div class="mt-4">
					<BreezeLabel
						for="author"
						value="author"
					/>
					<BreezeInput
						id="author"
						v-model="form.author"
						type="text"
						class="mt-1 block w-full"
						autocomplete="author"
					/>
				</div>

				<div class="flex space-x-5 mt-4">
					<div class="w-1/2">
						<BreezeLabel
							for="price"
							value="price"
						/>
						<BreezeInput
							id="price"
							v-model="form.price"
							type="number"
							class="mt-1 block w-full"
							autocomplete="price"
						/>
					</div>
					<div class="w-1/2">
						<BreezeLabel
							for="stock_count"
							value="stock_count"
						/>
						<BreezeInput
							id="stock_count"
							v-model="form.stock_count"
							type="number"
							class="mt-1 block w-full"
							autocomplete="stock_count"
						/>
					</div>
				</div>

				<div class="flex items-center justify-start mt-4">
					<BreezeButton
						:class="{ 'opacity-25': form.processing }"
						:disabled="form.processing"
					>
						Create
					</BreezeButton>
				</div>
			</div>
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
        BreezeValidationErrors,
    },

    layout: AdminLayout,

    props: ['categories'],

    data() {
        return {
            form: this.$inertia.form({
                cover_photo: '',
                title: '',
                excerpt: '',
                author: '',
                price: '',
                category_id: '',
                stock_count: '',
            }),
            coverPhotoPreview: '',
            coverPhotoName: '',
            showCoverPhotoEdit: false,
        }
    },

    methods: {
        submit() {
            this.form.post(route('admin.books.store'))
        },

        selectedCoverPhoto(e) {
            this.form.cover_photo = e.target.files[0]
            this.coverPhotoName = this.$refs.coverPhoto.files[0].name
            const reader = new FileReader()
            reader.onload = (e) => {
                this.coverPhotoPreview = e.target.result
            }
            reader.readAsDataURL(this.$refs.coverPhoto.files[0])
        }
    }
}
</script>

<style lang="scss" scoped>

</style>
