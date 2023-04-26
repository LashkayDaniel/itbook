<template>
    <html>
    <body>
    <!--    <modal v-if="loginError" :title="ok" :message="this.loginError"></modal>-->
    <div class="block">
        <div class="block__logo">
            <img src="../../../img/logo.svg" alt="logo">
        </div>
        <div class="block__title">Sign In</div>
        <form class="block__form" method="post">
            <p class="form__label">Email</p>
            <input v-model="email" class="form__input" name="login" type="email" placeholder="Input email" required>

            <p class="form__label">Password</p>
            <input v-model="password" class="form__input" name="password" type="password" placeholder="Input password"
                   required>

            <p v-if="loginError" class="form__label-warning">{{ this.loginError }}</p>

            <p v-if="loginSuccess" class="form__label-success">Успішно авторизовано!</p>

            <button @click.prevent="login" class="form__button" type="submit">Login</button>
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

import router from "@/router";
import Modal from "../Modal.vue";

export default {
    name: " SignIn",

    components: {
        modal: Modal,
    },

    data() {
        return {
            email: '',
            password: '',
            loginError: '',
            loginSuccess: false,

        }
    },

    methods: {
        login() {

            if (this.email === '' || this.password === '') {
                this.loginError = "Заповніть поля значеннями";
                setTimeout(() => {
                    this.loginError = ''
                }, 2000);
                return;
            }

            axios.post('/api/auth/login', {
                email: this.email,
                password: this.password,
            })
                .then(response => {
                    console.log(response.data)
                    this.loginError = '';
                    this.loginSuccess = true;
                    localStorage.setItem('x_xsrf_token', response.config.headers['X-XSRF-TOKEN']);
                    setTimeout(() => {
                        router.push({name: 'main'})
                    }, 2000)
                })
                .catch(err => {

                    console.log(err.message);
                    this.loginSuccess = false;
                    this.loginError = err.message;
                    setTimeout(() => {
                        this.loginError = ''
                    }, 3000)

                })

        }
    }
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

@keyframes warning {
    0% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.2);
    }
    100% {
        transform: scale(1);
    }

}

.form {
    &__label {
        border: none;
        text-align: start;
        font-size: 20px;
        margin: 5px;
    }

    &__label-error {
        color: red;
        font-size: 15px;
    }

    &__label-warning {
        padding: 5px;
        border-radius: 3px;
        font-weight: bold;
        color: #5b452c;
        background-color: orange;
        font-size: 14px;
        transition: warning .9s ease;
    }

    &__label-success {
        color: greenyellow;
        font-weight: bold;
        font-size: 16px;
    }

    &__input {
        background-color: transparent;
        border: none;
        font-weight: bold;
        color: antiquewhite;
        border-bottom: 2px solid #8ecae6;
        margin-bottom: 15px;
        width: 100%;
        font-size: 14px;
        border-radius: 5px;
        padding: 10px 5px;

        &:focus {
            outline: none;
        }
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
