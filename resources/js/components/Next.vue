<template>
    <to-top/>
    <search
        v-if="search.showPanel"
        :inputText="search.inputValue"
        @showSearch="closeSearch"
        @showFindResult="showFoundedTheme"
    />
    <div class="container">
        <aside class="themes-menu"
               :class="{'themes-menu--active' : !preloader.description}"
               @click="showMenu">
            <div class="themes-menu__btn">ok</div>
            <div class="themes-menu__word">Зміст</div>
            <div class="themes-menu__btn">ок</div>
        </aside>

        <aside ref="themes" class="themes"
               :class="[{'themes--hide' : !preloader.description && showAsideMenu},
               {'themes--active' : !showAsideMenu}]">
            <div class="search" v-if="!preloader.themes">
                <input class="search__input"
                       type="text"
                       name="search"
                       v-model="search.inputValue"
                       @keyup.enter="this.search.showPanel=true"
                       placeholder="Пошук у книзі">
                <button class="search__btn"
                        type="button"
                        @click="this.search.showPanel=true">
                    Шукати
                </button>
            </div>

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
                         @click="toggleSection(index)">
                        <div class="item__name"
                             :class="{'item__name--active' : section.isExpand}">
                            {{ section.section }}
                        </div>
                        <div class="item__icon"
                             :class="{'item__icon--active':section.isExpand}"
                             @click="section.isExpand=false">
                            <span></span>
                        </div>
                    </div>

                    <ol v-if="section.isExpand" class="themes__link">
                        <li v-for="(theme,index) in section.themes">
                            <a class="link__name"
                               href=""
                               @click.prevent="getContent(theme)"
                               :class="{'link__name--active link__name--disabled' : theme === selectedTheme.name}">
                                {{ theme }}
                            </a>
                        </li>
                    </ol>
                    <hr>
                </li>
            </ol>
        </aside>

        <section class="block">
            <article v-if="preloader.description" class="block__start">
                <div class="block__first-arrow">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <img class="block__book-icon" src="@/../../resources/img/book-icon.png" alt="book icon">
                <div class="block__text">Оберіть розділ, який Вас цікавить найбільше</div>
                <img class="block__last-arrow" src="@/../../resources/img/img_4.png" alt="book icon">
            </article>

            <div v-else>
                <article class="block__panel">
                    <div class="navigation">
                        <i class="navigation__link"
                           v-if="selectedSection.name !=='' ">
                            {{ selectedSection.name }}
                        </i>
                        <i class="navigation__link"
                           v-if="selectedTheme.name !=='' ">
                            {{ selectedTheme.name }}
                        </i>
                    </div>

                    <button v-if="!showEmptyPage && hasUserToken"
                            @click="downloadContent"
                            title="Завантажити"
                            class="bottom__btn-download">
                        Завантажити
                    </button>
                </article>
                <article class="block__description" id="content">
                    <h2 class="description__title">{{ selectedTheme.name }}</h2>
                    <loader v-if="showLoader"/>

                    <div v-if="showEmptyPage" class="empty-page">
                        <img class="empty-page__image" src="@/../../resources/img/empty-page.png"
                             alt="empty page image">
                        <h2 class="empty-page__title">Сторінка порожня</h2>
                        <p class="empty-page__subtitle">Невдовзі тут з'явиться інформація</p>
                    </div>

                    <div v-for="(item, index) in contentHtml" :key="index"
                         v-html="this.highlightText(item,this.search.searchWord)">
                    </div>

                    <hr>
                </article>
            </div>

            <article class="bottom" v-if="!showLoader">
                <button v-if="showNextBtn"
                        class="bottom__btn-next"
                        @click="nextTheme">
                    Далі: <span>{{ nextThemeInfo.name }}</span>
                </button>
            </article>
        </section>
    </div>
</template>

<script>
import ToTop from "@/components/more/ToTop.vue";
import Loader from "@/components/more/Loader.vue";
import Search from "@/components/more/Search.vue";

