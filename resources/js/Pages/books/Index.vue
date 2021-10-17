<template>
    <BreezeNavBarLayout>
        <Flash/>
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-7">
            <section>
                <h1 class="font-bold mb-3 text-gray-500 text-xl">All Books</h1>
                <div class="grid grid-cols-5 gap-4">
                    <div v-for="book in books">
                        <Book :data="book"></Book>
                    </div>
                </div>
            </section>
        </main>
    </BreezeNavBarLayout>
</template>

<script>
    import {Link} from '@inertiajs/inertia-vue3'
    import BreezeApplicationLogo from '@/Components/ApplicationLogo'
    import BreezeNavBarLayout from '@/Layouts/NavBar'
    import Book from './Book'
    import CartLink from '@/Components/CartLink'
    export default {
        components: { 
            BreezeNavBarLayout,
            BreezeApplicationLogo,
            Book,
            CartLink,
            Link
        },

        props: {
            books: Object
        }
    }
</script>

<style lang="scss" scoped>

</style>