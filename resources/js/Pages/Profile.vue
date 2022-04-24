<template>
  <Head>
    <title>Profile</title>
    <meta
      head-key="description"
      name="description"
      content="This is your profile page"
    >
  </Head>

  <div class="bg-white mt-16 pb-10 pt-12 shadow">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex flex-col lg:flex-row items-center space-y-5 justify-center lg:space-x-5">
        <img
          src="/images/cover.png"
          alt="profile image"
          class="rounded-3xl h-40 w-40"
        >
        <div>
          <h1 class="text-3xl mb-2">
            {{ $page.props.auth.user.name }}
          </h1>
          <p class="text-gray-500 mb-7">
            {{ $page.props.auth.user.email }}
          </p>
          <Link
            :href="route('books.index')"
            class="border hover:border-gray-700 px-4 py-1.5 rounded-2xl text-sm"
          >
            Edit
          </Link>
        </div>
      </div>

      <!-- dashboard stats -->
      <div class="flex lg:justify-center mt-16 space-x-10 overflow-x-auto py-10">
        <div class="relative min-w-40 text-center border flex flex-col p-5 rounded-3xl">
          <svg
            class="fill-current text-gray-500 h-16 w-16 mx-auto absolute -top-8 left-1/2 transform -translate-x-1/2 bg-white border rounded-full p-3"
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 20 20"
            fill="currentColor"
          >
            <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" />
          </svg>
          <p class="text-2xl font-bold mb-2 mt-5">
            0
          </p>
          <p class="leading-tight text-gray-700 text-sm">
            Total Purchased <br> Books
          </p>
        </div>
        <div class="relative min-w-40 text-center border flex flex-col p-5 rounded-3xl">
          <svg
            class="fill-current text-gray-500 h-16 w-16 mx-auto absolute -top-8 left-1/2 transform -translate-x-1/2 bg-white border rounded-full p-3"
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 20 20"
            fill="currentColor"
          >
            <path
              fill-rule="evenodd"
              d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"
              clip-rule="evenodd"
            />
          </svg>
          <p class="text-2xl font-bold mb-2 mt-5">
            0
          </p>
          <p class="leading-tight text-gray-700 text-sm">
            Total Spent <br> Amount
          </p>
        </div>
        <div class="relative min-w-40 text-center border flex flex-col p-5 rounded-3xl">
          <svg
            class="fill-current text-gray-500 h-16 w-16 mx-auto absolute -top-8 left-1/2 transform -translate-x-1/2 bg-white border rounded-full p-3"
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 20 20"
            fill="currentColor"
          >
            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
            <path
              fill-rule="evenodd"
              d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z"
              clip-rule="evenodd"
            />
          </svg>
          <p class="text-2xl font-bold mb-2 mt-5">
            {{ totalOrderCount }}
          </p>
          <p class="leading-tight text-gray-700 text-sm">
            Total <br> Orders
          </p>
        </div>
        <div class="relative min-w-40 text-center border flex flex-col p-5 rounded-3xl">
          <svg
            class="fill-current text-gray-500 h-16 w-16 mx-auto absolute -top-8 left-1/2 transform -translate-x-1/2 bg-white border rounded-full p-3"
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 20 20"
            fill="currentColor"
          >
            <path
              fill-rule="evenodd"
              d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
              clip-rule="evenodd"
            />
          </svg>
          <p class="text-2xl font-bold mb-2 mt-5">
            0
          </p>
          <p class="leading-tight text-gray-700 text-sm">
            Pending <br> Orders
          </p>
        </div>
      </div>
    </div>
  </div>

  <!-- links -->
  <div class="z-10 shadow bg-white border-b border-black flex justify-center pt-6 rounded-b-2xl space-x-10 sticky top-16 mb-16">
    <Link
      :href="route('books.index')"
      class="border-b-2 border-blue-500 px-3 py-1.5"
    >
      My Coupons
    </Link>
    <Link
      :href="route('books.index')"
      class="text-gray-500 hover:text-gray-700 px-3 py-1.5"
    >
      My Wishs
    </Link>
  </div>

  <couponslist />
</template>

<script>
import BreezeNavBarLayout from '@/Layouts/NavBar'
import couponslist from '@/Components/CouponsList'

export default {
    components: {couponslist},

    layout: BreezeNavBarLayout,

    props: ['totalOrderCount'],
}
</script>

<style lang="scss" scoped>

</style>