<template>
	<Head>
		<title>Admin</title>
		<meta
			head-key="description"
			name="description"
			content="This is the default description"
		>
	</Head>
	<flash-message />
	<div class="flex flex-row min-h-screen">
		<div class="bg-gray-900 flex-shrink-0 self-start sticky text-white top-0 w-64">
			<div class="flex flex-col min-h-screen p-6">
				<Link
					:href="route('welcome')"
					class="font-black uppercase mb-5 text-2xl text-white"
				>
					<svg
						width="54"
						height="18"
						viewBox="0 0 54 18"
						fill="none"
						xmlns="http://www.w3.org/2000/svg"
					>
						<path
							d="M0.856506 18V0.545441H2.83804V9.20453H3.0298L10.3806 0.545441H12.9694L6.09798 8.42045L12.9694 18H10.5724L4.8835 9.88635L2.83804 12.3409V18H0.856506Z"
							fill="currentColor"
						/>
						<path
							d="M43 18V1H48.5309C49.6329 1 50.5418 1.20475 51.2577 1.61426C51.9735 2.01823 52.5066 2.56331 52.8568 3.24951C53.2069 3.93018 53.382 4.68554 53.382 5.51562C53.382 6.24609 53.2609 6.84928 53.0189 7.3252C52.7821 7.8011 52.4679 8.1774 52.0765 8.45411C51.6903 8.7308 51.2706 8.93555 50.8174 9.06835V9.23438C51.3014 9.26758 51.7882 9.4502 52.2774 9.78223C52.7666 10.1143 53.176 10.5902 53.5057 11.21C53.8352 11.8297 54 12.5879 54 13.4844C54 14.3366 53.8198 15.103 53.4592 15.7837C53.0988 16.4644 52.5297 17.0039 51.7521 17.4023C50.9745 17.8007 49.9626 18 48.7162 18H43ZM44.9157 16.1738H48.7162C49.9677 16.1738 50.8561 15.9138 51.3813 15.3936C51.9117 14.8679 52.177 14.2315 52.177 13.4844C52.177 12.9088 52.0405 12.3776 51.7675 11.8906C51.4946 11.3981 51.1058 11.0052 50.6011 10.7119C50.0964 10.4131 49.499 10.2637 48.809 10.2637H44.9157V16.1738ZM44.9157 8.4707H48.4691C49.0459 8.4707 49.566 8.34895 50.0294 8.10547C50.4981 7.86198 50.8689 7.51888 51.1419 7.07617C51.4199 6.63346 51.559 6.11329 51.559 5.51562C51.559 4.76856 51.3169 4.13493 50.8329 3.61474C50.3488 3.08903 49.5814 2.82618 48.5309 2.82618H44.9157V8.4707Z"
							fill="currentColor"
						/>
						<path
							d="M25.3124 8.4C25.3124 11.3298 22.8457 13.8 19.6874 13.8C16.5292 13.8 14.0624 11.3298 14.0624 8.4C14.0624 5.4702 16.5292 3 19.6874 3C22.8457 3 25.3124 5.4702 25.3124 8.4Z"
							stroke="currentColor"
						/>
						<path
							d="M39.9375 6.00001C39.9375 8.92981 37.4707 11.4 34.3125 11.4C31.1543 11.4 28.6875 8.92981 28.6875 6.00001C28.6875 3.07021 31.1543 0.600006 34.3125 0.600006C37.4707 0.600006 39.9375 3.07021 39.9375 6.00001Z"
							stroke="currentColor"
						/>
						<path
							d="M19.125 17.4H34.875"
							stroke="currentColor"
						/>
					</svg>
				</Link>
				<div class="text-center">
					<div class="text-base">
						{{ $page.props.auth.user.name }}
					</div>

					<div class="text-sm text-gray-400">
						{{ $page.props.auth.user.email }}
					</div> 
				</div>

				<div class="flex-1 flex flex-col mt-8">
					<div class="flex-1">
						<Link
							:href="route('admin.dashboard')"
							class="py-2 block hover:text-white"
							:class="[route().current('admin.dashboard') ? 'text-white' : 'text-gray-400']"
						>
							Dashboard
						</Link>

						<Link
							:href="route('admin.notifications.index')"
							class="py-2 block hover:text-white"
							:class="[route().current('notifications.index') ? 'text-white' : 'text-gray-400']"
						>
							Notifications
						</Link>
            
						<AdminDropDown
							align="right"
							width="48"
						>
							<template #trigger>
								<span class="rounded-md">
									<button
										type="button"
										class="inline-flex justify-between duration-150 ease-in-out focus:outline-none font-medium leading-4 py-2 text-left hover:text-white transition w-full"
										:class="[$page.url.startsWith('/admin/books') ? 'text-white' : 'text-gray-400']"
									>
										Manage Books

										<svg
											class="ml-2 -mr-0.5 h-4 w-4"
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
								<Link
									:href="route('admin.books.index')"
									class="block border-l-2 duration-150 ease-in-out focus:outline-none leading-5 px-4 py-2 text-left text-sm transition w-full hover:text-white hover:border-white"
									:class="[$page.component == 'Admin/Books/Index' ? 'text-white border-white' : 'text-gray-500 border-gray-500']"
								>
									Books list
								</Link>
								<Link
									:href="route('admin.books.create')"
									class="block border-l-2 duration-150 ease-in-out focus:outline-none leading-5 px-4 py-2 text-left text-sm transition w-full hover:text-white hover:border-white"
									:class="[$page.component == 'Admin/Books/Create' ? 'text-white border-white' : 'text-gray-500 border-gray-500']"
								>
									Create Books
								</Link>
                
								<!-- <Link
                  :href="route('admin.books.show')"
                  class="block border-l-2 duration-150 ease-in-out focus:outline-none leading-5 px-4 py-2 text-left text-sm transition w-full"
                  :class="[$page.component == 'Admin/Books/Show' ? 'text-white border-white' : 'text-gray-500 border-gray-500']"
                >
                  Show Books
                </Link> -->
							</template>
						</AdminDropDown>

						<AdminDropDown
							align="right"
							width="48"
						>
							<template #trigger>
								<span class="rounded-md">
									<button
										type="button"
										class="inline-flex justify-between duration-150 ease-in-out focus:outline-none font-medium leading-4 py-2 text-left hover:text-white transition w-full"
										:class="[$page.url.startsWith('/admin/orders') ? 'text-white' : 'text-gray-400']"
									>
										Manage Orders

										<svg
											class="ml-2 -mr-0.5 h-4 w-4"
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
								<Link
									:href="route('admin.orders.index')"
									class="block border-l-2 duration-150 ease-in-out focus:outline-none leading-5 px-4 py-2 text-left text-sm transition w-full hover:text-white hover:border-white"
									:class="[$page.component == 'Admin/Orders/Index' ? 'text-white border-white' : 'text-gray-500 border-gray-500']"
								>
									Orders
								</Link>
							</template>
						</AdminDropDown>

						<AdminDropDown
							align="right"
							width="48"
						>
							<template #trigger>
								<span class="rounded-md">
									<button
										type="button"
										class="inline-flex justify-between duration-150 ease-in-out focus:outline-none font-medium leading-4 py-2 text-left hover:text-white transition w-full"
										:class="[$page.url.startsWith('/admin/coupons') ? 'text-white' : 'text-gray-400']"
									>
										Manage Coupons

										<svg
											class="ml-2 -mr-0.5 h-4 w-4"
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
								<Link
									:href="route('admin.coupons.index')"
									class="block border-l-2 duration-150 ease-in-out focus:outline-none leading-5 px-4 py-2 text-left text-sm transition w-full hover:text-white hover:border-white"
									:class="[$page.component == 'Admin/Coupons/Index' ? 'text-white border-white' : 'text-gray-500 border-gray-500']"
								>
									Coupons
								</Link>
								<Link
									:href="route('admin.coupons.create')"
									class="block border-l-2 duration-150 ease-in-out focus:outline-none leading-5 px-4 py-2 text-left text-sm transition w-full hover:text-white hover:border-white"
									:class="[$page.component == 'Admin/Coupons/Create' ? 'text-white border-white' : 'text-gray-500 border-gray-500']"
								>
									Generate Coupons
								</Link>
							</template>
						</AdminDropDown>
					</div>
          
					<Link
						:href="route('logout')"
						method="post"
						as="button"
						class="self-start py-2 text-left text-gray-400 hover:text-white"
					>
						LogOut
					</Link>
				</div>
			</div>
		</div>
		<div class="flex-1 bg-gray-50">
			<header class="flex justify-between bg-white p-5 shadow">
				<h2 class="font-semibold text-xl text-gray-800 leading-tight">
					<slot name="header" />
				</h2>

				<BreezeDropdown
					align="right"
					width="72"
				>
					<template #trigger>
						<div class="relative cursor-pointer">
							<svg
								xmlns="http://www.w3.org/2000/svg"
								class="h-6 w-6 text-gray-400 hover:text-gray-500"
								fill="none"
								viewBox="0 0 24 24"
								stroke="currentColor"
								stroke-width="2"
							>
								<path
									stroke-linecap="round"
									stroke-linejoin="round"
									d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"
								/>
							</svg>
							<span
								v-if="$page.props.unreadNotifications.length"
								class="absolute top-0 -right-0.5 flex h-3 w-3"
							>
								<span class="animate-ping absolute inline-flex h-3 w-3 rounded-full bg-red-400 opacity-75" />
								<span class="relative inline-flex rounded-full h-3 w-3 bg-red-500" />
							</span>
						</div>
					</template>

					<template #content>
						<div class="px-5 py-4">
							<div class="flex justify-between items-baseline">
								<h1>Notifications</h1>
								<Link
									:href="route('admin.notifications.index')"
									class="text-xs hover:underline"
								>
									See all
								</Link>
							</div>
							<div v-if="$page.props.unreadNotifications.length">
								<div
									v-for="unreadNotification in $page.props.unreadNotifications"
									:key="unreadNotification"
								>
									<BreezeDropdownLink
										:href="route('admin.notifications.show', unreadNotification.id)"
										as="button"
										class="rounded mt-3"
									>
										<span v-html="unreadNotification.data.message" />
									</BreezeDropdownLink>
								</div>
							</div>
							<div
								v-else
								class="bg-gray-300 mt-3 py-2 rounded text-center text-gray-500 text-sm"
							>
								no unread notifications
							</div>
						</div>
					</template>
				</BreezeDropdown>
			</header>

			<slot />
		</div>
	</div>
</template>

<script>
import AdminDropDown from '@/Pages/Admin/AdminDropDown'
import FlashMessage from '@/Components/FlashMessage'
import BreezeDropdown from '@/Components/Dropdown'
import BreezeDropdownLink from '@/Components/DropdownLink'
export default {
    components: {
        AdminDropDown,
        FlashMessage,
        BreezeDropdown,
        BreezeDropdownLink
    },
}
</script>

<style lang="scss" scoped>

</style>