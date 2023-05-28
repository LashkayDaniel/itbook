<template>
    <router-link class="btn-to-main" :to="{name: 'main'}">Повернутись назад</router-link>

    <div class="root">
        <h2 class="root__title">Короткий словник термінів</h2>

        <div class="root__items">

            <div class="items__row">
                <p class="items__title">База даних (Database)</p>
                <div class="items__line"></div>
                <p class="items__description">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut cum eaque
                    iusto odio odit optio porro quae quaerat rem vitae?</p>
            </div>

            <div class="items__row">
                <p class="items__title">Таблиця (Table)</p>
                <div class="items__line"></div>
                <p class="items__description">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut cum eaque
                    iusto odio odit optio porro quae quaerat rem vitae?</p>
            </div>

            <div v-for="item in dictionaryItems"
                 class="items__row">
                <p class="items__title">{{ item.title }}</p>
                <div class="items__line"></div>
                <p class="items__description">{{ item.description }}</p>
            </div>

        </div>


    </div>

</template>

<script>
export default {
    name: "Dictionary",
    data() {
        return {
            dictionaryItems: [],
        }
    },
    methods: {
        getDictionaryItems() {
            axios.get('api/dictionary/get')
                .then(response => {
                    this.dictionaryItems = response.data.items
                    console.log(this.dictionaryItems);
                })
                .catch(error => {
                    console.log(error);
                })
        },
    },

    created() {
        this.getDictionaryItems();
    }
}
</script>

<style lang="scss" scoped>
@import '@/../sass/main/_dictionary.scss';

</style>
