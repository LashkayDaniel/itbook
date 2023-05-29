<template>
    <msg-popup v-if="popup.show" :message="popup.message" :type="popup.type"/>

    <article class="main-block">
        <section class="left">
            <div class="add-new">
                <h2 class="add-new__title">Нове слово</h2>
                <hr/>
                <div class="add-new__block">
                    <input type="text"
                           class="block__input-name"
                           placeholder="Введіть назву"
                           required
                           v-model="newWord.wordName"
                    >
                    <textarea class="block__textarea"
                              placeholder="Введіть опис"
                              required
                              v-model="newWord.description"
                    />
                    <button @click.prevent="addNewWord" class="block__btn-add">Додати</button>
                </div>
            </div>

            <hr class="break-line">

            <h2 class="add-new__title">Перелік всіх слів</h2>
            <div class="words-list">
                <div class="words-list__row"
                     v-for="item in words">
                    <p class="row__title">{{ item.title }}</p>
                    <p class="row__description">{{ item.description }}</p>
                    <button type="button"
                            class="row__btn-remove"
                            title="Видалити"
                            @click="removeWord(item)">
                        ⛔
                    </button>
                </div>
            </div>

        </section>
    </article>
</template>

<script>
import MsgPopup from "../more/MsgPopup.vue";

export default {
    name: "DictionarySetting",
    components: {
        MsgPopup
    },
    data() {
        return {
            newWord: {
                wordName: '',
                description: '',
            },
            words: [],
            popup: {
                show: false,
                type: '',
                message: '',
            },
        }
    },
    methods: {
        getWordsList() {
            axios.get('api/dictionary/get')
                .then(response => {
                    this.words = []

                    this.words = response.data.items
                })
                .catch(error => {
                    console.log(error);
                })

        },

        addNewWord() {
            const title = this.newWord.wordName
            const description = this.newWord.description

            if (title.length < 5) {
                this.popupConfig('warning', 'Поле "Назва" повинно містити щонайменше 5 символів')
                return;
            }
            if (description.length < 10) {
                this.popupConfig('warning', 'Поле "Опис" повинно містити щонайменше 10 символів')
                return
            }

            axios.post('api/dictionary/create', {
                title: title,
                description: description
            })
                .then(response => {

                    this.popupConfig('success', 'Нове слово успішно створено!')
                    this.getWordsList()
                    this.newWord.wordName = ''
                    this.newWord.description = ''
                })
                .catch(error => {
                    console.log(error.data);
                    if (error.response.data.errors.title[0]) {
                        this.popupConfig('warning', `Назва "${title}" уже існує!`);
                    }
                })
        },

        removeWord(item) {
            if (!confirm(`Ви впевнені, що бажаєте видалити дане слово із словника?`)) {
                this.popupConfig('error', 'Не вдалося видалити слово!')
                return;
            }

            axios.delete(`api/dictionary/delete/${item.id}`)
                .then(response => {
                    this.popupConfig('success', 'Слово успішно видалено!')
                    this.getWordsList()
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
        this.getWordsList()
    }
}
</script>

<style lang="scss" scoped>
@import "@/../sass/admin/_dictionary-setting.scss";
@import "@/../sass/admin/_book-setting.scss";

</style>
