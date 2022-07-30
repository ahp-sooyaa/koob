<template>
	<AdminHeader>
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			Notifications
		</h2>
	</AdminHeader>

	<div class="w-2/3 my-12 mx-5">
		<div class="flex border-b-2">
			<Link
				:href="route('admin.notifications.index')"
				:class="route().current('admin.notifications.index') ? '-mb-0.5 border-b-2 border-gray-900 text-gray-700' : 'text-gray-500'"
				class="py-1 px-5 flex items-center"
			>
				All
				<span
					class="ml-1 px-1.5 py-0.5 rounded-full text-xs"
					:class="route().current('admin.notifications.index') ? 'bg-gray-900 text-white' : 'bg-gray-500 text-gray-200'"
				>
					{{ notifications.length }}
				</span>
			</Link>
			<Link
				:href="route('admin.unread-notifications')"
				:class="route().current('admin.unread-notifications') ? '-mb-0.5 border-b-2 border-gray-900 text-gray-700' : 'text-gray-500'"
				class="py-1 px-5 flex items-center"
			>
				Unread
				<span
					class="ml-1 px-1.5 py-0.5 rounded-full text-xs"
					:class="route().current('admin.unread-notifications') ? 'bg-gray-900 text-white' : 'bg-gray-500 text-gray-200'"
				>
					{{ unreadNotifications.length }}
				</span>
			</Link>
		</div>
		<div
			v-if="notifications.length"
			class="my-5 space-y-2 divide-y"
		>
			<div
				v-for="(notification, index) in notifications"
				:key="notification.id"
			>
				<div
					@click="readNotification(notification.id)"
					class="flex items-baseline justify-between hover:bg-gray-100 cursor-pointer rounded px-5 py-2"
					:class="index !== 0 ? 'mt-2' : ''"
				>
					<span v-html="notification.data.message" />
					<span class="text-sm">
						{{ formatDate(notification.created_at) }}
					</span>
				</div>
			</div>
		</div>
		<div
			v-else
			class="my-5 text-sm text-gray-500 text-center"
		>
			<span v-show="route().current('admin.notifications.index')">
				You don't have any notifications yet!
			</span>
			<span v-show="route().current('admin.unread-notifications')">
				You have read all notifications!
			</span>
		</div>
	</div>
</template>

<script>
import AdminLayout from '@/Layouts/Admin'
import AdminHeader from '@/Components/AdminHeader'
import format from '@/mixins/format'
export default {
    components: { AdminHeader },

    mixins: [format],

    layout: AdminLayout,

    props: ['notifications', 'unreadNotifications'],

    methods: {
        readNotification(id) {
            this.$inertia.get(route('admin.notifications.show', id))
        },
    }
}
</script>

<style lang="scss" scoped>
</style>
