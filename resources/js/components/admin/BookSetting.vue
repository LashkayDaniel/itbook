<template>
    <article class="main-block">
        <section class="left">
            <div class="add-new">
                <h2 class="add-new__title">Наповнення сторінки</h2>
                <hr>
                <div class="add-new__block">
                    <label class="block__label" for="sections">Виберіть розділ: </label>
                    <select class="block__select" name="sections" v-model="fillingPage.selectedSection"
                            @change="sectionChange">
                        <option value="" selected disabled>-- Розділи --</option>
                        <option v-for="section in sections" :value="section.name">{{ section.name }}</option>
                    </select>
                </div>

                <div class="add-new__block">
                    <label class="block__label" for="themes">Виберіть тему: </label>
                    <select class="block__select" name="themes" v-model="fillingPage.selectedTheme"
                            @change="themeChange">>
                        <option value="" selected disabled>-- Теми --</option>
                        <option v-for="theme in fillingPage.filteredThemes" :value="theme.title">{{
                                theme.title
                            }}
                        </option>
                    </select>
                </div>
                <hr class="break-line">

                <p class="block__label"
                   v-if="fillingPage.selectedSection">
                    <b>{{ fillingPage.selectedSection }} > {{ fillingPage.selectedTheme }}</b>
                </p>

                <hr class="break-line">

                <div class="add-new__block"
                     style="position: sticky; top:0px; background-color: rgb(132,132,164)"
                     v-if="fillingPage.selectedTheme!=='' && fillingPage.selectedSection!==''"
                >

                    <button class="block__btn-add-themes"
                            @click="addParagraph.showPanel = !addParagraph.showPanel"
                    >Додати текст
                    </button>

                    <input type="file" id="upload" hidden @change="imageUpload" accept="image/*"/>
                    <label for="upload" class="block__btn-add-themes">Додати зображення</label>

                    <button class="block__btn-add-themes"
                            @click="addCode.showPanel = !addCode.showPanel">
                        Додати код
                    </button>

                    <button class="block__btn-add-themes"
                            @click="">
                        Додати список
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

                    <div v-if="this.addCode.showPanel" class="paragraph">
                        <label for="paragraph" class="paragraph__label">Введіть код:</label>
                        <textarea v-model="addCode.inputCode" name="paragraph" class="paragraph__input"
                                  placeholder="Введіть код"/>
                        <button class="paragraph__btn-add"
                                @click="addNewCode(this.addCode.inputCode)"
                        >Додати
                        </button>
                    </div>
                </div>
                <hr class="break-line">

                <div class="description">
                    <div v-for="(item, index) in htmlContentArray" :key="index"
                         v-on:dblclick="removeItem(item,index)"
                         title="Клікніть 2 рази, щоб видалити"
                         v-html="item"></div>

                    <p v-if="fillingPage.emptyPage"
                       style="text-align: center; color: #c27868; letter-spacing: 1px"
                    >Сторінка порожня. Наповніть її</p>

                    <!--                    <img :src="`/storage/uploads/images/1683834356.image2.png`" alt="img">-->
                </div>

                <hr class="break-line">
                <button v-if="fillingPage.selectedTheme!=='' && fillingPage.selectedSection!==''"
                        @click="saveHtmlContent"
                        class="description__btn-save">Зберегти
                </button>
            </div>
        </section>
        <section class="right">
            <div class="add-new">
                <h2 class="add-new__title">Новий розділ</h2>
                <hr/>
                <form class="add-new__block">
                    <input type="text"
                           class="block__input-name"
                           placeholder="Введіть назву"
                           required
                           v-model="newSection.newSectionName"
                    >
                    <select class="block__select" v-model="newSection.selectedSectionAfter">
                        <option value="" selected disabled>Додати після:</option>
                        <option v-for="section in sections" :value="section.name">{{ section.name }}</option>
                    </select>
                    <button @click.prevent="addNewSection" class="block__btn-add">Додати</button>
                </form>

                <p v-if="newSection.addSuccess" class="add-new__success">✔ Успішно додано!</p>
            </div>

            <hr class="break-line">

            <div class="add-new">
                <h2 class="add-new__title">Нова тема</h2>
                <hr/>
                <div class="add-new__block">
                    <input type="text"
                           class="block__input-name"
                           placeholder="Введіть назву"
                           v-model="newTheme.newThemeName"
                           required
                    >
                    <select class="block__select" v-model="newTheme.selectedSection">
                        <option value="" selected disabled>Додати до розділу:</option>
                        <option v-for="section in sections" :value="section.name">{{ section.name }}</option>

                    </select>
                    <select class="block__select">
                        <option value="" selected disabled>Додати після:</option>
                        <option value="">Вступ</option>
                        <option value="">Моделі даних</option>
                        <option value="">Структура реляційних бд</option>
                        <option value="">Проектування баз даних</option>
                    </select>
                    <button @click.prevent="addNewTheme" class="block__btn-add">Додати</button>
                </div>
            </div>
            <p v-if="newTheme.addSuccess" class="add-new__success">✔ Успішно додано!</p>

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

            addCode: {
                showPanel: false,
                inputCode: '',
            },

            htmlContentArray: [],
            sections: [],
            themes: [],

            fillingPage: {
                filteredThemes: [],
                selectedSection: '',
                selectedTheme: '',
                emptyPage: false,
            },

            newSection: {
                newSectionName: '',
                selectedSectionAfter: '',
                addSuccess: false,
            },

            newTheme: {
                newThemeName: '',
                selectedSection: '',
                addSuccess: false,
            },

        }
    },
    methods: {
        addNewParagraph(text) {
            this.htmlContentArray.push(`<p class="description__paragraph">${text}</p>`);
            this.addParagraph.showPanel = false;
            this.addParagraph.inputText = ''
            this.fillingPage.emptyPage = false

        },

        addNewImage(imageUrl) {
            this.htmlContentArray.push(`<img src="${imageUrl}" alt="image" class="description__image"/>`);
            this.fillingPage.emptyPage = false
        },

        addNewCode(code) {

            this.addCode.inputCode = this.addCode.inputCode.replace(/</g, '&lt;').replace(/>/g, '&gt;');

            this.htmlContentArray.push(`<pre class="description__code"><code>${this.addCode.inputCode}</code></pre>`);

            // INSERT INTO `users`
            // VALUE AS (...)
            //
            // &lt;?php&gt;
            this.addCode.showPanel = false;
            this.addCode.inputCode = ''
            this.fillingPage.emptyPage = false

        },

        updateMyHtmlContent(event) {
            this.htmlContent = event.target.innerHTML;
        },

        imageUpload(event) {
            const imageFile = event.target.files[0];
            console.log(imageFile);
            const imageUrl = URL.createObjectURL(imageFile);


            const formData = new FormData();
            formData.append('image', imageFile);

            axios.post('api/theme/imageUpload', formData)
                .then(response => {
                    const imageName = response.data.image_name;
                    console.log('image name: ' + imageName);

                    const imageUrl = `/storage/uploads/images/${imageName}`
                    this.addNewImage(imageUrl)


                })
                .catch(error => {

                })
        },

        saveHtmlContent() {
            // let htmlContent = ''
            // let arr = []
            // this.htmlContentArray.forEach(elem => {
            //     htmlContent += elem;
            //     arr.push(elem)
            // })
            // console.log('From saved: ' + JSON.stringify(htmlContent))
            // console.log('From array: ' + arr)
            // console.log('From array 2: ' + JSON.stringify(this.htmlContentArray))

            axios.post('api/theme/createDescription', {
                theme_name: this.fillingPage.selectedTheme,
                description: JSON.stringify(this.htmlContentArray)
            })
                .then(response => {
                    console.log(response);
                })
                .catch(error => {
                    console.log(error);
                })

        },
//////////////////////////////////////////////
        removeItem(item, index) {
            const contentType = item.substring(item.indexOf('<') + 1, item.indexOf(' '));
            if (contentType === 'img') {
                const img = document.createElement('div');
                img.innerHTML = item;

                const src = img.querySelector('img').getAttribute('src');
                const imageName = src.split('/').pop()
                img.remove()


                axios.post('api/theme/imageRemove', {
                    image_name: imageName,
                })
                    .then(response => {
                        console.log(response);
                    })
                    .catch(error => {
                        console.log(error);
                    })
            }

            this.htmlContentArray.splice(index, 1);


        },

        beforeExit() {

        },


        //// api
        getAllSections() {
            axios.get('api/section/getAll')
                .then(response => {
                    this.sections = response.data
                })
                .catch(error => {
                    console.log(error);
                })
        },
        getAllThemes() {
            axios.get('api/theme/getAll')
                .then(response => {
                    this.themes = response.data
                })
                .catch(error => {
                    console.log(error);
                })
        },

        getThemes(sectionName) {
            axios.post('api/theme/get', {
                section_name: sectionName
            })
                .then(response => {
                    this.fillingPage.filteredThemes = response.data.themes
                })
                .catch(error => {
                    console.log(error);
                })
        },

        getContent(themeName) {
            axios.post('api/theme/getContent', {
                theme_name: themeName
            })
                .then(response => {
                    const resp = response.data.content
                    // console.log('response: ' + JSON.stringify(resp));
                    // console.log('length ' + JSON.parse(resp).length);
                    const description = resp.description

                    if (description !== "[]") {
                        this.htmlContentArray = JSON.parse(description);
                        this.fillingPage.emptyPage = false

                    } else {
                        console.log('nooooot')
                        this.htmlContentArray = []//[`<h2 class="description__title">${this.fillingPage.selectedTheme}</h2>`]
                        this.fillingPage.emptyPage = true
                    }
                })
                .catch(error => {
                    console.log(error);
                });
        },

////test
        addNewSection() {
            axios.post('api/section/create', {
                section_name: this.newSection.newSectionName,
                insert_after: this.newSection.selectedSectionAfter,
            })
                .then(response => {
                    console.log(response);
                    this.newSection.addSuccess = response.data.status;

                    setTimeout(() => {
                        this.newSection.addSuccess = false
                    }, 2000);
                })
                .catch(error => {
                    console.log(error);
                })
        },

        addNewTheme() {
            console.log(this.newTheme.newThemeName);
            console.log(this.newTheme.selectedSection);

            axios.post('api/theme/create', {
                title: this.newTheme.newThemeName,
                section_name: this.newTheme.selectedSection,
            })
                .then(response => {
                    console.log(response);
                    this.newTheme.addSuccess = response.data.status;

                    setTimeout(() => {
                        this.newTheme.addSuccess = false
                    }, 2000);
                })
                .catch(error => {
                    console.log(error);
                })
        },


        /////////// end api

        sectionChange(event) {
            const sectionName = event.target.value;
            this.getThemes(sectionName)
            this.fillingPage.selectedTheme = ''
            this.htmlContentArray = []
        },

        themeChange(event) {
            const themeName = event.target.value;
            this.getContent(themeName)
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

        //// api call
        this.getAllSections();
        this.getAllThemes();

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
