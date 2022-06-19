<template>
	<Head>
		<title>Admin book detail</title>
		<meta
			head-key="description"
			name="description"
			content="This is the book detail page of admin"
		>
	</Head>

	{{ book.title }}
	<img
		:src="book.cover"
		alt="book cover"
	>
</template>

<script>
import AdminLayout from '@/Layouts/Admin'

export default {
    layout: AdminLayout,
    
    props: ['book']
}
</script>

<style lang="scss" scoped>

</style>