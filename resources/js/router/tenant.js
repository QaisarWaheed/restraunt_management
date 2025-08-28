import { createRouter, createWebHistory } from 'vue-router';
import TenantFrontendLayout from '../layouts/TenantFrontendLayout.vue';
import TenantDashboardLayout from '../layouts/TenantDashboardLayout.vue';
import TenantLanding from '../views/tenant/landing.vue';
import axios from 'axios';

const routes = [

  // Tenant Frontend routes
    {
        path: '/',
        component: TenantFrontendLayout,
        children: [
            {
                path: '',
                name: 'tenant-landing',
                component: TenantLanding,
                beforeEnter: (to, from, next) => {
                    const host = window.location.host;
                    const mainDomain = window.MAIN_DOMAIN ;
                    // Example: 4v57qif4mzpa3wap.localhost:8000
                    if (host && host !== mainDomain) {
                    // if (host && host !== 'localhost:8000' && host !== '127.0.0.1:8000') {
                        // It's a tenant subdomain, show tenant landing
                        next();
                    } else {
                        // It's the main domain, redirect to main home page
                        next({ name: 'home' });
                    }
                }
            },
            {
              path: 'checkout',
              name: 'checkout',
              component: () => import('../views/tenant/Checkout.vue')
            },
            {
              path: 'stock-check',
              name: 'stock-check',
              component: () => import('../views/tenant/StockCheck.vue')
            },
            {
              path: 'reservation',
              name: 'reservation',
              component: () => import('../views/tenant/Reservation.vue')
            },
            {
              path: 'about',
              name: 'about',
              component: () => import('../views/tenant/About.vue')
            },
            {
              path: 'contact',
              name: 'contact',
              component: () => import('../views/tenant/Contact.vue')
            },
            {
              path: 'privacy',
              name: 'privacy',
              component: () => import('../views/tenant/Privacy.vue')
            },
            {
              path: 'page/:slug',
              name: 'cms-page',
              component: () => import('../views/tenant/CmsPage.vue')
            },
            {
              path: '/login',
              name: 'tenant-login',
              component: () => import('../views/tenant/Login.vue'),
              meta: { public: true }
            },
        ]
    },


  // Tenant Dashboard routes
  {
    path: '/dashboard/home',
    meta: { requiresAuth: true },
    component: TenantDashboardLayout,
    children: [
        {
          path: '',
          name: 'tenant-dashboard',
          component: () => import('../views/tenant_dashboard/TenantDashboard.vue'),
          meta: { requiresAuth: true }
        },
        {
          path: '/dashboard/roles',
          name: 'tenant-roles',
          component: () => import('../views/tenant_dashboard/Roles.vue'),
          meta: { requiresAuth: true }
        },
        {
          path: '/dashboard/users',
          name: 'tenant-users',
          component: () => import('../views/tenant_dashboard/Users.vue'),
          meta: { requiresAuth: true }
        },
        {
          path: '/dashboard/categories',
          name: 'tenant-categories',
          meta: { requiresAuth: true },
          component: () => import('../views/tenant_dashboard/Categories.vue'),
          meta: { requiresAuth: true }
        },
        {
          path: '/dashboard/products',
          name: 'tenant-products',
          meta: { requiresAuth: true },
          component: () => import('../views/tenant_dashboard/Products.vue')
        },
        {
          path: '/dashboard/settings',
          name: 'tenant-settings',
          meta: { requiresAuth: true },
          component: () => import('../views/tenant_dashboard/Settings.vue')
        },
        {
          path: '/dashboard/cms',
          name: 'tenant-cms',
          meta: { requiresAuth: true },
          component: () => import('../views/tenant_dashboard/CMS.vue')
        },
        {
          path: '/dashboard/email-settings',
          name: 'tenant-email-settings',
          meta: { requiresAuth: true },
          component: () => import('../views/tenant_dashboard/EmailSettings.vue')
        },
        {
          path: '/dashboard/orders',
          name: 'tenant-orders',
          meta: { requiresAuth: true },
          component: () => import('../views/tenant_dashboard/Orders.vue')
        },
        {
          path: '/dashboard/stock-check-requests',
          name: 'tenant-stock-check-requests',
          meta: { requiresAuth: true },
          component: () => import('../views/tenant_dashboard/StockCheckRequests.vue')
        },
        {
          path: '/dashboard/quote-requests',
          name: 'tenant-quote-requests',
          meta: { requiresAuth: true },
          component: () => import('../views/tenant_dashboard/QuoteRequests.vue')
        },
        {
          path: '/dashboard/reservations',
          name: 'tenant-reservations',
          meta: { requiresAuth: true },
          component: () => import('../views/tenant_dashboard/Reservations.vue')
        },
        {
          path: '/dashboard/contact-reqs',
          name: 'tenant-contact-reqs',
          meta: { requiresAuth: true },
          component: () => import('../views/tenant_dashboard/ContactRequests.vue')
        },
        {
          path: '/dashboard/subscribers',
          name: 'tenant-subscribers',
          meta: { requiresAuth: true },
          component: () => import('../views/tenant_dashboard/Subscribers.vue')
        },
        {
          path: '/dashboard/customers',
          name: 'tenant-customers',
          meta: { requiresAuth: true },
          component: () => import('../views/tenant_dashboard/Customers.vue')
        },
        {
          path: '/dashboard/bulletin',
          name: 'tenant-bulletin',
          meta: { requiresAuth: true },
          component: () => import('../views/tenant_dashboard/Bulletin.vue')
        },



        // Add more tenant child routes here
    ]
}
];

const router = createRouter({
    history: createWebHistory(),
    routes
});
router.beforeEach((to, from, next) => {
  const token = localStorage.getItem('token')
  if (to.meta.requiresAuth && !token) {
    next('/login')
  } else if (to.path === '/login' && token) {
    next('/dashboard/home') // prevent showing login again if already logged in
  } else {
    next()
  }
})

export default router;
