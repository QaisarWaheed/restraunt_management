<template>
  <div class="StockCheckRequests-page">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h4 class="mb-0">{{ $t('tenant_dashboard.stock_check_requests.title') }}</h4>
    </div>
    <div class="card">
      <div class="card-body">
        <div v-if="loading" class="text-center py-5">
          <div class="spinner-border text-danger" role="status"><span class="visually-hidden">{{ $t('dashboard_common.loading') }}</span></div>
        </div>
        <div v-else-if="requests.length === 0" class="text-center py-5 text-muted">
          <i class="fas fa-box-open fa-3x mb-3" style="color: #bdbdbd;"></i>
          <div class="h5 mb-2">{{ $t('tenant_dashboard.stock_check_requests.noRequests') }}</div>
        </div>
        <div v-else class="table-responsive">
          <table class="table table-hover table-sm StockCheckRequests-table">
            <thead>
              <tr>
                <th>{{ $t('tenant_dashboard.stock_check_requests.tableHeaders.name') }}</th>
                <th>{{ $t('tenant_dashboard.stock_check_requests.tableHeaders.email') }}</th>
                <th>{{ $t('tenant_dashboard.stock_check_requests.tableHeaders.phone') }}</th>
                <th>{{ $t('tenant_dashboard.stock_check_requests.tableHeaders.product') }}</th>
                <th>{{ $t('tenant_dashboard.stock_check_requests.tableHeaders.quantity') }}</th>
                <th>{{ $t('tenant_dashboard.stock_check_requests.tableHeaders.createdAt') }}</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="req in requests" :key="req.id">
                <td>{{ req.full_name }}</td>
                <td>{{ req.email }}</td>
                <td>{{ req.phone_number }}</td>
                <td>{{ req.product?.name || '-' }}</td>
                <td>{{ req.qty }}</td>
                <td>{{ new Date(req.created_at).toLocaleString() }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const requests = ref([])
const loading = ref(false)

const fetchRequests = async () => {
  loading.value = true
  try {
    const { data } = await axios.get('/tenant/stock-check-reqs')
    if (data.success) {
      requests.value = data.data.data || []
    } else {
      requests.value = []
    }
  } catch (e) {
    requests.value = []
  }
  loading.value = false
}

onMounted(() => {
  fetchRequests()
})
</script>

<style scoped>
.StockCheckRequests-page {
  padding: 20px;
  font-family: 'Inter', 'Roboto', 'Segoe UI', Arial, sans-serif;
  font-size: 16px;
}

.filter-card {
  background: #fff;
  border-radius: 12px;
  box-shadow: 0 2px 12px rgba(60,60,60,0.08);
  border: 1px solid #e0e0e0;
  padding: 1.5rem 2rem 1rem 2rem;
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

.btn-add-Category {
  background: #1565c0;
  color: #fff;
  font-weight: 500;
  font-size: 15px;
  border-radius: 8px;
  padding: 0.6rem 1.6rem;
  box-shadow: 0 2px 8px rgba(21,101,192,0.08);
  border: none;
  transition: background 0.15s, box-shadow 0.15s;
}
.btn-add-Category:hover, .btn-add-Category:focus {
  background: #0d47a1;
  color: #fff;
  box-shadow: 0 4px 16px rgba(21,101,192,0.13);
}

.StockCheckRequests-table {
  border: 1px solid #e0e0e0;
  box-shadow: 0 2px 8px rgba(60,60,60,0.06);
  font-size: 15px;
  border-radius: 8px;
  overflow: hidden;
}
.StockCheckRequests-table thead th {
  background: #fafbfc;
  position: sticky;
  top: 0;
  z-index: 2;
  font-weight: 500;
  color: #b71c1c;
}
.StockCheckRequests-table tbody tr:nth-child(even) {
  background: #f7f7f7;
}
.StockCheckRequests-table tbody tr:hover {
  background: #fff3f3;
}

.btn-group .btn-action {
  padding: 0.25rem 0.5rem;
  font-size: 0.95rem;
  border-radius: 6px;
  border: none;
  transition: background 0.13s;
}
.btn-view { background: #e3f2fd; color: #1565c0; }
.btn-view:hover { background: #bbdefb; color: #0d47a1; }
.btn-edit { background: #e8f5e9; color: #388e3c; }
.btn-edit:hover { background: #c8e6c9; color: #1b5e20; }
.btn-delete { background: #ffebee; color: #c62828; }
.btn-delete:hover { background: #ffcdd2; color: #b71c1c; }
.btn-restore { background: #fffde7; color: #fbc02d; }
.btn-restore:hover { background: #fff9c4; color: #f9a825; }
.btn-hard-delete { background: #fbe9e7; color: #d84315; }
.btn-hard-delete:hover { background: #ffccbc; color: #bf360c; }

.Category-details p {
  margin-bottom: 0.5rem;
}

.table td {
  vertical-align: middle;
}

.Category-modal-content {
  font-family: 'Inter', 'Roboto', 'Segoe UI', Arial, sans-serif;
  font-size: 16px;
  background: #fff;
  border-radius: 0 0 12px 12px;
  border: 1px solid #e0e0e0;
  box-shadow: 0 8px 32px rgba(60,60,60,0.13);
  max-width: 650px;
  margin: auto;
  padding: 0;
}
.Category-modal-header {
  background: #c62828;
  color: #fff;
  border-radius: 0;
  border: none;
  padding: 1.2rem 2rem;
  position: relative;
}
.Category-modal-title {
  font-size: 1.25rem;
  font-weight: 400;
  letter-spacing: 0.01em;
}
.Category-modal-header .btn-close {
  filter: invert(1) grayscale(1) brightness(2);
  opacity: 1;
}
.Category-modal-body {
  background: #fafbfc;
  padding: 2rem 2rem 1.5rem 2rem;
}
.Category-modal-footer {
  border-top: 1px solid #ececec;
  padding: 1.2rem 2rem;
  background: #fafbfc;
  border-radius: 0 0 12px 12px;
  display: flex;
  justify-content: center;
}
.input-group-text {
  background: #f5f5f5;
  border: 1px solid #e0e0e0;
  color: #b71c1c;
  font-size: 1.1rem;
}
.btn-submit {
  background: #c62828;
  color: #fff;
  text-transform: uppercase;
  font-weight: 400;
  font-size: 15px;
  border: none;
  border-radius: 6px;
  box-shadow: 0 2px 6px rgba(198,40,40,0.08);
  padding: 0.7rem 2.2rem;
  letter-spacing: 1px;
  transition: background 0.15s, box-shadow 0.15s;
}
.btn-submit:hover, .btn-submit:focus {
  background: #b71c1c;
  color: #fff;
  box-shadow: 0 4px 12px rgba(198,40,40,0.13);
}

.drag-handle {
  vertical-align: middle;
}
</style>
