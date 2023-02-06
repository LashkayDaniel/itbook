<template>
    <div class="block">
        <div class="block-inner">
            <h1 class="block-inner__title">404</h1>
            <b class="block-inner__subtitle">Not Found</b>
            <br/>
            <router-link class="block-inner__link" to="/">На головну</router-link>
        </div>
    </div>
</template>

<script>
export default {
    name: "NotFound"
}
</script>

<style lang="scss" scoped>
.block {
    width: 100vw;
    height: 100vh;
    background: #7c7070;
    margin: 0 auto;
    display: flex;
    justify-content: center;
    align-items: center;
}

.block-inner {
    text-align: center;

    &__title {
        font-size: 100px;
    }

    &__subtitle {
        font-size: 40px;
    }

    &__link {
        padding: 0;
        text-decoration: none;
        font-size: 45px;
        color: #e35322;
    }
}
</style>
