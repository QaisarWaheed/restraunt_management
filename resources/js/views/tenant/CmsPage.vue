<template>
  <div class="cms-page">
    <div class="container py-5">
      <div v-if="loading" class="text-center py-5">
        <div class="spinner-border text-danger" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
      </div>

      <div v-else-if="!page" class="text-center py-5">
        <div class="error-content">
          <i class="fas fa-file-slash fa-4x text-muted mb-4"></i>
          <h2 class="text-muted mb-3">Page Not Found</h2>
          <p class="text-muted mb-4">The page you're looking for doesn't exist or has been removed.</p>
          <router-link to="/" class="btn btn-danger">
            <i class="fas fa-home me-2"></i>Back to Home
          </router-link>
        </div>
      </div>

      <div v-else class="cms-content">
        <!-- Page Header -->
        <div class="page-header text-center mb-5">
          <h1 class="page-title">{{ page.page_title }}</h1>
          <div class="page-meta text-muted">
            <span v-if="page.menu?.page_title" class="me-3">
              <i class="fas fa-folder me-1"></i>{{ page.menu.page_title }}
            </span>
            <span class="me-3">
              <i class="fas fa-calendar me-1"></i>{{ formatDate(page.created_at) }}
            </span>
            <span v-if="page.keyword" class="me-3">
              <i class="fas fa-tag me-1"></i>{{ page.keyword }}
            </span>
          </div>
        </div>

        <!-- Page Content -->
        <div class="page-body">
          <div class="content-wrapper" v-html="page.content"></div>
        </div>

        <!-- Navigation -->
        <div class="page-navigation mt-5 pt-4 border-top">
          <div class="row">
            <div class="col-md-6 mb-3 mb-md-0">
              <router-link v-if="previousPage" :to="{ name: 'cms-page', params: { slug: previousPage.keyword } }" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>{{ previousPage.page_title }}
              </router-link>
            </div>
            <div class="col-md-6 text-md-end">
              <router-link v-if="nextPage" :to="{ name: 'cms-page', params: { slug: nextPage.keyword } }" class="btn btn-outline-secondary">
                {{ nextPage.page_title }}<i class="fas fa-arrow-right ms-2"></i>
              </router-link>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed, watch } from 'vue'
import { useRoute } from 'vue-router'
import axios from 'axios'

const route = useRoute()
const page = ref(null)
const loading = ref(true)
const allPages = ref([])

const fetchPage = async () => {
  try {
    loading.value = true
    console.log('Fetching page for slug:', route.params.slug)
    const response = await axios.get(`/tenant/cms_page/${route.params.slug}`)
    page.value = response.data.data
    console.log('Page data loaded:', page.value?.page_title)
  } catch (error) {
    console.error('Error fetching page:', error)
    page.value = null
  } finally {
    loading.value = false
  }
}

const fetchAllPages = async () => {
  try {
    const response = await axios.get('/tenant/cms_menu', {
      params: {
        status: 'active',
        per_page: 1000 // Get all pages for navigation
      }
    })
    allPages.value = response.data.data.data || []
  } catch (error) {
    console.error('Error fetching all pages:', error)
    allPages.value = []
  }
}

const formatDate = (dateString) => {
  return new Date(dateString).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  })
}

const currentPageIndex = computed(() => {
  return allPages.value.findIndex(p => p.keyword === route.params.slug)
})

const previousPage = computed(() => {
  const index = currentPageIndex.value
  return index > 0 ? allPages.value[index - 1] : null
})

const nextPage = computed(() => {
  const index = currentPageIndex.value
  return index >= 0 && index < allPages.value.length - 1 ? allPages.value[index + 1] : null
})

onMounted(async () => {
  await Promise.all([fetchPage(), fetchAllPages()])
})

// Watch for route changes to refetch page data
watch(
  () => route.fullPath,
  async (newPath, oldPath) => {
    if (newPath !== oldPath) {
      // Reset page state and loading
      page.value = null
      loading.value = true
      await fetchPage()
    }
  }
)
</script>

