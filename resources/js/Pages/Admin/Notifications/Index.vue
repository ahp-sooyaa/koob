<template>
	<AdminLayout>
		<template #header>
			<h2 class="font-semibold text-xl text-gray-800 leading-tight">
				Notifications
			</h2>
		</template>
		<div class="my-12 mx-5">
			<div class="flex border-b-2">
				<Link
					:href="route('admin.notifications.index')"
					:class="route().current('admin.notifications.index') ? '-mb-0.5 border-b-2 border-gray-900' : ''"
					class="py-1 px-2"
				>
					All
				</Link>
				<Link
					:href="route('admin.unread-notifications')"
					:class="route().current('admin.unread-notifications') ? '-mb-0.5 border-b-2 border-gray-900' : ''"
					class="py-1 px-2"
				>
					Unread
				</Link>
			</div>
			<div
				v-if="notifications.length"
				class="my-5 space-y-2"
			>
				<div
					v-for="notification in notifications"
					:key="notification.id"
				>
					<div
						@click="readNotification(notification.id)"
						class="bg-gray-100 hover:bg-gray-200 cursor-pointer rounded px-5 py-2"
						v-html="notification.data.message"
					/>
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
	</AdminLayout>
</template>

<script>
import AdminLayout from '@/Layouts/Admin'
export default {
    components: { AdminLayout },

    props: ['notifications', 'unreadNotifications'],

    methods: {
        readNotification(id) {
            this.$inertia.get(route('admin.notifications.show', id))
        },
    },
}
</script>

<style lang="scss" scoped>
</style>