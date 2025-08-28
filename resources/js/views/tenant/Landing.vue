<template>
  <!-- Banner Section (Hero) -->
  <section class="main-banner-section position-relative d-flex align-items-end justify-content-center" style="min-height: 260px; width: 100vw; left: 50%; right: 50%; margin-left: -50vw; margin-right: -50vw; background: url('/Mox_files/menu.jpg') center center/cover no-repeat;">
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: rgba(0,0,0,0.45); z-index: 1;"></div>
    <div class="container position-relative" style="z-index: 2;">
      <div class="row align-items-end">
        <div class="col-12 col-md-12 mx-auto">
          <div v-if="loading" class="text-center py-5 text-white">
            <div class="spinner-border text-light" role="status">
              <span class="visually-hidden">Loading...</span>
            </div>
          </div>
          <div v-else-if="tenantSettings" class="text-white d-flex align-items-center p-3 p-md-4 shadow-lg position-relative" style="margin-top: 120px;">
            <img v-if="tenantSettings.logo" :src="tenantSettings.logo" :alt="tenantSettings.business_name + ' Logo'" class="shadow-sm me-3" style="height: 80px; object-fit: cover;">
            <img v-else src="/assets/logo/default-logo.png" :alt="tenantSettings.business_name + ' Logo'" class="shadow-sm me-3" style="width:100px; height: 80px; object-fit: cover;">
            
            <div class="flex-grow-1">
              <div class="d-flex align-items-center mb-1">
                <h3 class="mb-0 fw-bold" style="font-size: 2rem;">{{ tenantSettings.business_name }}</h3>
                <span 
                  class="badge ms-2"
                  :class="{'bg-success': tenantSettings.is_active, 'bg-warning': !tenantSettings.is_active}"
                  style="font-size: 0.9rem;">
                  {{ tenantSettings.is_active ? 'OPEN' : 'CLOSED' }}
                </span>
              </div>
              <div class="mb-1" style="font-size: 1.05rem;" v-if="tenantSettings.address"><i class="fas fa-map-marker-alt me-1"></i> {{ tenantSettings.address }}</div>
               <div class="mb-1" style="font-size: 1.05rem;" v-if="tenantSettings.country"><i class="fas fa-globe me-1"></i> {{ tenantSettings.country }}</div>
              <!-- Review system commented out for now -->
              <!-- <div class="d-flex align-items-center mb-1">
                <span class="me-3"><i class="fas fa-utensils me-1"></i> Indian</span>
                <span class="badge bg-danger me-2"><i class="fas fa-star me-1"></i> 0.0</span>
                <span class="">0 Reviews</span>
              </div> -->
            </div>
            <div class="ms-auto d-none d-md-block" v-if="tenantSettings.pickup_start_end_time">
              <span class="badge bg-danger px-3 py-2" style="font-size: 1.1rem;">Pick: {{ tenantSettings.pickup_start_end_time }}</span>
            </div>
          </div>
           <div v-else class="text-center py-5 text-white">
            <p>Unable to load restaurant information.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Breadcrumbs below banner -->
  <div class="container">
    <nav aria-label="breadcrumb" class="mt-2 mb-0">
      <ol class="breadcrumb align-items-center" style="background: transparent;">
        <li class="breadcrumb-item"><router-link to="/" class="text-danger"><i class="fas fa-home"></i> HOME</router-link></li>
        <li v-if="tenantSettings && tenantSettings.country" class="breadcrumb-item"><span class="text-danger">{{ tenantSettings.country }}</span></li>
        <li v-if="tenantSettings && tenantSettings.business_name" class="breadcrumb-item active text-danger" aria-current="page">{{ tenantSettings.business_name }}</li>
      </ol>
    </nav>
  </div>

  <section class="menu-section py-5">
    <div class="container">
      <!-- Category Tabs -->
      <ul class="nav nav-tabs mb-4 justify-content-center" role="tablist">
        <li class="nav-item" v-for="cat in categories" :key="cat.id ?? 'all'" role="presentation">
          <button class="nav-link" :class="{ active: selectedCategory.id === cat.id }" @click="selectedCategory = cat" type="button" role="tab">
            {{ cat.name }}
          </button>
        </li>
      </ul>
      <!-- Filter/Sort Bar -->
      <div class="filter-bar d-flex justify-content-between align-items-center mb-4 p-2 bg-white rounded shadow-sm flex-wrap">
        <div>
          <div class="dropdown d-inline me-2">
            <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
              Sort by {{ sortBy === 'default' ? 'Default' : 
                       sortBy === 'price_low_high' ? 'Price: Low to High' :
                       sortBy === 'price_high_low' ? 'Price: High to Low' : 'Rating' }}
            </button>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#" @click.prevent="handleSort('default')">Default</a></li>
              <li><a class="dropdown-item" href="#" @click.prevent="handleSort('price_low_high')">Price: Low to High</a></li>
              <li><a class="dropdown-item" href="#" @click.prevent="handleSort('price_high_low')">Price: High to Low</a></li>
              <li><a class="dropdown-item" href="#" @click.prevent="handleSort('rating')">Rating</a></li>
            </ul>
          </div>
        </div>
        <div class="d-flex align-items-center flex-wrap">
          <div class="dropdown d-inline me-3">
            <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
              Show 12
            </button>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">Show 6</a></li>
              <li><a class="dropdown-item" href="#">Show 12</a></li>
              <li><a class="dropdown-item" href="#">Show 24</a></li>
            </ul>
          </div>
          <button class="btn btn-link text-dark px-2" :class="{active: viewMode==='grid'}" @click="viewMode='grid'" title="Grid View"><i class="material-icons">grid_view</i></button>
          <button class="btn btn-link text-dark px-2" :class="{active: viewMode==='list'}" @click="viewMode='list'" title="List View"><i class="material-icons">view_list</i></button>
        </div>
      </div>
      <!-- Menu Items Grid/List -->
      <div v-if="filteredMenuItems.length > 0 && viewMode === 'grid'" class="row g-4">
        <div class="col-12 col-sm-6 col-lg-3" v-for="item in filteredMenuItems" :key="item.id">
          <div class="card h-100 shadow-sm border-0">
            <div class="position-relative">
              <img v-if="item.image" :src="item.image" class="card-img-top" :alt="item.name" style="object-fit: cover; height: 180px;">
              <span v-if="item.discount" class="badge bg-danger position-absolute top-0 start-0 m-2">{{ item.discount }}% OFF</span>
            </div>
            <div class="card-body d-flex flex-column">
              <h5 class="card-title" style="font-size: 1.1rem; font-weight: bold;">{{ item.name }}</h5>
              <p class="card-text text-muted mb-2" style="font-size: 0.95rem;">{{ item.description }}</p>
              <ul class="list-unstyled mb-2" style="font-size: 0.95rem;">
                <li><span class="material-icons text-danger" style="font-size: 1.1em; vertical-align: middle;">local_offer</span> <b>Category:</b> {{ item.category?.name }}</li>
                <li><span class="material-icons text-danger" style="font-size: 1.1em; vertical-align: middle;">check_circle</span> <b>Availability:</b> {{ item.is_active ? 'Available' : 'Unavailable' }}</li>
                <!-- <li v-if="item.stock_quantity !== null && item.stock_quantity !== undefined"><span class="material-icons text-danger" style="font-size: 1.1em; vertical-align: middle;">fitness_center</span> <b>Stock:</b> {{ item.stock_quantity }}</li>
                <li v-if="item.sku"><span class="material-icons text-danger" style="font-size: 1.1em; vertical-align: middle;">spa</span> <b>SKU:</b> {{ item.sku }}</li> -->
              </ul>
              <div class="mt-auto">
                <div class="d-flex align-items-center justify-content-between mb-2">
                  <span class="text-muted" style="font-size: 0.95rem;">Customer Review</span>
                  <span class="text-warning" style="font-size: 1.1rem;">★★★★★</span>
                </div>
                <div class="d-flex align-items-center justify-content-between">
                  <span class="fw-bold text-danger" style="font-size: 1.15rem;">
                    {{ tenantSettings?.currency_symbol || '$' }}&nbsp;{{ item.price }}
                  </span>
                  <div>
                    <button class="btn btn-link text-danger p-0 me-2"><i class="material-icons">favorite_border</i></button>
                    <button class="btn btn-link text-danger p-0" @click="addToCart(item)"><i class="material-icons">shopping_cart</i></button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div v-else-if="filteredMenuItems.length > 0 && viewMode === 'list'" class="list-view-menu">
        <div class="card mb-4 shadow-sm border-0 list-menu-card" v-for="item in filteredMenuItems" :key="item.id">
          <div class="row g-0 align-items-center">
            <div class="col-md-4 col-lg-3">
              <img v-if="item.image" :src="item.image" class="img-fluid rounded-start w-100" :alt="item.name" style="object-fit: cover; height: 100%; min-height: 180px;">
            </div>
            <div class="col-md-8 col-lg-9">
              <div class="card-body">
                <h5 class="card-title mb-2" style="font-size: 1.2rem; font-weight: bold;">{{ item.name }}</h5>
                <p class="card-text text-muted mb-2" style="font-size: 0.98rem;">{{ item.description }}</p>
                <div class="d-flex flex-wrap align-items-center mb-2 mt-3">
                  <span class="me-3"><span class="material-icons text-danger align-middle">local_offer</span> <b>Category:</b> {{ item.category?.name }}</span>
                  <span class="me-3"><span class="material-icons text-danger align-middle">check_circle</span> <b>Availability:</b> {{ item.is_active ? 'Available' : 'Unavailable' }}</span>
                  <!-- <span class="me-3" v-if="item.stock_quantity !== null && item.stock_quantity !== undefined"><span class="material-icons text-danger align-middle">fitness_center</span> <b>Stock:</b> {{ item.stock_quantity }}</span> -->
                  <!-- <span class="me-3" v-if="item.sku"><span class="material-icons text-danger align-middle">spa</span> <b>SKU:</b> {{ item.sku }}</span> -->
                  <span class="me-3"><span class="text-muted">Customer Review</span> <span class="text-warning">★★★★★</span></span>
                </div>
                <div class="d-flex align-items-center justify-content-between">
                  <span class="fw-bold text-danger" style="font-size: 1.15rem;">
                    {{ tenantSettings?.currency_symbol || '$' }}&nbsp;{{ item.price }}
                  </span>
                  <div>
                    <button class="btn btn-link text-danger p-0 me-2"><i class="material-icons">favorite_border</i></button>
                    <button class="btn btn-link text-danger p-0" @click="addToCart(item)"><i class="material-icons">shopping_cart</i></button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div v-else class="text-center text-muted py-5">
        No products found for this category.
      </div>
    </div>
  </section>

  <!-- Reservation Section -->
  <section class="reservation-section py-5">
    <div class="container">
      <div class="reservation-card mx-auto">
        <h2 class="text-center reservation-title">Reservation</h2>
        <div class="text-center reservation-subtitle mb-4">We provide free, secure and instantly confirmed online reservation.</div>
        <form @submit.prevent="handleReservation" autocomplete="off">
          <div class="row g-3 mb-3">
            <div class="col-md-4">
              <div class="input-group">
                <input type="text" class="form-control" v-model="reservation.full_name" required placeholder="Full Name*" id="reservationFullName"
                  :disabled="reservationLoading"
                  data-bs-toggle="tooltip" title="Enter your full name">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
              </div>
            </div>
            <div class="col-md-4">
              <div class="input-group">
                <input type="text" class="form-control" v-model="reservation.phone_number" required placeholder="Phone Number*" id="reservationPhone"
                  :disabled="reservationLoading"
                  data-bs-toggle="tooltip" title="Enter your phone number">
                <span class="input-group-text"><i class="fas fa-phone"></i></span>
              </div>
            </div>
            <div class="col-md-4">
              <div class="input-group">
                <input type="email" class="form-control" v-model="reservation.email" required placeholder="Email*" id="reservationEmail"
                  :disabled="reservationLoading"
                  data-bs-toggle="tooltip" title="Enter your email address">
                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
              </div>
            </div>
            <div class="col-md-4">
              <div class="input-group">
                <input type="date" class="form-control" v-model="reservation.date" required placeholder="Date*" id="reservationDate"
                  :disabled="reservationLoading"
                  data-bs-toggle="tooltip" title="Select reservation date">
                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
              </div>
            </div>
            <div class="col-md-4">
              <div class="input-group">
                <input type="time" class="form-control" v-model="reservation.time" required placeholder="Time*" id="reservationTime"
                  :disabled="reservationLoading"
                  data-bs-toggle="tooltip" title="Select reservation time">
                <span class="input-group-text"><i class="fas fa-clock"></i></span>
              </div>
            </div>
            <div class="col-md-4">
              <div class="input-group">
                <input type="number" min="1" class="form-control" v-model="reservation.guests" required placeholder="Guests*" id="reservationGuests"
                  :disabled="reservationLoading"
                  data-bs-toggle="tooltip" title="Number of guests">
                <span class="input-group-text"><i class="fas fa-users"></i></span>
              </div>
            </div>
          </div>
          <div class="mb-3">
            <textarea class="form-control" v-model="reservation.message" rows="3" required placeholder="Message" id="reservationMessage"
              :disabled="reservationLoading"
              data-bs-toggle="tooltip" title="Add any special requests or notes"></textarea>
          </div>
          <div class="d-grid mb-2">
            <button type="submit" class="btn btn-danger" :disabled="reservationLoading">
              <span v-if="reservationLoading"><span class="spinner-border spinner-border-sm me-2"></span>Processing...</span>
              <span v-else>MAKE RESERVATION</span>
            </button>
          </div>
        </form>
        <!-- <div class="reservation-callout text-center mt-3">
          <span>You can also call: <span class="text-danger fw-bold">(+100) 123 456 7890</span> to make a reservation</span>
        </div> -->
      </div>
    </div>
  </section>

