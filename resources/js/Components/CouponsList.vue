<template>
	<div class="max-w-2xl mx-auto mb-12">
		<h1 class="max-w-sm mx-auto text-gray-700 text-center mb-4">
			All of your <b>saved coupons</b> which are still valid and <b>gifted coupons</b> from us will appear here.
		</h1>
		<div class="flex items-center justify-between relative mb-10">
			<input
				v-model="code"
				type="text"
				placeholder="coupon code"
				class="rounded-2xl w-full focus:ring-0 focus:border-black"
			>
			<div
				@click="saveCoupon"
				class="absolute bg-gray-800 px-7 py-2 right-0 rounded-2xl"
				:class="code ? 'cursor-pointer text-gray-100' : 'opacity-50 cursor-default text-gray-500'"
			>
				Save
			</div>
		</div>
		<div v-if="Object.keys(coupons).length">
			<div
				v-for="coupon in coupons"
				:key="coupon.id"
			>
				<div class="bg-gray-700 flex justify-between px-10 py-5 rounded-2xl text-gray-100">
					<div>
						<h1 class="font-black text-4xl">
							{{ coupon.type === 'Percentage' ? `${coupon.value}%` : `$${coupon.value}` }}
							<span class="uppercase">off</span>
						</h1>
						<div class="text-gray-400 mb-4">
							Coupon expire at <span class="text-gray-200">{{ formatDate(coupon.expired_at) }}</span>
						</div>
						<div class="font-semibold text-xl">
							{{ coupon.program_name }}
						</div>
					</div>
					<div class="flex flex-col justify-between">
						<div class="-mr-10 bg-gradient-to-r from-gray-700 px-10 py-1 rounded to-gray-700 via-gray-500 shadow font-bold tracking-wider">
							{{ coupon.code }}
						</div>
						<!-- <div class="text-right">
              {{ coupon.pivot.isApplied ? 'Already applied' : '' }}
            </div> -->
					</div>
				</div>
			</div>
		</div>
		<div
			v-else
			class="text-gray-500 text-center"
		>
			<h1>You don't have saved coupon yet!</h1>
		</div>
	</div>
</template>

<script>
import axios from 'axios'
import format from '@/mixins/format'
export default {
    mixins: [format],

    data() {
        return {
            coupons: '',
            code: ''
        }
    },

    created() {
        this.fetchCouponsData()
    },

    methods: {
        fetchCouponsData() {
            axios.get(route('coupons.index'))
                .then(res => this.coupons = res.data)
        },

        saveCoupon() {
            if (!this.code || this.code.trim() === null) return

            axios
                .post(route('coupons.store'), {code: this.code})
                .then(res => {
                    this.coupons.push(res.data.coupon)
                    this.code = ''
                    flash(res.data.message)
                })
                .catch(err => flash(err.response.data.message, 'error'))
        },
    }
}
</script>

<style lang="scss" scoped>

</style>
