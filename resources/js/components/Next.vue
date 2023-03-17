<template>
    <div class="container">
        <!--        <div class="block">-->
        <!--            <h1 class="block__title">Main pageee</h1>-->
        <!--            <p class="block__text">text text text</p>-->
        <!--        </div>-->

        <section class="section-row">
            <div class="themes">
                <div class="themes__search">
                    <input class="search__input" type="text" name="search" placeholder="Пошук у книзі">
                    <button class="search__btn" type="button">Пошук</button>
                </div>
                <ol class="themes__link">
                    <li v-for="section in this.sections">
                        <a href=""> {{ section.section }} </a>
                        <ol class="themes__sublink">
                            <li v-for="theme in section.themes">
                                <a href="/4234"> {{ theme }}</a>
                            </li>
                        </ol>
                    </li>
                </ol>
            </div>

            <div class="description">
                <p>This Intermediate/Advanced SQL Tutorial will cover the SELECT statement in great detail. The SELECT
                    statement is the core of SQL, and it is likely that the vast majority of your SQL commands will be
                    SELECT statements. Due to the enormous amount of options available for the SELECT statement, this
                    entire tutorial has been dedicated to it.

                    When constructing SQL Queries (with the SELECT statement), it is very useful to know all of the
                    possible options and the best or more efficient way to do things. This Tutorial will help provide
                    you with those skills.

                    Although it is recommended that you go through the Beginner Course first, or at least the SELECT
                    statement lesson, it is not required. The Beginner Course covers four other SQL Commands and allows
                    you to practice those as well.

                    You can submit all of your SQL commands in the Text submission box at the bottom of each of the main
                    pages.</p>
                <p>This Intermediate/Advanced SQL Tutorial will cover the SELECT statement in great detail. The SELECT
                    statement is the core of SQL, and it is likely that the vast majority of your SQL commands will be
                    SELECT statements. Due to the enormous amount of options available for the SELECT statement, this
                    entire tutorial has been dedicated to it.

                    When constructing SQL Queries (with the SELECT statement), it is very useful to know all of the
                    possible options and the best or more efficient way to do things. This Tutorial will help provide
                    you with those skills.

                    Although it is recommended that you go through the Beginner Course first, or at least the SELECT
                    statement lesson, it is not required. The Beginner Course covers four other SQL Commands and allows
                    you to practice those as well.

                    You can submit all of your SQL commands in the Text submission box at the bottom of each of the main
                    pages.</p>
                <p>This Intermediate/Advanced SQL Tutorial will cover the SELECT statement in great detail. The SELECT
                    statement is the core of SQL, and it is likely that the vast majority of your SQL commands will be
                    SELECT statements. Due to the enormous amount of options available for the SELECT statement, this
                    entire tutorial has been dedicated to it.

                    When constructing SQL Queries (with the SELECT statement), it is very useful to know all of the
                    possible options and the best or more efficient way to do things. This Tutorial will help provide
                    you with those skills.

                    Although it is recommended that you go through the Beginner Course first, or at least the SELECT
                    statement lesson, it is not required. The Beginner Course covers four other SQL Commands and allows
                    you to practice those as well.

                    You can submit all of your SQL commands in the Text submission box at the bottom of each of the main
                    pages.</p>
                <p>This Intermediate/Advanced SQL Tutorial will cover the SELECT statement in great detail. The SELECT
                    statement is the core of SQL, and it is likely that the vast majority of your SQL commands will be
                    SELECT statements. Due to the enormous amount of options available for the SELECT statement, this
                    entire tutorial has been dedicated to it.

                    When constructing SQL Queries (with the SELECT statement), it is very useful to know all of the
                    possible options and the best or more efficient way to do things. This Tutorial will help provide
                    you with those skills.

                    Although it is recommended that you go through the Beginner Course first, or at least the SELECT
                    statement lesson, it is not required. The Beginner Course covers four other SQL Commands and allows
                    you to practice those as well.

                    You can submit all of your SQL commands in the Text submission box at the bottom of each of the main
                    pages.</p>
                <p>This Intermediate/Advanced SQL Tutorial will cover the SELECT statement in great detail. The SELECT
                    statement is the core of SQL, and it is likely that the vast majority of your SQL commands will be
                    SELECT statements. Due to the enormous amount of options available for the SELECT statement, this
                    entire tutorial has been dedicated to it.

                    When constructing SQL Queries (with the SELECT statement), it is very useful to know all of the
                    possible options and the best or more efficient way to do things. This Tutorial will help provide
                    you with those skills.

                    Although it is recommended that you go through the Beginner Course first, or at least the SELECT
                    statement lesson, it is not required. The Beginner Course covers four other SQL Commands and allows
                    you to practice those as well.

                    You can submit all of your SQL commands in the Text submission box at the bottom of each of the main
                    pages.</p>
            </div>
        </section>
    </div>
</template>

<script>
export default {
    name: "Next",
    data: function () {
        return {
            sections: []
        }
    },

    methods: {
        getSections() {
            axios.get('api/sections')
                .then(response => {
                    this.sections = response.data
                })
                .catch(error => {
                    console.log(error)
                })
        },
    },

    mounted() {
        this.getSections();
    }

}
</script>

<style lang="scss" scoped>
.container {
    max-width: 1300px;
    margin: 0 auto;
}

.block {
    text-align: center;
    background: #c06b6b;
    color: antiquewhite;
    padding: 40px 0 10px 0;
    border-radius: 10px;
    margin: 20px 0;

    &__title {
        font-size: 40px;
    }

    &__text {
        font-size: 30px;
    }

    &__btn-start {
        border-radius: 5px;
        background: #000;
        margin-top: 50px;
        padding: 5px 15px;
        font-size: 25px;

        &:hover {
            opacity: .8;
        }
    }
}

ol {
    list-style: decimal;
    padding-left: 40px;
}


.section-row {
    margin: 20px 0;
    display: flex;
    align-content: space-between;

    .themes {
        max-width: 300px;
        border-radius: 10px;

        &__search {

            &__input {
                background-color: #e8dbdb;
                color: red;

                &:active {
                    border: none;
                }
            }

            &__btn {

            }
        }

        &__link {
            font-weight: bold;

        }

        &__sublink {
            font-weight: normal;
        }


        a {
            font-size: 18px;
            color: #1a202c;
            outline: none;
            text-decoration: none;

            &:hover {
                background: #ecdcdc;
                border-radius: 5px;
            }
        }
    }

    .description {
        padding: 20px 25px;
        max-height: 650px;
        overflow-y: scroll;
        margin-left: 5px;
        width: 100%;
    }

}


</style>
