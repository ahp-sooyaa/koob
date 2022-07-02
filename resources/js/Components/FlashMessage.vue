<template>
	<transition name="slide-fade">
		<!--		<div
			v-if="show"
			:class="[status == 'error' ? 'bg-red-500' : 'bg-green-500']"
			class="fixed flex items-center px-3 py-2 rounded-lg shadow-lg space-x-2 text-white top-5 right-5 z-50"
			role="alert"
		>
			<svg
				v-if="status == 'success'"
				xmlns="http://www.w3.org/2000/svg"
				class="h-5 w-5"
				viewBox="0 0 20 20"
				fill="currentColor"
			>
				<path
					fill-rule="evenodd"
					d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
					clip-rule="evenodd"
				/>
			</svg>
			<svg
				v-else
				xmlns="http://www.w3.org/2000/svg"
				class="h-5 w-5"
				viewBox="0 0 20 20"
				fill="currentColor"
			>
				<path
					fill-rule="evenodd"
					d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
					clip-rule="evenodd"
				/>
			</svg>
			<div
				class="text-center transition ease-in-out duration-500 transform"
			>
				{{ body }}
			</div>
			<span
				v-show="flashCount"
				class="px-1 rounded text-sm"
				:class="status == 'error' ? 'bg-red-400' : 'bg-green-400'"
			>{{ flashCount }}</span>
		</div>-->
		<div class="bg-white border fixed right-5 rounded-lg shadow space-x-2 top-5 z-50">
			<div
				class="flex items-center justify-between max-w-3xl"
			>
				<div
					v-if="success && show"
					class="flex items-center mr-4"
				>
					<svg
						class="bg-green-500 border fill-current flex-shrink-0 h-6 ml-4 mr-2 p-1.5 rounded-full text-white"
						xmlns="http://www.w3.org/2000/svg"
						viewBox="0 0 20 20"
					>
						<polygon points="0 11 2 9 7 14 18 3 20 5 7 18" />
					</svg>
					<div class="py-3 text-gray-700 text-sm font-medium">
						{{ success }}
					</div>
				</div>
				<div
					v-if="(error || Object.keys($page.props.errors).length > 0) && show"
					class="flex items-center mr-4"
				>
					<svg
						xmlns="http://www.w3.org/2000/svg"
						class="bg-red-500 border fill-current flex-shrink-0 h-6 ml-4 mr-2 p-1.5 rounded-full text-white"
						fill="none"
						viewBox="0 0 24 24"
						stroke="currentColor"
						stroke-width="3"
					>
						<path
							stroke-linecap="round"
							stroke-linejoin="round"
							d="M6 18L18 6M6 6l12 12"
						/>
					</svg>
					<div
						v-if="error"
						class="py-3 text-gray-700 text-sm font-medium"
					>
						{{ error }}
					</div>
					<div
						v-else
						class="py-3 text-gray-700 text-sm font-medium"
					>
						<span v-if="Object.keys($page.props.errors).length === 1">
							There is one form error.
						</span>
						<span v-else>There are {{ Object.keys($page.props.errors).length }} form errors.</span>
					</div>
				</div>
			</div>
		</div>
	</transition>
</template>

<script>
export default {
    data(){
        return {
            show: false,
            success: '',
            error: '',
            timeOut: '',
        }
    },

    watch: {
        '$page.props.flash': {
            handler() {
                this.show = true
                this.success = this.$page.props.flash.success
                this.error = this.$page.props.flash.error
                if (this.timeOut) {
                    clearTimeout(this.timeOut)
                }
                this.hide()
            },
            deep: true
        },
    },

    created(){
        window.events.on('flash' , data => this.flash(data))
    },

    methods: {
        flash(data){
            if (data.status === 'success') {
                this.success = data.message
            } else {
                this.error = data.message
            }

            if (this.timeOut) {
                clearTimeout(this.timeOut)
            }
            this.show = true
            this.hide()
        },

        hide() {
            this.timeOut = setTimeout(() => {
                this.show = false
            }, 3000)
        }
    },
}
</script>

<style scoped>
.slide-fade-enter-active,
.slide-fade-leave-active {
  transition: all .5s;
}
.slide-fade-enter,
.slide-fade-leave-to {
  /* transform: translateY(-100px); */
  transform: translateX(50px);
  opacity: 0;
}
</style>
