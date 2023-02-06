<template>
    <header>
        <nav class="navigation-wrapper" :class="{'nav-animation' : isActive}">
            <div class="logo-wrapper">
                <!--                <strong>Hungary</strong>-->
                <img class="logo" src="../../img/itbook.svg" alt="it">
            </div>


            <ul v-if="isActive" class="navigation">
                <li class="navigation__item">
                    <router-link class="navigation__item-link" to="login"><strong>Login</strong></router-link>
                </li>
                <li class="navigation__item">
                    <router-link class="navigation__item-link" to="example"><strong>Example</strong></router-link>
                </li>
            </ul>
        </nav>
    </header>
</template>

<script>
export default {
    name: "Header",
    props: {
        isActive: Boolean
    },
    data() {
        return {}
    }
}
</script>

<style lang="scss" scoped>
a {
    text-decoration: none;
}

li {
    list-style-type: none;
}

.navigation-wrapper {
    position: relative;
    display: flex;
    align-items: center;
    width: 100vw;
    justify-content: center;
    padding: 15px;
    text-transform: uppercase;
    background-color: #222222;
}

.nav-animation {
    animation: logo 1s linear 1 normal running 0s forwards;
}


@keyframes logo {

    50% {
        justify-content: space-around;
    }
    70% {
        justify-content: space-evenly;
    }
    100% {
        justify-content: space-between;
    }
}


.logo-wrapper {
    font-family: "Times New Roman", Times, serif;
    font-size: 30px;
    color: white;

}

.logo {
    height: 70px;

    &:hover {
        opacity: 0.8;
    }
}

.navigation {
    padding: 0;
    margin: 0;
    height: 100%;
    display: flex;
    justify-content: center;

    &__item {
    }

    &__item-link {
        color: #7f9cd5;
        border-radius: 10px;
        border: solid 2px #7c99d9;
        padding: 10px;
        margin: 20px;

        &:hover {
            border-color: #0c213b;
            color: rgb(209 207 220);
        }
    }
}


</style>