</template>

<script>
import { ref, onMounted, computed, watch, inject } from 'vue';
import axios from 'axios';
import Swal from 'sweetalert2';
import { Tooltip } from 'bootstrap';
import { useCart } from '../../composables/useCart';

export default {
  name: 'TenantLanding',
  setup() {
    const loading = ref(true);
    const tenantSettings = ref(null);
    const categories = ref([{ id: null, name: 'All Categories' }]);
    const products = ref([]);
    const selectedCategory = ref({ id: null, name: 'All Categories' });
    const viewMode = ref('grid');
    const sortBy = ref('default');
    const reservation = ref({
      full_name: '',
      phone_number: '',
      email: '',
      date: '',
      time: '',
      guests: '',
      message: ''
    });
    const reservationLoading = ref(false);
    const cart = inject('cart', useCart())

    // Show toast when product is added
    const addToCart = (product) => {
      cart.addToCart(product);
      Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'success',
        title: 'Added to cart!',
        showConfirmButton: false,
        timer: 1200,
        timerProgressBar: true,
      });
    };

    const fetchTenantSettings = async () => {
      try {
        const response = await axios.get('/tenant/get-tenant-details');
        if (response.data.success && response.data.data) {
          tenantSettings.value = response.data.data;
        }
      } catch (error) {
        console.error('Error fetching tenant settings:', error);
        tenantSettings.value = null;
      } finally {
        loading.value = false;
      }
    };

    const fetchCategories = async () => {
      try {
        const response = await axios.get('/tenant/public/categories', {
          params: { is_active: true }
        });
        if (response.data.success) {
          // Use paginated data
          const cats = response.data.data.data;
          categories.value = [
            { id: null, name: 'All Categories' },
            ...cats
          ];
          if (!categories.value.some(cat => cat.id === selectedCategory.value.id)) {
            selectedCategory.value = categories.value[0];
          }
        }
      } catch (error) {
        console.error('Error fetching categories:', error);
      }
    };

    const fetchProducts = async () => {
      try {
        const params = { is_active: true };
        const response = await axios.get('/tenant/public/products', { params });
        if (response.data.success) {
          // Use paginated data
          products.value = response.data.data.data;
        } else {
          products.value = [];
        }
      } catch (error) {
        console.error('Error fetching products:', error);
        products.value = [];
      }
    };

    // Watch for category change and filter products client-side
    const filteredMenuItems = computed(() => {
      let filtered = [...products.value];
      if (selectedCategory.value && selectedCategory.value.id) {
        filtered = filtered.filter(item => item.category_id === selectedCategory.value.id);
      }
      switch (sortBy.value) {
        case 'price_low_high':
          filtered.sort((a, b) => a.price - b.price);
          break;
        case 'price_high_low':
          filtered.sort((a, b) => b.price - a.price);
          break;
        case 'rating':
          filtered.sort((a, b) => (b.rating || 0) - (a.rating || 0));
          break;
        default:
          filtered.sort((a, b) => a.sort_order - b.sort_order);
      }
      return filtered;
    });

    const handleSort = (sortType) => {
      sortBy.value = sortType;
    };

    const handleReservation = async () => {
      reservationLoading.value = true;
      try {
        const response = await axios.post('/tenant/reservation', {
          full_name: reservation.value.full_name,
          phone_number: reservation.value.phone_number,
          email: reservation.value.email,
          date: reservation.value.date,
          time: reservation.value.time,
          guests: parseInt(reservation.value.guests, 10),
          message: reservation.value.message
        });
        if (response.data.success) {
          await Swal.fire({
            icon: 'success',
            title: 'Reservation Submitted!',
            text: response.data.message,
            confirmButtonColor: '#c62828'
          });
          reservation.value = { full_name: '', phone_number: '', email: '', date: '', time: '', guests: '', message: '' };
        } else {
          throw new Error(response.data.message || 'Submission failed.');
        }
      } catch (error) {
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: error.response?.data?.message || 'Something went wrong! Please try again.',
          confirmButtonColor: '#c62828'
        });
      } finally {
        reservationLoading.value = false;
      }
    };

    onMounted(async () => {
      await fetchTenantSettings();
      await fetchCategories();
      await fetchProducts();
      document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
        new Tooltip(el);
      });
    });

    return {
      loading,
      tenantSettings,
      categories,
      selectedCategory,
      viewMode,
      filteredMenuItems,
      handleSort,
      reservation,
      reservationLoading,
      handleReservation,
      cart,
      addToCart
    };
  },
};
</script>

