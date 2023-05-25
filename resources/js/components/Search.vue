<template>
    <div class="search-wrapper">
        <section class="search-wrapper__block">
            <input type="text"
                   class="block__input"
                   placeholder="Введіть слово"
                   @keyup.enter="search"
                   @input="this.results=[];this.nothingFound=false"
                   v-model="inputValue">
            <button class="block__btn" @click="search">Search</button>
            <button class="block__close-btn"
                    @click="close">
                ✖
            </button>
            <ul class="block__list">
                <li class="list__item"
                    v-for="item in results">
                    <div class="item__content">
                        <a href="" class="item__title">{{ item.section.name }}. {{ item.title }}</a>
                        <!--                    <p class="item__subtitle"-->
                        <!--                       v-for="text in JSON.parse(item.description)"-->
                        <!--                       v-html="highlightText(text, this.inputValue)"-->
                        <!--                    ></p>-->
                        <p class="item__subtitle">Знайдено: {{ item.countFound }}
                        </p>
                    </div>
                    <button class="item__btn">ok</button>
                </li>
                <li v-if="inputValue.trim().length<2"
                    style="color: #f1ad46">Мінімум 2 символи
                </li>
                <li v-else-if="this.nothingFound"
                    style="color: #9abcc0">Нічого не знайдено за результатом: <b>{{ inputValue }}</b>
                </li>

            </ul>
        </section>
    </div>
</template>

<script>
export default {
    name: "Search",
    props: {
        inputText: String
    },
    data() {
        return {
            inputValue: '',
            results: [],
            nothingFound: false,
        }
    },

    methods: {
        close() {
            this.$emit('showSearch', false)
        },
        search() {
            this.results = []
            this.nothingFound = false

            if (this.inputValue.trim().length < 2) {
                return;
            }

            axios.post('api/theme/search', {
                searchText: this.inputValue
            })
                .then(response => {
                    const dataArray = response.data;
                    dataArray.forEach((item, index) => {
                        const description = JSON.parse(dataArray[index].description)
                        dataArray[index].countFound = this.getFindCount(description, this.inputValue);
                    })
                    this.results = dataArray
                    this.nothingFound = !this.results.length > 0;
                })
                .catch(error => {
                    console.log(error);
                })


        },
        highlightText(text, search) {
            if (!search) {
                return text;
            }
            const regex = new RegExp(`(${search})`, 'gi');
            return text.replace(regex, '<span style="background-color:rgba(222,222,88,0.87); color: darkred">$1</span>');
        },
        getFindCount(array, search) {
            const regex = new RegExp(`(${search.toLowerCase()})`, 'gi');
            let count = 0;

            array.forEach(item => {
                const matches = item.toLowerCase().match(regex);
                if (matches) {
                    count += matches.length;
                }
            });

            return count;
        },
    },

    created() {
        this.inputValue = this.inputText
        this.search()
    }
}
</script>

<style lang="scss" scoped>


.search-wrapper {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    overflow: hidden;
    z-index: 10;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: rgba(89, 99, 110, 0.8);


    &__block {
        background-color: #596677;
        border: solid 1px #65acd9;
        border-radius: 10px;
        padding: 20px 30px;
        position: relative;
        width: 50%;
        height: 60%;
    }
}

.block {

    &__input {
        padding: 5px 10px;
        border-radius: 5px;
    }

    &__btn {
        background-color: #5eadc9;
        padding: 5px 10px;
        border-radius: 5px;
        margin-left: 5px;
        color: #1f334d;
        font-weight: bold;
        letter-spacing: 1px;

        &:hover {
            background-color: #699fb2;
            transition: all .5s;
        }
    }

    &__close-btn {
        position: absolute;
        top: 0;
        right: 0;
        background-color: #ef4444;
        color: #811616;
        z-index: 11;
        border-radius: 50%;
        display: inline-block;
        width: 25px;
        height: 25px;
        align-items: center;
        text-align: center;
        transform: translate(50%, -50%);
    }

    &__list {
        overflow: auto;
        height: 100%;
    }
}

.list {
    &__item {
        background-color: #4b5563;
        margin: 5px 0;
        padding: 5px;
        border-radius: 5px;
        display: flex;
        justify-content: space-between;
    }
}

.item {
    &__content {
    }

    &__title {
        color: #a0aec0;
        font-weight: bold;

    }

    &__subtitle {

    }

    &__btn {
        background-color: #a0aec0;

        &:before {
            content: '';
            display: block;
            height: 3px;
            width: 15px;
            color: red;
            left: 0;
            top: 0;
        }

    }

}

</style>
