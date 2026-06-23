<template>
    <div id="main">
        <article class="post">
            <h1>
                {{ pageId && pageId !== 'null' ? 'Редактировать' : 'Создать' }}
                статью
            </h1>

            <input type="text" v-model="title" placeholder="Заголовок" />
            <div class="alert alert-danger" v-if="errors.title">
                {{ errors.title.join('. ') }}
            </div>

            <textarea
                v-model="content"
                placeholder="Текст статьи"
                rows="10"
            ></textarea>
            <div class="alert alert-danger" v-if="errors.content">
                {{ errors.content.join('. ') }}
            </div>

            <button type="submit" class="button big fit" @click="saveArticle">
                {{ pageId && pageId !== 'null' ? 'Обновить' : 'Создать' }}
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
            title: '',
            content: '',
            errors: {},
        };
    },
    mounted() {
        if (this.pageId && this.pageId !== 'null') {
            this.getArticle();
        }
    },
    methods: {
        getArticle() {
            this.datasend('articles/' + this.pageId)
                .then((result) => {
                    this.title = result.article.title;
                    this.content = result.article.content;
                })
                .catch((error) => {
                    console.error('Ошибка загрузки статьи:', error);
                });
        },
        saveArticle() {
            let formdata = new FormData();
            formdata.append('title', this.title || '');
            formdata.append('content', this.content || '');

            const isEdit = this.pageId && this.pageId !== 'null';
            const url = isEdit
                ? 'articles/' + this.pageId + '/update'
                : 'articles';

            this.datasend(url, 'POST', formdata).then((result) => {
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
