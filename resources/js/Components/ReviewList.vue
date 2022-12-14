<template>
	<div class="w-1/3 flex-shrink-0">
        <h1 class="text-xl mb-3">Average Rating</h1>
        <div class="text-4xl">{{ averageRating }} <span class="text-sm text-gray-600 -ml-2">out of 5</span></div>

        <div class="inline-flex mb-5 text-red-500">
            <svg v-for="rating in averageRating" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd" />
            </svg>
            <svg v-for="rating in (5 - parseInt(averageRating))" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
            </svg>
        </div>

        <div class="text-sm text-gray-900 space-y-2 tabular-nums slashed-zero">
            <div v-for="index in 5" class="flex items-baseline justify-between">
                <div class="w-14">{{ index }} star</div>
                <div class="flex-1 bg-white shadow border p-0.5 rounded-full">
                    <div class="bg-gray-900 rounded-full h-2" :style="'width: ' + percentageOfStar(index) + '%'"></div>
                </div>
                <p class="w-12 text-right">{{ percentageOfStar(index) }}%</p>
            </div>
        </div>
    </div>
    <div class="w-full">
        <div class="text-gray-700">
            <label for="rating" class="block mb-1">Your ratings</label>
            <div class="flex mb-3">
                <div
                    v-for="index in 5" 
                    :key="index" 
                    @click="selectedRating = index" 
                    @mouseover="hoverRating = index" 
                    @mouseleave="hoverRating = 1"
                >
                    <svg 
                        xmlns="http://www.w3.org/2000/svg" 
                        :fill="[selectedRating >= index || hoverRating >= index ? 'currentColor' : 'none']" 
                        viewBox="0 0 24 24" 
                        stroke-width="1.5" 
                        stroke="currentColor" 
                        class="w-5 h-5 cursor-pointer text-red-500"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                    </svg>
                </div>
            </div>

            <label for="review" class="block mb-1">Your review</label>
            <textarea v-model="review" name="review" id="review" cols="35" rows="5" class="rounded-2xl text-sm p-5 mb-5 block"></textarea>

            <Button @click="submitReview()">Submit review</Button>
        </div>
        <div class="mt-20 space-y-10">
            <div v-for="review in reviews" class="flex space-x-5 items-start">
                <img :src="review.user.profile_photo_url" alt="" class="flex-shrink-0 w-14 h-14">
                <div class="w-full">
                    <div class="flex justify-between">
                        <div>
                            <h1 class="font-bold -mb-1">{{ review.user.name }}</h1>
                            <span class="text-xs text-gray-500">reviewed on {{ formatDate(review.created_at) }}</span>
                            <span class="text-gray-500 mx-1">&CenterDot;</span>
                            <span class="text-xs text-gray-700">verified purchase</span>
                        </div>
                        <div class="flex mb-5 text-red-500">
                            <svg v-for="rating in parseInt(review.rating)" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                                <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd" />
                            </svg>

                            <svg v-for="emptyStar in parseInt(5 - review.rating)" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                            </svg>
                        </div>
                    </div>
                    <p v-if="! review.approved_at" class="rounded-xl px-5 py-2 mt-1 text-sm font-light bg-white shadow border">
                        This is a pending comment that is awaiting approval.
                    </p>
                    <p class="mt-2 text-gray-700">
                        {{ review.review }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import format from '@/mixins/format'
import Dropdown from '@/Components/Dropdown'
import Button from '@/Components/Button'
import axios from 'axios'

export default {
    components: { 
        Dropdown,
        Button,
    },

    props: ['bookId', 'reviewList', 'ratings'],

    mixins: [format],

    data() {
        return {
            reviews: this.reviewList,
            hoverRating: 1,
            selectedRating: 1,
            review: this.reviewList.filter(review => review.user_id === this.$page.props.auth.user.id)[0].review ?? '',
        }
    },

    computed: {
        averageRating() {
            var total = 0
            // var total = this.reviews.reduce((total, value) => total + parseInt(value.rating))

            for (var i = 0; i < this.reviews.length; i++) {
                total += parseInt(this.reviews[i].rating);
            }

            var average = total / this.reviews.length

            return average.toFixed(1)
        },
    },

    methods: {
        percentageOfStar(star) {
            var total = Object.values(this.ratings).reduce((total, value) => total + value);
            
            if (this.ratings[star]) {
                return Math.round((this.ratings[star] / total) * 100)
            }

            return 0
        },

        submitReview() {
            axios.post(route('reviews.store'), {
                bookId: this.bookId,
                rating: this.selectedRating,
                review: this.review,
            })
            .then(() => window.flash('good'))
            .catch(() => window.flash('bad', 'error'))
        }
    }
}
</script>
