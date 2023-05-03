<template>

    <div class="wrapper">
        <div class="block">
            <div class="block__logo">
                <router-link :to="{name: 'main'}">
                    <img src="../../../img/logo.svg" alt="logo" title="На головну">
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
                <p class="form__label-error">{{ errors.name }}</p>

                <label for="email" class="form__label">Email</label>
                <input type="email"
                       id="email"
                       v-model="email"
                       class="form__input"
                       placeholder="Введіть email"
                       required/>
                <p class="form__label-error">{{ errors.email }}</p>


                <label for="password" class="form__label">Пароль</label>
                <input type="password"
                       id="password"
                       v-model="password"
                       class="form__input"
                       placeholder="Введіть пароль"
                       required/>
                <p class="form__label-error">{{ errors.password }}</p>


                <label for="confirmPassword" class="form__label">Підтвердіть пароль</label>
                <input type="password"
                       id="confirmPassword"
                       v-model="confirmPassword"
                       class="form__input"
                       placeholder="Введіть пароль"
                       required/>
                <p class="form__label-error">{{ errors.confirm_password }}</p>


                <p v-if="signUpSuccess" class="form__label-success">Успішно зареєстровано!</p>


                <button @click.prevent="register" class="form__button" type="submit">Зареєструватися</button>
            </form>

            <div class="block__links">
                <router-link class="links__link" :to="{name: 'sign-in'}">Авторизація</router-link>
            </div>
        </div>
    </div>

</template>

<script>

export default {
    data() {
        return {
            name: '',
            email: '',
            password: '',
            confirmPassword: '',

            signUpSuccess: false,

            errors: {}
        };
    },
    methods: {
        register() {
            this.errors = {}

            axios.post('/api/auth/register', {
                name: this.name,
                email: this.email,
                password: this.password,
                confirm_password: this.confirmPassword
            })
                .then(response => {
                    console.log(response)
                    localStorage.setItem('x_xsrf_token', response.data.token);
                    this.signUpSuccess = true;
                    setTimeout(() => {
                        this.$router.push({name: 'main'})
                    }, 2000)
                })
                .catch(error => {
                    const errors = error.response.data.errors;
                    errors.hasOwnProperty('name') ? this.errors.name = errors.name[0] : ''
                    errors.hasOwnProperty('email') ? this.errors.email = errors.email[0] : ''
                    errors.hasOwnProperty('password') ? this.errors.password = errors.password[0] : ''
                    errors.hasOwnProperty('confirm_password') ? this.errors.confirm_password = errors.confirm_password[0] : ''

                })
        },
    },
};
</script>

<style lang="scss" scoped>
@import '@/../sass/auth/_sign.scss';

</style>
