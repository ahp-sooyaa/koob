<template>
	<Head>
		<title>Address Setting</title>
		<meta
			head-key="description"
			name="description"
			content="This is address setting page."
		>
	</Head>

	<SettingSideBarLayout>
		<template #header>
			<h2 class="font-semibold text-xl text-gray-800 leading-tight">
				Address Book
			</h2>
			<p class="text-sm text-gray-500 mt-1">
				Add, delete or manage saved addresses to facilitate buying process.
			</p>
		</template>
		
		<div class="w-full max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="group">
                <div class="p-10 flex justify-center rounded-lg border bg-gray-50 text-gray-500 group-hover:text-gray-900 cursor-pointer group-hover:border-gray-900 transform group-hover:-translate-y-1">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 002.25-2.25V6a2.25 2.25 0 00-2.25-2.25H6A2.25 2.25 0 003.75 6v2.25A2.25 2.25 0 006 10.5zm0 9.75h2.25A2.25 2.25 0 0010.5 18v-2.25a2.25 2.25 0 00-2.25-2.25H6a2.25 2.25 0 00-2.25 2.25V18A2.25 2.25 0 006 20.25zm9.75-9.75H18a2.25 2.25 0 002.25-2.25V6A2.25 2.25 0 0018 3.75h-2.25A2.25 2.25 0 0013.5 6v2.25a2.25 2.25 0 002.25 2.25z" />
                    </svg>

                    Add new address
                </div>
            </div>
            <div v-if="addresses.length" class="divide-y space-y-8">
                <div v-for="address in addresses" class="relative pt-8">
                    <h1 class="text-xl font-semibold tracking-wide mb-3">
                        {{ address.label }}
                    </h1>
                    <p class="text-gray-600">
                        {{ address.building }}, {{ address.street }}, {{ address.township }}, {{ address.city }}, {{ address.state }}
                    </p>
                    <div v-if="address.default" class="flex items-center space-x-1 mt-3">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-gray-900">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                        </svg>
                        <span class="inline-block text-sm text-gray-500">
                            Default delivery address
                        </span>
                    </div>
                    <Link :href="route('addresses.edit', address.id)">
                        <BreezeButton class="absolute top-8 right-0">
                            Edit Address
                        </BreezeButton>
                    </Link>
                </div>
            </div>
            <div v-else>
                No address yet!
            </div>
		</div>
	</SettingSideBarLayout>
</template>

<script>
import SettingSideBarLayout from '@/Layouts/SettingSideBar'
import BreezeButton from '@/Components/Button'

export default {
    components: {
        SettingSideBarLayout,
        BreezeButton
    },

    props: ['addresses'],
}
</script>

<style lang="scss" scoped>

</style>
