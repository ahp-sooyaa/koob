<template>
	<div>
		<div class="flex flex-col min-h-screen bg-gray-50">
			<nav class="fixed z-30 w-full bg-white border-b border-gray-100">
				<!-- Primary Navigation Menu -->
				<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
					<div class="flex justify-between h-16">
						<div class="flex">
							<!-- Logo -->
							<div class="flex-shrink-0 flex items-center">
								<Link
									:href="route('welcome')"
									class="uppercase font-bold text-xl"
								>
									<img
										src="/images/logo.svg"
										alt="logo"
									>
								</Link>
							</div>

							<!-- Navigation Links -->
							<div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
								<!-- <BreezeNavLink
                                  v-if="$page.props.auth.user"
                                  :href="route('dashboard')"
                                  :active="route().current('dashboard')"
                                >
                                  Dashboard
                                </BreezeNavLink> -->
								<BreezeNavLink
									:href="route('books.index')"
									:active="route().current('books.index')"
								>
									Shop
								</BreezeNavLink>
							</div>
						</div>

						<div class="hidden sm:flex sm:ml-6">
							<Search />
							<!-- Settings Dropdown -->
							<div
								v-if="$page.props.auth.user"
								class="flex items-center ml-3 relative"
							>
								<CartLink :responsive="false" />
								<BreezeDropdown
									align="right"
									width="48"
								>
									<template #trigger>
										<span class="inline-flex rounded-md">
											<button
												type="button"
												class="inline-flex items-center px-3 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
											>
												<img
													:src="$page.props.auth.user.profile_photo_url"
													:alt="$page.props.auth.user.name + '\'s avatar'"
													class="h-8 w-8"
												>

												<svg
													class="ml-0.5 -mr-0.5 h-4 w-4"
													xmlns="http://www.w3.org/2000/svg"
													viewBox="0 0 20 20"
													fill="currentColor"
												>
													<path
														fill-rule="evenodd"
														d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
														clip-rule="evenodd"
													/>
												</svg>
											</button>
										</span>
									</template>

									<template #content>
										<div v-if="$page.props.auth.user.is_admin">
											<BreezeDropdownLink
												:href="route('admin.dashboard')"
												as="button"
											>
												<div class="flex items-center gap-2">
													<svg
														xmlns="http://www.w3.org/2000/svg"
														class="h-6 w-6"
														fill="none"
														viewBox="0 0 24 24"
														stroke="currentColor"
														stroke-width="2"
													>
														<path
															stroke-linecap="round"
															stroke-linejoin="round"
															d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"
														/>
													</svg>
													Dashboard
												</div>
											</BreezeDropdownLink>
										</div>
										<div v-else>
											<BreezeDropdownLink
												:href="route('profile.edit')"
												as="button"
											>
												<div class="flex items-center gap-x-2">
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
												</div>
											</BreezeDropdownLink>
											<BreezeDropdownLink
												:href="route('orders.index')"
												as="button"
											>
												<div class="flex items-center gap-x-2">
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

													Orders & Returns
												</div>
											</BreezeDropdownLink>
											<BreezeDropdownLink
												:href="route('addresses.index')"
												as="button"
											>
												<div class="flex items-center gap-x-2">
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
												</div>
											</BreezeDropdownLink>
										</div>
										<BreezeDropdownLink
											:href="route('logout')"
											method="post"
											as="button"
										>
											<div class="flex items-center gap-x-1.5 pl-0.5">
												<svg
													xmlns="http://www.w3.org/2000/svg"
													class="h-5 w-5"
													fill="none"
													viewBox="0 0 24 24"
													stroke="currentColor"
													stroke-width="2"
												>
													<path
														stroke-linecap="round"
														stroke-linejoin="round"
														d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
													/>
												</svg>
												Log Out
											</div>
										</BreezeDropdownLink>
									</template>
								</BreezeDropdown>
							</div>

							<template v-else>
								<div class="flex space-x-3 ml-3">
									<CartLink :responsive="false" />
									<Link
										:href="route('login')"
										:active="route().current('login')"
										class="flex items-center text-sm hover:text-gray-700 text-gray-500"
									>
										Sign in
									</Link>
									<Link
										:href="route('register')"
										:active="route().current('register')"
										class="flex items-center text-sm hover:text-gray-700 text-gray-500 border my-3 px-3 rounded-2xl hover:border-gray-500"
									>
										Create an account
									</Link>
								</div>
							</template>
						</div>

						<!-- Hamburger -->
						<div class="-mr-2 flex items-center sm:hidden">
							<search />
							<button
								@click="showingNavigationDropdown = ! showingNavigationDropdown"
								class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out ml-3"
							>
								<svg
									class="h-6 w-6"
									stroke="currentColor"
									fill="none"
									viewBox="0 0 24 24"
								>
									<path
										:class="{'hidden': showingNavigationDropdown, 'inline-flex': ! showingNavigationDropdown }"
										stroke-linecap="round"
										stroke-linejoin="round"
										stroke-width="2"
										d="M4 6h16M4 12h16M4 18h16"
									/>
									<path
										:class="{'hidden': ! showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }"
										stroke-linecap="round"
										stroke-linejoin="round"
										stroke-width="2"
										d="M6 18L18 6M6 6l12 12"
									/>
								</svg>
							</button>
						</div>
					</div>
				</div>

				<!-- Responsive Navigation Menu -->
				<div
					:class="{'block': showingNavigationDropdown, 'hidden': ! showingNavigationDropdown}"
					class="sm:hidden"
				>
					<div class="pt-2 pb-3 space-y-1">
						<!-- currently comment out this link, instead of dashboard profile page will be used -->
						<!--<BreezeResponsiveNavLink
							v-if="$page.props.auth.user"
							:href="route('dashboard')"
							:active="route().current('dashboard')"
						>
							Dashboard
						</BreezeResponsiveNavLink>-->
						<BreezeResponsiveNavLink
							:href="route('books.index')"
							:active="route().current('books.index')"
						>
							Shop
						</BreezeResponsiveNavLink>
						<CartLink :responsive="true" />
					</div>

					<!-- Responsive Settings Options -->
					<div
						v-if="$page.props.auth.user"
						class="pt-4 pb-1 border-t border-gray-200"
					>
						<div class="px-4">
							<div class="font-medium text-base text-gray-800">
								{{ $page.props.auth.user.name }}
							</div>
							<div class="font-medium text-sm text-gray-500">
								{{ $page.props.auth.user.email }}
							</div>
						</div>

						<div class="mt-3 space-y-1">
							<BreezeResponsiveNavLink
								:href="route('profile.edit')"
								:active="route().current('profile.edit')"
							>
								<div class="flex items-center gap-x-2">
									<svg
										xmlns="http://www.w3.org/2000/svg"
										fill="none"
										viewBox="0 0 24 24"
										stroke-width="1.5"
										stroke="currentColor"
										class="w-6 h-6"
									>
										<path
											stroke-linecap="round"
											stroke-linejoin="round"
											d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"
										/>
									</svg>

									Manage Account
								</div>
							</BreezeResponsiveNavLink>
							<BreezeResponsiveNavLink
								:href="route('orders.index')"
								:active="route().current('orders.index')"
							>
								<div class="flex items-center gap-x-2">
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

									Orders & Returns
								</div>
							</BreezeResponsiveNavLink>
							<BreezeResponsiveNavLink
								:href="route('addresses.index')"
								:active="route().current('addresses.index')"
							>
								<div class="flex items-center gap-x-2">
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
								</div>
							</BreezeResponsiveNavLink>
							<BreezeResponsiveNavLink
								:href="route('logout')"
								method="post"
								as="button"
							>
								<div class="flex items-center gap-2">
									<svg
										xmlns="http://www.w3.org/2000/svg"
										class="h-6 w-6"
										fill="none"
										viewBox="0 0 24 24"
										stroke="currentColor"
										stroke-width="2"
									>
										<path
											stroke-linecap="round"
											stroke-linejoin="round"
											d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
										/>
									</svg>
									Log Out
								</div>
							</BreezeResponsiveNavLink>
						</div>
					</div>

					<div
						v-else
						class="pt-4 pb-1 border-t border-gray-200"
					>
						<BreezeResponsiveNavLink
							:href="route('login')"
							:active="route().current('login')"
						>
							Sign in
						</BreezeResponsiveNavLink>
						<BreezeResponsiveNavLink
							:href="route('register')"
							:active="route().current('register')"
						>
							Create an account
						</BreezeResponsiveNavLink>
					</div>
				</div>
			</nav>

			<!-- Page Heading -->
			<header
				v-if="$slots.header"
				class="bg-white shadow sticky top-0 z-20"
			>
				<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 mt-16">
					<slot name="header" />
				</div>
			</header>

			<!-- Page Content -->
			<main class="flex-1">
				<flash-message />
				<slot />
			</main>

			<!-- page Footer -->
			<footer class="bg-gray-900 text-white">
				<div class="pt-10 lg:pt-20 pb-5">
					<div class="px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto flex flex-col lg:flex-row space-y-10 space-x-0 lg:space-y-0 lg:space-x-32">
						<div>
							<h1 class="text-lg font-bold mb-5">
								Support Menu
							</h1>
							<ul class="space-y-3 text-gray-100">
								<li>About Me</li>
								<li>Contact Us</li>
								<li>My account</li>
								<li>Terms & Condition</li>
							</ul>
						</div>
						<div>
							<h1 class="text-lg font-bold mb-5">
								Customer Services
							</h1>
							<ul class="space-y-3 text-gray-100">
								<li>Shipping</li>
								<li>Returns</li>
								<li>Warranty</li>
								<li>FAQ</li>
								<li>Payments</li>
							</ul>
						</div>
						<div>
							<h1 class="text-lg font-bold mb-5">
								Contact Information
							</h1>
							<ul class="space-y-3 text-gray-100">
								<li class="flex space-x-3 items-center">
									<svg
										height="20"
										aria-hidden="true"
										viewBox="0 0 16 16"
										width="20"
										fill="currentColor"
									>
										<path
											fill-rule="evenodd"
											d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.013 8.013 0 0016 8c0-4.42-3.58-8-8-8z"
										/>
									</svg>
									<a href="https://github.com/ahp-sooyaa">https://github.com/ahp-sooyaa</a>
								</li>
								<li class="flex space-x-3 items-center">
									<svg
										xmlns="http://www.w3.org/2000/svg"
										viewBox="0 0 20 20"
										fill="currentColor"
										width="20"
										height="20"
									>
										<path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
										<path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
									</svg>
									<p>
										apaing894@gmail.com
									</p>
								</li>
							</ul>
						</div>
					</div>
					<hr class="my-10 border border-gray-600">
					<div class="text-center text-sm">
						© 2021 All Right Reserved. Aung Htet Paing.
					</div>
				</div>
			</footer>
		</div>
	</div>
</template>

<script>
import BreezeDropdown from '@/Components/Dropdown.vue'
import BreezeDropdownLink from '@/Components/DropdownLink.vue'
import BreezeNavLink from '@/Components/NavLink.vue'
import BreezeResponsiveNavLink from '@/Components/ResponsiveNavLink.vue'
import CartLink from '@/Components/CartLink'
import FlashMessage from '@/Components/FlashMessage.vue'
import Search from '@/Components/SearchModal'

export default {
    components: {
        BreezeDropdown,
        BreezeDropdownLink,
        BreezeNavLink,
        BreezeResponsiveNavLink,
        CartLink,
        FlashMessage,
        Search
    },

    data() {
        return {
            showingNavigationDropdown: false,
        }
    },
}
</script>
