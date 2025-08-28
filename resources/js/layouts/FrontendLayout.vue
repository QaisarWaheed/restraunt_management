<template>

  <div class="frontend-layout">
    <!-- Top Bar -->
    <div class="top-bar bg-dark text-light pt-4 pb-2">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-md-8">
            <ul class="list-inline mb-0">
              <li class="list-inline-item me-3">
                <a :href="`mailto:${contactEmail}`" class="text-light text-decoration-none">
                  <i class="fas fa-envelope me-1"></i> {{ contactEmail }}
                </a>
              </li>
              <li class="list-inline-item">
                <a :href="`tel:${contactPhone}`" class="text-light text-decoration-none">
                  <i class="fas fa-phone me-1"></i> {{ contactPhone }}
                </a>
              </li>
            </ul>
          </div>
          <div class="col-md-4 text-end">
          </div>
        </div>
      </div>
    </div>

    <!-- Header -->
    <div style="position: relative; z-index: 1050; top: 40px;">
      <header class="header">
        <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
          <div class="container">
            <router-link class="navbar-brand" to="/">
              <img src="/assets/logo/restromanage-logo.png" alt="RestroManage" class="logo" />
            </router-link>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
              <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                  <router-link class="nav-link" :to="{ name: 'food-ordering' }">{{ $t('nav.foodOrdering') }}</router-link>
                </li>
                <li class="nav-item">
                  <router-link class="nav-link" :to="{ name: 'restaurant-services' }">{{ $t('nav.restaurantServices') }}</router-link>
                </li>
                <li class="nav-item">
                  <router-link class="nav-link" :to="{ name: 'pricing' }">{{ $t('nav.pricing') }}</router-link>
                </li>
                <li class="nav-item">
                  <router-link class="nav-link btn btn-primary text-white" :to="{ name: 'tenant-register' }">
                    {{ $t('nav.getAccess') }}
                  </router-link>

                </li>
                <li>

                    <language-switcher />
                </li>
              </ul>


            </div>
          </div>
        </nav>
      </header>
    </div>
    <!-- Main Content -->
    <main class="main-content">
      <router-view></router-view>
    </main>

    <!-- Footer -->

    <footer class="footer bg-dark text-light py-5">
      <div class="container">
        <div class="row">
          <div class="col-md-4 mb-4">
            <h5 class="mb-3">{{ $t('footer.aboutUs') }}</h5>
            <p>{{ $t('footer.aboutText') }}</p>
          </div>
          <div class="col-md-4 mb-4">
            <h5 class="mb-3">{{ $t('footer.quickLinks.title') }}</h5>
            <ul class="list-unstyled">
              <li class="mb-2">
                <router-link class="text-light text-decoration-none" :to="{ name: 'about' }">{{ $t('footer.aboutUs') }}</router-link>
              </li>
              <li class="mb-2">
                <router-link class="text-light text-decoration-none" :to="{ name: 'contact' }">{{ $t('footer.contactUs') }}</router-link>
              </li>
              <li class="mb-2">
                <router-link class="text-light text-decoration-none" :to="{ name: 'privacy' }">{{ $t('footer.privacy') }}</router-link>
              </li>
              <li class="mb-2">
                <router-link class="text-light text-decoration-none" :to="{ name: 'terms' }">{{ $t('footer.terms') }}</router-link>
              </li>
            </ul>
          </div>
          <div class="col-md-4 mb-4">
            <h5 class="mb-3">{{ $t('footer.contactInfo') }}</h5>
            <ul class="list-unstyled">
              <li class="mb-2">
                <i class="fas fa-map-marker-alt me-2"></i> {{ $t('footer.address') }}
              </li>
              <li class="mb-2">
                <i class="fas fa-phone me-2"></i> {{ $t('topbar.phone') }}
              </li>
              <li class="mb-2">
                <i class="fas fa-envelope me-2"></i> {{ contactEmail }}
              </li>
            </ul>
          </div>
        </div>
        <hr class="my-4 bg-light">
        <div class="text-center">
          <p class="mb-0">{{ $t('footer.copyright') }}</p>
        </div>
      </div>
    </footer>
  </div>
</template>

<script setup>
import { watch } from 'vue'
import { useRoute } from 'vue-router'
import LanguageSwitcher from '../components/frontend/LanguageSwitcher.vue'
import { contactEmail, contactPhone } from '../utils/contact.js'

