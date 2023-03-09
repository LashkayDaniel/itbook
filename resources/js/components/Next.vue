<template>
    <div class="container">
        <div class="block">
            <h1 class="block__title">Main pageee</h1>
            <p class="block__text">text text text</p>

        </div>

        <ol>
            <li v-for="section in this.sections">
                <a href=""> {{ section.section }} </a>
                <ol>
                    <li v-for="theme in section.themes">
                        <a href="/4234"> {{ theme }}</a>
                    </li>
                </ol>
            </li>
        </ol>

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
    max-width: 900px;
    margin: 0 auto;
}

.block {
    text-align: center;
    background: #c06b6b;
    color: antiquewhite;
    padding: 40px 0 10px 0;
    border-radius: 10px;
    margin: 20px;

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


    // test
    ul {
        list-style: circle;
        padding-left: 40px;
    }

    ol {
        list-style: decimal;
        padding-left: 40px;
    }

     a {
        outline: none;
        text-decoration: none;
    }

    // end test
}
</style>
