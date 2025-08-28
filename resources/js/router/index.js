import { createRouter, createWebHistory } from 'vue-router';
import DashboardLayout from '../layouts/DashboardLayout.vue';
import FrontendLayout from '../layouts/FrontendLayout.vue';

const routes = [
  // Frontend Routes
  {
    path: '/',
    component: FrontendLayout,
    children: [
      {
        path: '',
        name: 'home',
        component: () => import('../views/frontend/Home.vue')
      },
      {
        path: 'food-ordering',
        name: 'food-ordering',
        component: () => import('../views/frontend/FoodOrdering.vue')
      },
      {
        path: 'restaurant-services',
        name: 'restaurant-services',
        component: () => import('../views/frontend/RestaurantServices.vue')
      },
      {
        path: 'pricing',
        name: 'pricing',
        component: () => import('../views/frontend/Pricing.vue')
      },
      {
        path: 'about',
        name: 'about',
        component: () => import('../views/frontend/About.vue')
      },
      {
        path: 'contact',
        name: 'contact',
        component: () => import('../views/frontend/Contact.vue')
      },
      {
        path: 'privacy',
        name: 'privacy',
        component: () => import('../views/frontend/Privacy.vue')
      },
      {
        path: 'terms',
        name: 'terms',
        component: () => import('../views/frontend/Terms.vue')
      },
      {
        path: 'tenant-register',
        name: 'tenant-register',
        component: () => import('../views/frontend/TenantRegister.vue'),
        meta: { public: true }
      },
      {
        path: 'login',
        name: 'login',
        component: () => import('../views/auth/Login.vue'),
        meta: { public: true }
      }
    ]
  },
  // Dashboard Routes
  {
    path: '/dashboard',
    component: DashboardLayout,
    children: [
      {
        path: '',
        name: 'dashboard',
        component: () => import('../views/dashboard/Dashboard.vue')
      },
      {
        path: 'users',
        name: 'users',
        component: () => import('../views/dashboard/Users.vue')
      },
      {
        path: 'roles',
        name: 'roles',
        component: () => import('../views/dashboard/Roles.vue')
      },
      {
        path: 'tenants',
        name: 'tenants',
        component: () => import('../views/dashboard/Tenants.vue')
      }
    ]
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

// Navigation guard
router.beforeEach((to, from, next) => {
  // Allow public routes
  if (to.meta.public) {
    next();
    return;
  }

  // Check authentication for dashboard routes
  if (to.path.startsWith('/dashboard')) {
    const token = localStorage.getItem('token');
    if (!token) {
      next('/login');
      return;
    }
  }

  next();
});

export default router; 