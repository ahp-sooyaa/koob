<template>
  <transition name="slide-fade">
    <div
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
    </div>
  </transition>
</template>

<script>
export default {
    data(){
        return {
            body: '',
            status: 'success',
            show: false,
            flashCount: 0
        }
    },

    // watch: {
    //     '$page.props.flash': {
    //         handler() {
    //             this.show = true
    //         },
    //         deep: true,
    //     },
    // },

    created(){
        window.events.on('flash' , data => this.flash(data) )
    },

    methods: {
        flash(data){
            this.body = data.message
            this.status = data.status

            this.show = true
            this.flashCount++

            setTimeout(() => {
                this.show = false
                this.flashCount = 0
            }, 3000)
        },
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