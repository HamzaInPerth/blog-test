<template>
  <div class="container">
    <NavBar />
    
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

    <nav aria-label="Page navigation" class="d-flex justify-content-center mt-3">
      <ul class="pagination">
        <li class="page-item" :class="{ 'disabled': currentPage === 1 }" style="cursor: pointer;">
          <a class="page-link" @click="getArticles(currentPage - 1)" aria-label="Previous">
            <span aria-hidden="true">&laquo;</span>
          </a>
        </li>
        <li class="page-item" v-for="page in lastPage" :key="page" :class="{ 'active': currentPage === page }" style="cursor: pointer;">
          <a class="page-link" @click="getArticles(page)">{{ page }}</a>
        </li>
        <li class="page-item" :class="{ 'disabled': currentPage === lastPage }" style="cursor: pointer;">
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
import NavBar from '../components/Common/NavBar.vue'
import { fetchArticles } from '@/services/ArticleService'
import { type IArticle } from '@/interfaces/ArticleInterface'

export default {
  components: {
    ArticleCard,
    NavBar
  },
  data() {
    return {
      hasError: false as boolean,
      articles: [] as IArticle[],
      currentPage: 1 as number,
      from: 1 as number,
      lastPage: null as number | null
    }
  },
  created() {
    this.getArticles()
  },
  methods: {
    async getArticles(page: number = 1) {
      try {
        const { current_page, from, last_page, data } = await fetchArticles(page)
        this.currentPage = current_page
        this.from = from
        this.lastPage = last_page
        this.articles = data
        console.log(data)
      } catch (error) {
        console.error('Error fetching articles:', error)
      }
    }
  }
}
</script>
