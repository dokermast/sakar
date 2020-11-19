<template>
    <div class="container text-center">

        <h4 class="title">Articles</h4>

        <div v-if="showArticlesList" id="articles-list">
            <a class="btn btn-outline-primary add-btn" @click="toggle()">Add article</a>

            <div v-for="(item, index) in pagination.data" class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <div class="card" style="max-width: 100%;">
                        <div class="row no-gutters">
                            <div class="col-md-4">
                                <img v-if="item.img_path" :src="'/public/storage/' + item.img_path" class="card-img" alt="">
                                <img v-else :src="image_default" class="card-img" alt="">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title">{{item.title}}</h5>
                                    <p class="card-text">{{item.content}}</p>
                                    <a class="btn btn-outline-danger" @click="deleteArticle(item.id)">Delete</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2"></div>

            </div>

            <!--   PAGINATION     -->
            <div id="pagination">
                <nav class="nav justify-content-center" aria-label="Page navigation example">
                    <ul class="pagination">
                        <li v-if="pagination.prev_page_url" class="page-item"><a class="page-link" @click="articlePagin(pagination.prev_page_url)" :disabled="!pagination.prev_page_url">Previous</a></li>
                        <li class="page-item"><a class="page-link" href="">Page {{pagination.current_page}} of {{pagination.last_page}}</a></li>
                        <li v-if="pagination.next_page_url" class="page-item"><a class="page-link" @click="articlePagin(pagination.next_page_url)">Next</a></li>
                    </ul>
                </nav>
            </div>

        </div>

        <div v-if="showArticlesForm" id="articles-form">
            <a class="btn btn-outline-secondary main-btn" @click="toggle()">Back to Articles list</a>
            <article-form @formClose="formClose"></article-form>
        </div>

    </div>
</template>

<script>
    import ArticleForm from './ArticleForm'
    export default {
        name: "Articles",
        props: {
        },
        data () {
            return {
                articles: [],
                image_default: '/public/default.png',
                showArticlesList: true,
                showArticlesForm: false,
                pagination: Object,
                url: '/public/articles',
            }
        },
        mounted () {
            this.getArticles();
        },
        methods: {
            getArticles(){
                axios.get(this.url).then((response) => {
                    this.pagination = response.data.articles;
                });
            },
            articlePagin(url){
                this.url = url;
                this.getArticles();
            },
            toggle(){
                this.showArticlesForm = !this.showArticlesForm;
                this.showArticlesList = !this.showArticlesList;
            },
            deleteArticle(id){
                axios.delete('/public/articles/' + id).then((response) => {
                    if (response.data.success){
                        this.getArticles();
                    } else {
                        console.log(response.data.message);
                    }
                });
            },
            formClose(){
                this.showArticlesForm = false;
                this.showArticlesList = true;
                this.getArticles();
            }
        },
        components: {
            ArticleForm,
        }
    }
</script>

<style scoped>
    #pagination {
        margin: 20px 0;
    }
    .main-btn {
        margin: 20px;
    }
    .title {
        color: #4696e5;
        font-size: 36px;
        font-weight: bold;
        margin: 30px 0;
    }
    .add-btn {
        margin: 0 0 30px 0;
    }
</style>
