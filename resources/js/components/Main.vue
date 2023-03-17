<template>
    <navbar :is-active="showNext"/>
    <start v-if="!this.showNext" @nextStep="changeStep"/>
    <next v-if="this.showNext"></next>
</template>

<script>
import Header from "./Header.vue";
import Start from "./Start.vue";
import Next from "./Next.vue";

export default {
    name: "Main",
    components: {
        navbar: Header,
        start: Start,
        next: Next
    }, data() {
        return {
            showNext: false
        }
    },

    methods: {
        changeStep() {
            this.showNext = true;

        }
    },

}
</script>

<style scoped>

</style>
