<template>
    <Head>
        <title>Book Detail</title>
        <meta
            head-key="description"
            name="description"
            content="This is the book detail page"
        />
    </Head>

    <BreezeNavBarLayout>
        <template v-if="previousPurchasedOrder" #header>
            <!-- <h2 class="font-semibold text-xl text-gray-800 leading-tight">
				Shop
			</h2> -->
            <h1 class="text-sm text-gray-700">
                You have previously purchased this book. See
                <Link
                    :href="route('orders.show', previousPurchasedOrder.id)"
                    class="transform underline hover:translate-y-20 hover:text-gray-900"
                >
                    order detail
                </Link>
            </h1>
        </template>

        <section
            class="mx-auto mb-16 max-w-7xl px-4 pt-7 sm:px-6 lg:px-10"
            :class="{ 'mt-16': !previousPurchasedOrder }"
        >
            <!-- <div
				v-if="previousPurchasedOrder"
				class="text-gray-700 text-sm bg-white inline-block mb-5 px-5 py-3 rounded-2xl shadow"
			>
				<h1>
					You have previously purchased this book. See
					<Link
						:href="route('orders.show', previousPurchasedOrder.id)"
						class="hover:text-gray-900 transform hover:translate-y-20 underline"
					>
						order detail
					</Link>
				</h1>
			</div> -->
            <div class="flex flex-col justify-start md:flex-row">
                <img
                    :src="book.cover_url"
                    alt="book_cover"
                    class="h-96 w-full object-cover md:w-72"
                />
                <div class="mt-8 md:ml-8 md:w-1/2">
                    <h1 class="mb-1 text-4xl font-bold tracking-tight">
                        {{ book.title }}
                    </h1>
                    <div class="mb-3 text-2xl font-semibold text-gray-900">
                        {{ formatPrice(book.price) }}
                    </div>
                    <p class="mb-3 text-gray-700">
                        {{ book.excerpt }}
                    </p>
                    <div class="flex">
                        <select
                            id="qty"
                            v-model="quantity"
                            name="qty"
                            class="mr-3 rounded-2xl text-xs"
                            @change="updateCartQuantity(book, $event)"
                        >
                            <option v-for="qty in 10" :key="qty" :value="qty">
                                {{ qty }}
                            </option>
                        </select>
                        <Button
                            v-if="book.stock_count"
                            :disabled="isAdded"
                            :class="{ 'cursor-default opacity-50': isAdded }"
                            class="w-full"
                            @click="addToCart"
                        >
                            {{ isAdded ? "Added" : "Add" }} to Cart
                        </Button>
                        <Button v-else class="w-full cursor-default opacity-50">
                            Out of stock
                        </Button>
                    </div>
                </div>
            </div>
        </section>

        <section class="mx-auto mb-16 max-w-7xl px-4 pt-7 sm:px-6 lg:px-10">
            <div
                class="mb-10 flex space-x-10 border-b-2 pb-2 text-lg tracking-wide text-gray-400"
            >
                <h1
                    class="-mb-2.5 cursor-pointer border-b-2 border-transparent pb-2 transition duration-300 ease-in-out hover:border-gray-900 hover:text-gray-900"
                    :class="{
                        'border-gray-900 text-gray-900':
                            activeTab === 'details',
                    }"
                    @click="activeTab = 'details'"
                >
                    Details
                </h1>
                <h1
                    class="-mb-2.5 cursor-pointer border-b-2 border-transparent pb-2 transition duration-300 ease-in-out hover:border-gray-900 hover:text-gray-900"
                    :class="{
                        'border-gray-900 text-gray-900':
                            activeTab === 'reviews',
                    }"
                    @click="activeTab = 'reviews'"
                >
                    Reviews
                </h1>
            </div>
            <div v-show="activeTab === 'details'" class="space-y-5 md:w-1/4">
                <div class="flex items-center justify-between space-x-2">
                    <span class="text-gray-500">Publisher</span>
                    <div class="mt-1 flex-1 border-t" />
                    <span>Manager FeedWise</span>
                </div>
                <div class="flex items-center justify-between space-x-2">
                    <span class="text-gray-500">Year of publishing</span>
                    <div class="mt-1 flex-1 border-t" />
                    <span>2015</span>
                </div>
                <div class="flex items-center justify-between space-x-2">
                    <span class="text-gray-500">No of pages</span>
                    <div class="mt-1 flex-1 border-t" />
                    <span>100</span>
                </div>
                <div class="flex items-center justify-between space-x-2">
                    <span class="text-gray-500">ISBN</span>
                    <div class="mt-1 flex-1 border-t" />
                    <span>2544365629</span>
                </div>
                <div class="flex items-center justify-between space-x-2">
                    <span class="text-gray-500">Format</span>
                    <div class="mt-1 flex-1 border-t" />
                    <span>Online Book, Paper Book</span>
                </div>
            </div>
            <div
                v-show="activeTab === 'reviews'"
                class="flex flex-col space-y-10 lg:flex-row lg:space-y-0 lg:space-x-16"
            >
                <ReviewList :book-id="book.id" />
            </div>
        </section>
    </BreezeNavBarLayout>
</template>

<script>
import Button from "@/Components/Button";
import ReviewList from "@/Components/ReviewList";
import BreezeNavBarLayout from "@/Layouts/NavBar";
import format from "@/mixins/format";

export default {
    components: {
        Button,
        BreezeNavBarLayout,
        ReviewList,
    },

    mixins: [format],

    props: ["book", "previousPurchasedOrder"],

    data() {
        return {
            quantity: 1,
            initialQuantity: 1,
            isAdded: this.$page.props.cart.some(
                (item) => item["id"] === this.book.id
            ),
            activeTab: "reviews",
        };
    },

    methods: {
        addToCart() {
            axios
                .post(route("cart.store", this.book.id), { qty: this.quantity })
                .then((res) => {
                    this.isAdded = true;
                    window.events.emit("cartQtyUpdated");
                    window.flash(res.data.message);
                })
                .catch((err) =>
                    window.flash(err.response.data.message, "error")
                );
        },

        updateCartQuantity(book, event) {
            if (book.stock_count < parseInt(event.target.value)) {
                this.quantity = this.initialQuantity;
                window.flash(
                    `Quantity is exceeding over stock. Available quantity(${book.stock_count})`,
                    "error"
                );
            } else {
                this.initialQuantity = this.quantity;
            }
        },
    },
};
</script>

<style lang="scss" scoped></style>
