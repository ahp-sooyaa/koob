<template>
	<div class="relative">
		<div
			@click="open = ! open"
			class="flex"
		>
			<slot name="trigger" />
		</div>

		<!-- Full Screen Dropdown Overlay -->
		<div
			v-show="open"
			@click="open = false"
			class="fixed inset-0 z-40"
		/>

		<transition
			enter-active-class="transition ease-out duration-200"
			enter-from-class="transform opacity-0 scale-95"
			enter-to-class="transform opacity-100 scale-100"
			leave-active-class="transition ease-in duration-75"
			leave-from-class="transform opacity-100 scale-100"
			leave-to-class="transform opacity-0 scale-95"
		>
			<div
				v-show="open"
				@click="open = false"
				class="absolute z-50 mt-2 rounded-md shadow-lg bg-white"
				:class="[widthClass, alignmentClasses]"
				style="display: none;"
			>
				<div
					class="py-1 rounded-md ring-1 ring-black ring-opacity-5"
					:class="contentClasses"
				>
					<slot name="content" />
				</div>
			</div>
		</transition>
	</div>
</template>

<script>
import { onMounted, onUnmounted, ref } from 'vue'

export default {
    props: {
        align: {
            type: String,
            default: 'right'
        },
        width: {
            type: String,
            default: '48'
        },
        contentClasses: {
            type: Function,
            default: () => ['py-1', 'bg-white']
        }
    },

    setup() {
        let open = ref(false)

        const closeOnEscape = (e) => {
            if (open.value && e.keyCode === 27) {
                open.value = false
            }
        }

        onMounted(() => document.addEventListener('keydown', closeOnEscape))
        onUnmounted(() => document.removeEventListener('keydown', closeOnEscape))

        return {
            open,
        }
    },

    computed: {
        widthClass() {
            return {
                '48': 'w-48',
                '72': 'w-72'
            }[this.width.toString()]
        },

        alignmentClasses() {
            if (this.align === 'left') {
                return 'origin-top-left left-0'
            } else if (this.align === 'right') {
                return 'origin-top-right right-0'
            } else {
                return 'origin-top'
            }
        },
    }
}
</script>
