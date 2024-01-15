<template>
    <div class="d-flex flex-column p-3 justify-center">
        <div v-if="erroMessage" class="alert alert-warning mt-2">
            {{ erroMessage }}
        </div>
        <div class="form-group mb-3">
            <input type="text" v-model="article.title" class="w-100 p-3" placeholder="Your title...">
        </div>
        <div class="form-group mb-3">
            <Ckeditor :editor="editor" v-model="article.content" />
        </div>
        <div class="form-group mb-3">
            <button class="btn btn-primary w-auto" @click="createNewArticle">Create new article</button>
        </div>

    </div>
</template>
  
<script lang="ts">
import ClassicEditor from '@ckeditor/ckeditor5-build-classic'
import CKEditor from '@ckeditor/ckeditor5-vue'
import { createPost } from '@/services/ArticleService'
import { type ICreateArticle } from '@/interfaces/ArticleInterface'

export default {
    components: {
        Ckeditor: CKEditor.component,
    },
    data() {
        return {
            editor: ClassicEditor,
            article: {
                title: '',
                content: '<p>Your new article...</p>',
            } as ICreateArticle,
            erroMessage: null as string | null,
        }
    },
    methods: {
        async createNewArticle() {
            this.erroMessage = null
            if (this.article.title.trim() === '' || this.article.content.trim() === '') {
                this.erroMessage = 'Please fill in both title and content.'
                return
            }

            try {
                const response = await createPost(this.article)
                console.log(response)
            } catch (error) {
                this.erroMessage = 'Error on creating article, please try again.'
            }
        }
    }
}
</script>
  
<style>
.ck-editor__editable {
    min-height: 400px;
}
</style>