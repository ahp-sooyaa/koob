<template>
	<header class="flex justify-between bg-white p-5 shadow">
		<slot />

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
						v-if="unreadNotifications.length"
						class="absolute top-0.5 right-0.5 flex h-2 w-2"
					>
						<span
							class="animate-ping absolute inline-flex h-2 w-2 rounded-full bg-red-400 opacity-75"
						/>
						<span
							class="relative inline-flex rounded-full h-2 w-2 bg-red-500"
						/>
					</span>
				</div>
			</template>

			<template #content>
				<div class="px-5 py-4">
					<div class="flex justify-between items-baseline pb-3">
						<h1>Notifications</h1>
						<Link
							:href="route('admin.notifications.index')"
							class="text-xs hover:underline"
						>
							See all
						</Link>
					</div>
					<div
						v-if="unreadNotifications.length"
						class="max-h-96 overflow-y-auto"
					>
						<div
							v-for="(unreadNotification, index) in unreadNotifications"
							:key="unreadNotification"
						>
							<BreezeDropdownLink
								:href="route('admin.notifications.show', unreadNotification.id)"
								as="button"
								class="rounded"
								:class="index === 0 ? '' : 'mt-3'"
							>
								<span
									v-html="unreadNotification.data.message"
								/>
							</BreezeDropdownLink>
						</div>
					</div>
					<div
						v-else
						class="bg-gray-300 mt-3 py-2 rounded text-center text-gray-500 text-sm"
					>
						No unread notifications
					</div>
				</div>
			</template>
		</BreezeDropdown>
	</header>
</template>

<script>
import BreezeDropdown from '@/Components/Dropdown'
import BreezeDropdownLink from '@/Components/DropdownLink'

export default {
    components: {
        BreezeDropdown,
        BreezeDropdownLink,
    },

    data() {
        return {
            unreadNotifications: this.$page.props.auth.user.unread_notifications ?? []
        }
    },
}
</script>