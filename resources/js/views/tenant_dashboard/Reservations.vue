<template>
  <div class="Reservations-page">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h4 class="mb-0">{{ $t('tenant_dashboard.reservations.title') }}</h4>
    </div>
    <!-- Filters Row -->
    <div class="mb-4">
      <div class="filter-body">
        <div class="row g-3 align-items-end flex-nowrap">
          <div class="col-md-6">
            <label class="form-label mb-1">{{ $t('tenant_dashboard.reservations.search') }}</label>
            <input v-model="filters.search" @input="applyFilters" type="text" class="form-control filter-input" :placeholder="$t('tenant_dashboard.reservations.searchPlaceholder')">
          </div>
          <div class="col-md-6 d-flex align-items-end justify-content-end">
            <!-- Column Filter Dropdown -->
            <div class="dropdown column-filter-dropdown ms-auto">
              <button class="btn btn-outline-secondary dropdown-toggle" type="button" @click="toggleColumnDropdown" ref="dropdownBtn">
                <i class="fas fa-filter me-1"></i> {{ $t('tenant_dashboard.reservations.columns') }}
              </button>
              <div class="dropdown-menu p-3" :class="{ show: showColumnDropdown }" style="min-width: 260px; max-height: 320px; overflow-y: auto;">
                <div class="form-check mb-2">
                  <input class="form-check-input" type="checkbox" id="selectAllCols" v-model="selectAllChecked" @change="toggleSelectAll">
                  <label class="form-check-label" for="selectAllCols">{{ $t('tenant_dashboard.reservations.selectAll') }}</label>
                </div>
                <div v-for="col in allColumns" :key="col.key" class="form-check mb-1">
                  <input class="form-check-input" type="checkbox" :id="'col-' + col.key" v-model="tempSelectedColumns" :value="col.key">
                  <label class="form-check-label" :for="'col-' + col.key">{{ col.label }}</label>
                </div>
                <div class="d-flex justify-content-end gap-2 mt-3">
                  <button class="btn btn-sm btn-primary" @click="applyColumnSelection">{{ $t('tenant_dashboard.reservations.ok') }}</button>
                  <button class="btn btn-sm btn-secondary" @click="cancelColumnSelection">{{ $t('tenant_dashboard.reservations.cancel') }}</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Reservations Table -->
    <div class="card">
      <div class="card-body">
        <div v-if="loading" class="text-center py-5">
          <div class="spinner-border text-danger" role="status"><span class="visually-hidden">{{ $t('dashboard_common.loading') }}</span></div>
        </div>
        <div v-else-if="reservations.length === 0" class="text-center py-5 text-muted">
          <i class="fas fa-store fa-3x mb-3" style="color: #bdbdbd;"></i>
          <div class="h5 mb-2">{{ $t('tenant_dashboard.reservations.noReservations') }}</div>
          <div>{{ $t('tenant_dashboard.reservations.noReservationsMessage') }}</div>
        </div>
        <div v-else class="table-responsive">
          <table class="table table-hover table-sm Reservations-table">
            <thead>
              <tr>
                <th v-for="col in visibleColumns" :key="col.key">{{ col.label }}</th>
                <th>{{ $t('tenant_dashboard.reservations.action') }}</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="reservation in reservations" :key="reservation.id">
                <td v-for="col in visibleColumns" :key="col.key">
                  <div v-if="col.key === 'full_name'">
                    <div class="fw-bold">{{ reservation.full_name }}</div>
                    <div class="small text-muted">{{ reservation.email }}</div>
                  </div>
                  <span v-else-if="col.key === 'created_at'">
                    {{ reservation.created_at ? new Date(reservation.created_at).toLocaleString() : '' }}
                  </span>
                  <span v-else>
                    {{ reservation[col.key] }}
                  </span>
                </td>
                <td>
                  <button class="btn btn-sm btn-primary" @click="showDetails(reservation)"><i class="fas fa-eye"></i> {{ $t('tenant_dashboard.reservations.viewDetails') }}</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <!-- Pagination -->
        <div v-if="pagination.total > 0" class="d-flex justify-content-between align-items-center mt-3">
          <div class="text-muted">
            {{ $t('tenant_dashboard.reservations.showing') }} {{ pagination.from }} {{ $t('tenant_dashboard.reservations.to') }} {{ pagination.to }} {{ $t('tenant_dashboard.reservations.of') }} {{ pagination.total }} {{ $t('tenant_dashboard.reservations.entries') }}
          </div>
          <nav v-if="pagination.last_page > 1">
            <ul class="pagination mb-0">
              <li class="page-item" :class="{ disabled: pagination.current_page === 1 }">
                <button class="page-link" @click="goToPage(pagination.current_page - 1)" :disabled="pagination.current_page === 1">&laquo;</button>
              </li>
              <li v-for="page in paginationWindow" :key="page" class="page-item" :class="{ active: page === pagination.current_page }">
                <button class="page-link" @click="goToPage(page)">{{ page }}</button>
              </li>
              <li class="page-item" :class="{ disabled: pagination.current_page === pagination.last_page }">
                <button class="page-link" @click="goToPage(pagination.current_page + 1)" :disabled="pagination.current_page === pagination.last_page">&raquo;</button>
              </li>
            </ul>
          </nav>
        </div>
      </div>
    </div>
    <!-- Details Modal -->
    <div class="modal fade" id="detailsModal" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">{{ $t('tenant_dashboard.reservations.detailsTitle') }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <table class="table table-bordered">
              <tbody>
                <tr v-for="col in allColumns" :key="col.key">
                  <th>{{ col.label }}</th>
                  <td>
                    <span v-if="col.key === 'created_at' && selectedReservation.created_at">
                      {{ new Date(selectedReservation.created_at).toLocaleString() }}
                    </span>
                    <span v-else>
                      {{ selectedReservation[col.key] }}
                    </span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ $t('tenant_dashboard.reservations.close') }}</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, watch, computed } from 'vue'
