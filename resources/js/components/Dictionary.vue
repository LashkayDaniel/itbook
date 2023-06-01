<template>
    <router-link class="btn-to-main" :to="{name: 'main'}"></router-link>

    <div class="root">
        <h2 class="root__title">Короткий словник термінів</h2>
        <loader v-if="showLoader"></loader>
        <div class="root__items">
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
import Loader from "@/components/more/Loader.vue";

export default {
    name: "Dictionary",
    components: {
        Loader
    },
    data() {
        return {
            dictionaryItems: [],
            showLoader: true,
        }
    },
    methods: {
        getDictionaryItems() {
            axios.get('api/dictionary/get')
                .then(response => {
                    this.dictionaryItems = response.data.items
                    this.showLoader = false;
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
