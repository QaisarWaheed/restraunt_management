<template>
  <div class="tenant-dashboard-layout">
    <!-- Top Bar -->
    <header class="td-header d-flex align-items-center justify-content-between px-4 py-2 bg-white border-bottom fixed-top">
      <div class="d-flex align-items-center gap-3">
        <img src="/assets/logo/logo.jpg" alt="Restro-Manage" class="td-header-logo me-3" />
        <div class="d-none d-md-block text-start" style="line-height: 1.1;">
          <div class="fw-bold" style="font-size: 1.08rem;">{{ user?.name || 'User Name' }}</div>
          <div class="text-muted" style="font-size: 0.98rem;">Role:
            <span class="badge bg-light text-black">
              {{ user?.role_name || 'N/A' }}
            </span>
          </div>
          <div class="text-muted" style="font-size: 0.92rem;">Member since {{ memberSince }}</div>
        </div>
      </div>
      <!-- Professional Navigation Bar -->
      <nav class="navbar navbar-expand-md navbar-light flex-grow-1 justify-content-center">
        <ul class="navbar-nav mx-auto">
          <li class="nav-item">
            <router-link to="/dashboard/stock-check-requests" class="nav-link px-3" active-class="active">{{ $t('stockCheckRequests') }}</router-link>
          </li>
          <li class="nav-item">
            <router-link to="/dashboard/orders" class="nav-link px-3" active-class="active">{{ $t('orders') }}</router-link>
          </li>
          <li class="nav-item dropdown position-static mega-menu-parent">
            <a class="nav-link dropdown-toggle px-3" href="#" id="megaMenuDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Setting
            </a>
            <div class="dropdown-menu mega-menu-dropdown shadow-lg p-4 mt-2" aria-labelledby="megaMenuDropdown">
              <div class="row" style="min-width: 480px;">
                <div class="col-6">
                  <div class="mb-2 text-uppercase text-muted" style="font-size: 0.93rem; letter-spacing: 0.5px;">{{ $t('restaurantSettings') }}</div>
                  <router-link to="/dashboard/users" class="dropdown-item"><i class="fas fa-user"></i> {{ $t('users') }}</router-link>
                  <router-link to="/dashboard/roles" class="dropdown-item"><i class="fas fa-user-tag"></i> {{ $t('roles') }}</router-link>

                </div>
                <div class="col-6">
                  <div class="mb-2 text-uppercase text-muted" style="font-size: 0.93rem; letter-spacing: 0.5px;">Theme Settings</div>
                  <router-link to="/dashboard/settings" class="dropdown-item"><i class="fas fa-cogs"></i> Theme Settings</router-link>
                  <router-link to="/dashboard/themes" class="dropdown-item"><i class="fas fa-paint-brush"></i> Themes</router-link>
                  <router-link to="/dashboard/colors" class="dropdown-item"><i class="fas fa-palette"></i> Colors</router-link>
                  <router-link to="/dashboard/layouts" class="dropdown-item"><i class="fas fa-columns"></i> Layouts</router-link>
                </div>
              </div>
            </div>
          </li>
        </ul>
      </nav>
      <div class="d-flex align-items-center gap-2">
        <LanguageSwitcher class="" />
        <div class="position-relative">
          <button class="btn btn-link text-danger me-3 position-relative" data-bs-toggle="tooltip" data-bs-placement="bottom" :title="$t('notifications')" @click="toggleNotificationDropdown">
            <i class="fas fa-bell"></i>
            <span v-if="unreadCount > 0" class="notification-badge">{{ unreadCount }}</span>
          </button>
          <div v-if="showNotificationDropdown" class="notification-dropdown card shadow position-absolute end-0 mt-2" style="min-width:340px; max-width:95vw; z-index:2000;">
            <div class="card-header d-flex justify-content-between align-items-center py-2 px-3 bg-white border-bottom">
              <span class="fw-bold">Notifications</span>
              <div>
                <!-- <button v-if="unreadCount > 0" type="button" class="btn btn-link btn-sm text-success me-2" @click="markAllNotificationsRead" title="Mark all as read">
                  <i class="fas fa-check-double"></i>
                </button> -->
                <button type="button" class="btn-close btn-sm" @click="closeNotificationDropdown"></button>
              </div>
            </div>
            <div class="card-body p-0" style="max-height:350px; overflow:auto;">
              <div v-if="loadingNotifications" class="d-flex justify-content-center align-items-center py-4">
                <div class="spinner-border text-danger" role="status" style="width: 1.8rem; height: 1.8rem;"></div>
              </div>
              <div v-else-if="notifications.length === 0" class="text-center text-muted py-4">
                <i class="fas fa-bell-slash fa-2x mb-2"></i><br>No notifications
              </div>
              <div v-else>
                <div v-for="n in notifications" :key="n.id" class="border-bottom px-3 py-3 d-flex justify-content-between align-items-center notification-item" :class="{ 'text-muted bg-light': n.is_read }">
                  <div style="min-width:0;">
                    <div class="fw-bold text-truncate" style="max-width:180px;">{{ n.title }}</div>
                    <div class="text-truncate" style="font-size:0.97em; max-width:180px;">{{ n.message }}</div>
                    <div class="text-muted" style="font-size:0.85em;">{{ new Date(n.created_at).toLocaleString() }}</div>
                  </div>
                  <!-- <div class="d-flex flex-column align-items-end gap-1 ms-2">
                    <button v-if="n.order_id" class="btn btn-link btn-sm text-primary p-0 mb-1" @click="seeOrder(n)" title="See Order"><i class="fas fa-eye"></i> See Order</button>
                    <button v-if="!n.is_read" class="btn btn-link btn-sm text-success p-0" @click="markNotificationRead(n.id)" title="Mark as read"><i class="fas fa-check-circle"></i> Mark as Read</button>
                  </div> -->
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Language Switcher -->

        <!-- Profile Icon with Tooltip -->
        <div class="dropdown me-2">
          <button class="btn btn-link text-dark dropdown-toggle p-0 d-flex align-items-center" type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false" :title="user ? user.name + ' (' + (user.role_name || $t('role')) + ')' : $t('profile')" data-bs-placement="bottom">
            <span v-if="user && user.avatar" class="rounded-circle overflow-hidden" style="width:32px;height:32px;display:inline-block;">
              <img :src="user.avatar" :alt="user.name" style="width:100%;height:100%;object-fit:cover;" />
            </span>
            <span v-else class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center" style="width:32px;height:32px;font-size:1.1rem;">
              {{ user && user.name ? user.name.charAt(0).toUpperCase() : 'U' }}
            </span>
          </button>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
            <li><a class="dropdown-item" href="/dashboard/password"><i class="fas fa-key text-danger"></i> &nbsp; {{ $t('passwordChange') }}</a></li>
            <li><a class="dropdown-item" id="dashboard-settings-btn" href="/dashboard/settings"><i class="fas fa-cogs text-danger"></i> &nbsp; {{ $t('settings') }}</a></li>
            <li><a class="dropdown-item" id="dashboard-settings-btn" href="/dashboard/email-settings"><i class="fas fa-envelope text-danger"></i> &nbsp; {{ $t('emailSetting') }}</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#" @click.prevent="logout"><i class="fas fa-sign-out text-danger"></i> &nbsp; {{ $t('logout') }}</a></li>
          </ul>
        </div>
      </div>
    </header>
    <!-- Notification Modal -->
    <div class="modal fade" :class="{ show: showNotificationModal }" tabindex="-1" style="display: block;" v-if="showNotificationModal">
      <div class="modal-dialog modal-dialog-scrollable modal-md">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Notifications</h5>
            <button type="button" class="btn-close" @click="closeNotificationModal"></button>
          </div>
          <div class="modal-body p-0">
            <div v-if="notifications.length === 0" class="text-center text-muted py-4">No notifications</div>
            <div v-for="n in notifications" :key="n.id" class="border-bottom p-3 d-flex justify-content-between align-items-center" :class="{ 'text-muted': n.is_read }">
              <div>
                <div class="fw-bold">{{ n.title }}</div>
                <div style="font-size:0.95em;">{{ n.message }}</div>
                <div class="text-muted" style="font-size:0.85em;">{{ new Date(n.created_at).toLocaleString() }}</div>
              </div>
              <!-- <button v-if="!n.is_read" class="btn btn-sm btn-outline-success ms-2" @click="markNotificationRead(n.id)">Mark as read</button> -->
            </div>
          </div>
        </div>
      </div>
      <div class="modal-backdrop fade show" @click="closeNotificationModal"></div>
    </div>
    <div class="td-main d-flex justify-content-center align-items-start bg-light py-2" style="padding-top: 74px !important;">
      <!-- Sidebar -->
      <aside class="td-sidebar bg-white shadow rounded-3 me-4">
        <div class="td-sidebar-scroll">

          <nav class="td-nav flex-column">
            <router-link to="/dashboard/home" class="td-nav-link" active-class="active"><i class="fas fa-th-large"></i> <span>{{ $t('dashboard') }}</span></router-link>
            <!-- <router-link to="/dashboard/orders" class="td-nav-link" active-class="active"><i class="fas fa-shopping-cart"></i> <span>{{ $t('orders') }}</span></router-link> -->
            <router-link to="/dashboard/orders" class="td-nav-link" active-class="active">
              <i class="fas fa-shopping-cart"></i>
              <span>{{ $t('orders') }}</span>
              <span v-if="counts.orders > 0" class="badge bg-light text-dark ms-2">{{ counts.orders }}</span>
            </router-link>
            <router-link to="/dashboard/stock-check-requests" class="td-nav-link" active-class="active">
              <i class="fas fa-boxes"></i>
              <span>{{ $t('stockCheckRequests') }}</span>
              <!-- <span v-if="counts.stockCheckReqs > 0" class="badge bg-light text-dark ms-2">{{ counts.stockCheckReqs }}</span> -->
            </router-link>
            <!-- <router-link to="/dashboard/quote-requests" class="td-nav-link" active-class="active"><i class="fas fa-file-invoice-dollar"></i> <span>{{ $t('quoteRequests') }}</span></router-link> -->
            <router-link to="/dashboard/reservations" class="td-nav-link" active-class="active"><i class="fas fa-calendar-alt"></i> <span>{{ $t('reservations') }}</span></router-link>
            <router-link to="/dashboard/contact-reqs" class="td-nav-link" active-class="active"><i class="fas fa-calendar-alt"></i> <span>{{ $t('contactReqs') }}</span></router-link>
            <router-link to="/dashboard/subscribers" class="td-nav-link" active-class="active"><i class="fas fa-calendar-alt"></i> <span>{{ $t('subscribers') }}</span></router-link>
            <router-link to="/dashboard/customers" class="td-nav-link" active-class="active"><i class="fas fa-users"></i> <span>{{ $t('customers') }}</span></router-link>
            <router-link to="/dashboard/bulletin" class="td-nav-link" active-class="active"><i class="fas fa-bullhorn"></i> <span>{{ $t('bulletin') }}</span></router-link>
            <router-link to="/dashboard/categories" class="td-nav-link" active-class="active"><i class="fas fa-list"></i> <span>{{ $t('categories') }}</span></router-link>
            <router-link to="/dashboard/products" class="td-nav-link" active-class="active"><i class="fas fa-box"></i> <span>{{ $t('products') }}</span></router-link>
            <router-link to="/dashboard/cms" class="td-nav-link" active-class="active"><i class="fas fa-file-alt"></i> <span>{{ $t('content_system') }}</span></router-link>
            <router-link to="/dashboard/roles" class="td-nav-link" active-class="active"><i class="fas fa-user-tag"></i> <span>{{ $t('roles') }}</span></router-link>
            <router-link to="/dashboard/users" class="td-nav-link" active-class="active"><i class="fas fa-user"></i> <span>{{ $t('users') }}</span></router-link>
            <router-link to="/dashboard/logout" class="td-nav-link" active-class="active"><i class="fas fa-sign-out-alt"></i> <span>{{ $t('logout') }}</span></router-link>

          </nav>
        </div>
      </aside>
      <!-- Main Content -->
      <main class="td-content bg-white rounded-3 shadow p-4 flex-grow-1">
        <router-view></router-view>
      </main>
    </div>
  </div>
