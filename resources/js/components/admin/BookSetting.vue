<template>
    <msg-popup v-if="popup.show" :message="popup.message" :type="popup.type"/>
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
                   v-if="fillingPage.selectedSection"
                   style="position: sticky; top:0px; background-color: rgb(132,132,164); color: #b0ced7">
                    <b>{{ fillingPage.selectedSection }} > {{ fillingPage.selectedTheme }}</b>
                </p>

                <hr class="break-line">

                <div class="add-new__block"
                     style="position: sticky; top:35px; background-color: rgb(132,132,164);"
                     v-if="fillingPage.selectedTheme!=='' && fillingPage.selectedSection!==''">

                    <button class="block__btn-add-new"
                            @click="addParagraph.showPanel = !addParagraph.showPanel"
                    >Додати текст
                    </button>

                    <input type="file" id="upload" hidden @change="imageUpload" accept="image/*"/>
                    <label for="upload" class="block__btn-add-new">Додати зображення</label>

                    <button class="block__btn-add-new"
                            @click="addImageName.showPanel = !addImageName.showPanel">
                        Додати назву картинки
                    </button>

                    <button class="block__btn-add-new"
                            @click="addCode.showPanel = !addCode.showPanel">
                        Додати код
                    </button>

                    <button class="block__btn-add-new"
                            @click="addSubparagraph.showPanel = !addSubparagraph.showPanel">
                        Додати підпункт
                    </button>

                    <button class="block__btn-add-new"
                            @click="addList.showPanel = !addList.showPanel">
                        Додати список
                    </button>

                    <button class="block__btn-add-new"
                            @click="addNote.showPanel = !addNote.showPanel">
                        Додати примітку
                    </button>

                    <div v-if="this.addParagraph.showPanel" class="paragraph">
                        <label for="paragraph" class="paragraph__label">Введіть текст:</label>
                        <textarea v-model="addParagraph.inputText" name="paragraph" class="paragraph__input"
                                  placeholder="Введіть текст"
                                  @keydown.enter="addNewParagraph(this.addParagraph.inputText)"/>
                        <button class="paragraph__btn-add"
                                @click="addNewParagraph(this.addParagraph.inputText)"
                        >Додати
                        </button>
                    </div>

                    <div v-if="this.addImageName.showPanel" class="paragraph">
                        <label for="paragraph" class="paragraph__label">Введіть назву картинки:</label>
                        <input v-model="addImageName.imageName"
                               name="paragraph"
                               class="paragraph__input-small"
                               placeholder="Введіть назву"
                               @keydown.enter="addNewImageName(addImageName.imageName)"/>
                        <button class="paragraph__btn-add"
                                @click="addNewImageName(addImageName.imageName)"
                        >Додати
                        </button>
                    </div>

                    <div v-if="this.addCode.showPanel" class="paragraph">
                        <label for="paragraph" class="paragraph__label">Введіть код:</label>
                        <textarea v-model="addCode.inputCode" name="paragraph" class="paragraph__input"
                                  placeholder="Введіть код"
                                  @keydown.enter="addNewCode(this.addCode.inputCode)"/>
                        <button class="paragraph__btn-add"
                                @click="addNewCode(this.addCode.inputCode)"
                        >Додати
                        </button>
                    </div>

                    <div v-if="this.addSubparagraph.showPanel" class="paragraph">
                        <label for="paragraph" class="paragraph__label">Введіть підпункт:</label>
                        <input v-model="addSubparagraph.inputName"
                               name="paragraph"
                               class="paragraph__input-small"
                               placeholder="Введіть назву"
                               @keydown.enter="addNewSubparagraph(this.addSubparagraph.inputName)"/>
                        <button class="paragraph__btn-add"
                                @click="addNewSubparagraph(this.addSubparagraph.inputName)"
                        >Додати
                        </button>
                    </div>

                    <div v-if="this.addList.showPanel" class="paragraph">
                        <label for="paragraph" class="paragraph__label">Введіть елемент списку:</label>
                        <input v-model="addList.inputName"
                               name="paragraph"
                               class="paragraph__input-small"
                               placeholder="Введіть назву"
                               @keydown.enter="addNewList(this.addList.inputName)"/>
                        <button class="paragraph__btn-add"
                                @click="addNewList(this.addList.inputName)"
                        >Додати
                        </button>
                    </div>

                    <div v-if="this.addNote.showPanel" class="paragraph">
                        <label for="paragraph" class="paragraph__label">Введіть код:</label>
                        <textarea v-model="addNote.inputText" name="paragraph" class="paragraph__input"
                                  placeholder="Введіть код"
                                  @keydown.enter="addNewNote(this.addNote.inputText)"/>
                        <button class="paragraph__btn-add"
                                @click="addNewNote(this.addNote.inputText)"
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

                    <loader v-if="showLoader"/>

                    <p v-if="fillingPage.emptyPage"
                       style="text-align: center; color: #c27868; letter-spacing: 1px"
                    >Сторінка порожня. Наповніть її</p>

                </div>

                <hr class="break-line">
                <button v-if="fillingPage.selectedTheme!=='' && fillingPage.selectedSection!=='' && hasEdit"
                        @click="saveHtmlContent"
                        class="description__btn-save">Зберегти
                </button>
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
                           required
                           v-model="newSection.newSectionName"
                    >
                    <select class="block__select" v-model="newSection.selectedSectionAfter">
                        <option value="" selected disabled>Додати після:</option>
                        <option v-for="section in sections" :value="section.name">{{ section.name }}</option>
                    </select>
                    <button @click.prevent="addNewSection" class="block__btn-add">Додати</button>
                </div>
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
                    <select class="block__select"
                            v-model="newTheme.selectedSection"
                            @change="newSectionChange">
                        <option value="" selected disabled>Додати до розділу:</option>
                        <option v-for="section in sections" :value="section.name">{{ section.name }}</option>

                    </select>
                    <select class="block__select" v-model="newTheme.selectedThemeAfter">
                        <option value="" selected disabled>Додати після:</option>
                        <option v-for="theme in newTheme.themesList" :value="theme.title">{{ theme.title }}</option>
                    </select>
                    <button @click.prevent="addNewTheme" class="block__btn-add">Додати</button>
                </div>
            </div>

            <hr class="break-line">

            <div class="add-new">
                <h2 class="add-new__title">Редагування назви розділу</h2>
                <hr/>
                <div class="add-new__block">
                    <select class="block__select"
                            v-model="renameSection.oldSection">
                        <option value="" selected disabled>Виберіть розділ:</option>
                        <option v-for="section in sections" :value="section.name">{{ section.name }}</option>
                    </select>
                    <input type="text"
                           class="block__input-name"
                           placeholder="Нова назва"
                           v-model="renameSection.newSectionName"
                           required
                    >
                    <button v-if="renameSection.oldSection" @click.prevent="renameSectionMethod()"
                            class="block__btn-add">Змінити
                    </button>
                </div>
            </div>

            <hr class="break-line">

            <div class="add-new">
                <h2 class="add-new__title">Редагування назви теми</h2>
                <hr/>
                <div class="add-new__block">
                    <select class="block__select"
                            v-model="renameTheme.selectedSection"
                            @change="renameThemeChange">
                        <option value="" selected disabled>Виберіть розділ:</option>
                        <option v-for="section in sections" :value="section.name">{{ section.name }}</option>
                    </select>
                    <select class="block__select" v-model="renameTheme.oldTheme">
                        <option value="" selected disabled>Виберіть тему:</option>
                        <option v-for="theme in renameTheme.themesList"
                                :value="theme.title">{{ theme.title }}
                        </option>
                    </select>
                    <input type="text"
                           class="block__input-name"
                           placeholder="Нова назва"
                           v-model="renameTheme.newThemeName"
                           required
                    >
                    <button v-if="renameTheme.oldTheme" @click.prevent="renameThemeMethod()"
                            class="block__btn-add">Змінити
                    </button>
                </div>
            </div>

            <hr class="break-line">

            <div class="add-new">
                <h2 class="add-new__title">Видалення розділу</h2>
                <hr/>
                <div class="add-new__block">
                    <select class="block__select" v-model="deleteSection.selectedSection">
                        <option value="" selected disabled>Виберіть розділ:</option>
                        <option v-for="section in sections" :value="section.id">{{ section.name }}</option>
                    </select>
                    <button v-if="deleteSection.selectedSection" @click.prevent="deleteSectionById()"
                            class="block__btn-remove">Видалити
                    </button>
                </div>
            </div>
            <hr class="break-line">

            <div class="add-new">
                <h2 class="add-new__title">Видалення теми</h2>
                <hr/>
                <div class="add-new__block">
                    <select class="block__select"
                            v-model="deleteTheme.selectedSection"
                            @change="deleteThemeChange">
                        <option value="" selected disabled>Виберіть розділ:</option>
                        <option v-for="section in sections" :value="section.name">{{ section.name }}</option>
                    </select>
                    <select class="block__select" v-model="deleteTheme.selectedTheme">
                        <option value="" selected disabled>Виберіть тему:</option>
                        <option v-for="theme in deleteTheme.themesList"
                                :value="theme.title">{{ theme.title }}
                        </option>
                    </select>
                    <p class="block__label" v-if="deleteTheme.selectedTheme"><b>Вибрано:</b>
                        "{{ deleteTheme.selectedSection }}" > "{{ deleteTheme.selectedTheme }}"</p>
                    <button v-if="deleteTheme.selectedTheme" @click.prevent="deleteThemeById"
                            class="block__btn-remove">Видалити
                    </button>
                </div>
            </div>

        </section>

    </article>
