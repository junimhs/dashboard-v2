<template>
    <div class="hidden md:flex space-x-10">
        <div class="relative">
            <button @click.stop.prevent="toggleMenu" type="button" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium inline-flex items-center focus:outline-none" aria-expanded="false">
                <span>{{ text }}</span>
                <svg class="text-gray-300 ml-2 h-5 w-5 group-hover:text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>

            <div v-show="isOpen" class="absolute z-10 -ml-4 mt-3 transform px-2 w-screen max-w-md sm:px-0 lg:ml-0">
                <div class="rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 overflow-hidden">
                    <div class="relative grid gap-6 bg-white px-5 py-6 sm:gap-8 sm:p-8">
                        <slot />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "MenuGroup",
    props: {
      text: {
          type: String,
          required: true
      }
    },
    data() {
        return {
            isOpen: false
        }
    },
    mounted() {
      document.addEventListener('click', this.clickOutListener);
    },
    methods: {
        toggleMenu() {
            this.isOpen = !this.isOpen;
        },
        close() {
          this.isOpen = false;
        },
        clickOutListener(e) {
            if(!this.$el.contains(e.target)) {
                this.close();
            }
        },
        rootCloseListener(vm) {
            if(vm !== this) {
                this.close()
            }
        }
    },
    watch: {
        isOpen(value) {
            if(value) {
                this.$root.$emit('menugroup::open', this);
            }
        }
    },
    created() {
        this.$root.$on('menugroup::open', this.rootCloseListener)
    }
}
</script>

<style scoped>

</style>
