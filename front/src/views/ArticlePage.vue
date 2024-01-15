<template>
    <div>
        <div v-if="!isLoading" class="m-3">
            <div>
                <h1>{{ article.title }}</h1>
                <p>{{ article.content }}</p>
            </div>
            <div v-if="author">
                <small>Article written by : </small>
                <router-link :to="`/${author.username}`">
                    {{ author?.name }}
                </router-link>
            </div>
        </div>
    </div>
</template>

<script lang="ts">

import { getOneArticle } from '@/services/ArticleService'
import { type IArticle } from '@/interfaces/ArticleInterface'
import { type IUser } from '@/interfaces/UserInterfaces'

export default {
    data() {
        return {
            isLoading: true,
            article: {
                title: null as string | null,
                content: null as string | null,
            },
            author: null as IUser | null
        }
    },
    created() {
        this.getArticle(Number(this.$route.params.id))
    },
    methods: {
        async getArticle(id: number) {
            try {
                const { title, content, user } = await getOneArticle(id) as IArticle
                this.article.title = title
                this.article.content = content
                this.author = user || null
                this.isLoading = false
            } catch (error) {
                console.error('Error fetching articles:', error)
            }
        }
    }
}

</script>