<style scoped>
.cms-page {
  min-height: 60vh;
  background: #f8f9fa;
}

.page-header {
  background: white;
  padding: 3rem 2rem;
  border-radius: 12px;
  box-shadow: 0 2px 12px rgba(0,0,0,0.08);
  margin-bottom: 2rem;
}

.page-title {
  font-family: 'Playfair Display', serif;
  font-size: 2.5rem;
  font-weight: bold;
  color: #2c3e50;
  margin-bottom: 1rem;
}

.page-meta {
  font-size: 0.95rem;
}

.page-body {
  background: white;
  padding: 3rem;
  border-radius: 12px;
  box-shadow: 0 2px 12px rgba(0,0,0,0.08);
  margin-bottom: 2rem;
}

.content-wrapper {
  font-size: 1.1rem;
  line-height: 1.8;
  color: #2c3e50;
}

.content-wrapper :deep(h1),
.content-wrapper :deep(h2),
.content-wrapper :deep(h3),
.content-wrapper :deep(h4),
.content-wrapper :deep(h5),
.content-wrapper :deep(h6) {
  font-family: 'Playfair Display', serif;
  font-weight: bold;
  color: #2c3e50;
  margin-top: 2rem;
  margin-bottom: 1rem;
}

.content-wrapper :deep(h1) { font-size: 2.2rem; }
.content-wrapper :deep(h2) { font-size: 1.8rem; }
.content-wrapper :deep(h3) { font-size: 1.5rem; }
.content-wrapper :deep(h4) { font-size: 1.3rem; }
.content-wrapper :deep(h5) { font-size: 1.1rem; }
.content-wrapper :deep(h6) { font-size: 1rem; }

.content-wrapper :deep(p) {
  margin-bottom: 1.5rem;
}

.content-wrapper :deep(ul),
.content-wrapper :deep(ol) {
  margin-bottom: 1.5rem;
  padding-left: 2rem;
}

.content-wrapper :deep(li) {
  margin-bottom: 0.5rem;
}

.content-wrapper :deep(blockquote) {
  border-left: 4px solid #dc3545;
  padding-left: 1.5rem;
  margin: 2rem 0;
  font-style: italic;
  color: #6c757d;
}

.content-wrapper :deep(img) {
  max-width: 100%;
  height: auto;
  border-radius: 8px;
  margin: 1.5rem 0;
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.content-wrapper :deep(table) {
  width: 100%;
  border-collapse: collapse;
  margin: 1.5rem 0;
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.content-wrapper :deep(th),
.content-wrapper :deep(td) {
  padding: 0.75rem;
  border: 1px solid #dee2e6;
}

.content-wrapper :deep(th) {
  background: #f8f9fa;
  font-weight: bold;
}

.content-wrapper :deep(a) {
  color: #dc3545;
  text-decoration: none;
}

.content-wrapper :deep(a:hover) {
  text-decoration: underline;
}

.page-navigation {
  background: white;
  padding: 2rem;
  border-radius: 12px;
  box-shadow: 0 2px 12px rgba(0,0,0,0.08);
}

.error-content {
  max-width: 500px;
  margin: 0 auto;
}

/* Responsive Design */
@media (max-width: 768px) {
  .page-header {
    padding: 2rem 1rem;
  }

  .page-title {
    font-size: 2rem;
  }

  .page-body {
    padding: 2rem 1.5rem;
  }

  .content-wrapper {
    font-size: 1rem;
  }

  .content-wrapper :deep(h1) { font-size: 1.8rem; }
  .content-wrapper :deep(h2) { font-size: 1.5rem; }
  .content-wrapper :deep(h3) { font-size: 1.3rem; }
}

@media (max-width: 576px) {
  .page-header {
    padding: 1.5rem 1rem;
  }

  .page-title {
    font-size: 1.8rem;
  }

  .page-body {
    padding: 1.5rem 1rem;
  }

  .page-meta {
    font-size: 0.9rem;
  }

  .page-meta span {
    display: block;
    margin-bottom: 0.5rem;
  }
}
</style>
