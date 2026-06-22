<template>
    <div id="main">
        <h1>Статьи пользователя</h1>
        
        <div v-if="articles.data && articles.data.length === 0">
            <p>У этого пользователя пока нет статей</p>
        </div>
        
        <ArticleComponent 
            v-for="article in articles.data" 
            :key="article.id"
            :article="article" 
            :changePage="changePage"
            :PUBLIC="PUBLIC"
        />

        <ul class="actions pagination">
            <li>
                <a href="#" @click.prevent="getArticles(page - 1)" 
                   :class="{disabled: page === 1}" 
                   class="button big previous">
                    Предыдущая
                </a>
            </li>
            <li>
                <a href="#" @click.prevent="getArticles(page + 1)" 
                   :class="{disabled: articles.current_page === articles.last_page}" 
                   class="button big next">
                    Следующая
                </a>
            </li>
        </ul>
    </div>
</template>

<script>
import ArticleComponent from '../components/ArticleComponent.vue';

export default {
    name: 'UserArticles',
    props: ['datasend', 'changePage', 'PUBLIC', 'pageId'],
    components: {
        ArticleComponent,
    },
    data() {
        return {
            articles: [],
            page: 1,
        };
    },
    mounted() {
        this.getArticles();
    },
    methods: {
        getArticles(page = 1) {
            this.datasend('articleUser/' + this.pageId + '?page=' + page)
                .then((result) => {
                    this.articles = result;
                    this.page = result.current_page;
                });
        },
    },
};
</script>