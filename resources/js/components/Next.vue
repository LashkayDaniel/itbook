<template>
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

            <ol class="themes__list">
                <li v-for="(section,index) in this.sections">
                    <div class="list__item" @click="section.isExpand=!section.isExpand">
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
                            <transition name="accordion-fade">
                                <a class="link__name" href=""> {{ theme }}</a>
                            </transition>
                        </li>
                        <hr>
                        <p class="labs__title">Лабораторні роботи:</p>
                        <li class="labs__item" v-for="labs in section.labs">
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
            <article class="block__panel">
                <div class="navigation">
                    <a class="navigation__link" href="">Вступ</a>
                    <a class="navigation__link" href="">Історія баз даних</a>
                </div>

                <div class="search">
                    <input class="search__input" type="text" name="search" placeholder="Пошук у книзі">
                    <button class="search__btn" type="button">Пошук</button>
                </div>
            </article>
            <article class="block__description">
                <h2 class="description__title">Історія баз даних</h2>
                <p>This Intermediate/Advanced SQL Tutorial will cover the SELECT statement in great detail. The
                    SELECT
                    statement is the core of SQL, and it is likely that the vast majority of your SQL commands will
                    be
                    SELECT statements. Due to the enormous amount of options available for the SELECT statement,
                    this
                    entire tutorial has been dedicated to it.

                    When constructing SQL Queries (with the SELECT statement), it is very useful to know all of the
                    possible options and the best or more efficient way to do things. This Tutorial will help
                    provide
                    you with those skills.

                    Although it is recommended that you go through the Beginner Course first, or at least the SELECT
                    statement lesson, it is not required. The Beginner Course covers four other SQL Commands and
                    allows
                    you to practice those as well.

                    You can submit all of your SQL commands in the Text submission box at the bottom of each of the
                    main
                    pages.</p>
                <p>This Intermediate/Advanced SQL Tutorial will cover the SELECT statement in great detail. The
                    SELECT
                    statement is the core of SQL, and it is likely that the vast majority of your SQL commands will
                    be
                    SELECT statements. Due to the enormous amount of options available for the SELECT statement,
                    this
                    entire tutorial has been dedicated to it.

                    When constructing SQL Queries (with the SELECT statement), it is very useful to know all of the
                    possible options and the best or more efficient way to do things. This Tutorial will help
                    provide
                    you with those skills.

                    Although it is recommended that you go through the Beginner Course first, or at least the SELECT
                    statement lesson, it is not required. The Beginner Course covers four other SQL Commands and
                    allows
                    you to practice those as well.

                    You can submit all of your SQL commands in the Text submission box at the bottom of each of the
                    main
                    pages.</p>
                <p>This Intermediate/Advanced SQL Tutorial will cover the SELECT statement in great detail. The
                    SELECT
                    statement is the core of SQL, and it is likely that the vast majority of your SQL commands will
                    be
                    SELECT statements. Due to the enormous amount of options available for the SELECT statement,
                    this
                    entire tutorial has been dedicated to it.

                    When constructing SQL Queries (with the SELECT statement), it is very useful to know all of the
                    possible options and the best or more efficient way to do things. This Tutorial will help
                    provide
                    you with those skills.

                    Although it is recommended that you go through the Beginner Course first, or at least the SELECT
                    statement lesson, it is not required. The Beginner Course covers four other SQL Commands and
                    allows
                    you to practice those as well.

                    You can submit all of your SQL commands in the Text submission box at the bottom of each of the
                    main
                    pages.</p>
                <p>This Intermediate/Advanced SQL Tutorial will cover the SELECT statement in great detail. The
                    SELECT
                    statement is the core of SQL, and it is likely that the vast majority of your SQL commands will
                    be
                    SELECT statements. Due to the enormous amount of options available for the SELECT statement,
                    this
                    entire tutorial has been dedicated to it.

                    When constructing SQL Queries (with the SELECT statement), it is very useful to know all of the
                    possible options and the best or more efficient way to do things. This Tutorial will help
                    provide
                    you with those skills.

                    Although it is recommended that you go through the Beginner Course first, or at least the SELECT
                    statement lesson, it is not required. The Beginner Course covers four other SQL Commands and
                    allows
                    you to practice those as well.

                    You can submit all of your SQL commands in the Text submission box at the bottom of each of the
                    main
                    pages.</p>
                <p>This Intermediate/Advanced SQL Tutorial will cover the SELECT statement in great detail. The
                    SELECT
                    statement is the core of SQL, and it is likely that the vast majority of your SQL commands will
                    be
                    SELECT statements. Due to the enormous amount of options available for the SELECT statement,
                    this
                    entire tutorial has been dedicated to it.

                    When constructing SQL Queries (with the SELECT statement), it is very useful to know all of the
                    possible options and the best or more efficient way to do things. This Tutorial will help
                    provide
                    you with those skills.

                    Although it is recommended that you go through the Beginner Course first, or at least the SELECT
                    statement lesson, it is not required. The Beginner Course covers four other SQL Commands and
                    allows
                    you to practice those as well.

                    You can submit all of your SQL commands in the Text submission box at the bottom of each of the
                    main
                    pages.</p>
            </article>
        </section>
    </div>
</template>

<script>
export default {
    name: "Next",
    data: function () {
        return {
            sections: [],
            items: [
                {
                    id: 1,
                    title: "Sample Title 1",
                    content: "Lorem ipsum dolor sit amet",
                    isExpand: true,
                    computedHeight: 0,
                },
                {
                    id: 2,
                    title: "Sample Title 2",
                    content: "Felis eget nunc lobortis mattis aliquam faucibus purus in massa. Maecenas volutpat blandit aliquam etiam.",
                    isExpand: false,
                    computedHeight: 0,
                },
                {
                    id: 3,
                    title: "Sample Title 3",
                    content: "Pretium quam vulputate dignissim suspendisse. Tristique senectus et netus et. Vulputate ut pharetra sit amet aliquam. Leo urna molestie at elementum eu facilisis sed odio morbi. Ut morbi tincidunt augue interdum velit euismod in pellentesque massa.",
                    isExpand: false,
                    computedHeight: 0,
                },
                {
                    id: 4,
                    title: "Sample Title 4",
                    content: "Odio euismod lacinia at quis risus sed vulputate. Nulla pharetra diam sit amet nisl suscipit adipiscing bibendum est. Proin sagittis nisl rhoncus mattis rhoncus urna neque viverra justo. Ut pharetra sit amet aliquam id diam maecenas. Enim ut tellus elementum sagittis vitae et leo. Egestas fringilla phasellus faucibus scelerisque eleifend. Odio euismod lacinia at quis risus sed vulputate odio.",
                    isExpand: false,
                    computedHeight: 0,
                },
            ],
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

                    console.log(data);
                })
                .catch(error => {
                    console.log(error)
                })
        },


        //accordion

        // end accordion
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

.container {
    max-width: 1500px;
    padding: 0 20px;
    margin: 20px auto;
    display: flex;
    align-content: space-between;
}


</style>
