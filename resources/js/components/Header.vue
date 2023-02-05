<template>
    <header>
        <nav class="navigation-wrapper">
            <div class="logo-wrapper">
                <strong>Hungary</strong>
            </div>

            <ul class="navigation">
                <li>
                    <router-link to="login"><strong>Login</strong></router-link>
                </li>
                <li>
                    <router-link to="example"><strong>Example</strong></router-link>
                </li>
            </ul>
        </nav>
    </header>
</template>

<script>
export default {
    name: "Header"
}
</script>

<style scoped>
body {
    background-color: rgb(207 200 231);
}

a {
    text-decoration: none;
}

#logo {
    width: 50px;
    height: 50px;
}

li {
    list-style-type: none;
}

.navigation-wrapper {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
    text-transform: uppercase;
    background-color: #222222;
}

.logo-wrapper {
    font-family: "Times New Roman", Times, serif;
    font-size: 30px;
    color: white;
}

.navigation {
    display: flex;
}

.navigation li {
    margin: 30px;
}

.navigation li a {
    color: rgb(141 131 183);
}

.navigation li a:hover {
    color: rgb(209 207 220);
}

</style>
