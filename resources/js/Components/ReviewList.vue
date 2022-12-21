<template>
	<div class="w-1/3 flex-shrink-0">
        <div class="flex">
            <div class="mr-5">
                <div class="text-4xl bg-red-500 text-white p-3 mb-3 rounded-md grid place-items-center">
                    {{ averageRating }} 
                    <div class="text-sm text-red-300">out of 5</div>
                </div>

                <div class="inline-flex mb-5 text-red-500">
                    <svg v-for="rating in parseInt(averageRating)" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                        <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd" />
                    </svg>
                    <svg v-for="rating in (5 - parseInt(averageRating))" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                    </svg>
                </div>
            </div>

            <div class="text-sm text-gray-900 space-y-2 tabular-nums slashed-zero w-96">
                <div v-for="index in 5" class="flex items-baseline justify-between">
                    <div class="mr-2">{{ index }} star</div>
                    <div class="flex-1 bg-white shadow border rounded-full">
                        <div class="bg-red-500 rounded-full h-2" :style="'width: ' + percentageOfStar(index) + '%'"></div>
                    </div>
                    <p class="w-10 text-right">{{ percentageOfStar(index) }}%</p>
                </div>
            </div>
        </div>
    </div>
    <div class="w-full">
        <div v-if="$page.props.auth.user" class="text-gray-700 flex flex-col">
            <div class="flex items-center space-x-2">
                <label for="rating" class="text-gray-700">Your rating:</label>
                <div class="flex">
                    <div
                        v-for="index in 5" 
                        :key="index" 
                        @click="selectedRating = index" 
                        @mouseover="hoverRating = index" 
                        @mouseleave="hoverRating = 0"
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
            </div>
            <BreezeInputError
                :message="errors.rating ? errors.rating[0] : ''"
            />

            <textarea v-model="review" name="review" id="review" cols="35" rows="5" class="rounded-2xl text-sm p-5 mt-4 mb-2 block border border-gray-300 focus:border-gray-500 focus:ring focus:ring-gray-300" placeholder="Share your experience"></textarea>
            <BreezeInputError
                :message="errors.review ? errors.review[0] : ''"
            />

            <BreezeButton @click="submitReview()" v-text="authUserReview ? 'Update review' : 'Submit review'" class="ml-auto"/>
        </div>
        <div v-else class="flex justify-center space-x-2 rounded-md p-3 text-gray-700 text-sm tracking-widest">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m0-10.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.75c0 5.592 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.57-.598-3.75h-.152c-3.196 0-6.1-1.249-8.25-3.286zm0 13.036h.008v.008H12v-.008z" />
            </svg>

            <span>
                Please <Link :href="route('login')" class="underline hover:text-gray-900 font-semibold">login</Link> first to give review & rating.
            </span>
        </div>
        <div v-if="reviews.length > 0" class="mt-10 space-y-5">
            <div v-for="review in reviews" class="w-full bg-white p-5 rounded-lg border">
                <div v-if="! review.approved_at || review.id === authUserReview?.id" class="flex justify-between px-5 py-2 text-sm font-light mb-5 -mx-5 -mt-5 border-b rounded-t-lg bg-gray-50">
                    <p v-if="! review.approved_at" class="flex items-end">
                        Your review is awaiting approval.
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 text-gray-900">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zM8.94 6.94a.75.75 0 11-1.061-1.061 3 3 0 112.871 5.026v.345a.75.75 0 01-1.5 0v-.5c0-.72.57-1.172 1.081-1.287A1.5 1.5 0 108.94 6.94zM10 15a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                        </svg>
                    </p>
                    <div v-if="review.id === authUserReview?.id" @click="deleteReview(review.id)" class="ml-auto text-xs tracking-widest border border-gray-300 rounded-full px-2 hover:border-gray-500 cursor-pointer hover:bg-gray-300">
                        delete
                    </div>
                </div>
                <div class="flex justify-between">
                    <div class="flex space-x-3">
                        <img :src="review.user.profile_photo_url" alt="" class="flex-shrink-0 w-10 h-10">
                        <div>
                            <h1 class="font-bold -mb-1">{{ review.user.name }}</h1>
                            <span class="text-xs text-gray-500">reviewed on {{ formatDate(review.created_at) }}</span>
                            <span class="text-gray-500 mx-1">&CenterDot;</span>
                            <span class="text-xs text-gray-700">verified purchase</span>
                        </div>
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
                
                <p class="mt-2 text-gray-700">
                    {{ review.review }}
                </p>
            </div>
        </div>
        <div v-else class="mt-10 text-center">
            <img src="/images/not-found.svg" alt="Not found svg" class="w-32 h-32 mx-auto">
            <h1 class="mt-8 text-xl font-bold text-gray-900 tracking-wide">
                Woh! No Rating Yet.
            </h1>
            <p class="text-sm text-gray-500 mb-5 mt-1 w-72 mx-auto">
                Submit review & rating for the first time.
            </p>
        </div>
    </div>
</template>

<script>
import format from '@/mixins/format'
import BreezeDropdown from '@/Components/Dropdown'
import BreezeButton from '@/Components/Button'
import BreezeInputError from '@/Components/InputError'
import axios from 'axios'

export default {
    components: { 
        BreezeDropdown,
        BreezeButton,
        BreezeInputError,
    },

    props: ['bookId'],

    mixins: [format],

    data() {
        return {
            reviews: [],
            ratings: [],
            hoverRating: 0,
            selectedRating: 0,
            review: '',
            authUserReview: '',
            errors: {},
        }
    },

    created() {
        this.fetchReviewsAndRatings()
    },

    computed: {
        averageRating() {
            if (! Object.values(this.ratings).length) {
                return 0.0
            }

            let totalScore = 0, totalResponse = 0

            for (const star in this.ratings) {
                totalScore += parseInt(this.ratings[star] * star);
                totalResponse += parseInt(this.ratings[star]);
            }
            let average = totalScore / totalResponse

            return average.toFixed(1)
        },
    },

    methods: {
        fetchReviewsAndRatings() {
            axios.get(route('books.reviews.index', this.bookId))
                .then((res) => {
                    this.reviews = res.data.reviews
                    this.ratings = res.data.ratings

                    let authUser = this.$page.props.auth.user
                    if (authUser) {
                        this.authUserReview = this.reviews.find(review => review.user.id === authUser.id)
                        this.review = this.authUserReview?.review
                        this.selectedRating = this.authUserReview?.rating
                    }
                })
                .catch((err) => {
                    console.log(err)
                })
        },

        percentageOfStar(star) {
            if (this.ratings[star] && Object.values(this.ratings).length) {
                var total = Object.values(this.ratings).reduce((total, value) => total + value);
            
                return Math.round((this.ratings[star] / total) * 100)
            }

            return 0
        },

        submitReview() {
            let method = this.authUserReview ? 'patch' : 'post'
            let url = this.authUserReview ? route('reviews.update', this.authUserReview.id) : route('books.reviews.store', this.bookId)

            axios({
                method : method,
                url: url,
                data: {
                    book_id: this.bookId,
                    rating: this.selectedRating,
                    review: this.review,
                }
            })
            .then((res) => {
                this.fetchReviewsAndRatings()
                window.flash(res.data.message)
            })
            .catch((err) => {
                this.errors = err.response.data.errors
                window.flash(err.response.data.message, 'error')
            })
        },

        deleteReview(id) {
            axios.delete(route('reviews.destroy', id))
                .then(res => {
                    this.fetchReviewsAndRatings()
                    window.flash(res.data.message)
                })
                .catch(err => window.flash(err.response.data.message, 'error'))
        }
    }
}
</script>
