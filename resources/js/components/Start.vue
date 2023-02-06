<template>
    <div class="container">
        <div class="block">
            <h1 class="block__title">Title</h1>
            <p class="block__text">text text text</p>
            <button @click="change" class="block__btn-start">Start</button>
        </div>
    </div>
</template>

<script>
export default {
    name: "Start",
    data() {
        return {}
    },
    methods: {
        change() {
            this.$emit("nextStep")
        }
    }
}
</script>

<style lang="scss" scoped>
.container {
    max-width: 900px;
    margin: 0 auto;
}

.block {
    text-align: center;
    background: #3d3939;
    color: antiquewhite;
    padding: 40px 0 10px 0;
    border-radius: 10px;
    margin: 20px;

    &__title {
        font-size: 40px;
    }

    &__text {
        font-size: 30px;
    }

    &__btn-start {
        border-radius: 5px;
        background: #000;
        margin-top: 50px;
        padding: 5px 15px;
        font-size: 25px;

        &:hover {
            opacity: .8;
        }
    }
}
</style>