</template>

<script>
import { driver } from 'driver.js';
import 'driver.js/dist/driver.css';
import { Tooltip } from 'bootstrap'
import LanguageSwitcher from '../components/LanguageSwitcher.vue'
import axios from 'axios'

let dashboardTour = null;

export default {
  name: 'TenantDashboardLayout',
  components: {
    LanguageSwitcher
  },
  data() {
    let user = null;
    try {
      user = JSON.parse(localStorage.getItem('user')) || null;
    } catch (e) { user = null; }
    return {
      user,
      languages: [
        { code: 'en', name: 'English' },
        { code: 'de', name: 'Deutsch' }
      ],
      selectedLang: { code: 'en', name: 'English' },
      notifications: [],
      showNotificationDropdown: false,
      loadingNotifications: false,
      notificationPollInterval: null,
      counts: {
        orders: 0,
        stockCheckReqs: 0,
        // ...add more as needed
      }
    }
  },
  computed: {
    memberSince() {
      if (!this.user || !this.user.created_at) return ''
      const date = new Date(this.user.created_at)
      return date.toLocaleString('default', { month: 'short', year: 'numeric' })
    },
    unreadCount() {
      return this.notifications.filter(n => !n.is_read).length;
    }
  },
  mounted() {
    this.fetchUser()
    this.initTooltips()
    this.fetchNotifications();
    this.fetchCounts();
    // Poll notifications every 20 seconds
    this.notificationPollInterval = setInterval(() => {
      this.fetchNotifications();
    }, 20000);
    // Show welcome notification dropdown for testing
    setTimeout(() => {
      this.showWelcomeNotification && this.showWelcomeNotification();
    }, 800);
    // Fix for Bootstrap dropdowns if needed
    this.$nextTick(() => {
      document.querySelectorAll('.dropdown-toggle').forEach(el => {
        el.addEventListener('click', function(e) {
          e.stopPropagation();
        })
      })
    })

    // Watch for route changes and scroll to top
    this.$watch(
      () => this.$route.path,
      () => {
        // Scroll to top when route changes
        window.scrollTo({
          top: 0,
          left: 0,
          behavior: 'smooth'
        })
      },
      { immediate: true }
    )
    // Show tour for first-time users
    if (!localStorage.getItem('tenant_dashboard_tour_shown')) {
      setTimeout(() => {
        dashboardTour = driver({
          showProgress: true,
          steps: [
            {
              element: '#profileDropdown',
              popover: {
                title: 'Profile & Settings',
                description: 'Click here to open your profile menu. You will find the Settings option inside.',
                position: 'bottom',
                onNextClick: () => {
                  // Open the dropdown programmatically
                  const dropdownBtn = document.getElementById('profileDropdown');
                  if (dropdownBtn) dropdownBtn.click();
                  setTimeout(() => dashboardTour.moveNext(), 300);
                }
              }
            },
            {
              element: '#dashboard-settings-btn',
              popover: {
                title: 'Go to Settings',
                description: 'Now click on Settings to set up your business details.',
                position: 'right',
                onNextClick: () => {
                  localStorage.setItem('tenant_dashboard_tour_shown', '1');
                  window.location.href = '/dashboard/settings';
                }
              }
            }
          ]
        });
        dashboardTour.drive();
      }, 1200);
    }
    document.addEventListener('click', this.handleClickOutsideDropdown);
  },
  beforeUnmount() {
    document.removeEventListener('click', this.handleClickOutsideDropdown);
    if (this.notificationPollInterval) clearInterval(this.notificationPollInterval);
  },
  methods: {
    async fetchUser() {
      try {
        // const axios = this.$axios || (await import('axios')).default

        const response = await axios.get('/tenant/auth-check', {
          withCredentials: true,
        })

        this.user = response.data.user
        this.user.role_name = response.data.role_name


        localStorage.setItem('user', JSON.stringify(response.data.user))
      } catch (error) {
        console.error('Error fetching user:', error)
      }
    },

    setLang(lang) {
      this.selectedLang = lang
      // Optionally emit or store lang code for i18n
    },
    initTooltips() {
      this.$nextTick(() => {
        document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
          new Tooltip(el)
        })
      })
    },
    async fetchNotifications() {
      this.loadingNotifications = true;
      try {
        const res = await axios.get('/tenant/notifications');
        if (res.data.success) this.notifications = res.data.data;
      } catch (e) {}
      this.loadingNotifications = false;
    },
    async markNotificationRead(id) {
      await axios.post(`/tenant/notifications/${id}/read`);
      this.notifications = this.notifications.map(n =>
        n.id === id ? { ...n, is_read: true } : n
      );
    },
    async markAllNotificationsRead() {
      try {
        await axios.post('/tenant/notifications/mark-all-read');
        this.notifications = this.notifications.map(n => ({ ...n, is_read: true }));
      } catch (e) {}
    },
    toggleNotificationDropdown() {
      this.showNotificationDropdown = !this.showNotificationDropdown;
    },
    closeNotificationDropdown() {
      this.showNotificationDropdown = false;
    },
    handleClickOutsideDropdown(e) {
      const dropdown = document.querySelector('.notification-dropdown');
      const bell = document.querySelector('.fa-bell');
      if (dropdown && !dropdown.contains(e.target) && !bell.contains(e.target)) {
        this.closeNotificationDropdown();
      }
    },
    async logout() {
      try {
        await axios.post('/tenant/logout');
        localStorage.removeItem('user');
        await this.$swal({
          icon: 'success',
          title: this.$t('logoutSuccess'),
          text: this.$t('youHaveBeenLoggedOut'),
          timer: 2000,
          showConfirmButton: false
        });
        setTimeout(() => {
          window.location.href = '/tenant/login';
        }, 2000);
      } catch (error) {
        localStorage.removeItem('user');
        await this.$swal({
          icon: 'success',
          title: this.$t('logoutSuccess'),
          text: this.$t('youHaveBeenLoggedOut'),
          timer: 2000,
          showConfirmButton: false
        });
        setTimeout(() => {
          window.location.href = '/tenant/login';
        }, 2000);
      }
    },
    async seeOrder(notification) {
      if (notification.order_id) {
        await this.markNotificationRead(notification.id);
        this.closeNotificationDropdown();
        this.$router.push(`/dashboard/orders?order_id=${notification.order_id}`);
      }
    },
    async fetchCounts() {
      // Orders
      try {
        const ordersRes = await axios.get('/tenant/orders', { params: { per_page: 1 } });
        this.counts.orders = ordersRes.data.data.total || 0;
      } catch { this.counts.orders = 0; }
      // Stock Check Requests
      try {
        const stockRes = await axios.get('/tenant/stock-check-reqs', { params: { per_page: 1 } });
        this.counts.stockCheckReqs = stockRes.data.data.total || 0;
      } catch { this.counts.stockCheckReqs = 0; }
      // ...repeat for other modules
    }
  }
}
</script>

