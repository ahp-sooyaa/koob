<template>
	<Head>
		<title>Admin book edit</title>
		<meta
			head-key="description"
			name="description"
			content="This is the book edit page of admin"
		>
	</Head>

	<AdminHeader>
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			Edit Book
		</h2>
	</AdminHeader>

	<BreezeValidationErrors class="w-1/2 mx-auto bg-red-100 border-2 border-red-200 mt-5 px-10 py-5 rounded-2xl" />

	<form
		@submit.prevent="submit"
		class="px-5 pt-10"
	>
		<select
			id="category_id"
			v-model="form.category_id"
			name="category_id"
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
		<div>
			<BreezeLabel
				for="cover"
				value="cover"
			/>
			<input
				@input="form.cover = $event.target.files[0]"
				type="file"
			>
		</div>
		<progress
			v-if="form.progress"
			:value="form.progress.percentage"
			max="100"
		>
			{{ form.progress.percentage }}%
		</progress>

		<div class="mt-4">
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

		<div class="mt-4">
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

		<div class="mt-4">
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
        BreezeValidationErrors,
    },

    layout: AdminLayout,

    props: ['categories', 'book'],

    data() {
        return {
            form: this.$inertia.form({
                cover: '',
                title: this.book.title,
                excerpt: this.book.excerpt,
                author: this.book.author,
                price: this.book.price,
                stock_count: this.book.stock_count,
                category_id: this.book.category_id,
            })
        }
    },

    methods: {
        submit() {
            this.form.post(route('admin.books.update', { book: this.book, _method: 'patch' }))
        }
    }
}
</script>

<style lang="scss" scoped>

</style>
