<template>
    <article class="main-block">
        <section class="left">
            <div class="add-new">
                <h2 class="add-new__title">Наповнення сторінки</h2>
                <hr>
                <div class="add-new__block">
                    <label class="block__label" for="sections">Виберіть розділ: </label>
                    <select class="block__select" name="sections">
                        <option value="" selected disabled>-- Розділи --</option>
                        <option value="">Вступ</option>
                        <option value="">Моделі даних</option>
                        <option value="">Структура реляційних бд</option>
                        <option value="">Проектування баз даних</option>
                    </select>
                </div>

                <div class="add-new__block">
                    <label class="block__label  " for="themes">Виберіть тему: </label>
                    <select class="block__select" name="themes">
                        <option value="" selected disabled>-- Теми --</option>
                        <option value="">Вступ</option>
                        <option value="">Моделі даних</option>
                        <option value="">Структура реляційних бд</option>
                        <option value="">Проектування баз даних</option>
                    </select>
                </div>

                <hr class="break-line">
                <p class="block__label"><b>Вступ > Історія баз даних</b></p>
                <hr class="break-line">

                <div class="add-new__block" style="position: sticky; top:0px; background-color: rgb(132,132,164)">
                    <button class="block__btn-add-themes"
                            @click="addParagraph.showPanel = !addParagraph.showPanel"
                    >Додати текст
                    </button>

                    <input type="file" id="upload" hidden @change="imageUpload"/>
                    <label for="upload" class="block__btn-add-themes">Додати зображення</label>

                    <button class="block__btn-add-themes"
                            @click="addNewCode('s')">Додати код
                    </button>

                    <div v-if="this.addParagraph.showPanel" class="paragraph">
                        <label for="paragraph" class="paragraph__label">Введіть текст:</label>
                        <textarea v-model="addParagraph.inputText" name="paragraph" class="paragraph__input"
                                  placeholder="Введіть текст"/>
                        <button class="paragraph__btn-add"
                                @click="addNewParagraph(this.addParagraph.inputText)"
                        >Додати
                        </button>
                    </div>
                </div>
                <hr class="break-line">


                <!--                <div @click="removeElement" class="description">-->
                <!--                    <div v-html="htmlContent" @input="updateMyHtmlContent"></div>-->
                <!--                </div>-->

                <div class="description" @click="removeElement">
                    <div v-for="(item, index) in htmlContentArray" :key="index" @click="removeItem(index)"
                         v-html="item"></div>
                </div>

                <hr class="break-line">
                <button @click="saveHtmlContent" class="description__btn-save">Зберегти</button>
            </div>
        </section>
        <section class="right">
            <div class="add-new">
                <h2 class="add-new__title">Новий розділ</h2>
                <hr/>
                <div class="add-new__block">
                    <input type="text"
                           class="block__input-name"
                           placeholder="Введіть назву"
                    >
                    <select class="block__select">
                        <option value="" selected disabled>Додати після:</option>
                        <option value="">Вступ</option>
                        <option value="">Моделі даних</option>
                        <option value="">Структура реляційних бд</option>
                        <option value="">Проектування баз даних</option>
                    </select>
                    <button @click.prevent="" class="block__btn-add">Додати</button>
                </div>

                <p class="add-new__success">✔ Успішно додано!</p>
            </div>

            <hr class="break-line">

            <div class="add-new">
                <h2 class="add-new__title">Нова тема</h2>
                <hr/>
                <div class="add-new__block">
                    <input type="text"
                           class="block__input-name"
                           placeholder="Введіть назву"
                    >
                    <select class="block__select">
                        <option value="" selected disabled>Додати до розділу:</option>
                        <option value="">Вступ</option>
                        <option value="">Моделі даних</option>
                        <option value="">Структура реляційних бд</option>
                        <option value="">Проектування баз даних</option>
                    </select>
                    <select class="block__select">
                        <option value="" selected disabled>Додати після:</option>
                        <option value="">Вступ</option>
                        <option value="">Моделі даних</option>
                        <option value="">Структура реляційних бд</option>
                        <option value="">Проектування баз даних</option>
                    </select>
                    <button @click.prevent="" class="block__btn-add">Додати</button>
                </div>
            </div>
        </section>

    </article>
</template>

<script>
export default {
    name: "BookSetting",
    data() {
        return {
            addParagraph: {
                showPanel: false,
                inputText: '',
            },
            htmlContent: '<h2 class="description__title">Історія баз даних</h2>',
            htmlContentArray: ['<h2 class="description__title">Історія баз даних</h2>'],
        }
    },
    methods: {
        addNewParagraph(text) {
            this.htmlContentArray.push(`<p class="description__paragraph">${text}</p>`);
            this.addParagraph.showPanel = false;
            this.addParagraph.inputText = ''
        },

        addNewImage(imageUrl) {
            this.htmlContentArray.push(`<img src="${imageUrl}" alt="image" class="description__image"/>`);
        },

        addNewCode(code) {
            this.htmlContentArray.push(`<pre class="description__code">
<div>
INSERT INTO \`users\`
VALUE AS (...)

&lt;?php&gt;
</div>
</pre>`);
        },

        updateMyHtmlContent(event) {
            this.htmlContent = event.target.innerHTML;
        },

        imageUpload(event) {
            const file = event.target.files[0];
            const imageUrl = URL.createObjectURL(file);
            this.addNewImage(imageUrl)
        },

        saveHtmlContent() {
            console.log(this.htmlContent)
        },
//////////////////////////////////////////////
        removeElement(event) {
            event.target.parentNode.removeChild(event.target);
        },
        removeItem(index) {
            this.htmlContentArray.splice(index, 1);
        },

        beforeExit() {

        }
    },
    created() {
        this.beforeExit();
        window.addEventListener('beforeunload', function (e) {
            // Відміна захоплення події, якщо користувач вибирає залишитися на сторінці
            e.preventDefault();
            // Встановлення тексту за замовчуванням
            e.returnValue = '';
            // Показуємо спливаюче вікно
            var confirmationMessage = 'Are you sure you want to leave?';
            (e || window.event).returnValue = confirmationMessage;
            return confirmationMessage;
        });

    },

    beforeUnmount() {
        window.addEventListener('beforeunload', function (e) {
            // Відміна захоплення події, якщо користувач вибирає залишитися на сторінці
            e.preventDefault();
            // Встановлення тексту за замовчуванням
            e.returnValue = '';
            // Показуємо спливаюче вікно
            var confirmationMessage = 'Are you sure you want to leave?';
            (e || window.event).returnValue = confirmationMessage;
            return confirmationMessage;
        });
        this.beforeExit();
    },

}
</script>

<style lang="scss" scoped>
@import "@/../sass/admin/_book-setting.scss";

</style>
