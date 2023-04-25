<template>
    <div>
        <Head>
            <title>Shop</title>
            <meta
                head-key="description"
                name="description"
                content="This is the shop page"
            />
        </Head>

        <BreezeNavBarLayout>
            <template #header>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Shop
                </h2>
            </template>
            <section
                class="mx-auto mb-14 max-w-7xl px-4 pt-7 lg:my-16 lg:px-10"
            >
                <div
                    v-if="booksCount"
                    class="flex flex-col space-y-5 space-x-0 lg:flex-row lg:space-y-0 lg:space-x-10"
                >
                    <div class="w-full lg:w-1/5">
                        <div class="mb-4 flex items-baseline justify-between">
                            <h1>Filters</h1>
                            <span
                                v-show="filters.search || categoryFilter"
                                class="cursor-pointer text-sm text-gray-500 hover:underline"
                                @click="clearFilter"
                                >clear</span
                            >
                        </div>

                        <h1>Categories</h1>
                        <div
                            class="-ml-1 flex flex-nowrap items-baseline overflow-x-auto pb-3 pt-1 lg:flex-wrap lg:space-y-2"
                        >
                            <button
                                class="mx-1 inline-block cursor-pointer rounded-2xl border bg-white px-4 py-1 text-sm capitalize shadow"
                                :class="
                                    !categoryFilter
                                        ? 'border-blue-400 text-blue-500'
                                        : 'text-gray-600'
                                "
                                @click="filterCategory(null)"
                            >
                                all
                            </button>
                            <button
                                v-for="category in categories"
                                :key="category.slug"
                                class="mx-1 inline-block cursor-pointer rounded-2xl border bg-white px-4 py-1 text-sm capitalize shadow"
                                :class="
                                    categoryFilter === category.slug
                                        ? 'border-blue-400 text-blue-500'
                                        : 'text-gray-600'
                                "
                                @click="filterCategory(category.slug)"
                            >
                                {{ category.name }}
                            </button>
                        </div>
                    </div>
                    <div class="w-full lg:w-4/5">
                        <div
                            class="flex flex-col items-center justify-between space-x-3 md:flex-row lg:items-center"
                        >
                            <search-box
                                :search-query="filters.search"
                                placeholder="Search by book title or excerpt..."
                                classes="hover:border-transparent focus:border-transparent rounded-full w-full"
                            />
                            <div
                                class="mb-5 mt-3 flex w-full items-center justify-between md:mb-0 md:mt-0 md:w-auto"
                            >
                                <div
                                    v-show="books.total"
                                    class="text-sm text-gray-600 md:hidden"
                                >
                                    Showing {{ books.from }}-{{ books.to }} of
                                    {{ books.total }}
                                </div>
                                <sorting :sorting="sorting" />
                            </div>
                        </div>
                        <div
                            v-show="books.total"
                            class="mt-7 hidden text-sm text-gray-600 md:block"
                        >
                            Showing {{ books.from }}-{{ books.to }} of
                            {{ books.total }}
                        </div>
                        <div v-if="Object.keys(books.data).length">
                            <div
                                class="my-5 grid grid-cols-1 gap-y-5 sm:grid-cols-2 sm:gap-7 md:grid-cols-3 md:gap-10 lg:grid-cols-4"
                            >
                                <div
                                    v-for="book in books.data"
                                    :key="book.id"
                                    class="flex h-full flex-col rounded-xl pb-5"
                                >
                                    <Book :data="book" />
                                </div>
                            </div>

                            <!-- paginator -->
                            <paginator
                                v-show="books.total > books.per_page"
                                :links="books.links"
                            />
                        </div>

                        <div
                            v-else
                            class="mt-32 grid place-items-center text-center"
                        >
                            <img
                                src="/images/not-found.svg"
                                alt="Not Found svg"
                                class="h-52 w-52"
                                loading="lazy"
                            />
                            <h1
                                class="mt-8 text-xl font-bold tracking-wide text-gray-900"
                            >
                                Result Not Found
                            </h1>
                            <p class="mb-5 mt-1 w-72 text-sm text-gray-500">
                                Please try again with different keywords or
                                check spelling
                            </p>
                        </div>
                    </div>
                </div>
                <div v-else class="flex flex-col items-center">
                    <lottie-player
                        src="https://assets6.lottiefiles.com/packages/lf20_0s6tfbuc.json"
                        background="transparent"
                        speed="1"
                        style="width: 200px; height: 200px"
                        loop
                        autoplay
                        class="mx-auto"
                    />
                    <p>There is no books data in database.</p>
                </div>
            </section>
        </BreezeNavBarLayout>
    </div>
</template>

<script>
import Paginator from "@/Components/Paginator";
import SearchBox from "@/Components/SearchBox";
import Sorting from "@/Components/Sort";
import BreezeNavBarLayout from "@/Layouts/NavBar";
import Book from "@/Pages/Books/Book";

export default {
    components: {
        BreezeNavBarLayout,
        Book,
        SearchBox,
        Paginator,
        Sorting,
    },

    props: {
        books: {
            type: Object,
            required: true,
        },
        categories: {
            type: Object,
            required: true,
        },
        sorting: {
            type: String,
            default: null,
        },
        filters: {
            type: Object,
            default: null,
        },
        booksCount: {
            type: Number,
            required: true,
        },
    },

    data() {
        return {
            categoryFilter: this.filters.category,
        };
    },

    methods: {
        filterCategory(value) {
            this.$inertia.get(this.$page.url, { category: value, page: 1 });
        },

        clearFilter() {
            this.$inertia.get(this.$page.url, { search: null, category: null });
        },
    },
};
</script>
