<template>

    <div class="wrapper">
        <div class="block">
            <div v-if="type === 'success'" class="block__success">{{ message }}</div>
            <div v-if="type === 'warning'" class="block__warning">{{ message }}</div>
            <div v-if="type === 'error'" class="block__error">{{ message }}</div>
        </div>
    </div>

</template>

<script>
export default {
    name: "MsgPopup",
    props: {
        message: String,
        type: String,
    }
}
</script>

<style lang="scss" scoped>
.wrapper {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    backdrop-filter: blur(1px);
    display: flex;
    justify-content: center;
    align-items: end;
    z-index: 99;
}

.block {
    div {
        margin: 20px auto;
        text-align: center;
        padding: 5px 10px;
        font-size: 20px;
        border-radius: 5px;
    }

    &__success {
        box-shadow: 0px 9px 25px -5px rgba(95, 230, 80, 1);
        background-color: #a9e790;
        color: #339a15;
        border: solid 1px #41771f;

        &::before {
            content: '✅';
            margin-right: 10px;
        }
    }

    &__warning {
        box-shadow: 0px 9px 25px -5px rgba(232, 229, 79, 1);
        background-color: #dabe93;
        color: #c25c37;
        border: solid 1px #ef8b44;

        &::before {
            content: '⚠';
            margin-right: 10px;
        }
    }

    &__error {
        box-shadow: 0px 9px 25px -5px rgba(250, 75, 75, 1);
        background-color: #e19d9d;
        color: #e51c1c;
        border: solid 1px #ef4444;

        &::before {
            content: '❌';
            margin-right: 10px;
        }
    }
}


</style>
