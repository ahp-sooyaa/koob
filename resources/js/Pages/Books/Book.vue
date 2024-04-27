<template>
    <div class="flex space-x-5">
        <img
            :src="data.cover_url"
            :alt="data.title + '\'s cover image'"
            class="mb-5 h-44 w-32 flex-shrink-0 object-cover shadow-xl sm:mx-auto md:h-56 md:w-44"
        />
        <div class="flex-1 sm:hidden">
            <Link
                :href="'books/' + data.slug"
                class="text-lg font-semibold line-clamp-2 hover:underline lg:text-sm"
            >
                {{ data.title }}
            </Link>
            <div class="mt-2 mb-auto mr-3 text-lg text-gray-700 lg:text-sm">
                <span v-if="data.promotion" class="text-gray-500 line-through">{{ formatPrice(data.price) }}</span>
                {{ price }}
            </div>
        </div>
    </div>
    <div class="flex flex-1 flex-col px-1">
        <Link
            :href="'books/' + data.slug"
            class="hidden text-lg font-semibold hover:underline sm:block sm:line-clamp-2 lg:text-sm"
        >
            {{ data.title }}
        </Link>
        <div
            class="mt-2 mb-auto mr-3 hidden text-lg text-gray-700 sm:block lg:text-sm"
        >
            <span v-if="data.promotion" class="text-gray-400 line-through">{{ formatPrice(data.price) }}</span>
            {{ price }}
        </div>
        <div
            v-if="data.stock_count"
            class="mt-3 flex justify-between space-x-3"
        >
            <div
                class="flex flex-1 cursor-pointer items-center justify-center rounded-xl border bg-gray-700 px-5 text-sm text-white shadow-md hover:shadow-none"
                dusk="buyNow"
                @click="buyNow"
            >
                Buy Now
            </div>
            <div
                class="relative flex h-14 w-14 cursor-pointer items-center rounded-xl border bg-gray-200 shadow hover:shadow-none lg:h-11 lg:w-12"
                dusk="addToCart"
                @click="addToCart"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-8 w-12"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"
                    />
                </svg>
                <svg
                    v-if="!isAdded"
                    xmlns="http://www.w3.org/2000/svg"
                    class="absolute right-1.5 top-1.5 h-5 w-5 rounded-full bg-white text-gray-600 shadow lg:h-4 lg:w-4"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"
                    />
                </svg>
                <svg
                    v-else
                    xmlns="http://www.w3.org/2000/svg"
                    class="absolute right-1.5 top-1.5 h-5 w-5 rounded-full bg-white text-gray-600 shadow lg:h-4 lg:w-4"
                    viewBox="0 0 20 20"
                    fill="currentColor"
                    stroke="none"
                >
                    <path
                        fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd"
                    />
                </svg>
            </div>
        </div>
        <div
            v-else
            class="rounded-xl bg-gray-200 py-3 text-center text-sm text-gray-400"
        >
            Out of stock
        </div>
    </div>
</template>

<script>
import format from "@/mixins/format";

export default {
    mixins: [format],

    props: {
        data: {
            type: Object,
            required: true,
        },
    },

    data() {
        return {
            isAdded: this.$page.props.cart.some((item) => {
                return item["id"] === this.data.id;
            }),
        };
    },

    computed: {
        price() {
            if (this.data.promotion) {
                let amount = this.data.promotion.is_percentage_discount
                    ? this.data.price -
                      this.data.price *
                          (this.data.promotion.discount_amount / 100)
                    : 100 *
                      (this.data.price / 100 -
                          this.data.promotion.discount_amount / 100);
                return this.formatPrice(amount);
            }

            return this.formatPrice(this.data.price);
        },
    },

    methods: {
        addToCart() {
            axios
                .post(route("cart.store", this.data.id))
                .then((res) => {
                    this.isAdded = true;
                    window.events.emit("cartQtyUpdated");
                    window.flash(res.data.message);
                })
                .catch((err) =>
                    window.flash(err.response.data.message, "error")
                );
        },

        buyNow() {
            this.$inertia.post(route("buyNow.store", this.data.id));
        },
    },
};
</script>
