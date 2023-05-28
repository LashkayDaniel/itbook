<template>

    <sign-in v-if="!isTokenValid" :forAdmin="true"/>
    <div v-else class="main">
        <aside class="navbar">
            <div class="navbar__logo">
                <router-link to="/">
                    <img class="logo__img" src="@/../img/logo.svg" alt="logo">
                </router-link>

                <p class="navbar__views">Глядачів книги: {{ this.currentCountViews }}</p>
            </div>
            <div class="navbar__items">
                <div class="items__item" :class="{'items__item--active' : componentSwitch.showBookSetting}"
                     @click="
                            componentSwitch.showBookSetting = true;
                            componentSwitch.showDictionarySetting = false;
                            componentSwitch.showUserSetting = false;
                            ">
                    <img src="../../../img/book-icon-admin.png"
                         alt="link icon"/>
                    <span>Книга</span>
                </div>
                <div class="items__item" :class="{'items__item--active' : componentSwitch.showDictionarySetting}"
                     @click="
                                            componentSwitch.showBookSetting = false;
                                            componentSwitch.showDictionarySetting = true;
                                            componentSwitch.showUserSetting = false;
                                            ">
                    <img src="../../../img/dictionary-icon-admin.png"
                         alt="link icon"/>
                    <span>Словник</span>
                </div>
                <div class="items__item" :class="{'items__item--active' : componentSwitch.showUserSetting}"
                     @click="
                            componentSwitch.showBookSetting = false;
                            componentSwitch.showDictionarySetting = false;
                            componentSwitch.showUserSetting = true;
                            ">
                    <img src="../../../img/users-icon-admin.png"
                         alt="link icon"/>
                    <span>Користувачі</span>
                </div>
            </div>
            <div class="navbar__bottom">
                <button class="bottom__logout" @click.prevent="this.logout">Logout</button>
            </div>
        </aside>

        <div class="right-panel">
            <book-setting
                v-if="componentSwitch.showBookSetting"
            />
            <dictionary-setting
                v-if="componentSwitch.showDictionarySetting"
            />
            <user-setting
                v-if="componentSwitch.showUserSetting"
            />
        </div>
    </div>
</template>

<script>
import SignIn from "../auth/SignIn.vue";
import BookSetting from "../admin/BookSetting.vue";
import DictionarySetting from "../admin/DictionarySetting.vue";
import UserSetting from "../admin/UserSetting.vue";

export default {
    name: "Admin",
    components: {
        SignIn,
        BookSetting,
        DictionarySetting,
        UserSetting
    },
    data() {
        return {
            isTokenValid: false,
            componentSwitch: {
                showBookSetting: true,
                showDictionarySetting: false,
                showUserSetting: false
            },
            currentCountViews: 0,
        }
    },
    methods: {
        checkToken(token) {
            axios.post('/api/auth/checkToken', {
                token: token
            })
                .then(response => {
                    console.log(response);
                    this.isTokenValid = response.data.status;
                })
                .catch(error => {
                    alert('token Invalid')
                    localStorage.removeItem('admin_token')

                })
        },

        logout() {
            const currentToken = localStorage.getItem('admin_token');
            axios.defaults.headers.common['Authorization'] = `Bearer ${currentToken}`;
            axios.get('/api/auth/logout')
                .then(resp => {
                    console.log(resp);
                    localStorage.removeItem('admin_token');
                    location.reload();
                })
                .catch(err => {
                    console.log(err);
                })
        },

        getViews() {
            axios.get('api/view/getViews')
                .then(response => {
                    console.log(response);
                    this.currentCountViews = response.data.length
                })
                .catch(error => {
                    console.log(error);
                })
        },

    },
    created() {
        const token = localStorage.getItem('admin_token')
        if (token) {
            this.checkToken(token)
        }

        this.getViews()

    },
    mounted() {
        // setInterval(() => {
        //     this.getViews()
        // }, 5000);
    },
};
</script>


<style lang="scss" scoped>
@import "@/../sass/admin/_navbar.scss";

</style>
