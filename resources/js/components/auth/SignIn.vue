<template>
    <div class="wrapper">
        <div class="block">
            <div class="block__logo">
                <router-link :to="{name: 'main'}">
                    <img src="../../../img/logo.svg" alt="logo" title="На головну">
                </router-link>
            </div>
            <div class="block__title">Авторизація</div>
            <form class="block__form" method="post">

                <label for="login" class="form__label">Email</label>
                <input v-model="email" class="form__input" name="login" type="email" placeholder="Введіть email"
                       required>

                <label for="password" class="form__label">Пароль</label>
                <div class="form__pass-field">
                    <input v-model="password"
                           ref="password"
                           class="pass-field__input form__input"
                           name="password"
                           :type="passwordType"
                           placeholder="Введіть пароль"
                    >
                    <button v-if="password.length>0"
                            type="button"
                            class="pass-field__btn-show"
                            @click.prevent="showPassword">
                        {{ passwordType === 'password' ? 'Показати' : 'Приховати' }}
                    </button>
                </div>

                <p v-if="loginError" class="form__label-warning">{{ this.loginError }}</p>

                <p v-if="loginSuccess" class="form__label-success">Успішно авторизовано!</p>

                <button @click.prevent="forAdmin ? loginAdmin() : loginUser()" class="form__button" type="submit">Ввійти
                </button>
            </form>

            <div v-if="!forAdmin" class="block__links">
                <router-link class="links__link" :to="{name: 'reset-pass'}">Забули пароль?</router-link>
                <router-link class="links__link" :to="{name: 'sign-up'}">Реєстрація</router-link>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    name: " SignIn",
    props: {
        forAdmin: {
            Boolean,
            default: false
        }
    },
    data() {
        return {
            email: '',
            password: '',
            passwordType: 'password',
            loginError: '',
            loginSuccess: false,
        }
    },

    methods: {
        showPassword() {
            this.passwordType = this.passwordType === 'password' ? 'text' : 'password';
        },
        loginUser() {
            console.log('log from user login')
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
                    // localStorage.setItem('x_xsrf_token', response.config.headers['X-XSRF-TOKEN']);
                    localStorage.setItem('x_xsrf_token', response.data.token);

                    setTimeout(() => {
                        this.$router.push({name: 'main'})
                    }, 2000)
                })
                .catch(err => {

                    console.log(err.message);
                    this.loginSuccess = false;
                    this.loginError = err.message;
                    setTimeout(() => {
                        this.loginError = ''
                    }, 3000)
                });
        },
        loginAdmin() {
            console.log('log from admin login')
            if (this.email === '' || this.password === '') {
                this.loginError = "Заповніть поля значеннями";
                setTimeout(() => {
                    this.loginError = ''
                }, 2000);
                return;
            }

            axios.post('/api/auth/adminLogin', {
                email: this.email,
                password: this.password,
            })
                .then(response => {
                    if (response.data.status) {
                        console.log(response.data)
                        this.loginError = '';
                        this.loginSuccess = true;

                        // localStorage.setItem('x_xsrf_token', response.config.headers['X-XSRF-TOKEN']);
                        localStorage.setItem('admin_token', response.data.token);

                        setTimeout(() => {
                            this.$router.push({name: 'admin'})
                            location.reload();
                        }, 2000)
                    }
                })
                .catch(err => {
                    console.log(err.message);
                    this.loginSuccess = false;
                    this.loginError = err.message;
                    setTimeout(() => {
                        this.loginError = ''
                    }, 3000)
                });
        },

    }
}
</script>

<style lang="scss" scoped>
@import '@/../sass/auth/_sign.scss';

</style>
