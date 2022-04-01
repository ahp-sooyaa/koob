<template>
  <BreezeNavBarLayout>
    <header class="bg-cover bg-hero-image flex flex-col items-center justify-center min-h-screen lg:mt-28 lg:mx-10 lg:overflow-hidden relative lg:rounded-3xl text-white">
      <div class="absolute z-10 flex flex-col items-center space-y-5 w-full px-4 pt-16 lg:w-2/3 text-center">
        <h1 class="font-extrabold text-5xl">
          Get your favorite book with best price
        </h1>
        <p class="max-w-2xl text-2xl">
          Lorem, ipsum dolor sit amet consectetur adipisicing elit. Fuga excepturi eveniet, ipsum deserunt expedita.
        </p>
        <Link
          :href="route('books.index')"
          class="bg-gradient-to-r font-bold from-indigo-500 inline-block px-5 py-2 rounded-lg shadow-2xl text-white to-blue-500"
        >
          Shop Now
        </Link>
      </div>
      <div class="absolute bg-black bg-opacity-25 h-full inset-0" />
    </header>

    <section class="py-20">
      <div class="container mx-auto">
        <h1 class="font-bold text-center text-2xl mb-8">
          Shop by category
        </h1>
        <div class="grid grid-cols-1 gap-y-5 md:grid-cols-3 lg:grid-cols-5 md:gap-x-10 px-4 sm:px-6 lg:px-8">
          <div class="flex justify-center relative overflow-hidden">
            <div class="absolute bg-gradient-to-b bottom-0 flex font-bold from-transparent h-full items-end justify-center pb-5 text-white to-gray-800 via-transparent w-full">
              Action & Adventure
            </div>
            <img
              src="images/cover.png"
              alt="cover image"
              class="h-full lg:h-72 w-full"
            >
          </div>
          <div class="flex justify-center relative">
            <div class="absolute bg-gradient-to-b bottom-0 flex font-bold from-transparent h-full items-end justify-center pb-5 text-white to-gray-800 via-transparent w-full">
              Mystery
            </div>
            <img
              src="images/cover.png"
              alt="cover image"
              class="h-full lg:h-72 w-full"
            >
          </div>
          <div class="flex justify-center relative">
            <div class="absolute bg-gradient-to-b bottom-0 flex font-bold from-transparent h-full items-end justify-center pb-5 text-white to-gray-800 via-transparent w-full">
              Action
            </div>
            <img
              src="images/cover.png"
              alt="cover image"
              class="h-full lg:h-72 w-full"
            >
          </div>
          <div class="flex justify-center relative">
            <div class="absolute bg-gradient-to-b bottom-0 flex font-bold from-transparent h-full items-end justify-center pb-5 text-white to-gray-800 via-transparent w-full">
              Classic
            </div>
            <img
              src="images/cover.png"
              alt="cover image"
              class="h-full lg:h-72 w-full"
            >
          </div>
          <div class="flex justify-center relative">
            <div class="absolute bg-gradient-to-b bottom-0 flex font-bold from-transparent h-full items-end justify-center pb-5 text-white to-gray-800 via-transparent w-full">
              Cosmic
            </div>
            <img
              src="images/cover.png"
              alt="cover image"
              class="h-full lg:h-72 w-full"
            >
          </div>
        </div>
      </div>
    </section>

    <section class="py-20 bg-white">
      <div class="container mx-auto">
        <h1 class="font-bold text-center text-2xl mb-8">
          Trending Books
        </h1>
        <div class="grid grid-cols-1 gap-y-5 md:grid-cols-3 lg:grid-cols-5 md:gap-x-10 px-4 sm:px-6 lg:px-8">
          <div class="flex flex-col items-center">
            <img
              src="images/cover.png"
              alt="cover image"
              class="h-full lg:h-72 w-full mb-5"
            >
            <p class="text-gray-500">
              John Doe
            </p>
            <h1 class="font-bold text-lg">
              Title of book
            </h1>
            <span class="text-sm">$ 29.99</span>
          </div>
          <div class="flex flex-col items-center">
            <img
              src="images/cover.png"
              alt="cover image"
              class="h-full lg:h-72 w-full mb-5"
            >
            <p class="text-gray-500">
              John Doe
            </p>
            <h1 class="font-bold text-lg">
              Title of book
            </h1>
            <span class="text-sm">$ 29.99</span>
          </div>
          <div class="flex flex-col items-center">
            <img
              src="images/cover.png"
              alt="cover image"
              class="h-full lg:h-72 w-full mb-5"
            >
            <p class="text-gray-500">
              John Doe
            </p>
            <h1 class="font-bold text-lg">
              Title of book
            </h1>
            <span class="text-sm">$ 29.99</span>
          </div>
          <div class="flex flex-col items-center">
            <img
              src="images/cover.png"
              alt="cover image"
              class="h-full lg:h-72 w-full mb-5"
            >
            <p class="text-gray-500">
              John Doe
            </p>
            <h1 class="font-bold text-lg">
              Title of book
            </h1>
            <span class="text-sm">$ 29.99</span>
          </div>
          <div class="flex flex-col items-center">
            <img
              src="images/cover.png"
              alt="cover image"
              class="h-full lg:h-72 w-full mb-5"
            >
            <p class="text-gray-500">
              John Doe
            </p>
            <h1 class="font-bold text-lg">
              Title of book
            </h1>
            <span class="text-sm">$ 29.99</span>
          </div>
        </div>
      </div>
    </section>

    <section class="my-20">
      <div class="container mx-auto">
        <h1 class="font-bold text-center text-2xl mb-8">
          Popular Authors
        </h1>
        <div class="grid grid-cols-1 gap-y-5 md:grid-cols-3 lg:grid-cols-5 md:gap-x-10 px-4 sm:px-6 lg:px-8">
          <div class="flex flex-col items-center">
            <img
              src="images/avatar.jpg"
              alt="author avatar"
              class="rounded-full h-32 mb-5"
            >
            <h1 class="font-bold text-2xl">
              John Doe
            </h1>
          </div>
          <div class="flex flex-col items-center">
            <img
              src="images/avatar.jpg"
              alt="author avatar"
              class="rounded-full h-32 mb-5"
            >
            <h1 class="font-bold text-2xl">
              John Doe
            </h1>
          </div>
          <div class="flex flex-col items-center">
            <img
              src="images/avatar.jpg"
              alt="author avatar"
              class="rounded-full h-32 mb-5"
            >
            <h1 class="font-bold text-2xl">
              John Doe
            </h1>
          </div>
          <div class="flex flex-col items-center">
            <img
              src="images/avatar.jpg"
              alt="author avatar"
              class="rounded-full h-32 mb-5"
            >
            <h1 class="font-bold text-2xl">
              John Doe
            </h1>
          </div>
          <div class="flex flex-col items-center">
            <img
              src="images/avatar.jpg"
              alt="author avatar"
              class="rounded-full h-32 mb-5"
            >
            <h1 class="font-bold text-2xl">
              John Doe
            </h1>
          </div>
        </div>
      </div>
    </section>
  </BreezeNavBarLayout>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3'
import BreezeNavBarLayout from '@/Layouts/NavBar'
export default {
    components: { 
        Link, 
        BreezeNavBarLayout 
    }
}
</script>

<style lang="scss" scoped>

</style>