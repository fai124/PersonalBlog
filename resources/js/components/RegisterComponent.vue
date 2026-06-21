<template>
    <div>
        <input type="text" v-model="name" placeholder="Имя" />
        <div class="alert alert-danger" v-if="errors.name">
            {{ errors.name.join('. ') }}
        </div>
        
        <input type="email" v-model="email" placeholder="Email" />
        <div class="alert alert-danger" v-if="errors.email">
            {{ errors.email.join('. ') }}
        </div>
        
        <input type="password" v-model="password" placeholder="Пароль" />
        <div class="alert alert-danger" v-if="errors.password">
            {{ errors.password.join('. ') }}
        </div>
        
        <button type="button" class="button big fit" @click="register">
            Зарегистрироваться
        </button>
    </div>
</template>

<script>
export default {
    name: 'RegisterComponent',
    props: ['datasend', 'changeToken'],
    data() {
        return {
            name: null,
            email: null,
            password: null,
            errors: {},
        };
    },
    methods: {
        register() {
            let formdata = new FormData();
            if (this.name) formdata.append('name', this.name);
            if (this.email) formdata.append('email', this.email);
            if (this.password) formdata.append('password', this.password);

            this.datasend('register', 'POST', formdata)
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