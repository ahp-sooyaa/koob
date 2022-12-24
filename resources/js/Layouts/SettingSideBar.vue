<template>
	<BreezeNavBarLayout>
		<template
			v-if="$slots.header"
			#header
		>
			<slot name="header" />
		</template>

		<div class="mt-12 bg-white">
			<div class="flex flex-col lg:flex-row max-w-7xl mx-auto">
				<div class="px-4 sm:px-6 lg:px-8 pt-5 lg:p-10 w-full lg:w-80 flex-shrink-0">
					<div>
						<div class="flex justify-between text-sm text-gray-500">
							<span>Signed in as</span>
							<Link
								:href="route('logout')"
								method="post"
								as="button"
								class="underline"
							>
								Sign out
							</Link>
						</div>
						<h1 class="text-xl mt-2">
							{{ $page.props.auth.user.name }}
						</h1>
					</div>
					<div class="border-t my-8" />
					<div class="space-y-5 text-sm">
						<Link 
							:href="route('profile.edit')" 
							class="flex gap-x-3 hover:text-gray-900" 
							:class="[route().current('profile.edit') ? 'text-gray-900' : 'text-gray-500']"
						>
							<svg
								xmlns="http://www.w3.org/2000/svg"
								fill="none"
								viewBox="0 0 24 24"
								stroke-width="1.5"
								stroke="currentColor"
								class="w-5 h-5"
							>
								<path
									stroke-linecap="round"
									stroke-linejoin="round"
									d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"
								/>
							</svg>

							Manage Account
						</Link>
						<Link 
							:href="route('orders.index')" 
							class="flex gap-x-3 hover:text-gray-900" 
							:class="[route().current('orders.index') ? 'text-gray-900' : 'text-gray-500']"
						>
							<svg
								xmlns="http://www.w3.org/2000/svg"
								fill="none"
								viewBox="0 0 24 24"
								stroke-width="1.5"
								stroke="currentColor"
								class="w-5 h-5"
							>
								<path
									stroke-linecap="round"
									stroke-linejoin="round"
									d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"
								/>
							</svg>

							Orders & Return
						</Link>
						<Link 
							:href="route('addresses.index')" 
							class="flex gap-x-3 hover:text-gray-900" 
							:class="[route().current('addresses.index') ? 'text-gray-900' : 'text-gray-500']"
						>
							<svg
								xmlns="http://www.w3.org/2000/svg"
								fill="none"
								viewBox="0 0 24 24"
								stroke-width="1.5"
								stroke="currentColor"
								class="w-5 h-5"
							>
								<path
									stroke-linecap="round"
									stroke-linejoin="round"
									d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"
								/>
								<path
									stroke-linecap="round"
									stroke-linejoin="round"
									d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"
								/>
							</svg>

							Address Book
						</Link>
						<!-- <div class="flex gap-x-3 text-gray-600 hover:text-gray-900 cursor-pointer">
							<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
								<path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
							</svg>

							Payment Cards
						</div> -->
					</div>
				</div>
				<slot />
			</div>
		</div>
	</BreezeNavBarLayout>
</template>

<script>
import BreezeNavBarLayout from '@/Layouts/NavBar'

export default {
    components: {
        BreezeNavBarLayout
    },
}
</script>
