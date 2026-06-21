<template>
    <div id="main">
        <article class="post" v-if="article">
            <header>
                <div class="title">
                    <h2>{{ article.title }}</h2>
                </div>
                <div class="meta">
                    <time class="published">
                        {{ formatDate(article.created_at) }}
                    </time>
                    <a href="#" class="author">
                        <span class="name">{{ article.user.name }}</span>
                    </a>
                </div>
            </header>
            
            <p>{{ article.content }}</p>
            
            <footer>
                <ul class="stats">
                    <li v-if="isAuthor">
                        <a href="#" @click.prevent="changePage('AddArticle', pageId)">Редактировать</a>
                    </li>
                    <li v-if="isAuthor">
                        <a href="#" class="red" @click="deleteArticle">Удалить</a>
                    </li>
                </ul>
            </footer>
        </article>
    </div>
</template>

<script>
export default {
    name: 'SingleArticle',
    props: ['datasend', 'changePage', 'pageId'],
    data() {
        return {
            article: null,
            isAuthor: false,
            isAuth: localStorage.getItem('token') ? true : false,
        };
    },
    mounted() {
        this.getArticle();
    },
    methods: {
        formatDate(date) {
            return new Date(date).toLocaleDateString('ru-RU', {
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            });
        },
        getArticle() {
            const url = this.isAuth ? 'articles/' + this.pageId : 'public/articles/' + this.pageId;
            this.datasend(url).then((result) => {
                this.article = result.article;
                this.isAuthor = result.isAuthor || false;
            });
        },
        deleteArticle() {
            if (confirm('Удалить статью?')) {
                this.datasend('articles/' + this.pageId, 'DELETE')
                    .then(() => {
                        this.changePage('HomePage');
                    });
            }
        },
    },
};
</script>