<style scoped>
.tenant-dashboard-layout {
  min-height: 100vh;
  background: #f5f6fa;
  display: flex;
  flex-direction: column;
}
.td-header {
  background: #fff;
  color: #222;
  height: 64px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  box-shadow: 0 2px 8px rgba(0,0,0,0.04);
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  z-index: 1050;
  border-bottom: 1px solid #eee;
}
.td-header-logo {
  height: 44px;
  width: auto;
}
.td-header .btn-link {
  color: #222;
  font-size: 1.3rem;
}
.td-main {
  flex: 1 1 0%;
  min-height: 0;
  padding-top: 2rem;
}
.td-sidebar {
  width: 250px;
  min-height: 500px;
  background: #fff;
  border-radius: 12px;
  box-shadow: 0 2px 12px rgba(0,0,0,0.07);
  display: flex;
  flex-direction: column;
  align-items: stretch;
  max-height: calc(100vh - 90px);
}
.td-sidebar-scroll {
  overflow-y: auto;
  max-height: calc(100vh - 90px);
  padding-bottom: 1rem;
}
.td-user-info {
  background: #fafafa;
  border-radius: 12px 12px 0 0;
}
.td-avatar {
  width: 64px;
  height: 64px;
  border-radius: 50%;
  background: #f0f0f0;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 0.5rem;
}
.td-user-name {
  font-size: 1.1rem;
  color: #444;
}
.td-nav {
  display: flex;
  flex-direction: column;
  gap: 0.2rem;
  padding: 0.31rem 0.5rem;
}
.td-nav-link {
  display: flex;
  align-items: center;
  gap: 1rem;
  color: #444;
  padding: 0.5rem 1.0rem;
  border-radius: 8px;
  font-size: 1.05rem;
  font-weight: 500;
  text-decoration: none;
  transition: background 0.15s, color 0.15s;
}
.td-nav-link i {
  font-size: 1.2rem;
  color: #b71c1c;
}
.td-nav-link.active, .td-nav-link:hover {
  background: #f5f5f5;
  color: #d32f2f;
}
.td-content {
  min-width: 0;
  min-height: 500px;
  background: #fff;
  border-radius: 12px;
  box-shadow: 0 2px 12px rgba(0,0,0,0.07);
  margin-left: 0;
  flex: 1 1 0%;
}
@media (max-width: 991.98px) {
  .td-main {
    flex-direction: column;
    align-items: stretch;
    padding: 1rem 0.5rem;
  }
  .td-sidebar {
    width: 100%;
    margin-bottom: 1.5rem;
  }
  .td-content {
    margin-left: 0;
    padding: 1rem;
  }
}
.td-nav-section {
  font-size: 0.95rem;
  color: #b71c1c;
  font-weight: 600;
  margin: 1.2rem 0 0.3rem 1.2rem;
  letter-spacing: 0.5px;
}
.navbar-nav .nav-link {
  color: #222;
  font-weight: 500;
  font-size: 1.08rem;
  transition: color 0.2s;
}
.navbar-nav .nav-link.active, .navbar-nav .nav-link:hover {
  color: #d32f2f;
}
.navbar-nav .dropdown-menu {
  min-width: 160px;
  font-size: 1rem;
}
.lang-switcher-group {
  position: relative;
}
.lang-switcher-btn {
  font-weight: 500;
  color: #222;
  background: #fff;
  border: 1.5px solid #e0e0e0;
  border-radius: 7px;
  padding: 5px 18px 5px 12px;
  min-width: 120px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.04);
  transition: border 0.15s, box-shadow 0.15s;
  font-size: 1.08rem;
  outline: none;
}
.lang-switcher-btn:focus, .lang-switcher-btn:hover {
  border: 1.5px solid #b71c1c;
  box-shadow: 0 4px 16px rgba(183,28,28,0.08);
  color: #b71c1c;
  background: #fafafa;
}
.lang-switcher-label {
  font-size: 1.08rem;
  font-weight: 500;
  color: #222;
}
.lang-switcher-dropdown {
  min-width: 160px;
  border-radius: 10px;
  box-shadow: 0 8px 32px rgba(0,0,0,0.12);
  border: 1px solid #eee;
  padding: 4px 0;
  margin-top: 4px;
}
.lang-switcher-dropdown-label {
  font-size: 1.07rem;
  color: #222;
  font-weight: 500;
}
.dropdown-item.active, .dropdown-item:active, .dropdown-item:focus, .dropdown-item:hover {
  background: #f5f5f5;
  color: #b71c1c;
}
.modal {
  display: block;
  background: rgba(0,0,0,0.25);
  z-index: 3000;
}
.modal-backdrop {
  z-index: 2999;
}
.notification-dropdown {
  min-width: 340px;
  max-width: 95vw;
  z-index: 2000;
  right: 0;
  border-radius: 12px;
  border: 1px solid #eee;
  box-shadow: 0 4px 24px rgba(0,0,0,0.10);
  background: #fff;
}
.notification-item {
  transition: background 0.2s;
  border-radius: 8px;
}
.notification-item:hover {
  background: #f8f9fa !important;
}
.notification-badge {
  position: absolute;
  top: -8px;
  right: -8px;
  background: linear-gradient(135deg, #e53935 60%, #b71c1c 100%);
  color: #fff;
  border-radius: 50%;
  min-width: 26px;
  height: 26px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.08rem;
  font-weight: bold;
  box-shadow: 0 2px 8px rgba(229,57,53,0.18);
  border: 2px solid #fff;
  z-index: 10;
  transition: background 0.2s, box-shadow 0.2s;
}
.notification-badge:hover {
  background: linear-gradient(135deg, #b71c1c 60%, #e53935 100%);
  box-shadow: 0 4px 16px rgba(229,57,53,0.25);
}
</style>
