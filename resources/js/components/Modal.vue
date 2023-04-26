<template>
    <div class="modal-mask" @click="$emit('close')">
        <div class="modal-wrapper">
            <div class="modal-container">
                <div class="modal-header">
                    <h3>{{ title }}</h3>
                    <span class="close" @click="$emit('close')">&times;</span>
                </div>
                <div class="modal-body">
                    <p>{{ message }}</p>
                </div>
                <div class="modal-footer">
                    <button @click="$emit('close')">OK</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        title: {
            type: String,
            default: "Error"
        },
        message: {
            type: String,
            required: true
        }
    }
}
</script>

<style scoped>
.modal-mask {
    position: fixed;
    z-index: 9998;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
}

.modal-wrapper {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.modal-container {
    background-color: #fff;
    width: 500px;
    border-radius: 5px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.33);
}

.modal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 20px;
    border-bottom: 1px solid #eee;
}

.modal-header h3 {
    margin: 0;
    font-size: 20px;
}

.modal-header .close {
    cursor: pointer;
    font-size: 24px;
}

.modal-body {
    padding: 20px;
}

.modal-footer {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    padding: 20px;
    border-top: 1px solid #eee;
}

.modal-footer button {
    border: none;
    background-color: #2196f3;
    color: #fff;
    font-size: 16px;
    padding: 8px 16px;
    border-radius: 4px;
    cursor: pointer;
}
</style>
