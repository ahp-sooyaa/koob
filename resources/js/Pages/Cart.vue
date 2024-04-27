<template>
    <Head>
        <title>Cart</title>
        <meta
            head-key="description"
            name="description"
            content="This is cart page where all of your cart items can be seen here."
        />
    </Head>

    <BreezeNavBarLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Shopping Cart
            </h2>
            <div
                v-if="overStockItems.length"
                class="mt-2 rounded border border-red-200 px-5 py-3 text-red-500 ring ring-inset ring-red-50"
            >
                <h1 class="font-semibold">
                    {{ overStockItems.length }} items in your cart has changed
                    quantity to maximum available quantity.
                </h1>
                <p class="text-sm">
                    Items in your Shopping Cart will always reflect the most
                    recent price and stock quantity.
                </p>
                <div
                    v-for="overStockItem in overStockItems"
                    :key="overStockItem.id"
                    class="list-item text-sm"
                >
                    {{ overStockItem.title }}
                </div>
            </div>
        </template>
        <div class="mx-auto my-12 min-h-96 max-w-7xl px-4 sm:px-6 lg:px-8">
            <div
                v-if="cartItems.length"
                class="-mx-4 flex flex-col space-y-5 bg-white shadow-md lg:-mx-0 lg:flex-row lg:space-y-0 lg:rounded-2xl"
            >
                <div class="w-full p-4 lg:w-2/3 lg:border-r lg:p-8">
                    <ul class="space-y-10">
                        <li
                            v-for="(item, index) in cartItems"
                            :key="item.id"
                            class="flex space-x-5"
                        >
                            <img
                                :src="item.cover_url"
                                :alt="item.title + '\'s cover image'"
                                class="h-32 w-24 object-cover lg:h-40 lg:w-32"
                            />
                            <div class="flex flex-1 flex-col items-start">
                                <Link
                                    :href="route('books.show', item.slug)"
                                    class="line-clamp-2"
                                >
                                    {{ item.title }}
                                </Link>
                                <div class="mt-3 flex items-center space-x-5">
                                    <select
                                        class="cursor-pointer rounded-2xl text-xs shadow-md"
                                        name="quantity"
                                        @change="
                                            updateCartQuantity(
                                                index,
                                                item,
                                                $event
                                            )
                                        "
                                    >
                                        <option
                                            v-for="qty in 10"
                                            :key="qty"
                                            :value="qty"
                                            :selected="item.quantity === qty"
                                        >
                                            {{ qty }}
                                        </option>
                                    </select>
                                    <span
                                        class="font-semibold text-gray-500 line-through"
                                    >
                                        {{ formatPrice(item.price) }}
                                    </span>
                                    <span class="font-semibold">
                                        {{ cartItemPrice(item) }}
                                    </span>
                                </div>

                                <div
                                    v-if="$page.props.auth.user"
                                    class="mt-5 inline-block cursor-pointer rounded-md border px-3 py-1.5 text-xs shadow hover:bg-gray-50 hover:shadow-none"
                                    @click="saveForLater(index, item)"
                                >
                                    Save for later
                                </div>
                            </div>
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 flex-shrink-0 cursor-pointer text-sm text-red-500 hover:text-red-800"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                                dusk="removeFromCart"
                                @click="removeFromCart(index, item)"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                            <!-- </button> -->
                        </li>
                    </ul>
                </div>

                <div
                    class="sticky top-36 w-full self-start p-4 lg:w-1/3 lg:p-8"
                >
                    <h1 class="mb-5 text-xl font-semibold capitalize">
                        cart summary
                    </h1>
                    <div class="space-y-5 divide-y">
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-500">SubTotal</span>
                                <span>{{ cartTotal }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Delivery Fee</span>
                                <span>Free</span>
                            </div>
                        </div>
                        <div class="flex justify-between pt-5">
                            <span class="text-gray-500">Total</span>
                            <span dusk="cartTotal">{{ cartTotal }}</span>
                        </div>
                    </div>
                    <div class="mt-5 flex items-center justify-end">
                        <Link
                            :href="route('books.index')"
                            class="text-gray-500 hover:text-gray-900"
                        >
                            Continue Shopping
                        </Link>
                        <Link
                            dusk="checkout"
                            :href="route('checkout.index')"
                            class="ml-4 flex cursor-pointer items-center justify-center rounded-xl border bg-gray-700 px-5 py-3 text-sm text-white shadow-md hover:shadow-none"
                        >
                            Checkout
                        </Link>
                    </div>
                </div>
            </div>

            <div v-else class="flex flex-col items-center">
                <!-- <lottie-player
					src="https://assets6.lottiefiles.com/packages/lf20_0s6tfbuc.json"
					background="transparent"
					speed="1"
					style="width: 200px; height: 200px"
					loop
					autoplay
					class="mx-auto"
				/> -->
                <img
                    src="/images/empty-cart.svg"
                    alt="Empty Cart svg"
                    class="h-52 w-52"
                />

                <h1 class="mt-8 text-xl font-bold tracking-wide text-gray-900">
                    Your Cart is Empty
                </h1>
                <p class="mb-5 mt-1 w-72 text-center text-sm text-gray-500">
                    Looks like you haven't added anything to your cart yet
                </p>
                <Link :href="route('books.index')">
                    <BreezeButton> Continue Shopping </BreezeButton>
                </Link>
            </div>

            <!-- save for later section -->
            <div
                v-if="allSavedItems.length"
                class="-mx-4 mt-10 bg-white p-4 shadow-md lg:-mx-0 lg:rounded-2xl lg:p-8"
            >
                <div class="mb-5 flex items-center">
                    <h1
                        class="mr-2 text-xl font-semibold leading-tight text-gray-800"
                    >
                        Save for later
                    </h1>
                </div>

                <ul class="space-y-10">
                    <li
                        v-for="(item, index) in allSavedItems"
                        :key="item.id"
                        class="flex space-x-5"
                    >
                        <img
                            :src="item.cover_url"
                            :alt="item.title + '\'s cover image'"
                            class="h-32 w-24 object-cover lg:h-40 lg:w-32"
                        />
                        <div class="flex flex-1 flex-col items-start">
                            <Link
                                :href="route('books.show', item.slug)"
                                class="line-clamp-2 hover:underline"
                            >
                                {{ item.title }}
                            </Link>
                            <div class="mt-3 flex items-center space-x-5">
                                <span class="font-semibold">
                                    {{ formatPrice(item.price) }}
                                </span>
                            </div>

                            <div
                                v-cloak
                                v-if="isInStockItem(item.id)"
                                class="mt-auto inline-block cursor-pointer rounded-md border px-3 py-1.5 text-xs shadow hover:bg-gray-50 hover:shadow-none"
                                @click="moveToCart(index, item)"
                            >
                                Move to cart
                            </div>
                            <div v-else class="mt-3 text-sm text-gray-500">
                                This item is no longer available. Out of Stock.
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </BreezeNavBarLayout>
</template>

<script>
import BreezeButton from "@/Components/Button";
import BreezeNavBarLayout from "@/Layouts/NavBar";
import format from "@/mixins/format";
import axios from "axios";

export default {
    components: {
        BreezeNavBarLayout,
        BreezeButton,
    },

    mixins: [format],

    props: [
        "cartItems",
        "allSavedItems",
        "overStockItems",
        "availableSavedItems",
        "promotions",
    ],

    computed: {
        cartQuantity() {
            let totalQty = 0;
            for (const key in this.cartItems) {
                totalQty += this.cartItems[key].quantity;
            }

            return totalQty;
        },
        cartTotal() {
            let amount = 0;
            for (const key in this.cartItems) {
                if (
                    this.cartItems[key].discount_amount &&
                    this.cartItems[key].is_percentage_discount
                ) {
                    amount +=
                        this.cartItems[key].quantity *
                        (this.cartItems[key].price -
                            (this.cartItems[key].price *
                                this.cartItems[key].discount_amount) /
                                100);
                } else {
                    amount +=
                        this.cartItems[key].quantity *
                            this.cartItems[key].price -
                        this.cartItems[key].discount_amount;
                }
            }

            return this.formatPrice(amount);
        },
    },

    methods: {
        cartItemPrice(item) {
            if (item.is_percentage_discount) {
                return this.formatPrice(
                    item.price - item.price * (item.discount_amount / 100)
                );
            }

            return this.formatPrice(item.price - item.discount_amount);
        },

        isInStockItem(id) {
            if (this.availableSavedItems) {
                return this.availableSavedItems.some((item) => {
                    return item.id === id;
                });
            }
        },

        removeFromCart(index, item) {
            let _this = this;

            axios.delete(route("cart.destroy", item.id)).then((res) => {
                _this.cartItems.splice(index, 1);

                window.events.emit("cartQtyUpdated");
                window.flash(res.data.message);
            });
        },

        updateCartQuantity(index, item, event) {
            let _this = this;
            let cartItem = _this.cartItems[index];

            axios
                .patch(route("cart.update", item.id), {
                    qty: parseInt(event.target.value),
                })
                .then((res) => {
                    cartItem.quantity = parseInt(event.target.value);

                    window.events.emit("cartQtyUpdated");
                    window.flash(res.data.message);
                })
                .catch((err) => {
                    event.target.value = cartItem.quantity;
                    window.flash(err.response.data.message, "error");
                });
        },

        saveForLater(index, item) {
            let _this = this;

            axios.post(route("saveForLater.store", item.id)).then((res) => {
                _this.cartItems.splice(index, 1);
                _this.allSavedItems.push(item);
                _this.availableSavedItems.push(item);

                window.events.emit("cartQtyUpdated");
                window.flash(res.data.message);
            });
        },

        moveToCart(index, item) {
            let _this = this;

            axios.post(route("moveToCart", item.id)).then((res) => {
                _this.allSavedItems.splice(index, 1);
                _this.cartItems.push(item);

                window.events.emit("cartQtyUpdated");
                window.flash(res.data.message);
            });
        },
    },
};
</script>
