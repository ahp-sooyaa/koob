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
            <div v-if="addresses.length">
                <div class="group cursor-pointer">
                    <Link :href="route('addresses.create')" as="button" class="p-10 flex justify-center rounded-lg border bg-gray-50 text-gray-500 group-hover:text-gray-900 cursor-pointer group-hover:border-gray-900 transform group-hover:-translate-y-1 w-full">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 002.25-2.25V6a2.25 2.25 0 00-2.25-2.25H6A2.25 2.25 0 003.75 6v2.25A2.25 2.25 0 006 10.5zm0 9.75h2.25A2.25 2.25 0 0010.5 18v-2.25a2.25 2.25 0 00-2.25-2.25H6a2.25 2.25 0 00-2.25 2.25V18A2.25 2.25 0 006 20.25zm9.75-9.75H18a2.25 2.25 0 002.25-2.25V6A2.25 2.25 0 0018 3.75h-2.25A2.25 2.25 0 0013.5 6v2.25a2.25 2.25 0 002.25 2.25z" />
                        </svg>

                        Add Address
                    </Link>
                </div>
                <div class="divide-y space-y-8">
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
                        <!-- <Link :href="route('addresses.edit', address.id)">
                            <BreezeButton class="absolute top-8 right-0">
                                Edit Address
                            </BreezeButton>
                        </Link> -->
                        <div class="absolute top-8 right-0">
                            <Dropdown align="right">
                                <template #trigger>
                                    <button class="hover:bg-gray-200 hover:shadow rounded-lg focus:bg-gray-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-8">
                                            <path d="M3 10a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zM8.5 10a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zM15.5 8.5a1.5 1.5 0 100 3 1.5 1.5 0 000-3z" />
                                        </svg>
                                    </button>
                                </template>
                                <template #content>
                                    <DropdownLink :href="route('addresses.edit', address.id)" class="w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out flex gap-1.5 items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                        </svg>

                                        Edit
                                    </DropdownLink>
                                    <DropdownLink :href="route('addresses.destroy', address.id)" method="delete" class="w-full px-4 py-2 text-left text-sm leading-5 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out flex gap-1.5 items-center text-red-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                        </svg>

                                        Delete
                                    </DropdownLink>
                                </template>
                            </Dropdown>
                        </div>
                    </div>
                </div>
            </div>
            <div v-else class="flex flex-col items-center py-10">
                <img src="/images/no-address.svg" alt="No address svg" class="w-52 h-52">
                <h1 class="mt-8 text-xl font-bold text-gray-900 tracking-wide">
                    No address yet!
                </h1>
                <p class="text-sm text-gray-500 mb-5 mt-1">
                    Please add your address for better experience
                </p>
                <Link :href="route('addresses.create')">
                    <BreezeButton>
                        Add Address
                    </BreezeButton>
                </Link>
            </div>
		</div>
	</SettingSideBarLayout>
</template>

<script>
import Dropdown from '@/Components/Dropdown'
import DropdownLink from '@/Components/DropdownLink'
import SettingSideBarLayout from '@/Layouts/SettingSideBar'
import BreezeButton from '@/Components/Button'

export default {
    components: {
        Dropdown,
        DropdownLink,
        SettingSideBarLayout,
        BreezeButton
    },

    props: ['addresses'],
}
</script>

<style lang="scss" scoped>

</style>
