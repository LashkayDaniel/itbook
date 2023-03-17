<template>
    <div class="">
        Exampleee

        <router-link to="/">main</router-link>

        <button @click.prevent="logout"><b>LOGOUT</b></button>
    </div>
</template>

<script>
import router from "@/router";

export default {
    name: "Example",


    methods: {
        logout() {
            axios.get('/logout')
                .then(res => {
                    console.log(res)
                    localStorage.removeItem('x_xsrf_token')
                    router.push({name: 'main'})
                })
        }
    },

}
</script>

<style scoped>

</style>
