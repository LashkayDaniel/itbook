<template>
    <transition name="fade">
        <button v-show="this.showBtn" class="btn-to-top" @click="scrollTop"></button>
    </transition>
</template>

<script>
export default {
    name: "ToTop",
    data() {
        return {
            showBtn: false,
        }
    },
    methods: {
        scrollTop() {
            window.scrollTo({
                top: 0,
                left: 0,
                behavior: 'smooth',
            });
        }
    },
    mounted() {
        let that = this;
        window.addEventListener("scroll", function () {
            let scroll = window.scrollY
            scroll > 350 ? that.showBtn = true : that.showBtn = false
        })
    }
}
</script>

<style lang="scss" scoped>
.btn-to-top {
    position: fixed;
    right: 50px;
    bottom: 30px;
    background-color: rgba(84, 107, 133, 0.61);
    width: 50px;
    height: 50px;
    border-radius: 50%;
    z-index: 2;

    &:before {
        content: '';
        display: block;
        width: 15px;
        height: 15px;
        position: absolute;
        top: 40%;
        left: 33%;
        border-radius: 2px;
        border-bottom: solid 4px rgb(165, 199, 208);
        border-left: solid 4px rgb(165, 199, 208);
        transform: rotate(135deg);
    }

    &:after {
        content: '';
        display: block;
        width: 4px;
        height: 15px;
        position: absolute;
        top: 50%;
        left: 45%;
        border-radius: 5px;
        background-color: rgb(165, 199, 208);
        transform: translate(0%, -20%);

    }

    &:hover {
        transition: 1s ease;
        transform: scale(1.2);
    }
}

.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.5s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}

@media (max-width: 1025px) {
    .btn-to-top {
        right: 30px;
        bottom: 30px;

    }
}

@media (max-width: 768px) {
    .btn-to-top {
        width: 45px;
        height: 45px;

    }
}

</style>
