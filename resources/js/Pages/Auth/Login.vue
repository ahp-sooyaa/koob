<template>
  <Head title="Log in" />

  <BreezeValidationErrors class="mb-4" />

  <div
    v-if="status"
    class="mb-4 font-medium text-sm text-green-600"
  >
    {{ status }}
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
