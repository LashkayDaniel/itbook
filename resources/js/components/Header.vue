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

import router from "@/router";

export default {
    name: "Header",
    props: {
        isActive: Boolean
    },
    data() {
        return {
            showDropdown: false,
            token: false,
        }
    },
    mounted() {
        this.token = localStorage.getItem('x_xsrf_token') ?? false
    },
    methods: {
        logout() {
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
        logout1() {
            axios.get('/logout')
                .then(res => {
                    localStorage.removeItem('x_xsrf_token')
                    router.go(0)
                })
        }
    },
}
</script>

<style lang="scss" scoped>
@import '@/../sass/main/_header.scss';
</style>
