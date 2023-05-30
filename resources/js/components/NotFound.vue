<template>
    <div class="block">
        <div class="block__inner">
            <img class="logo" src="@/../img/logo.svg" alt="logo">
            <h2 class="title">404</h2>
            <p class="subtitle">Сторінку не знайдено!</p>

            <router-link to="/">
                <button class="btn">На головну</button>
            </router-link>
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
    width: 100%;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: start;


    &__inner {
        position: relative;
        margin-top: 5%;
        text-align: center;
        padding: 10px 50px;
        border-radius: 10%;
        border: solid 2px #4b5563;
        box-shadow: 0px 39px 97px -16px rgb(61, 108, 112);

    }
}

.logo {
    margin: 30px auto;
}

.title {
    font-size: 50px;
    font-weight: bold;
    color: #5fa7c0;
    letter-spacing: 2px;
}

.subtitle {
    font-size: 30px;
    color: #589bb9;
}

.btn {
    position: absolute;
    bottom: -50px;
    transform: translate(-50%, 100%);
    font-size: 18px;
    font-weight: bold;
    padding: 8px 20px;
    color: #a0aec0;
    border: dashed 2px #51bbb8;

    &:hover {
        border: solid 2px #51bbb8;
        color: #47b6a9;
        transition: all .3s;
    }
}

@media (max-width: 850px) {

    .logo {
        transform: scale(.9);
    }
    .title {
        font-size: 40px;
    }

    .subtitle {
        font-size: 20px;
    }

    .btn {
        bottom: -30px;
        font-size: 16px;
    }
}
</style>
