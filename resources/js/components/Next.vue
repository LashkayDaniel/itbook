<template>
    <to-top/>
    <div class="container">
        <!--        <div class="block">-->
        <!--            <h1 class="block__title">Main pageee</h1>-->
        <!--            <p class="block__text">text text text</p>-->
        <!--        </div>-->

        <aside class="themes">
            <!--            <ol class="themes__list">-->
            <!--                <li v-for="section in this.sections">-->
            <!--                    <p class="list__name"> {{ section.section }} </p>-->
            <!--                    <ol class="themes__link">-->
            <!--                        <li v-for="theme in section.themes">-->
            <!--                            <a class="link__name" href=""> {{ theme }}</a>-->
            <!--                        </li>-->
            <!--                        <hr>-->
            <!--                        <p style="color: #a0aec0"><i>Labs:</i></p>-->
            <!--                        <li style="list-style: '+'"><a style=" font-weight: bold">Lab 1</a></li>-->
            <!--                        <li style="list-style: '+'"><a style=" font-weight: bold">Lab 2</a></li>-->
            <!--                        <li style="list-style: '+'"><a style=" font-weight: bold">Lab 3</a></li>-->

            <!--                    </ol>-->
            <!--                </li>-->
            <!--            </ol>-->

            <ol v-if="preloader.themes" class="themes__list--preloader">
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
            </ol>

            <ol v-else class="themes__list">
                <li v-for="(section,index) in this.sections">
                    <div class="list__item"
                         @click="section.isExpand=!section.isExpand;">
                        <div class="item__name"
                             :class="{'item__name--active' : section.isExpand}">
                            {{ section.section }}
                        </div>
                        <div class="item__icon" :class="{'item__icon--active':section.isExpand}">
                            <span></span>
                        </div>
                    </div>

                    <ol v-if="section.isExpand" class="themes__link">
                        <li v-for="theme in section.themes">
                            <a class="link__name"
                               href=""
                               @click.prevent="getContent(theme)"
                               :class="{'link__name--active' : theme === selectedTheme}">
                                {{ theme }}
                            </a>
                        </li>
                        <hr v-if="false">
                        <p v-if="false" class="labs__title">Лабораторні роботи:</p>
                        <li v-if="false" class="labs__item" v-for="labs in section.labs">
                            <a class="">{{ labs.title }}</a>
                            <img src="@/../../resources/img/lock-icon.png"
                                 width="20"
                                 style="opacity: .8; margin-right: 10px"
                                 alt="lock icon">
                        </li>

                    </ol>
                    <hr>

                </li>
            </ol>
        </aside>

        <section class="block">
            <article v-if="preloader.description" class="block__start">
                <img src="@/../../resources/img/book-icon.png" alt="book icon">
                <div class="">Оберіть розділ, який Вас цікавить найбільше</div>
                <img id="arrow" src="@/../../resources/img/img_4.png" alt="book icon">
            </article>

            <div v-else>
                <article class="block__panel">
                    <div class="navigation">
                        <i class="navigation__link"
                           v-if="selectedSection!==''">
                            {{ selectedSection }}
                        </i>
                        <i class="navigation__link"
                           v-if="selectedTheme!==''">
                            {{ selectedTheme }}
                        </i>
                    </div>

                    <div class="search">
                        <input class="search__input" type="text" name="search" placeholder="Пошук у книзі">
                        <button class="search__btn" type="button">Пошук</button>
                    </div>
                </article>
                <article class="block__description" id="content">
                    <h2 class="description__title">{{ selectedTheme }}</h2>
                    <loader v-if="showLoader"/>

                    <div v-if="showEmptyPage" class="empty-page">
                        <img class="empty-page__image" src="@/../../resources/img/empty-page.png"
                             alt="empty page image">
                        <h2 class="empty-page__title">Сторінка порожня</h2>
                        <p class="empty-page__subtitle">Невдовзі тут з'явиться інформація</p>
                    </div>

                    <div v-for="(item, index) in contentHtml" :key="index"
                         v-html="item"></div>

                    <!--                    <img-->
                    <!--                        class="description__image"-->
                    <!--                        src="https://assets.datacamp.com/production/repositories/6051/datasets/828b5e4e65e978b6ad1b1b9d19ada4c0f9e5d772/employees_db.png"-->
                    <!--                        alt="image">-->


                    <hr>
                </article>
                <button v-if="!showEmptyPage && !showLoader" @click="downloadContent" class="description__btn-download">
                    Download
                </button>
            </div>
        </section>
    </div>
</template>

<script>
import ToTop from "@/components/ToTop.vue";
import Loader from "@/components/Loader.vue";

export default {
    name: "Next",
    components: {
        ToTop,
        Loader
    },
    data: function () {
        return {
            preloader: {
                themes: true,
                description: true,
            },

            showLoader: true,
            showEmptyPage: false,

            sections: [],
            contentHtml: [],
            selectedSection: '',
            selectedTheme: '',

        }
    },

    methods: {
        getSections() {
            axios.get('api/sections')
                .then(response => {
                    let data = response.data;
                    data.forEach(item => {
                        item.labs = [
                            {
                                id: 1,
                                title: 'lab 1'
                            },
                            {
                                id: 2,
                                title: 'lab 2'
                            }, {
                                id: 3,
                                title: 'lab 3'
                            },
                        ];

                        item.isExpand = false;
                        item.computedHeight = 0;

                    })

                    this.sections = data;
                    this.preloader.themes = false;

                    console.log(data);
                })
                .catch(error => {
                    console.log(error)
                })
        },

        getContent(themeName) {
            this.preloader.description = false
            this.selectedTheme = themeName
            this.contentHtml = []
            this.showLoader = true
            this.showEmptyPage = false

            axios.post('api/theme/getContent', {
                theme_name: themeName
            })
                .then(response => {
                    const resp = response.data.content
                    this.selectedSection = resp.section.name

                    if (resp.description !== "[]") {
                        this.contentHtml = JSON.parse(resp.description);
                    } else {
                        console.log('nooooot')
                        this.contentHtml = [];//[`<h2 class="description__title">${this.fillingPage.selectedTheme}</h2>`]
                        this.showEmptyPage = true
                    }
                    this.showLoader = false
                })
                .catch(error => {
                    console.log(error);
                });
        },

        downloadContent() {
            const content = document.getElementById('content');
            // const pdfDoc = new jsPDF();

            // Отримуємо HTML контент блоку
            // const contentHtml = content.innerHTML;
            // pdfDoc.output('dataurlnewwindow', {encoding: 'UTF-8'});

            // Додаємо HTML контент до PDF документу
            // pdfDoc.fromHTML(contentHtml);

            const docx = htmlDocx.asBlob(content.innerHTML);

// Save Word document
            saveAs(docx, `${this.selectedTheme}.docx`);

            // Зберігаємо PDF документ
            // pdfDoc.save('document.pdf');

            // html2pdf()
            //     .from(content)
            //     .save();
        },


    },

    created() {
        this.getSections();

    },


    mounted() {
    }

}
</script>

<style lang="scss" scoped>
@import '@/../sass/main/_main-page.scss';
@import '@/../sass/main/_main-page-preloaders.scss';

.container {
    max-width: 1500px;
    padding: 0 20px;
    margin: 20px auto;
    display: flex;
    justify-content: space-between;
}


</style>
