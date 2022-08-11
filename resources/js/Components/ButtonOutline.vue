<template>
	<button
		:type="type"
		class="active:border-gray-900 border border-gray-800 duration-150 ease-in-out focus:border-gray-900 focus:outline-none focus:shadow-outline-gray font-semibold hover:border-gray-500 inline-flex items-center justify-center px-4 py-2 rounded-md text-gray-800 text-xs tracking-widest transition uppercase"
	>
		<slot />
	</button>
</template>

<script>
export default {
    props: {
        type: {
            type: String,
            default: 'submit',
        },
    }
}
</script>
