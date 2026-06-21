<template>
    <div>
        <input type="email" v-model="email" placeholder="Email" />
        <div class="alert alert-danger" v-if="errors.email">
            {{ errors.email.join('. ') }}
        </div>
        
        <input type="password" v-model="password" placeholder="Пароль" />
        <div class="alert alert-danger" v-if="errors.password">
            {{ errors.password.join('. ') }}
        </div>
        
        <button type="button" class="button big fit" @click="auth">
            Войти
        </button>
    </div>
</template>

<script>
export default {
    name: 'AuthComponent',
    props: ['datasend', 'changeToken'],
    data() {
        return {
            email: null,
            password: null,
            errors: {},
        };
    },
    methods: {
        auth() {
            let formdata = new FormData();
            if (this.email) formdata.append('email', this.email);
            if (this.password) formdata.append('password', this.password);

            this.datasend('auth', 'POST', formdata)
                .then((result) => {
                    console.log(result);
                    if (result.errors) {
                        this.errors = result.errors;
                    }
                    if (result.token) {
                        this.changeToken(result.token);
                    }
                });
        },
    },
};
</script>