<template>
    <html>
    <body>
    <div class="block">
        <div class="block__logo">
            <img src="../../../img/logo.svg" alt="logo">
        </div>
        <div class="block__title">Sign In</div>
        <form class="block__form" method="post" action="#">
            <p class="form__label">Login</p>
            <input class="form__input" name="login" type="text" placeholder="Input login" required>

            <p class="form__label">Password</p>
            <input class="form__input" name="password" type="password" placeholder="Input password" required>

            <button class="form__button" type="submit">Login</button>
        </form>

        <div class="block__links">
            <a class="links__link" href="#">Forgot password?</a>
            <router-link class="links__link" :to="{name: 'sign-up'}">Sign Up</router-link>
        </div>
    </div>
    </body>
    </html>
</template>

<script>
export default {
    name: " SignIn"
}
</script>

<style scoped lang="scss">
html,
body {
    height: 100vh;
    padding: 0;
    margin: 0;
    background-color: rgb(50 48 54);
    display: flex;
    justify-content: center;
}

.block {
    min-width: 800px;
    padding: 30px 100px;
    margin: auto;
    text-align: center;
    background-color: #3c3f45;
    border-radius: 10px;
    color: aliceblue;

    &__logo {
    }

    &__title {
        font-weight: bold;
        margin-top: 30px;
        font-size: 35px;
    }

    &__form {
        max-width: 450px;
        margin: 0 auto;
    }

    &__links {
        display: flex;
        margin-top: 20px;
        justify-content: space-evenly;
    }
}

.form {
    &__label {
        border: none;
        text-align: start;
        font-size: 25px;
        margin: 5px;
    }

    &__input {
        border: none;
        margin-bottom: 15px;
        width: 100%;
        font-size: 14px;
        border-radius: 5px;
        padding: 10px 5px;
    }

    &__button {
        border: none;
        padding: 10px 40px;
        margin-top: 10px;
        font-weight: bold;
        font-size: 16px;
        border-radius: 5px;

        &:hover {
            opacity: .8;
        }
    }
}

.links {
    &__link {
        color: aliceblue;
    }
}

@media (max-width: 880px) {
    .block {
        min-width: 700px;
    }
}

@media (max-width: 790px) {
    .block {
        min-width: 600px;
    }
}

@media (max-width: 650px) {
    .block {
        min-width: 500px;
    }
}

@media (max-width: 540px) {
    .block {
    }
}
</style>
