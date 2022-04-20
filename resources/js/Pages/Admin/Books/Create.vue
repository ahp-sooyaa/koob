<template>
  <Head>
    <title>Admin book create</title>
    <meta
      head-key="description"
      name="description"
      content="This is the book create page of admin"
    >
  </Head>

  <div class="bg-white p-5 shadow">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      Create Books
    </h2>
  </div>

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

    <div class="flex items-center justify-start mt-4">
      <BreezeButton
        :class="{ 'opacity-25': form.processing }"
        :disabled="form.processing"
      >
        Create
      </BreezeButton>
    </div>
  </form>
</template>

<script>
import AdminLayout from '@/Layouts/Admin'
import BreezeButton from '@/Components/Button'
import BreezeInput from '@/Components/Input'
import BreezeLabel from '@/Components/Label'
import BreezeValidationErrors from '@/Components/ValidationErrors'

export default {
    components: {
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
                cover: null,
                title: '',
                excerpt: '',
                author: '',
                price: '',
                category_id: '',
            })
        }
    },

    methods: {
        selectedImage(e) {
            this.form.cover = e.target.files[0]
            console.log(e.target.files[0])
            // let reader = new FileReader()
            // reader.readAsDataURL(this.featured_image)
            // reader.onload = (e) => {
            //     this.previewImage = e.target.result
            // }
        },
        submit() {
            this.form.post('/admin/books')
        }
    }
}
</script>

<style lang="scss" scoped>

</style>