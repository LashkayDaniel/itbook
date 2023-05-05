<template>
    <header>
        <nav class="navigation-wrapper" :class="{'nav-animation' : isActive}">
            <div class="container">
                <img class="logo" src="../../img/itbook.svg" alt=logo>


                <ul v-if="isActive" class="navigation">
                    <li v-if="!token" class="navigation__item">
                        <router-link class="navigation__item-link" :to="{name: 'sign-in'}">Login</router-link>
                    </li>

                    <li class="navigation__item">
                        <router-link class="navigation__item-link" to="example">Example</router-link>
                    </li>

                    <li class="navigation__item">
                        <router-link class="navigation__item-link" to="dictionary">Словник</router-link>
                    </li>

                    <li v-if="token" class="navigation__item dropdown">
                        <img src="https://www.w3schools.com/howto/img_avatar.png" alt="avatar" class="dropdown__avatar"
                             @click="showDropdown = !showDropdown"
                             :class="{'dropdown__avatar-active' : this.showDropdown}">
                        <ul v-if="showDropdown" class="dropdown__list">
                            <li class="dropdown__item"><a href="">пункт 1</a></li>
                            <li class="dropdown__item"><a href="">пункт 1</a></li>
                            <li class="dropdown__item">{{this.userInfo.name}}</li>
                            <li class="dropdown__item">{{this.userInfo.email}}</li>
                            <li class="dropdown__item">
                                <button @click.prevent="logout">Logout</button>
                            </li>
                        </ul>
                    </li>
                </ul>

            </div>
        </nav>
    </header>
</template>

<script>

export default {
    name: "Header",
    props: {
        isActive: Boolean
    },
    data() {
        return {
            showDropdown: false,
            token: false,
            userInfo:{}
        }
    },
    methods: {
        checkToken(token) {
            axios.post('/api/auth/checkToken', {
                token: token
            })
                .then(response => {
                    console.log(response);
                    this.token = response.data.status;


                    const currentToken = localStorage.getItem('x_xsrf_token');
                    axios.defaults.headers.common['Authorization'] = `Bearer ${currentToken}`;
                    axios.get('/api/userInfo')
                        .then(response => {
                            this.userInfo = response.data.user
                        })
                        .catch(error => {
                            console.log(error);

                        })
                    //
                })
                .catch(error => {
                    alert('token Invalid')
                    localStorage.removeItem('x_xsrf_token')

                })
        },
        logout() {
            const currentToken = localStorage.getItem('x_xsrf_token');
            axios.defaults.headers.common['Authorization'] = `Bearer ${currentToken}`;

            axios.get('/api/auth/logout')
                .then(resp => {
                    console.log(resp);
                    localStorage.removeItem('x_xsrf_token');
                    location.reload();
                })
                .catch(err => {
                    console.log(err);
                })
        },
    },

    created() {
        const userToken = localStorage.getItem('x_xsrf_token')
        if (userToken) {
            this.checkToken(userToken)
        }
    },
}
</script>

<style lang="scss" scoped>
@import '@/../sass/main/_header.scss';
</style>
