<template>

    <div class="wrapper">
        <div class="block">
            <div class="block__logo">
                <router-link to="main">
                    <img src="../../../img/logo.svg" alt="logo">
                </router-link>
            </div>
            <div class="block__title">Реєстрація</div>
            <form class="block__form" method="post">

                <label for="name" class="form__label">Ім'я</label>
                <input type="text"
                       id="name"
                       v-model="name"
                       class="form__input"
                       placeholder="Введіть ім'я"
                       required/>

                <label for="email" class="form__label">Email</label>
                <input type="email"
                       id="email"
                       v-model="email"
                       class="form__input"
                       placeholder="Введіть email"
                       required/>

                <label for="password" class="form__label">Пароль</label>
                <input type="password"
                       id="password"
                       v-model="password"
                       class="form__input"
                       placeholder="Введіть пароль"
                       required/>

                <label for="confirmPassword" class="form__label">Підтвердіть пароль</label>
                <input type="password"
                       id="confirmPassword"
                       v-model="confirmPassword"
                       class="form__input"
                       placeholder="Введіть пароль"
                       required/>

                <p v-if="loginError" class="form__label-warning">{{ this.loginError }}</p>

                <p v-if="loginSuccess" class="form__label-success">Успішно авторизовано!</p>

                <button @click.prevent="register" class="form__button" type="submit">Зареєструватися</button>
            </form>

            <div class="block__links">
                <router-link class="links__link" :to="{name: 'sign-in'}">Авторизація</router-link>
            </div>
        </div>
    </div>

</template>

<script>
import router from "@/router";

export default {
    data() {
        return {
            name: '',
            email: '',
            password: '',
            confirmPassword: '',

            errors: {}
        };
    },
    methods: {
        register() {
            axios.post('/api/auth/register', {
                name: this.name,
                email: this.email,
                password: this.password
            })
                .then(res => {
                    console.log(res)
                    localStorage.setItem('x_xsrf_token', res.config.headers['X-XSRF-TOKEN']);
                    router.push({name: 'admin'})
                })
                .catch(err => {
                    console.log(err);
                })
        },
    },
};
</script>

<style lang="scss" scoped>
@import '@/../sass/auth/_sign.scss';

</style>
