<template>
    <form class="signup-form" @submit.prevent="submitForm">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" id="name" v-model="name" required/>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" v-model="email" required/>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" v-model="password" required/>
        </div>
        <div class="form-group">
            <label for="confirmPassword">Confirm Password</label>
            <input type="password" id="confirmPassword" v-model="confirmPassword" required/>
        </div>
        <button type="submit">Sign Up</button>
    </form>
</template>

<script>
export default {
    data() {
        return {
            name: '',
            email: '',
            password: '',
            confirmPassword: '',
        };
    },
    methods: {
        submitForm() {
            // handle form submission here
        },
    },
};
</script>

<style>
.signup-form {
    display: flex;
    flex-direction: column;
    max-width: 400px;
    margin: 0 auto;
    padding: 20px;
    background-color: #f5f5f5;
}

.form-group {
    display: flex;
    flex-direction: column;
    margin-bottom: 10px;
}

label {
    font-weight: bold;
    margin-bottom: 5px;
}

input {
    padding: 10px;
    border: none;
    border-radius: 5px;
    font-size: 16px;
}

button {
    padding: 10px;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    background-color: #4caf50;
    color: white;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color: #3e8e41;
}
</style>