// Get the current route
const route = useRoute()

// Watch for route changes and scroll to top
watch(
  () => route.path,
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
</script>

<style scoped>
.frontend-layout {
  min-height: 100vh;
  display: flex;
  flex-direction: column;
}

.top-bar {
  font-size: 0.9rem;
  background-color: #1a1a1a !important;
  padding: 0.5rem 0;
}

.top-bar a {
  color: rgba(255, 255, 255, 0.8) !important;
  transition: color 0.3s ease;
}

.top-bar a:hover {
  color: #c62828 !important;
  text-decoration: none;
}

.top-bar i {
  color: #c62828;
}

.header {
  position: sticky;
  top: 0;
  z-index: 1000;
  background-color: white;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.navbar {
  padding: 1rem 0;
}

.logo {
  height: 40px;
  width: auto;
}

.nav-link {
  font-weight: 500;
  color: #333;
  margin: 0 0.5rem;
  transition: color 0.3s ease;
}

.nav-link:hover {
  color: #c62828;
}

.nav-link.btn {
  padding: 0.5rem 1.5rem;
  margin-left: 1rem;
  background-color: #c62828;
  border-color: #c62828;
}

.nav-link.btn:hover {
  background-color: white;
  border-color: #c62828;
  color: white;
}

.main-content {
  flex: 1;
}

.footer {
  margin-top: auto;
}

.footer h5 {
  color: white;
}

@media (max-width: 768px) {
  .top-bar {
    text-align: center;
  }

  .top-bar .col-md-4 {
    margin-top: 0.5rem;
  }

  .navbar-nav {
    text-align: center;
  }

  .nav-link {
    margin: 0.5rem 0;
  }

  .nav-link.btn {
    margin: 0.5rem auto;
    display: inline-block;
  }
}
</style>
<style scoped>

        :root {
            --primary-color: #c62828;
            --primary-dark: #b71c1c;
            --primary-light: #e57373;
            --error-color: #ff3d00;
            --text-primary: rgba(0, 0, 0, 0.87);
            --text-secondary: rgba(0, 0, 0, 0.6);
            --text-disabled: rgba(0, 0, 0, 0.38);
            --background: #fafafa;
            --surface: rgb(244.8, 244.8, 244.8);
        }

        body {
            padding-top: 96px !important; /* 40px topbar + ~56px navbar */
            background-color: var(--background);
            color: var(--text-primary);
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
        }

        .text-primary {
            color: var(--primary-color) !important;
        }

        .hero-section {
            min-height: 480px;
            width: 100vw;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 0;
            padding: 0;
        }
        .hero-bg {
            background: url('/images/hero-bg.jpg') no-repeat center center;
            background-size: cover;
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }
        .hero-overlay {
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.6);
            z-index: 2;
        }
        .hero-content {
            position: relative;
            z-index: 3;
            min-height: 480px;
            width: 100vw;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .hero-content h1 {
            font-size: 3.5rem;
            font-family: 'Lora', serif;
            font-weight: bold;
        }
        .hero-content p {
            font-size: 1.25rem;
            letter-spacing: 1px;
        }
        .hero-content .btn {
            font-size: 1.1rem;
            border-radius: 6px;
            box-shadow: none;
            margin: 0 8px;
            text-transform: uppercase;
        }
        @media (max-width: 767.98px) {
            .hero-content h1 {
                font-size: 2.2rem;
            }
            .hero-section, .hero-content {
                min-height: 320px;
            }
        }
        .team-img {
            width: 100%;
            aspect-ratio: 1/1.1;
            height: 300px;
            object-fit: cover;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
            background: #f5f5f5;
            display: block;
        }
        .team-social {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 0.5rem;
        }
        .team-social .social-icon svg {
            fill: #757575;
            transition: fill 0.2s;
        }
        .team-social .social-icon:hover svg {
            fill: #c62828;
        }
        .top-bar {
            position: fixed; top: 0; left: 0; width: 100%; z-index: 1051;
            background: #b71c1c; color: #fff; font-size: 1rem; font-family: 'Lora', serif;
            border-bottom: 1px solid #a31515; height: 40px; display: flex; align-items: center; padding: 0;
        }
        .top-bar .container-fluid { display: flex; justify-content: space-between; align-items: center; height: 40px; padding-left: 24px; padding-right: 24px; }
        .top-bar .contact-info span { margin-right: 24px; display: inline-flex; align-items: center; font-size: 0.98em; }
        .top-bar .contact-info i, .top-bar .contact-info .material-icons { font-size: 1.1em; margin-right: 6px; vertical-align: middle; color: #fff !important; }
        .top-bar .topbar-right { display: flex; align-items: center; gap: 16px; }
        .top-bar .social-icons a { color: #fff !important; margin-right: 8px; font-size: 1.1em; transition: color 0.2s; }
        .top-bar .social-icons a:last-child { margin-right: 0; }
        .top-bar .social-icons a:hover { color: #ffd700 !important; }
        .top-bar .lang-flag { width: 22px; height: 16px; margin-right: 6px; vertical-align: middle; object-fit: cover; border-radius: 2px; background: #fff; }
        .top-bar .account { display: inline-flex; align-items: center; cursor: pointer; font-size: 1em; margin-left: 10px; color: #fff !important; position: relative; user-select: none; }
        .top-bar .account .material-icons, .top-bar .account .arrow { color: #fff !important; }
        .account-dropdown { display: none; position: absolute; right: 0; top: 120%; min-width: 260px; background: #fff; color: #222; border-radius: 10px; box-shadow: 0 8px 32px rgba(0,0,0,0.18); padding: 0; z-index: 2000; font-size: 1rem; overflow: hidden; }
        .account-dropdown.show { display: block; }
        .account-dropdown .dropdown-header { background: #fafafa; padding: 18px 20px 12px 20px; text-align: center; border-bottom: 1px solid #eee; }
        .account-dropdown .dropdown-header img { width: 54px; height: 54px; border-radius: 50%; margin-bottom: 8px; object-fit: cover; background: #eee; }
        .account-dropdown .dropdown-header .name { font-weight: bold; font-size: 1.1em; margin-bottom: 2px; color: #222; }
        .account-dropdown .dropdown-header .username { font-size: 0.95em; color: #888; font-style: italic; }
        .account-dropdown .dropdown-item { display: flex; align-items: center; padding: 12px 20px; color: #222; font-size: 1em; border-bottom: 1px solid #f0f0f0; background: none; cursor: pointer; transition: background 0.2s; }
        .account-dropdown .dropdown-item:last-child { border-bottom: none; }
        .account-dropdown .dropdown-item i, .account-dropdown .dropdown-item .material-icons {
            color: #fff !important; background: #b71c1c; border-radius: 50%; width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center; margin-right: 14px; font-size: 1.2em; transition: background 0.2s, color 0.2s;
        }
        .account-dropdown .dropdown-item:hover { background: #f5f5f5; }
        .account-dropdown .dropdown-item:hover i, .account-dropdown .dropdown-item:hover .material-icons { background: #c62828; }
        .account-dropdown .dropdown-footer { padding: 12px 20px 10px 20px; background: #fafafa; text-align: center; border-top: 1px solid #eee; }
        .account-dropdown .dropdown-footer .social-icons a { color: #fff !important; background: #b71c1c; border-radius: 50%; width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center; margin: 0 4px; font-size: 1.1em; transition: background 0.2s; }
        .account-dropdown .dropdown-footer .social-icons a:hover { background: #c62828; }
        .navbar-fixed-top, .navbar.sticky-top, nav.navbar.fixed-top {
            top: 40px !important;
            z-index: 1050;
        }
        .top-bar {
        position: fixed; top: 0; left: 0; width: 100%; z-index: 1051;
        background: #b71c1c; color: #fff; font-size: 1rem; font-family: 'Lora', serif;
        border-bottom: 1px solid #a31515; height: 40px; display: flex; align-items: center; padding: 0;
      }
      .top-bar .container-fluid { display: flex; justify-content: space-between; align-items: center; height: 40px; padding-left: 24px; padding-right: 24px; }
      .top-bar .contact-info span { margin-right: 24px; display: inline-flex; align-items: center; font-size: 0.98em; }
      .top-bar .contact-info i, .top-bar .contact-info .material-icons { font-size: 1.1em; margin-right: 6px; vertical-align: middle; color: #fff !important; }
      .top-bar .topbar-right { display: flex; align-items: center; gap: 16px; }
      .top-bar .social-icons a { color: #fff !important; margin-right: 8px; font-size: 1.1em; transition: color 0.2s; }
      .top-bar .social-icons a:last-child { margin-right: 0; }
      .top-bar .social-icons a:hover { color: #ffd700 !important; }
      .top-bar .lang-flag { width: 22px; height: 16px; margin-right: 6px; vertical-align: middle; object-fit: cover; border-radius: 2px; background: #fff; }
      .top-bar .account { display: inline-flex; align-items: center; cursor: pointer; font-size: 1em; margin-left: 10px; color: #fff !important; position: relative; user-select: none; }
      .top-bar .account .material-icons, .top-bar .account .arrow { color: #fff !important; }
      .account-dropdown { display: none; position: absolute; right: 0; top: 120%; min-width: 260px; background: #fff; color: #222; border-radius: 10px; box-shadow: 0 8px 32px rgba(0,0,0,0.18); padding: 0; z-index: 2000; font-size: 1rem; overflow: hidden; }
      .account-dropdown.show { display: block; }
      .account-dropdown .dropdown-header { background: #fafafa; padding: 18px 20px 12px 20px; text-align: center; border-bottom: 1px solid #eee; }
      .account-dropdown .dropdown-header img { width: 54px; height: 54px; border-radius: 50%; margin-bottom: 8px; object-fit: cover; background: #eee; }
      .account-dropdown .dropdown-header .name { font-weight: bold; font-size: 1.1em; margin-bottom: 2px; color: #222; }
      .account-dropdown .dropdown-header .username { font-size: 0.95em; color: #888; font-style: italic; }
      .account-dropdown .dropdown-item { display: flex; align-items: center; padding: 12px 20px; color: #222; font-size: 1em; border-bottom: 1px solid #f0f0f0; background: none; cursor: pointer; transition: background 0.2s; }
      .account-dropdown .dropdown-item:last-child { border-bottom: none; }
      .account-dropdown .dropdown-item i, .account-dropdown .dropdown-item .material-icons {
        color: #fff !important; background: #b71c1c; border-radius: 50%; width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center; margin-right: 14px; font-size: 1.2em; transition: background 0.2s, color 0.2s;
      }
      .account-dropdown .dropdown-item:hover { background: #f5f5f5; }
      .account-dropdown .dropdown-item:hover i, .account-dropdown .dropdown-item:hover .material-icons { background: #c62828; }
      .account-dropdown .dropdown-footer { padding: 12px 20px 10px 20px; background: #fafafa; text-align: center; border-top: 1px solid #eee; }
      .account-dropdown .dropdown-footer .social-icons a { color: #fff !important; background: #b71c1c; border-radius: 50%; width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center; margin: 0 4px; font-size: 1.1em; transition: background 0.2s; }
      .account-dropdown .dropdown-footer .social-icons a:hover { background: #c62828; }


.nav-link.active, .nav-link:focus {
    background: #f5f5f5;
    color: #c62828 !important;
    box-shadow: none;
}

.nav-link:hover {
    color: #c62828 !important;
    background: #f5f5f5;
}

.footer-home {
    background: #292929;
    color: #fff;
    font-size: 16px;
    position: relative;
}
.footer-home .footer-title {
    font-family: 'Georgia', serif;
    font-weight: bold;
    color: #fff;
}
.footer-home p, .footer-home li, .footer-home label, .footer-home input, .footer-home textarea {
    color: #ccc;
}
.footer-home .form-control {
    background: #222;
    border: 1px solid #444;
    color: #fff;
    border-radius: 4px;
}
.footer-home .form-control:focus {
    background: #222;
    color: #fff;
    border-color: #c62828;
    box-shadow: none;
}
.footer-home .btn-danger {
    background: #c62828;
    border: none;
    border-radius: 4px;
    font-weight: bold;
    letter-spacing: 1px;
}
.footer-home .btn-danger:hover {
    background: #b71c1c;
}
.footer-home .footer-social a img {
    filter: grayscale(1) brightness(1.2);
    transition: filter 0.2s;
}
.footer-home .footer-social a:hover img {
    filter: none;
}
.footer-home hr {
    border-color: #444;
}
.footer-home .text-danger {
    color: #c62828 !important;
}
.footer-home .material-icons {
    vertical-align: middle;
    font-size: 20px;
}
@media (max-width: 767.98px) {
    .footer-home .row > div {
        margin-bottom: 2rem;
    }
    .footer-home .text-end, .footer-home .text-start {
        text-align: center !important;
    }
}
</style>