<style scoped>
.tenant-landing {
  min-height: 100vh;
  background-color: #f3f4f6;
}
.main-banner-section {
  overflow: hidden; /* Prevent banner overflow on small screens */
}
.menu-section {
  background: #fff;
}
.menu-section .nav-tabs .nav-link {
  font-weight: 500;
  color: #333;
  border: none;
  border-bottom: 2px solid transparent;
}
.menu-section .nav-tabs .nav-link.active {
  color: #d9534f;
  border-bottom-color: #d9534f;
}
.menu-section .nav-tabs .nav-link:hover {
  border-color: transparent;
}
.filter-bar .btn-outline-secondary {
  color: #555;
  border-color: #ccc;
}
.filter-bar .btn-link {
  color: #555;
}
.filter-bar .btn-link.active {
 color: #d9534f;
}
.list-menu-card img {
  width: 100%; /* Ensure image takes full width of its column */
}

@media (max-width: 1199px) {
  .col-lg-3 {
    flex: 0 0 33.333333%;
    max-width: 33.333333%;
  }
}
@media (max-width: 991px) {
  .col-lg-3, .col-md-6 {
    flex: 0 0 50%;
    max-width: 50%;
  }
}
@media (max-width: 767px) {
  .main-banner-section {
    margin-left: calc(-50vw + 50%) !important;
    margin-right: calc(-50vw + 50%) !important;
    width: 100vw !important;
    left: auto !important;
    right: auto !important;
  }
   .main-banner-section .container {
    padding-left: 15px;
    padding-right: 15px;
  }
  .list-menu-card img {
    height: 180px !important; /* Fix height for list view on mobile */
    width: 100% !important;
    object-fit: cover;
  }
  .col-lg-3, .col-md-6, .col-12, .col-sm-6 {
    flex: 0 0 100%;
    max-width: 100%;
  }
}
.reservation-section {
  background: #faf9f7;
}
.reservation-card {
  background: #fff;
  border-radius: 12px;
  box-shadow: 0 4px 24px rgba(0,0,0,0.10);
  padding: 2.5rem 2rem 1.5rem 2rem;
  max-width: 1100px;
  margin: 0 auto;
  border: 1.5px solid #e0e0e0;
}
.reservation-title {
  font-family: 'Playfair Display', serif;
  font-weight: bold;
  color: #222;
  font-size: 2.2rem;
  margin-bottom: 0.5rem;
  border-bottom: 3px solid #c62828;
  /* display: inline-block; */
  padding-bottom: 0.2rem;
}
.reservation-subtitle {
  color: #666;
  font-size: 1.08rem;
}
.reservation-callout {
  background: #f5f5f5;
  border-top: 1.5px solid #eee;
  padding: 1rem 0 0.5rem 0;
  color: #c62828;
  font-size: 1.08rem;
}
@media (max-width: 991.98px) {
  .reservation-card {
    padding: 1.2rem 0.5rem 1rem 0.5rem;
    max-width: 99vw;
  }
}
@media (max-width: 767.98px) {
  .reservation-title {
    font-size: 1.5rem;
  }
  .reservation-card {
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    padding: 1rem 0.2rem 0.5rem 0.2rem;
  }
}
</style>