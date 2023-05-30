<template>
    <div class="loader"></div>
</template>

<script>
export default {
    name: "Loader"
}
</script>

<style lang="scss" scoped>
.loader {
    width: 40px;
    height: 40px;
    margin: 40px auto;
    display: grid;
    border: 3px solid;
    border-radius: 50%;
    border-color: #61c2ee #0000;
    animation: rotate 2s infinite linear;

    &:before,
    &:after {
        content: "";
        grid-area: 1/1;
        margin: 2px;
        border: inherit;
        border-radius: 50%;
    }

    &::before {
        border-color: #3f7996 #0000;
        animation: inherit;
        animation-duration: .8s;
        animation-direction: reverse;
    }

    &::after {
        margin: 8px;
    }
}

@keyframes rotate {
    100% {
        transform: rotate(1turn)
    }
}

@media (max-width: 700px) {
    .loader {
        width: 30px;
        height: 30px;
        border: 2px solid;
        border-color: #61c2ee #0000;

    }
}
</style>
