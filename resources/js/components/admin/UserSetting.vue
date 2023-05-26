<template>
    users
    <msg-popup v-if="popup.show" :message="popup.message" :type="popup.type"/>
    <section class="users-list">
        <!--        <button @click="this.showAddProduct=true" class="products-list__btn-add">Додати товар</button>-->
        <table class="users-list__table">
            <tr>
                <th>Id</th>
                <th>Ім'я</th>
                <th>Email</th>
                <th>Дата реєстрації</th>
                <th></th>
            </tr>

            <tr v-if="this.showLoader">
                <div class="loader"></div>
            </tr>

            <tr v-else v-for="user in usersList">
                <td>{{ user.id }}</td>
                <td>{{ user.name }}</td>
                <td>{{ user.email }}</td>
                <td>{{ user.created_at }}</td>
                <td class="table__buttons">
                    <button class="buttons__remove" @click="deleteUser(user)">Видалити</button>
                </td>
            </tr>

        </table>

        <p class="users-list__not-found" v-if="usersList.length===0 && showLoader===false">
            <i>Користувачі відсутні.</i>
        </p>


        <nav class="pagination">
            <ul class="pagination__items">
                <li class="items__btn-prev" v-if="pagination.currentPage > 1"
                    @click="goToPage(pagination.currentPage - 1)"><a>&laquo;</a></li>
                <li v-if="pagination.lastPage!==1" class="items__btn" v-for="page in pagination.lastPage"
                    :key="page"
                    :class="{ 'items__btn--active': page === pagination.currentPage }"
                    @click="goToPage(page)">
                    <a>{{ page }}</a>
                </li>
                <li class="items__btn-next" v-if="pagination.currentPage < pagination.lastPage"
                    @click="goToPage(pagination.currentPage + 1)"><a>&raquo;</a></li>
            </ul>
        </nav>
    </section>
</template>

<script>
import MsgPopup from "@/components/MsgPopup.vue";

export default {
    name: "UserSetting",
    components: {
        MsgPopup
    },
    data() {
        return {
            usersList: [],
            showLoader: true,
            pagination: {
                currentPage: 0,
                lastPage: 0,
            },

            popup: {
                show: false,
                type: '',
                message: '',
            },
        }
    },
    methods: {
        getUsers(page = 1) {
            this.showLoader = true
            this.usersList = []

            axios.get('api/user/getAll?page=' + page)
                .then(response => {

                    const resArr = response.data.data;

                    resArr.forEach(user => {
                        const date = user.created_at;
                        user.created_at = new Date(date).toLocaleString()
                    })

                    this.usersList = resArr

                    this.pagination.currentPage = response.data.current_page;
                    this.pagination.lastPage = response.data.last_page;

                    this.showLoader = false
                })
                .catch(error => {
                    console.log(error);
                })
        },
        goToPage(page) {
            this.getUsers(page);
        },
        deleteUser(user) {
            if (!confirm(`Ви впевнені, що бажаєте видалити даного користувача?`)) {
                this.popupConfig('error', 'Не вдалося видалити користувача!')
                return;
            }

            const userId = user.id;
            axios.delete('api/user/delete/' + userId)
                .then(response => {
                    this.popupConfig('success', 'Користувача успішно видалено!')
                    this.getUsers()
                })
                .catch(error => {
                    console.log(error);
                })

        },
        popupConfig(type, message) {
            this.popup.show = true
            this.popup.type = type
            this.popup.message = message
            setTimeout(() => {
                this.popup.show = false
                this.popup.type = ''
                this.popup.message = ''
            }, 2000);
        },
    },
    created() {
        this.getUsers()
    }
}
</script>

<style lang="scss" scoped>
@import '@/../sass/admin/_user-setting.scss';

</style>