import axios from 'axios'
import Swal from 'sweetalert2'
import { Modal } from 'bootstrap'

const reservations = ref([])
const loading = ref(false)
const filters = ref({ search: '' })
const pagination = ref({
  current_page: 1,
  last_page: 1,
  per_page: 8,
  total: 0,
  from: 0,
  to: 0
})

const allColumns = [
  { key: 'full_name', label: $t('tenant_dashboard.reservations.name') },
  { key: 'phone_number', label: $t('tenant_dashboard.reservations.phone') },
  { key: 'guests', label: $t('tenant_dashboard.reservations.guests') },
  { key: 'email', label: $t('tenant_dashboard.reservations.email') },
  { key: 'date', label: $t('tenant_dashboard.reservations.date') },
  { key: 'time', label: $t('tenant_dashboard.reservations.time') },
  { key: 'message', label: $t('tenant_dashboard.reservations.message') },
  { key: 'created_at', label: $t('tenant_dashboard.reservations.createdAt') },
]
const COLUMN_CACHE_KEY = 'reservations_selected_columns_v1';
const selectedColumns = ref(['full_name', 'phone_number', 'guests'])
const visibleColumns = ref(allColumns.filter(col => selectedColumns.value.includes(col.key)))

// Column filter dropdown logic
const showColumnDropdown = ref(false)
const tempSelectedColumns = ref([...selectedColumns.value])
const selectAllChecked = ref(false)
const dropdownBtn = ref(null)

const toggleColumnDropdown = () => {
  showColumnDropdown.value = !showColumnDropdown.value
  tempSelectedColumns.value = [...selectedColumns.value]
  updateSelectAllChecked()
}
const applyColumnSelection = () => {
  selectedColumns.value = [...tempSelectedColumns.value]
  visibleColumns.value = allColumns.filter(col => selectedColumns.value.includes(col.key))
  showColumnDropdown.value = false
}
const cancelColumnSelection = () => {
  tempSelectedColumns.value = [...selectedColumns.value]
  showColumnDropdown.value = false
}
const toggleSelectAll = () => {
  if (selectAllChecked.value) {
    tempSelectedColumns.value = allColumns.map(col => col.key)
  } else {
    tempSelectedColumns.value = []
  }
}
const updateSelectAllChecked = () => {
  selectAllChecked.value = tempSelectedColumns.value.length === allColumns.length
}
watch(tempSelectedColumns, updateSelectAllChecked)

const selectedReservation = ref({})
let detailsModal = null
const showDetails = (reservation) => {
  selectedReservation.value = reservation
  if (!detailsModal) {
    detailsModal = new Modal(document.getElementById('detailsModal'))
  }
  detailsModal.show()
}

