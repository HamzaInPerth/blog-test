<template>
  <div class="container">


    <!-- Author Info -->
    <div class="row text-center m-5" v-if="author">
      <h1>My name is {{ author.name }}</h1>
      <h3>Welcome to my blog</h3>
    </div>

    <!-- Error Message -->
    <div v-if="hasError" class="alert alert-danger m-5">
      Sorry, an error occurred...
    </div>

    <!-- Loading -->
    <div v-if="isLoading" class="text-center m-5">
      <h1>Loading...</h1>
    </div>

    <!-- Articles -->
    <div v-else>
      <div class="row">
        <ArticleCard
          class="col-12 col-md-4 col-xl-3"
          v-for="article in articles"
          :key="article.id"
          :title="article.title"
          :content="article.content"
          :id="article.id"
        />
      </div>
    </div>

    <!-- Pagination -->
    <nav v-if="totalPage > 1" aria-label="Page navigation" class="d-flex justify-content-center mt-3">
      <ul class="pagination">
        <li class="page-item" :class="{ 'disabled': currentPage === 1 }" style="cursor: pointer;">
          <a class="page-link" @click="getArticles(currentPage - 1)" aria-label="Previous">
            <span aria-hidden="true">&laquo;</span>
          </a>
        </li>
        <li class="page-item" v-for="page in totalPage" :key="page" :class="{ 'active': currentPage === page }"
          style="cursor: pointer;">
          <a class="page-link" @click="getArticles(page)">{{ page }}</a>
        </li>
        <li class="page-item" :class="{ 'disabled': currentPage === totalPage }" style="cursor: pointer;">
          <a class="page-link" @click="getArticles(currentPage + 1)" aria-label="Next">
            <span aria-hidden="true">&raquo;</span>
          </a>
        </li>
      </ul>
    </nav>
  </div>
</template>

<script lang="ts">
import ArticleCard from '@/components/Article/ArticleCard.vue'
import { fetchUserArticles } from '@/services/ArticleService'
import { type IArticle } from '@/interfaces/ArticleInterface'
import { type IUser } from '@/interfaces/UserInterfaces'

export default {
  components: {
    ArticleCard
  },
  data() {
    return {
      currentUsername: '' as string,
      author: null as IUser | null,
      isLoading: true as boolean,
      hasError: false as boolean,
      articles: [] as IArticle[],
      currentPage: 1 as number,
      totalPage: 0 as number
    }
  },
  created() {
    this.currentUsername = this.$route.params.username as string
    this.getArticles()
  },
  methods: {
    async getArticles(pageNb: number = 1) {
      try {
        const { articles, author, page, total_page } = await fetchUserArticles(this.currentUsername, pageNb)
        this.articles = articles
        this.author = author
        this.currentPage = page
        this.totalPage = total_page
        this.isLoading = false
      } catch (error) {
        this.hasError = true
        console.error('Error fetching articles:', error)
      }
    }
  }
}
</script>
