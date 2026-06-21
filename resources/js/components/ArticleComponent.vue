<template>
    <article class="post">
        <header>
            <div class="title">
                <h2>
                    <a href="#" @click.prevent="changePage('SingleArticle', article.id)">
                        {{ article.title }}
                    </a>
                </h2>
            </div>
            <div class="meta">
                <time class="published">
                    {{ formatDate(article.created_at) }}
                </time>
                <a href="#" @click.prevent="changePage('UserArticles', article.user.id)" class="author">
                    <span class="name">{{ article.user ? article.user.name : 'Автор' }}</span>
                </a>
            </div>
        </header>
        
        <p>{{ truncate(article.content, 200) }}</p>
        
        <footer>
            <ul class="actions">
                <li>
                    <a href="#" @click.prevent="changePage('SingleArticle', article.id)" class="button big">
                        Читать далее
                    </a>
                </li>
            </ul>
        </footer>
    </article>
</template>
<script>
export default {
    name: 'ArticleComponent',
    props: ['article', 'changePage'],
    methods: {
        formatDate(date) {
            if (!date) return 'Дата неизвестна';
            return new Date(date).toLocaleDateString('ru-RU', {
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            });
        },
        truncate(text, length) {
            if (!text) return '';
            if (text.length <= length) return text;
            return text.substring(0, length) + '...';
        }
    }
};
</script>