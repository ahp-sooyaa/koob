<template>
    <div
        class="flex min-w-max items-baseline justify-between space-x-0 lg:w-auto lg:flex-row lg:space-x-3"
    >
        <dropdown align="right">
            <template #trigger>
                <span class="inline-flex rounded-md">
                    <button
                        type="button"
                        class="focus:outline-none inline-flex items-center rounded-md border border-transparent bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out hover:text-gray-700"
                    >
                        {{ sortedLabel }}
                        <svg
                            class="ml-2 -mr-0.5 h-4 w-4"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </button>
                </span>
            </template>

            <template #content>
                <button
                    class="focus:outline-none block w-full cursor-pointer px-4 py-2 text-left text-sm leading-5 text-gray-700 transition duration-150 ease-in-out hover:bg-gray-100 focus:bg-gray-100"
                    :class="sort === 'price,asc' ? 'text-blue-500' : ''"
                    @click="sort = 'price,asc'"
                >
                    Price (Low to High)
                </button>
                <button
                    class="focus:outline-none block w-full cursor-pointer px-4 py-2 text-left text-sm leading-5 text-gray-700 transition duration-150 ease-in-out hover:bg-gray-100 focus:bg-gray-100"
                    :class="sort === 'price,desc' ? 'text-blue-500' : ''"
                    @click="sort = 'price,desc'"
                >
                    Price (High to Low)
                </button>
                <button
                    class="focus:outline-none block w-full cursor-pointer px-4 py-2 text-left text-sm leading-5 text-gray-700 transition duration-150 ease-in-out hover:bg-gray-100 focus:bg-gray-100"
                    :class="sort === 'created_at,asc' ? 'text-blue-500' : ''"
                    @click="sort = 'created_at,asc'"
                >
                    Newest Books
                </button>
                <button
                    class="focus:outline-none block w-full cursor-pointer px-4 py-2 text-left text-sm leading-5 text-gray-700 transition duration-150 ease-in-out hover:bg-gray-100 focus:bg-gray-100"
                    :class="sort === 'created_at,desc' ? 'text-blue-500' : ''"
                    @click="sort = 'created_at,desc'"
                >
                    Oldest Books
                </button>
            </template>
        </dropdown>
    </div>
</template>

<script>
import Dropdown from "./Dropdown.vue";
export default {
    components: { Dropdown },

    props: ["sorting"],

    data() {
        return {
            sort: this.sorting,
        };
    },

    computed: {
        sortedLabel() {
            return {
                "price,asc": "Price (Low to High)",
                "price,desc": "Price (High to Low)",
                "created_at,asc": "Newest Books",
                "created_at,desc": "Oldest Books",
            }[this.sort.toString()];
        },
    },

    watch: {
        sort(value) {
            this.$inertia.get(
                this.$page.url,
                { sort: value },
                {
                    preserveState: true,
                }
            );
        },
    },
};
</script>

<style lang="scss" scoped></style>
