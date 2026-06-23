<template>
    <div id="main">
        <h1>Мои статьи</h1>
        
        <div v-if="articles.length === 0">
            <p>У вас пока нет статей. <a href="#" @click="changePage('AddArticle')">Создать</a></p>
        </div>
        
        <ArticleComponent 
            v-for="article in articles" 
            :key="article.id"
            :article="article" 
            :changePage="changePage"
            :PUBLIC="PUBLIC"
        />
    </div>
</template>

<script>
import ArticleComponent from '../components/ArticleComponent.vue';

export default {
    name: 'MyArticles',
    props: ['datasend', 'changePage', 'PUBLIC'],
    components: {
        ArticleComponent,
    },
    data() {
        return {
            articles: [], // массив
        };
    },
    mounted() {
        this.getArticles();
    },
    methods: {
        getArticles() {
            this.datasend('articles')
                .then((result) => {
                    this.articles = result; // массив
                });
        },
    },
};
</script>