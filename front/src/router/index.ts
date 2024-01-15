import { createRouter, createWebHistory } from 'vue-router'
import HomePageVue from '../views/HomePage.vue'
import AdminDashBoardVue from '../views/AdminDashBoard.vue'
import ArticlePageVue from '../views/ArticlePage.vue'
import UserBlogVue from '../views/UserBlog.vue'
import CreateArticleVue from '../views/CreateArticle.vue'
import UserLoginVue from '@/views/UserLogin.vue'
import UserRegisterVue from '@/views/UserRegister.vue'

const routes = [
  { path: '/', component: HomePageVue },
  { path: '/user/login', component: UserLoginVue },
  { path: '/user/register', component: UserRegisterVue },
  { path: '/articles/:id', component: ArticlePageVue },

  { path: '/article/new', component: CreateArticleVue, meta: { requiresUserAuth: true } },
  { path: '/admin/dashboard', component: AdminDashBoardVue, meta: { requiresAdminAuth: true } },
  // { path: '/admin/dashboard', component: Dashboard, meta: { requiresAdminAuth: true } }

  { path: '/:username', component: UserBlogVue }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

router.beforeEach((to, from, next) => {
  if (to.matched.some((record) => record.meta.requiresAdminAuth)) {
    
    const isAuthenticated = true 
    if (!isAuthenticated) {
      next('/')
    } else {
      next()
    }
  } else {
    next()
  }
})

export default router