const fetchReservations = async (page = 1) => {
  loading.value = true
  try {
    const params = {
      page,
      per_page: pagination.value.per_page,
      search: filters.value.search
    }
    const response = await axios.get('/tenant/reservations-list', { params })
    if (response.data.success) {
      const { data, current_page, last_page, per_page, total, from, to } = response.data.data
      reservations.value = data
      pagination.value = { current_page, last_page, per_page, total, from, to }
    } else {
      reservations.value = []
      pagination.value = { current_page: 1, last_page: 1, per_page: 8, total: 0, from: 0, to: 0 }
    }
  } catch (error) {
    reservations.value = []
    Swal.fire({ icon: 'error', title: 'Error', text: $t('tenant_dashboard.reservations.failedToFetch') })
  } finally {
    loading.value = false
  }
}

const applyFilters = () => {
  fetchReservations(1)
}

const goToPage = (page) => {
  if (page < 1 || page > pagination.value.last_page) return
  fetchReservations(page)
}

// Pagination window logic
const paginationWindow = computed(() => {
  const total = pagination.value.last_page
  const current = pagination.value.current_page
  const windowSize = 5
  let start = Math.max(1, current - 2)
  let end = Math.min(total, current + 2)
  if (end - start < windowSize - 1) {
    if (start === 1) {
      end = Math.min(total, start + windowSize - 1)
    } else if (end === total) {
      start = Math.max(1, end - windowSize + 1)
    }
  }
  const pages = []
  for (let i = start; i <= end; i++) pages.push(i)
  return pages
})

// Load from localStorage on mount
onMounted(() => {
  const cached = localStorage.getItem(COLUMN_CACHE_KEY)
  if (cached) {
    try {
      const parsed = JSON.parse(cached)
      if (Array.isArray(parsed) && parsed.every(k => allColumns.some(c => c.key === k))) {
        selectedColumns.value = parsed
        visibleColumns.value = allColumns.filter(col => selectedColumns.value.includes(col.key))
      }
    } catch {}
  }
  fetchReservations()
  visibleColumns.value = allColumns.filter(col => selectedColumns.value.includes(col.key))
})

// Save to localStorage on change
watch(selectedColumns, (val) => {
  localStorage.setItem(COLUMN_CACHE_KEY, JSON.stringify(val))
})
</script>

<style scoped>
.Reservations-page {
  padding: 20px;
  font-family: 'Inter', 'Roboto', 'Segoe UI', Arial, sans-serif;
  font-size: 16px;
}
.filter-body {
  padding: 0;
}
.filter-input {
  border-radius: 8px;
  font-size: 15px;
  border: 1px solid #e0e0e0;
  background: #fafbfc;
}
.Reservations-table {
  border: 1px solid #e0e0e0;
  box-shadow: 0 2px 8px rgba(60,60,60,0.06);
  font-size: 15px;
  border-radius: 8px;
  overflow: hidden;
}
.Reservations-table thead th {
  background: #fafbfc;
  position: sticky;
  top: 0;
  z-index: 2;
  font-weight: 500;
  color: #b71c1c;
}
.Reservations-table tbody tr:nth-child(even) {
  background: #f7f7f7;
}
.Reservations-table tbody tr:hover {
  background: #fff3f3;
}
.pagination .page-link {
  color: #6c757d;
  border: none;
  background-color: transparent;
  border-radius: 0.25rem;
  margin: 0 2px;
  padding: 0.5rem 0.75rem;
}
.pagination .page-item.active .page-link {
  background-color: #c62828;
  color: #fff;
  z-index: 3;
}
.pagination .page-item.disabled .page-link {
  color: #ced4da;
}
.pagination .page-link:hover {
  background-color: #f1f1f1;
}
.column-filter-dropdown {
  position: relative;
}
.column-filter-dropdown .dropdown-menu {
  left: auto;
  right: 0;
  min-width: 260px;
  box-shadow: 0 4px 24px rgba(60,60,60,0.13);
  border-radius: 8px;
  border: 1px solid #e0e0e0;
  z-index: 1052;
}
.column-filter-dropdown .form-check {
  user-select: none;
}
.fw-bold {
  font-weight: 600 !important;
}
.table td {
  vertical-align: middle;
}
</style>
