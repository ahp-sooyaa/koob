<template>
	<Link
		:href="href"
		:class="classes"
	>
		<slot />
	</Link>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3'

export default {
    components: {
        Link,
    },

    props: ['href', 'active'],

    computed: {
        classes() {
            return this.active
                ? 'w-full flex block pl-3 pr-4 py-2 border-l-4 border-gray-600 text-base font-medium text-gray-700 bg-gray-50 focus:outline-none focus:text-gray-800 focus:bg-gray-100 focus:border-gray-700 transition duration-150 ease-in-out'
                : 'w-full flex block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out'
        }
    }
}
</script>
