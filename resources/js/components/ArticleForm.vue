<template>
    <div>

        <modal v-if="showModal" :modalContent="modalContent" @modalClose="modalClose"></modal>

        <div class="row">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
                <h5 class="title-form">Add article form</h5>
                <form enctype="multipart/form-data">
                    <!--   TITLE   -->
                    <div class="form-group text-left">
                        <label for="title">Title</label>
                        <input type="text" v-model="title" name="title" class="form-control" id="title">
                    </div>
                    <!--    CONTENT  -->
                    <div class="form-group text-left">
                        <label for="content">Content</label>
                        <textarea type="text" v-model="content" name="content" class="form-control" id="content"></textarea>
                    </div>
                    <!--    IMAGE FILE  -->
                    <div class="form-group text-left">
                        <label for="image">Image file</label>
                        <input type="file" @change="onFileSelected" class="form-control-file" id="image">
                    </div>
                </form>
                <button class="btn btn-primary" @click="createArticle()">CREATE</button>

            </div>
            <div class="col-sm-2"></div>
        </div>

    </div>

</template>

<script>
    import Modal from './Modal'
    export default {
        name: "ArticlesForm",
        data () {
            return {
                selectedFile: null,
                title: '',
                content: '',
                modalContent: '',
                showModal: false,
                showForm: false,
            }
        },
        methods: {
            createArticle(){
                if(this.title === '' || this.content === '') {
                    return;
                }
                const fd = new FormData();
                if(this.selectedFile){
                    fd.append('image', this.selectedFile, this.selectedFile.name);
                }
                fd.append('title', this.title);
                fd.append('content', this.content);

                axios.post('/public/articles', fd).then((response) => {
                    if (!response.data.success){
                        this.modalContent = response.data.message.title;
                        this.showModal = true;
                    } else {
                        this.formClose();
                    }

                });

                // axios.post('/public/articles',{
                //     title: this.title,
                //     content: this.content,
                //     img_file: this.selectedFile.name,
                //
                // }).then((response) => {
                //     console.log(response);
                // });

            },
            onFileSelected(event){
                this.selectedFile = event.target.files[0];
            },
            modalClose(){
                this.showModal = false;
            },
            formClose(){
                this.$emit('formClose');
                console.log('emitFormClose');
            },
        },
        comments: {
            Modal
        }
    }

</script>

<style scoped>
    .form-group>label {
        color: #4696e5;
        font-size: 26px;
        font-weight: bold;
    }
    .title-form {
        background-color: #4696e5;
        font-size: 30px;
        font-weight: bold;
        color: white;
    }
</style>