export default {
    name: "Next",
    components: {
        ToTop,
        Loader,
        Search
    },
    data() {
        return {
            preloader: {
                themes: true,
                description: true,
            },

            windowWidth: 0,
            showAsideMenu: true,

            showLoader: true,
            showEmptyPage: false,
            showNextBtn: true,
            nextThemeInfo: '',

            sections: [],
            contentHtml: [],
            selectedSection: '',
            selectedTheme: '',

            hasUserToken: false,

            search: {
                showPanel: false,
                inputValue: '',
                showHighlightedText: false,
                searchWord: ''
            },
        }
    },

    methods: {
        showMenu() {
            this.showAsideMenu = !this.showAsideMenu
            console.log(this.showAsideMenu);
        },

        getSections() {
            axios.get('api/section/get')
                .then(response => {
                    let data = response.data;
                    data.forEach(item => {
                        item.isExpand = false;
                    })

                    this.sections = data;
                    this.preloader.themes = false;

                })
                .catch(error => {
                    console.log(error)
                })
        },

        toggleSection(index) {
            this.sections.forEach((section, i) => {
                section.isExpand = i === index;
            });

        },
        hideSection(index) {
            this.sections[index].isExpand = false
            console.log(this.sections[index].isExpand);
        },

        getContent(themeName) {
            this.preloader.description = false
            this.contentHtml = []
            this.showLoader = true
            this.showEmptyPage = false

            this.search.showHighlightedText = false

            this.selectedTheme = {
                name: themeName,
            }

            console.log('show Side Menu: ' + this.showAsideMenu);
            console.log('preloader: ' + this.preloader.description);

            if (this.windowWidth < 1100 && !this.showAsideMenu) {
                this.$refs.themes.className = 'themes--hide';
                console.log(this.$refs.themes.className);

            }

            axios.post('api/theme/getContent', {
                theme_name: themeName
            })
                .then(response => {
                    const resp = response.data.content

                    if (resp.description !== "[]") {
                        this.contentHtml = JSON.parse(resp.description);
                    } else {
                        this.contentHtml = []
                        this.showEmptyPage = true
                    }
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });


                    this.selectedSection = {
                        name: resp.section.name,
                        index: this.sections.findIndex(obj => obj.section === resp.section.name)
                    }

                    this.selectedTheme = {
                        name: themeName,
                        index: this.sections[this.selectedSection.index].themes.indexOf(this.selectedTheme.name)
                    }
                    this.showLoader = false

                    console.log('section: ' + this.selectedSection.index + ', theme: ' + this.selectedTheme.index)

                    const sectionId = this.selectedSection.index;
                    const nextThemeId = this.selectedTheme.index + 1;

                    const nextThemeName = this.sections[sectionId].themes[nextThemeId];

                    this.nextThemeInfo = {
                        name: nextThemeName,
                        index: nextThemeId,
                        section_id: sectionId
                    }
                    this.showNextBtn = this.sections[this.nextThemeInfo.section_id].themes.length !== this.nextThemeInfo.index;

                })
                .catch(error => {
                    console.log(error);
                });
        },

        checkUserToken() {
            const token = localStorage.getItem('x_xsrf_token')
            if (token) {
                this.hasUserToken = true;
            }
        },

        downloadContent() {
            const content = document.getElementById('content');
            const docx = htmlDocx.asBlob(content.innerHTML);

            saveAs(docx, `${this.selectedTheme.name}.docx`);

        },

        nextTheme() {
            const nextThemeName = this.nextThemeInfo.name
            if (nextThemeName !== undefined) {
                this.getContent(nextThemeName)
            }
        },

        createView() {
            axios.post('api/view/create')
                .then(response => {
                    console.log(response);
                })
                .catch(error => {
                    console.log(error);
                })
        },
        deleteView() {
            axios.post('api/view/delete')
                .then(response => {
                    console.log(response);
                })
                .catch(error => {
                    console.log(error);
                })
        },

        closeSearch() {
            this.search.showPanel = false
            this.search.inputValue = ''
        },
        showFoundedTheme(item) {
            console.log(item.title);
            console.log(item.searchWord);
            this.getContent(item.title)
            this.search.searchWord = item.searchWord
            this.search.showHighlightedText = true
        },
        highlightText(text, search) {
            if (!this.search.showHighlightedText || !search) {
                return text;
            }
            const regex = new RegExp(`(${search})`, 'gi');
            return text.replace(regex, '<span style="background-color:rgba(222,222,88,0.87); color: darkred">$1</span>');
        },


    },

    created() {
        this.getSections();
        this.checkUserToken();
        window.addEventListener('resize', () => {
            this.windowWidth = window.innerWidth
        });
    },


    mounted() {
        // this.createView();
        // document.addEventListener("visibilitychange", function () {
        //     if (document.visibilityState === 'visible') {
        //         // Код, який виконується, коли сторінка стає видимою
        //         console.log("Користувач повернувся на сторінку");
        //
        //     } else {
        //         // Код, який виконується, коли сторінка стає невидимою
        //         console.log("Користувач покинув сторінку");
        //         this.deleteView()
        //     }
        // });
    },

    beforeUnmount() {
        // this.deleteView()
        window.removeEventListener('resize', () => {
            this.windowWidth = 0
        });
    },

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
