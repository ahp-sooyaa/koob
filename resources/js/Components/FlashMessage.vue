<template>
	<div>
		<Transition name="slide-fade">
			<div
				v-if="(success || $page.props.flash.success) && show"
				class="max-w-sm bg-white border fixed right-5 rounded-lg shadow space-x-2 bottom-5 z-50"
			>
				<div
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
						<span v-if="$page.props.flash.success">
							{{ $page.props.flash.success }}
						</span>
						<span v-else>
							{{ success }}
						</span>
					</div>
				</div>
			</div>
		</Transition>
		<Transition name="slide-fade">
			<div
				v-if="(error || $page.props.flash.error) && show"
				class="max-w-sm bg-white border fixed right-5 rounded-lg shadow space-x-2 bottom-5 z-50"
			>
				<div class="flex items-center mr-4">
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
						class="py-3 text-gray-700 text-sm font-medium"
					>
						<span v-if="$page.props.flash.error">
							{{ $page.props.flash.error }}
						</span>
						<span v-else>
							{{ error }}
						</span>
					</div>
				</div>
			</div>
		</Transition>
		<!-- <div class="max-w-sm bg-white border fixed left-5 rounded-lg shadow space-x-2 bottom-5 z-50">
			<div v-for="message in messages">
				{{ message }}
			</div>
		</div> -->
	</div>
</template>

<script>
export default {
    data(){
        return {
            show: true,
            success: '',
            error: '',
            timeOut: '',
            // messages: [],
            // interval: ''
        }
    },

    watch: {
        '$page.props.flash': {
            handler() {
                this.show = true

                if (this.$page.props.flash.success || this.$page.props.flash.error) {
                    this.hide()
                }
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
                this.error = ''
            } else {
                this.error = data.message
                this.success = ''
            }
            // this.messages.push(data.message)
            // console.log(this.messages, data.message);
            this.show = true
			
            this.hide()

            // if (!this.interval) {
            // 	this.interval = setInterval(() => {
            // 		console.log('called');
            // 		if (this.messages.length > 0) {
            // 			this.messages.shift()
            // 		} else {
            // 			clearInterval(this.interval)
            // 		}
            // 	}, 3000)
            // }
        },

        hide() {
            if (this.timeOut) {
                clearTimeout(this.timeOut)
            }

            this.timeOut = setTimeout(() => {
                this.success = ''
                this.error = ''
                this.$page.props.flash.success = ''
                this.$page.props.flash.error = ''
                this.show = false
            }, 3000)
        },
    },
}
</script>

<style scoped>
.slide-fade-enter-active {
    transition: all 0.3s ease-out;
}

.slide-fade-leave-active {
    transition: all 0.8s cubic-bezier(1, 0.5, 0.8, 1);
}

.slide-fade-enter-from,
.slide-fade-leave-to {
    transform: translateX(20px);
    opacity: 0;
}
</style>