</template>

<script>
import MsgPopup from "@/components/MsgPopup.vue";
import Loader from "@/components/Loader.vue";

export default {
    name: "BookSetting",
    components: {
        MsgPopup,
        Loader
    },
    data() {
        return {
            addParagraph: {
                showPanel: false,
                inputText: '',
            },

            addImageName: {
                showPanel: false,
                imageName: '',
            },

            addCode: {
                showPanel: false,
                inputCode: '',
            },

            addSubparagraph: {
                showPanel: false,
                inputName: '',
            },

            addList: {
                showPanel: false,
                inputName: '',
            },

            addNote: {
                showPanel: false,
                inputText: '',
            },

            htmlContentArray: [],
            sections: [],
            hasEdit: false,
            showLoader: false,

            popup: {
                show: false,
                type: '',
                message: '',
            },

            fillingPage: {
                filteredThemes: [],
                selectedSection: '',
                selectedTheme: '',
                emptyPage: false,
            },

            newSection: {
                newSectionName: '',
                selectedSectionAfter: '',
            },

            newTheme: {
                themesList: [],
                newThemeName: '',
                selectedSection: '',
                selectedThemeAfter: '',
            },

            renameSection: {
                oldSection: '',
                newSectionName: '',
            },

            renameTheme: {
                selectedSection: '',
                themesList: [],
                oldTheme: '',
                newThemeName: '',
            },

            deleteSection: {
                selectedSection: ''
            },
            deleteTheme: {
                selectedSection: '',
                themesList: [],
                selectedTheme: ''
            }

        }
    },
    methods: {
        addNewParagraph(text) {
            if (text.trim().length <= 6) {
                this.popupConfig('warning', 'Поле повинно містити щонайменше 6 символів')
                return;
            }
            this.htmlContentArray.push(`<p class="description__paragraph">${text}</p>`);
            this.popupConfig('success', 'Елемент успішно додано!')

            this.addParagraph.showPanel = false;
            this.addParagraph.inputText = ''
            this.fillingPage.emptyPage = false
            this.hasEdit = true
        },

        addNewImage(imageUrl) {
            this.htmlContentArray.push(`<img src="${imageUrl}" alt="image" class="description__image"/>`);
            this.fillingPage.emptyPage = false;
            this.popupConfig('success', 'Зображення успішно додано!')
        },

        addNewImageName(name) {
            if (name.trim().length < 5) {
                this.popupConfig('warning', 'Поле повинно містити щонайменше 5 символів')
                return;
            }
            this.htmlContentArray.push(`<figcaption class="description__image-name">${name}</figcaption>`);

            this.addImageName.showPanel = false;
            this.addImageName.imageName = ''
            this.fillingPage.emptyPage = false;
            this.hasEdit = true
        },

        addNewCode(code) {
            if (code.trim().length < 6) {
                this.popupConfig('warning', 'Поле повинно містити щонайменше 6 символів')
                return;
            }
            this.addCode.inputCode = this.addCode.inputCode.replace(/</g, '&lt;').replace(/>/g, '&gt;');
            this.htmlContentArray.push(`<pre class="description__code"><code>${code}</code></pre>`);

            this.addCode.showPanel = false;
            this.addCode.inputCode = ''
            this.fillingPage.emptyPage = false;
            this.hasEdit = true
        },

        addNewSubparagraph(name) {
            if (name.trim().length < 4) {
                this.popupConfig('warning', 'Поле повинно містити щонайменше 4 символів')
                return;
            }
            this.htmlContentArray.push(`<h2 class="description__subparagraph">${name}</h2>`);

            this.addSubparagraph.showPanel = false;
            this.addSubparagraph.inputName = ''
            this.fillingPage.emptyPage = false;
            this.hasEdit = true
        },

        addNewList(name) {
            if (name.trim().length < 2) {
                this.popupConfig('warning', 'Поле повинно містити щонайменше 2 символів')
                return;
            }
            this.htmlContentArray.push(`<p class="description__list-item">${name}</p>`);

            this.addList.showPanel = false;
            this.addList.inputName = ''
            this.fillingPage.emptyPage = false;
            this.hasEdit = true
        },

        addNewNote(text) {
            if (text.trim().length <= 6) {
                this.popupConfig('warning', 'Поле повинно містити щонайменше 6 символів')
                return;
            }
            this.htmlContentArray.push(`<div class="description__note"><p class="description__note-text">${text}</p></div>`);

            this.addNote.showPanel = false;
            this.addNote.inputCode = ''
            this.fillingPage.emptyPage = false;
            this.hasEdit = true
        },

        imageUpload: function (event) {
            const imageFile = event.target.files[0];

            const formData = new FormData();
            formData.append('image', imageFile);

            axios.post('api/theme/imageUpload', formData)
                .then(response => {
                    const imageName = response.data.image_name;
                    console.log('image name: ' + imageName);

                    const imageUrl = `/storage/uploads/images/${imageName}`
                    this.addNewImage(imageUrl)
                    this.hasEdit = true
                })
                .catch(error => {
                    console.log(error);
                    const errors = error.response.data.errors;
                    let message
                    errors.hasOwnProperty('image') ? message = errors.image[0] : ''
                    this.popupConfig('warning', message)

                })
        },

        saveHtmlContent() {
            axios.post('api/theme/createDescription', {
                theme_name: this.fillingPage.selectedTheme,
                description: JSON.stringify(this.htmlContentArray)
            })
                .then(response => {
                    console.log(response);
                    this.hasEdit = false
                    this.popupConfig('success', 'Успішно збережено!')
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

            if (this.htmlContentArray.length === 0) {
                this.fillingPage.emptyPage = true
            }

            this.hasEdit = true
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

        async getThemes(sectionName) {
            try {
                const response = await axios.post('api/theme/get', {section_name: sectionName});
                return response.data.themes;
            } catch (error) {
                console.log(error);
                this.popupConfig('error', 'Невдалося отримати теми: ' + error)
                return null;
            }
        },

        getContent(themeName) {
            this.showLoader = true

            axios.post('api/theme/getContent', {
                theme_name: themeName
            })
                .then(response => {
                    const resp = response.data.content
                    const description = resp.description

                    if (description !== "[]") {
                        this.htmlContentArray = JSON.parse(description);
                        this.fillingPage.emptyPage = false
                    } else {
                        console.log('nooooot')
                        this.htmlContentArray = []
                        this.fillingPage.emptyPage = true
                    }
                    this.showLoader = false

                })
                .catch(error => {
                    console.log(error);
                });
        },

////test
        addNewSection() {
            const sectionName = this.newSection.newSectionName;
            if (sectionName.length < 4) {
                this.popupConfig('warning', 'Назва розділу повинна містити щонайменше 4 символів')
                return;
            }
            const data = {
                section_name: sectionName
            }

            const insertAfter = this.newSection.selectedSectionAfter;

            if (insertAfter) {
                data.insert_after = insertAfter
            }

            axios.post('api/section/create', data)
                .then(response => {
                    console.log(response);
                    this.newSection.addSuccess = response.data.status;
                    this.popupConfig('success', 'Новий розділ успішно створено!')
                    this.getAllSections()

                    this.newSection.newSectionName = ''
                    this.newSection.selectedSectionAfter = ''

                    setTimeout(() => {
                        this.newSection.addSuccess = false
                    }, 2000);
                })
                .catch(error => {
                    console.log(error);
                })
        },

        addNewTheme() {
            const themeName = this.newTheme.newThemeName
            const selectedSection = this.newTheme.selectedSection
            if (themeName.length < 5) {
                this.popupConfig('warning', 'Назва теми повинна містити щонайменше 5 символів')
                return;
            }

            if (!selectedSection) {
                this.popupConfig('warning', 'Виберіть розділ, в який бажаєте додати нову тему')
                return;
            }

            const data = {
                title: themeName,
                section_name: selectedSection
            }

            const insertAfter = this.newTheme.selectedThemeAfter;

            if (insertAfter) {
                data.insert_after = insertAfter
            }

            axios.post('api/theme/create', data)
                .then(response => {
                    console.log(response);
                    this.newTheme.addSuccess = response.data.status;
                    this.popupConfig('success', 'Нову тему успішно створено!')
                    this.getAllThemes()

                    this.newTheme.newThemeName = ''
                    this.newTheme.selectedThemeAfter = ''
                    this.newTheme.selectedSection = ''
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
                .then(themes => {
                    this.fillingPage.filteredThemes = themes
                })
            this.fillingPage.selectedTheme = ''
            this.htmlContentArray = []
        },

        themeChange(event) {
            const themeName = event.target.value;
            this.getContent(themeName)
        },

        newSectionChange(event) {
            const sectionName = event.target.value;
            this.getThemes(sectionName)
                .then(themes => {
                    this.newTheme.themesList = themes
                })
        },

        deleteThemeChange(event) {
            const sectionName = event.target.value;
            this.getThemes(sectionName)
                .then(themes => {
                    if (themes.length === 0) {
                        this.popupConfig('warning', `В розділі "${sectionName}" немає тем`)
                        this.deleteTheme.selectedSection = ''
                    }
                    this.deleteTheme.themesList = themes
                })

            this.deleteTheme.selectedTheme = ''
        },

        renameThemeChange(event) {
            const sectionName = event.target.value;
            this.getThemes(sectionName)
                .then(themes => {
                    if (themes.length === 0) {
                        this.popupConfig('warning', `В розділі "${sectionName}" немає тем`)
                        this.renameTheme.selectedSection = ''
                    }
                    this.renameTheme.themesList = themes
                })

            this.renameTheme.oldTheme = ''
        },

        renameSectionMethod() {

            if (!this.renameSection.oldSection) {
                this.popupConfig('warning', 'Виберіть розділ, який бажаєте редагувати')
                return;
            }

            const newSectionName = this.renameSection.newSectionName
            if (newSectionName.length < 5) {
                this.popupConfig('warning', 'Назва розділу повинна містити щонайменше 5 символів')
                return;
            }

            const oldSection = this.sections.find(obj => obj.name === this.renameSection.oldSection);
            axios.patch(`api/section/update/${oldSection.id}`, {
                new_name: this.renameSection.newSectionName
            })
                .then(response => {
                    this.popupConfig('success', 'Розділ успішно змінено!')
                    this.renameSection.newSectionName = ''
                    this.renameSection.oldSection = ''
                    this.getAllSections()
                })
                .catch(error => {
                    this.popupConfig('error', error.response.data.errors.new_name[0])
                    this.renameSection.newSectionName = ''
                })
        },

        renameThemeMethod() {
            if (!this.renameTheme.oldTheme) {
                this.popupConfig('warning', 'Виберіть тему, який бажаєте редагувати')
                return;
            }

            const newThemeName = this.renameTheme.newThemeName
            if (newThemeName.length < 5) {
                this.popupConfig('warning', 'Назва теми повинна містити щонайменше 5 символів')
                return;
            }

            const currentTheme = this.renameTheme.themesList.find(obj => obj.title === this.renameTheme.oldTheme);
            axios.patch('api/theme/update/' + currentTheme.id, {
                new_name: this.renameTheme.newThemeName
            })
                .then(response => {
                    this.popupConfig('success', 'Тему успішно видалено!')
                    this.renameTheme.selectedSection = ''
                    this.renameTheme.oldTheme = ''
                    this.renameTheme.newThemeName = ''
                    this.getAllThemes()
                })
                .catch(error => {
                    console.log(error);
                    this.popupConfig('error', error.response.data.errors.new_name[0])
                    this.renameTheme.newThemeName = ''
                })
        },

        deleteSectionById() {
            if (!confirm(`Ви впевнені, що бажаєте видалити розділ? Всі теми будуть також видалені`)) {
                this.popupConfig('error', 'Не вдалося видалити розділ!')
                this.deleteSection.selectedSection = ''
                return;
            }

            const sectionId = this.deleteSection.selectedSection;
            axios.delete('api/section/delete/' + sectionId)
                .then(response => {
                    this.popupConfig('success', 'Розділ успішно видалено!')
                    this.deleteSection.selectedSection = ''
                    this.getAllSections()
                })

        },
        deleteThemeById() {
            if (!confirm(`Ви впевнені що бажаєте видалити тему?`)) {
                this.popupConfig('error', 'Не вдалося видалити тему!')
                this.deleteTheme.selectedSection = ''
                this.deleteTheme.selectedTheme = ''
                this.deleteTheme.themesList = []
                return;
            }

            const currentTheme = this.deleteTheme.themesList.find(obj => obj.title === this.deleteTheme.selectedTheme);
            axios.delete('api/theme/delete/' + currentTheme.id)
                .then(response => {
                    this.popupConfig('success', 'Тему успішно видалено!')
                    this.deleteTheme.selectedSection = ''
                    this.deleteTheme.selectedTheme = ''
                    this.deleteTheme.themesList = []

                    this.getAllThemes()
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
        // this.beforeExit();
        // window.addEventListener('beforeunload', function (e) {
        //     // Відміна захоплення події, якщо користувач вибирає залишитися на сторінці
        //     e.preventDefault();
        //     // Встановлення тексту за замовчуванням
        //     e.returnValue = '';
        //     // Показуємо спливаюче вікно
        //     var confirmationMessage = 'Are you sure you want to leave?';
        //     (e || window.event).returnValue = confirmationMessage;
        //     return confirmationMessage;
        // });

        //// api call
        this.getAllSections();
        this.getAllThemes();

    },

    beforeUnmount() {
        // if (this.hasEdit) {
        //     window.addEventListener('load', function (e) {
        //         e.preventDefault();
        //         if (confirm('У вас є незбережена інформація. Зберегти її?')) {
        //             this.saveHtmlContent()
        //         } else {
        //             alert('no saved')
        //         }
        //
        //     });
        // }
        if (this.hasEdit) {
            if (confirm('У вас є незбережена інформація. Зберегти її?')) {
                this.saveHtmlContent()
            }
        }

    },

}
</script>

<style lang="scss" scoped>
@import "@/../sass/admin/_book-setting.scss";

</style>
