<template>
	<Head>
		<title>Welcome</title>
		<meta
			head-key="description"
			name="description"
			content="This is welcome page of koob"
		>
	</Head>

	<header
		class="bg-cover bg-hero-image flex flex-col items-center justify-center lg:mt-28 lg:mx-10 lg:overflow-hidden relative lg:rounded-3xl text-white"
		style="min-height: calc(100vh - 180px)"
	>
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

	<section class="py-20 px-4 sm:px-6 lg:px-8 bg-gray-50 relative">
		<div class="absolute text-5xl 2xl:text-9xl text-gray-700 opacity-5 font-black z-0">
			Trending
		</div>
		<div class="relative container mx-auto z-10">
			<h1 class="font-bold text-2xl mb-8">
				Trending
			</h1>
			<div class="grid md:grid-cols-2 2xl:grid-cols-3 gap-10">
				<div
					v-for="(book, index) in books"
					:key="index"
					class="flex space-x-5"
				>
					<img
						:src="book.cover_url"
						:alt="book.title + '\s cover image'"
						class="w-32 h-44 flex-shrink-0 shadow-2xl"
					>
					<div>
						<Link
							:href="'books/' + book.slug"
							class="font-bold tracking-wider text-lg line-clamp-2 hover:underline"
						>
							{{ book.title }}
						</Link>
						<div class="text-sm text-gray-400 mb-3">
							by 
							<span class="text-gray-700">
								{{ book.author }}
							</span>
						</div>
						<p class="w-4/5 line-clamp-2 text-sm text-gray-700 mb-3">
							{{ book.excerpt }}
						</p>
						<span>{{ formatPrice(book.price) }}</span>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="pb-20 px-4 sm:px-6 lg:px-8 bg-gray-50 relative">
		<div class="absolute text-5xl 2xl:text-9xl text-gray-700 opacity-5 font-black z-0">
			Romance
		</div>
		<div class="relative container mx-auto z-10">
			<h1 class="font-bold text-2xl mb-8">
				Romance 
			</h1>
			<div class="grid md:grid-cols-2 2xl:grid-cols-3 gap-10">
				<div
					v-for="(book, index) in books"
					:key="index"
					class="flex space-x-5"
				>
					<img
						:src="book.cover_url"
						:alt="book.title + '\s cover image'"
						class="w-32 h-44 flex-shrink-0 shadow-2xl"
					>
					<div>
						<Link
							:href="'books/' + book.slug"
							class="font-bold tracking-wider text-lg line-clamp-2 hover:underline"
						>
							{{ book.title }}
						</Link>
						<div class="text-sm text-gray-400 mb-3">
							by 
							<span class="text-gray-700">
								{{ book.author }}
							</span>
						</div>
						<p class="w-4/5 line-clamp-2 text-sm text-gray-700 mb-3">
							{{ book.excerpt }}
						</p>
						<span>{{ formatPrice(book.price) }}</span>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="my-20">
		<div class="container mx-auto">
			<div class="flex flex-col-reverse items-center mx-auto sm:flex-row sm:space-x-10 xl:w-1/2 px-4 sm:px-6 lg:px-8">
				<div class="text-right mt-5 2xl:mt-0">
					<span class="capitalize text-gray-700">author of the week</span>
					<div class="border-t mt-5 mb-3 w-20 border-gray-500 ml-auto" />
					<h1 class="text-5xl font-black mb-3 capitalize">
						sandro loren
					</h1>
					<p class="text-gray-600">
						Lorem ipsum dolor sit amet consectetur adipisicing elit. Deserunt deleniti exercitationem eligendi esse blanditiis? Quas non, sequi alias commodi harum eum necessitatibus consequuntur illo molestias ipsam, ipsum accusamus deserunt ab!
					</p>
				</div>
				<img
					src="images/avatar.jpg"
					alt="cover image"
					class="flex-shrink-0 shadow-2xl w-52 h-64 object-cover"
				>
			</div>
			<div class="flex mx-auto w-20 space-x-4 justify-center mt-10">
				<span class="bg-gray-400 block w-2 h-2 rounded-full" />
				<span class="bg-white border border-gray-400 block w-2 h-2 rounded-full" />
				<span class="bg-white border border-gray-400 block w-2 h-2 rounded-full" />
			</div>
		</div>
	</section>
</template>

<script>
import BreezeNavBarLayout from '@/Layouts/NavBar'
import format from '@/mixins/format'

export default {
    mixins: [ format ],
    layout: BreezeNavBarLayout,

    props: ['books'],
}
</script>

<style lang="scss" scoped>

</style>
