<template>
    <div id="main">
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
    name: 'HomePage',
    props: ['datasend', 'changePage', 'PUBLIC'],
    components: {
        ArticleComponent,
    },
    data() {
        return {
            articles: [], // теперь массив
        };
    },
    mounted() {
        this.getArticles();
    },
    methods: {
        getArticles() {
            this.datasend('article')
                .then((result) => {
                    this.articles = result; // result — массив
                });
        },
    },
};
</script>