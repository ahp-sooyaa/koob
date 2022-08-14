<template>
	<Head>
		<title>Admin dashboard</title>
		<meta
			head-key="description"
			name="description"
			content="This is admin dashboard of koob!"
		>
	</Head>

	<AdminHeader>
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			Dashboard
		</h2>
	</AdminHeader>

	<div class="mt-10 mx-5">
		<div class="grid grid-cols-3 gap-x-5 w-3/5">
			<div class="bg-white p-5 rounded-xl shadow space-y-5">
				<svg
					class="h-10 w-10 fill-current text-gray-700"
					xmlns="http://www.w3.org/2000/svg"
					viewBox="0 0 448 512"
				>
					<path d="M448 336v-288C448 21.49 426.5 0 400 0H96C42.98 0 0 42.98 0 96v320c0 53.02 42.98 96 96 96h320c17.67 0 32-14.33 32-31.1c0-11.72-6.607-21.52-16-27.1v-81.36C441.8 362.8 448 350.2 448 336zM143.1 128h192C344.8 128 352 135.2 352 144C352 152.8 344.8 160 336 160H143.1C135.2 160 128 152.8 128 144C128 135.2 135.2 128 143.1 128zM143.1 192h192C344.8 192 352 199.2 352 208C352 216.8 344.8 224 336 224H143.1C135.2 224 128 216.8 128 208C128 199.2 135.2 192 143.1 192zM384 448H96c-17.67 0-32-14.33-32-32c0-17.67 14.33-32 32-32h288V448z" />
				</svg>
				<div>
					<div class="font-bold text-2xl">
						{{ booksCount }}
					</div>
					<h1 class="text-md text-gray-500">
						Total Books
					</h1>
				</div>
			</div>
			<div class="bg-white p-5 rounded-xl shadow space-y-5">
				<svg
					class="h-10 w-10 fill-current text-gray-700"
					xmlns="http://www.w3.org/2000/svg"
					viewBox="0 0 384 512"
				>
					<path d="M384 128h-128V0L384 128zM256 160H384v304c0 26.51-21.49 48-48 48h-288C21.49 512 0 490.5 0 464v-416C0 21.49 21.49 0 48 0H224l.0039 128C224 145.7 238.3 160 256 160zM64 88C64 92.38 67.63 96 72 96h80C156.4 96 160 92.38 160 88v-16C160 67.63 156.4 64 152 64h-80C67.63 64 64 67.63 64 72V88zM72 160h80C156.4 160 160 156.4 160 152v-16C160 131.6 156.4 128 152 128h-80C67.63 128 64 131.6 64 136v16C64 156.4 67.63 160 72 160zM197.5 316.8L191.1 315.2C168.3 308.2 168.8 304.1 169.6 300.5c1.375-7.812 16.59-9.719 30.27-7.625c5.594 .8438 11.73 2.812 17.59 4.844c10.39 3.594 21.83-1.938 25.45-12.34c3.625-10.44-1.891-21.84-12.33-25.47c-7.219-2.484-13.11-4.078-18.56-5.273V248c0-11.03-8.953-20-20-20s-20 8.969-20 20v5.992C149.6 258.8 133.8 272.8 130.2 293.7c-7.406 42.84 33.19 54.75 50.52 59.84l5.812 1.688c29.28 8.375 28.8 11.19 27.92 16.28c-1.375 7.812-16.59 9.75-30.31 7.625c-6.938-1.031-15.81-4.219-23.66-7.031l-4.469-1.625c-10.41-3.594-21.83 1.812-25.52 12.22c-3.672 10.41 1.781 21.84 12.2 25.53l4.266 1.5c7.758 2.789 16.38 5.59 25.06 7.512V424c0 11.03 8.953 20 20 20s20-8.969 20-20v-6.254c22.36-4.793 38.21-18.53 41.83-39.43C261.3 335 219.8 323.1 197.5 316.8z" />
				</svg>
				<div>
					<div class="font-bold text-2xl">
						{{ ordersCount }}
					</div>
					<h1 class="text-md text-gray-500">
						Delivered Orders
					</h1>
				</div>
			</div>
			<div class="bg-white p-5 rounded-xl shadow space-y-5">
				<svg
					class="h-10 w-10 fill-current text-gray-700"
					xmlns="http://www.w3.org/2000/svg"
					viewBox="0 0 20 20"
					fill="currentColor"
				>
					<path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
				</svg>
				<div>
					<div class="font-bold text-2xl">
						{{ usersCount }}
					</div>
					<h1 class="text-md text-gray-500">
						Registered Users
					</h1>
				</div>
			</div>
		</div>
		<div class="flex space-x-5 mt-10">
			<div class="w-1/2 h-98">
				<h1 class="mb-3 font-semibold tracking-wider">
					Total Orders In {{ moment().format('YYYY') }}
				</h1>
				<Chart
					type="line"
					:labels="monthLabels"
					:datasets="[
						{
							label: 'Orders',
							backgroundColor: 'rgb(255, 255, 255)',
							hoverBackgroundColor: 'rgb(255, 99, 132)',
							borderColor: 'rgb(255, 99, 132)',
							data: orderDataSets,
							saleData: saleDataSets,
							tension: 0.3,
						},
					]"
				/>
			</div>
			<div class="w-1/2 h-98">
				<h1 class="mb-3 font-semibold tracking-wider">
					Registered Users In {{ moment().format('YYYY') }}
				</h1>
				<Chart
					type="line"
					:labels="monthLabels"
					:datasets="[
						{
							label: 'Registered Users',
							backgroundColor: 'rgb(255, 255, 255)',
							hoverBackgroundColor: 'rgb(99, 208, 255)',
							borderColor: 'rgb(99, 208, 255)',
							data: userDataSets,
							tension: 0.3,
						}
					]"
				/>
			</div>
		</div>
	</div>
</template>

<script>
import AdminLayout from '@/Layouts/Admin'
import AdminHeader from '@/Components/AdminHeader'
import Chart from '@/Components/Chart'
import moment from 'moment'

export default {
    components: { AdminHeader, Chart },

    layout: AdminLayout,

    props: [
        'booksCount',
        'ordersCount',
        'usersCount',
        'userDataSets',
        'orderDataSets',
        'saleDataSets',
    ],

    data() {
        return {
            moment: moment,
            monthLabels: [
                'January',
                'February',
                'March',
                'April',
                'May',
                'June',
                'July',
                'August',
                'September',
                'October',
                'November',
                'December'
            ],
        }
    },

    // computed: {
    //     currentYear() {
    //         return moment().format('YYYY')
    //     }
    // }
}
</script>
