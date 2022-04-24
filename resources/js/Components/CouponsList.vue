<template>
  <div
    v-for="coupon in coupons"
    :key="coupon.id"
    class="max-w-2xl mb-12 mx-auto"
  >
    <div class="bg-gray-700 flex justify-between px-10 py-5 rounded-2xl text-gray-100">
      <div>
        <h1 class="font-black text-4xl">
          {{ coupon.type == 'Percentage' ? `${coupon.value}%` : formatPrice(coupon.value) }} 
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
        <div class="text-right">
          {{ coupon.pivot.isApplied ? 'Already applied' : '' }}
        </div>
      </div>
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
        }
    },

    created() {
        this.fetchCouponsData()
    },

    methods: {
        fetchCouponsData() {
            axios.get('/coupon')
                .then(res => {
                    console.log(res)
                    this.coupons = res.data
                })
        }
    }
}
</script>

<style lang="scss" scoped>

</style>