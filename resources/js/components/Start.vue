<template>
    <div class="container">
        <div class="block">
            <h1 class="block__title">Ласкаво просимо до ІТ книги!</h1>
            <p class="block__text">Ця книга призначена для тих, хто бажає оволодіти навичками роботи з базами даних.
                Вона охоплює різноманітні аспекти баз даних, починаючи з основних концепцій і завершуючи складнішими
                технологіями та методологіями.</p>
            <p class="block__text">Тому запрошуємо Вас розпочати свою подорож у світ баз даних разом </p>
            <p class="block__text">Приємного читання та успіхів у вивченні баз даних!</p>
            <button @click="change" class="block__btn-start">Почати</button>
        </div>
    </div>
</template>

<script>
export default {
    name: "Start",
    data() {
        return {}
    },
    mounted() {
        const token = localStorage.getItem('x_xsrf_token')
        if (token) {
            this.change();

        }
    },
    methods: {
        change() {
            this.$emit("nextStep")
        }
    }
}
</script>

<style lang="scss" scoped>
@import url('https://fonts.googleapis.com/css2?family=Rubik:wght@300;400&display=swap');

.container {
    max-width: 900px;
    margin: 0 auto;
}

.block {
    background-color: transparent;
    color: antiquewhite;
    padding: 40px;
    border-radius: 10px;
    margin: 20px;
    text-align: center;
    position: relative;
    box-shadow: 0px 5px 53px -23px rgba(96, 151, 240, 1);


    &:before, &:after {
        content: '';
        background-image: url('../../img/branch.png');
        background-size: 100% 100%;
        display: inline-block;
        height: 65px;
        width: 100px;
        position: absolute;
    }

    &:before {
        left: 0;
        top: 0;
    }

    &:after {
        right: 0;
        bottom: 0;
        transform: rotate(180deg);
    }

    &__title {
        font-size: 35px;
        color: #31aee5;
        font-weight: bold;
        animation: title-color 5s infinite;

        @keyframes title-color {
            0% {
                text-shadow: 0 0 3px #25506b, 0 0 5px #72bcf1;
            }
            50% {
                text-shadow: 0 0 10px #33beb8, 0 0 15px #47a1ec;
            }
            100% {
                text-shadow: 0 0 3px #255c6b, 0 0 5px #72bcf1;
            }
        }
    }

    &__text {
        text-indent: 25px;
        font-size: 23px;
        text-align: justify;
        word-break: break-word;
        color: #2d80a6;
        margin: 10px 0;

        &:last-of-type {
            font-weight: bold;
            color: #6a8ac4;
        }

    }

    &__btn-start {
        border-radius: 5px;
        background: #2a6b88;
        color: #b4bcc7;
        margin-top: 50px;
        padding: 10px 20px;
        font-size: 20px;
        font-weight: bold;
        letter-spacing: 1px;
        position: absolute;
        transform: translate(-50%);

        &:hover {
            opacity: .8;
            transition: all .7s;

            &:after {
                content: '->';
                margin-left: 10px;
                color: #749cd0;
                animation: arrow-appear 0.5s ease-in-out;
                @keyframes arrow-appear {
                    0% {
                        opacity: 0;
                        transform: translateY(10px);
                    }
                    100% {
                        opacity: 1;
                        transform: translateY(0);
                    }
                }
            }
        }
    }
}
</style>
