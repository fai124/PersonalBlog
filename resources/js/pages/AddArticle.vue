<template>
    <div id="main">
        <article class="post">
            <h1>{{ pageId ? 'Редактировать' : 'Создать' }} статью</h1>
            
            <input type="text" v-model="title" placeholder="Заголовок" />
            <div class="alert alert-danger" v-if="errors.title">
                {{ errors.title.join('. ') }}
            </div>
            
            <textarea v-model="content" placeholder="Текст статьи" rows="10"></textarea>
            <div class="alert alert-danger" v-if="errors.content">
                {{ errors.content.join('. ') }}
            </div>
            
            <button type="submit" class="button big fit" @click="saveArticle">
                {{ pageId ? 'Обновить' : 'Создать' }}
            </button>
        </article>
    </div>
</template>

<script>
export default {
    name: 'AddArticle',
    props: ['datasend', 'changePage', 'pageId'],
    data() {
        return {
            title: null,
            content: null,
            errors: {},
        };
    },
    mounted() {
        if (this.pageId) {
            this.getArticle();
        }
    },
    methods: {
        getArticle() {
            this.datasend('articles/' + this.pageId).then((result) => {
                this.title = result.article.title;
                this.content = result.article.content;
            });
        },
        saveArticle() {
            let formdata = new FormData();
            if (this.title) formdata.append('title', this.title);
            if (this.content) formdata.append('content', this.content);
            
            const url = this.pageId ? 'articles/' + this.pageId : 'articles';
            const method = this.pageId ? 'PUT' : 'POST';
            
            this.datasend(url, method, formdata).then((result) => {
                if (result.errors) {
                    this.errors = result.errors;
                } else if (result.id) {
                    this.changePage('SingleArticle', result.id);
                }
            });
        },
    },
};
</script>