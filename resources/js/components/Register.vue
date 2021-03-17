<template>
    <div class="c-card u-mb-xsmall">
        <form class="c-card__body" @submit.prevent="register" method="post">
            <div class="c-field u-mb-small">
                <label class="c-field__label" for="first_name">Name</label>
                <input class="c-input" v-bind:class="{ border: errors.first_name}" type="text" id="first_name" v-model="user.first_name">
                <div v-if="errors.first_name" class="u-color-danger u-mb-small"> {{errors.first_name}} </div>
            </div>
            <div class="c-field u-mb-small">
                <label class="c-field__label" for="last_name">Surname</label>
                <input class="c-input" v-bind:class="{ border: errors.last_name}" type="text" id="last_name" v-model="user.last_name">
                <div v-if="errors.last_name" class="u-color-danger u-mb-small">{{ errors.last_name }}</div>
            </div>
            <div class="c-field u-mb-small">
                <label class="c-field__label" for="email">Email</label>
                <input class="c-input" v-bind:class="{ border: errors.email}" type="email" id="email" v-model="user.email">
                <div v-if="errors.email" class="u-color-danger u-mb-small">{{ errors.email }}</div>
                <div v-if="errorEmailExist" class="u-color-danger u-mb-small"> This email is in use. </div>
            </div>
            <div class="c-field u-mb-small">
                <label class="c-field__label" for="password">Password</label>
                <input class="c-input" v-bind:class="{ border: errors.password}" type="password" id="password" v-model="user.password" placeholder="Минимум 8 карактери">
                <div v-if="errors.password" class="u-color-danger u-mb-small">{{ errors.password }}</div>
            </div>
            <div class="c-field u-mb-small">
                <label class="c-field__label" for="c_password">Confirm password</label>
                <input class="c-input" v-bind:class="{ border: errors.c_password}" type="password" id="c_password" v-model="user.c_password" placeholder="Минимум 8 карактери">
                <div v-if="errors.c_password" class="u-color-danger u-mb-small">{{ errors.c_password }}</div>
                <div v-if="showErrorMessage" class="u-color-danger u-mb-small">Passwords doesn't match. </div>
            </div>
            <button v-if="!isLoading" class="c-btn c-btn--danger c-btn--fullwidth" type="submit">Sign up</button>
            <button v-if="isLoading" class="c-btn c-btn--danger c-btn--fullwidth"><i class="fa fa-spinner fa-spin mr-2"></i> </button>
        </form>
    </div>
</template>
<script>
    import axios from 'axios'
    export default {
        data(){
            return {
                user: {
                    first_name: '',
                    last_name: '',
                    email: '',
                    password: '',
                    c_password: ''
                },
                isRegistered: false,
                isLoading: false,
                showErrorMessage: false,
                errorEmailExist: false,
                errors: {
                    first_name: '',
                    last_name: '',
                    email: '',
                    password: '',
                    c_password: ''
                },
            }
        },
        methods: {
            register(){
                this.errors = {};
                this.errorEmailExist = false;
                this.showErrorMessage = false;
                if (this.user.first_name === '')
                {
                    this.errors.first_name = 'This field is required';
                }
                if (this.user.last_name === '')
                {
                    this.errors.last_name = 'This field is required';
                }
                if (this.user.email === '')
                {
                    this.errors.email = 'This field is required';
                }
                if (this.user.password === '')
                {
                    this.errors.password = 'This field is required';
                }
                if (this.user.password.length < 8)
                {
                    this.errors.password = 'Password should be at least 8 characters';
                }
                if (this.user.c_password === '')
                {
                    this.showErrorMessage = false;
                    this.errors.c_password= 'This field is required';
                }
                else
                {
                    if ( this.user.password !== this.user.c_password)
                    {
                        this.showErrorMessage = true;
                    }
                }

                if(this.user.first_name !== '' && this.user.last_name !== '' && this.user.email !== '' &&
                    this.user.password !== '' && this.user.password.length >= 8 && this.user.password === this.user.c_password) {
                    this.isLoading = true;
                    this.showErrorMessage = false;
                    axios.post('/register', this.user)
                        .then(response => {
                            if (response.data.status === 'success') {
                                this.isRegistered = true;
                                this.user.first_name = '',
                                    this.user.last_name = '',
                                    this.user.email = '',
                                    this.user.c_password = ''

                                this.isLoading = false;
                            }
                            else
                            {
                                this.isLoading = false;
                                this.errorEmailExist = true;
                            }
                        }).catch(error => {
                        console.log(error);
                    })
                }
                else
                {
                    this.isLoading = false;
                }
            },
            login(){
                window.location.href = '/login';
            }
        }
    }
</script>
