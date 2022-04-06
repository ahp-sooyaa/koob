<template>
  <Head title="Admin - Manage Books create" />

  <div class="bg-white p-5 shadow">
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
      <div>Edit Order #{{ order.id }}</div>
    </h2>
  </div>

  <div
    v-if="Object.keys($page.props.errors).length > 0"
    class="bg-red-100 border-2 border-red-200 mt-5 mx-5 px-10 py-5 rounded-2xl"
  >
    <BreezeValidationErrors />
  </div>
  <div
    v-if="$page.props.flash.message"
    class="bg-white w-1/2 mx-auto p-5 rounded-2xl mt-5 shadow ring ring-green-100"
  >
    {{ $page.props.flash.message }}
  </div>

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
        for="order placed at"
        value="order placed at"
      />
      <BreezeInput
        id="order placed at"
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
import { Head, Link } from '@inertiajs/inertia-vue3'
import BreezeButton from '@/Components/Button'
import BreezeInput from '@/Components/Input'
import BreezeLabel from '@/Components/Label'
import BreezeValidationErrors from '@/Components/ValidationErrors'

export default {
    components: {
        BreezeButton,
        BreezeInput,
        BreezeLabel,
        Head,
        Link,
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
            this.form.patch(route('admin.orders.update', this.order.id), this.form)
        },
    },
}
</script>

<style lang="scss" scoped>
</style>