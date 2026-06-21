<template>
    <div id="wrapper">
        <HeaderComponent
            :userInfo="userInfo"
            :PUBLIC="PUBLIC"
            :changePage="changePage"
        />

        <MenuComponent
            :logout="logout"
            :datasend="datasend"
            :user="user"
            :changeToken="changeToken"
            :changePage="changePage"
        />
        
        <!-- Страницы -->
        <HomePage v-if="page == 'HomePage'" 
            :datasend="datasend" 
            :changePage="changePage" 
            :pageId="pageId" 
            :PUBLIC="PUBLIC"
        />
    </div>
    
</template>

<script>
import MenuComponent from './components/MenuComponent.vue';
import HeaderComponent from './components/HeaderComponent.vue';
import HomePage from './pages/HomePage.vue';

export default {
    name: 'App',
    data() {
        return {
            page: localStorage.getItem('page') || 'HomePage',
            pageId: localStorage.getItem('pageId') || null,
            API: 'http://127.0.0.1:8000/api/',
            PUBLIC: 'http://127.0.0.1:8000/storage/',
            user: false,
            userInfo: {},
        };
    },
    components: {
        MenuComponent,
        HeaderComponent,
        HomePage,
    },
    mounted() {
        if (localStorage.getItem('token')) {
            this.getUser();
        }
    },
    methods: {
        logout() {
            this.datasend('logout')
                .then((result) => {
                    if (result) {
                        localStorage.removeItem('token');
                        this.changePage('HomePage');
                        this.user = false;
                        this.userInfo = {};
                        console.log(result);
                    }
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        

        changePage(page, pageId = null) {
            this.page = page;
            this.pageId = pageId;
            localStorage.setItem('page', page);
            localStorage.setItem('pageId', pageId);
        },
        

        getUser() {
            this.datasend('user')
                .then((response) => {
                    this.user = true;
                    this.userInfo = response;
                })
                .catch((error) => {
                    console.error(error);
                    localStorage.removeItem('token');
                });
        },
        

        datasend(route, method = 'GET', formdata = null) {
            let myHeaders = new Headers();
            myHeaders.append('Accept', 'application/json');
            
            if (localStorage.getItem('token')) {
                myHeaders.append(
                    'Authorization',
                    'Bearer ' + localStorage.getItem('token')
                );
            }

            let requestOptions = {
                method: method,
                headers: myHeaders,
                redirect: 'follow',
            };

            if (method != 'GET') {
                requestOptions.body = formdata;
            }
            
            return fetch(this.API + route, requestOptions).then((response) => {
                if (response.status == 401) {
                    localStorage.removeItem('token');
                    this.changePage('HomePage');
                    this.user = false;
                    this.userInfo = {};
                }
                return response.json();
            });
        },
        

        changeToken(token) {
            localStorage.setItem('token', token);
            this.user = true;
            this.getUser();
        },
    },
};
</script>