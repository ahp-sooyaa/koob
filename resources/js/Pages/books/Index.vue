<template>
    <div class="bg-gray-100 min-h-screen">
        <nav class="bg-white shadow mb-7">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center">
                    <BreezeApplicationLogo class="block h-9 w-auto" />
                    <div v-if="canLogin" class="hidden px-6 py-4 sm:block">
                        <Link v-if="$page.props.auth.user" href="/dashboard" class="text-sm text-gray-700 underline">
                            Dashboard
                        </Link>

                        <template v-else>
                            <Link :href="route('login')" class="text-sm text-gray-700 underline">
                                Log in
                            </Link>

                            <Link v-if="canRegister" :href="route('register')" class="ml-4 text-sm text-gray-700 underline">
                                Register
                            </Link>
                        </template>
                    </div>
                </div>
            </div>
        </nav>

        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <section>
                <h1 class="font-semibold mb-3 text-gray-500 text-lg">All Books</h1>
                <div class="flex flex-wrap bg-white px-4 py-5 rounded-md shadow">
                    <div v-for="book in books" class="w-1/5">
                        <book :data="book"></book>
                    </div>
                </div>
            </section>
        </main>
    </div>
</template>

<script>
    import {Link} from '@inertiajs/inertia-vue3'
    import BreezeApplicationLogo from '@/Components/ApplicationLogo'
    import book from '@/Components/Book'
    export default {
        components: { 
            Link,
            BreezeApplicationLogo,
            book
        },

        props: {
            canLogin: Boolean,
            canRegister: Boolean,
            books: Object
        }
    }
</script>

<style lang="scss" scoped>

</style>