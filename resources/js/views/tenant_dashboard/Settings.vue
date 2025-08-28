<template>
  <div class="settings-page">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h4 class="mb-0">{{ $t('tenant_dashboard.settings.title') }}</h4>
    </div>

    <div class="card">
      <div class="card-body">
        <div v-if="loading" class="text-center py-5">
          <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">{{ $t('dashboard_common.loading') }}</span>
          </div>
        </div>
        <form v-else @submit.prevent="saveSettings" class="settings-form">
          <!-- Basic Information -->
          <div class="section mb-4">
            <h5 class="section-title">{{ $t('tenant_dashboard.settings.basicInformation') }}</h5>
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">{{ $t('tenant_dashboard.settings.businessName') }}
                  <span class="ms-1" data-bs-toggle="tooltip" :title="$t('tenant_dashboard.settings.businessNameTooltip')">
                    <i class="fas fa-info-circle text-secondary"></i>
                  </span>
                </label>
                <input v-model="form.business_name" type="text" class="form-control" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">{{ $t('tenant_dashboard.settings.logo') }}
                  <span class="ms-1" data-bs-toggle="tooltip" :title="$t('tenant_dashboard.settings.logoTooltip')">
                    <i class="fas fa-info-circle text-secondary"></i>
                  </span>
                </label>
                <div class="d-flex align-items-center gap-3">
                  <div v-if="form.logo" class="logo-preview">
                    <img :src="form.logo" alt="Restaurant Logo" class="img-thumbnail" style="max-height: 100px;">
                  </div>
                  <div class="flex-grow-1">
                    <input type="file"
                           class="form-control"
                           accept="image/*"
                           @change="handleLogoUpload"
                           ref="logoInput">
                    <small class="text-muted">{{ $t('tenant_dashboard.settings.logoRequirements') }}</small>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <label class="form-label">{{ $t('tenant_dashboard.settings.email') }}
                  <span class="ms-1" data-bs-toggle="tooltip" :title="$t('tenant_dashboard.settings.emailTooltip')">
                    <i class="fas fa-info-circle text-secondary"></i>
                  </span>
                </label>
                <input v-model="form.email" type="email" class="form-control" required disabled readonly>
              </div>
              <div class="col-md-6">
                <label class="form-label">{{ $t('tenant_dashboard.settings.phone') }}
                  <span class="ms-1" data-bs-toggle="tooltip" :title="$t('tenant_dashboard.settings.phoneTooltip')">
                    <i class="fas fa-info-circle text-secondary"></i>
                  </span>
                </label>
                <input v-model="form.phone" type="tel" class="form-control" required>
              </div>
            </div>
          </div>

          <!-- Location Information -->
          <div class="section mb-4">
            <h5 class="section-title">{{ $t('tenant_dashboard.settings.locationInformation') }}</h5>
            <div class="row g-3">
              <div class="col-12">
                <label class="form-label">{{ $t('tenant_dashboard.settings.address') }}
                  <span class="ms-1" data-bs-toggle="tooltip" :title="$t('tenant_dashboard.settings.addressTooltip')">
                    <i class="fas fa-info-circle text-secondary"></i>
                  </span>
                </label>
                <input v-model="form.address" type="text" class="form-control" required>
              </div>
              <div class="col-md-4">
                <label class="form-label">{{ $t('tenant_dashboard.settings.city') }}
                  <span class="ms-1" data-bs-toggle="tooltip" :title="$t('tenant_dashboard.settings.cityTooltip')">
                    <i class="fas fa-info-circle text-secondary"></i>
                  </span>
                </label>
                <input v-model="form.city" type="text" class="form-control" required>
              </div>
              <div class="col-md-4">
                <label class="form-label">{{ $t('tenant_dashboard.settings.state') }}
                  <span class="ms-1" data-bs-toggle="tooltip" :title="$t('tenant_dashboard.settings.stateTooltip')">
                    <i class="fas fa-info-circle text-secondary"></i>
                  </span>
                </label>
                <input v-model="form.state" type="text" class="form-control" required>
              </div>
              <div class="col-md-4">
                <label class="form-label">{{ $t('tenant_dashboard.settings.postalCode') }}
                  <span class="ms-1" data-bs-toggle="tooltip" :title="$t('tenant_dashboard.settings.postalCodeTooltip')">
                    <i class="fas fa-info-circle text-secondary"></i>
                  </span>
                </label>
                <input v-model="form.postal_code" type="text" class="form-control" required>
              </div>
              <div class="col-md-4">
                <label class="form-label">{{ $t('tenant_dashboard.settings.country') }}
                  <span class="ms-1" data-bs-toggle="tooltip" :title="$t('tenant_dashboard.settings.countryTooltip')">
                    <i class="fas fa-info-circle text-secondary"></i>
                  </span>
                </label>
                <input v-model="form.country" type="text" class="form-control" required>
              </div>
              <div class="col-md-4">
                <label class="form-label">{{ $t('tenant_dashboard.settings.placeId') }}
                  <span class="ms-1" data-bs-toggle="tooltip" :title="$t('tenant_dashboard.settings.placeIdTooltip')">
                    <i class="fas fa-info-circle text-secondary"></i>
                  </span>
                </label>
                <input v-model="form.place_id" type="text" class="form-control">
              </div>
              <div class="col-md-4">
                <label class="form-label">{{ $t('tenant_dashboard.settings.pickupTimeRange') }}
                  <span class="ms-1" data-bs-toggle="tooltip" :title="$t('tenant_dashboard.settings.pickupTimeRangeTooltip')">
                    <i class="fas fa-info-circle text-secondary"></i>
                  </span>
                </label>
                <input v-model="form.pickup_start_end_time" type="text" class="form-control" placeholder="e.g., 9:00 AM - 10:00 PM">
              </div>
              <div class="col-md-6">
                <label class="form-label">{{ $t('tenant_dashboard.settings.latitude') }}
                  <span class="ms-1" data-bs-toggle="tooltip" :title="$t('tenant_dashboard.settings.latitudeTooltip')">
                    <i class="fas fa-info-circle text-secondary"></i>
                  </span>
                </label>
                <input v-model="form.latitude" type="number" step="any" class="form-control">
              </div>
              <div class="col-md-6">
                <label class="form-label">{{ $t('tenant_dashboard.settings.longitude') }}
                  <span class="ms-1" data-bs-toggle="tooltip" :title="$t('tenant_dashboard.settings.longitudeTooltip')">
                    <i class="fas fa-info-circle text-secondary"></i>
                  </span>
                </label>
                <input v-model="form.longitude" type="number" step="any" class="form-control">
              </div>
            </div>
          </div>

          <!-- System Settings -->
          <div class="section mb-4">
            <h5 class="section-title">{{ $t('tenant_dashboard.settings.systemSettings') }}</h5>
            <div class="row g-3">
              <div class="col-md-4">
                <label class="form-label">{{ $t('tenant_dashboard.settings.currency') }}
                  <span class="ms-1" data-bs-toggle="tooltip" :title="$t('tenant_dashboard.settings.currencyTooltip')">
                    <i class="fas fa-info-circle text-secondary"></i>
                  </span>
                </label>
                <div class="input-group">
                  <select v-model="form.currency_symbol" class="form-select">
                    <option v-for="c in staticCurrencies" :key="c.symbol" :value="c.symbol">
                      {{ c.name }} ({{ c.symbol }})
                    </option>
                  </select>
                  <span class="input-group-text" v-if="form.currency_symbol">{{ form.currency_symbol }}</span>
                </div>
              </div>
              <div class="col-md-4">
                <label class="form-label">{{ $t('tenant_dashboard.settings.timezone') }}
                  <span class="ms-1" data-bs-toggle="tooltip" :title="$t('tenant_dashboard.settings.timezoneTooltip')">
                    <i class="fas fa-info-circle text-secondary"></i>
                  </span>
                </label>
                <select v-model="form.timezone" class="form-select">
                  <option value="UTC">{{ $t('tenant_dashboard.settings.timezoneUTC') }}</option>
                  <option value="America/New_York">{{ $t('tenant_dashboard.settings.timezoneEastern') }}</option>
                  <option value="America/Chicago">{{ $t('tenant_dashboard.settings.timezoneCentral') }}</option>
                  <option value="America/Denver">{{ $t('tenant_dashboard.settings.timezoneMountain') }}</option>
                  <option value="America/Los_Angeles">{{ $t('tenant_dashboard.settings.timezonePacific') }}</option>
                </select>
              </div>
              <div class="col-md-4">
                <label class="form-label">{{ $t('tenant_dashboard.settings.dateFormat') }}
                  <span class="ms-1" data-bs-toggle="tooltip" :title="$t('tenant_dashboard.settings.dateFormatTooltip')">
                    <i class="fas fa-info-circle text-secondary"></i>
                  </span>
                </label>
                <select v-model="form.date_format" class="form-select">
                  <option value="Y-m-d">{{ $t('tenant_dashboard.settings.dateFormatYMD') }}</option>
                  <option value="m/d/Y">{{ $t('tenant_dashboard.settings.dateFormatMDY') }}</option>
                  <option value="d/m/Y">{{ $t('tenant_dashboard.settings.dateFormatDMY') }}</option>
                </select>
              </div>
              <div class="col-md-4">
                <label class="form-label">{{ $t('tenant_dashboard.settings.timeFormat') }}
                  <span class="ms-1" data-bs-toggle="tooltip" :title="$t('tenant_dashboard.settings.timeFormatTooltip')">
                    <i class="fas fa-info-circle text-secondary"></i>
                  </span>
                </label>
                <select v-model="form.time_format" class="form-select">
                  <option value="H:i:s">{{ $t('tenant_dashboard.settings.timeFormat24') }}</option>
                  <option value="h:i:s A">{{ $t('tenant_dashboard.settings.timeFormat12') }}</option>
                </select>
              </div>
              <div class="col-md-4">
                <label class="form-label">{{ $t('tenant_dashboard.settings.status') }}
                  <span class="ms-1" data-bs-toggle="tooltip" :title="$t('tenant_dashboard.settings.statusTooltip')">
                    <i class="fas fa-info-circle text-secondary"></i>
                  </span>
                </label>
                <div class="form-check form-switch mt-2">
                  <input class="form-check-input" type="checkbox" v-model="form.is_active" id="statusSwitch">
                  <label class="form-check-label" for="statusSwitch">
                    {{ form.is_active ? $t('tenant_dashboard.settings.statusActive') : $t('tenant_dashboard.settings.statusInactive') }}
                  </label>
                </div>
              </div>
            </div>
          </div>

          <!-- Social Media Links -->
          <div class="section mb-4">
            <h5 class="section-title">{{ $t('tenant_dashboard.settings.socialMediaLinks') }}</h5>
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">{{ $t('tenant_dashboard.settings.facebookLink') }}
                  <span class="ms-1" data-bs-toggle="tooltip" :title="$t('tenant_dashboard.settings.facebookLinkTooltip')">
                    <i class="fas fa-info-circle text-secondary"></i>
                  </span>
                </label>
                <input v-model="form.facebook_link" type="url" class="form-control">
              </div>
              <div class="col-md-6">
                <label class="form-label">{{ $t('tenant_dashboard.settings.twitterLink') }}
                  <span class="ms-1" data-bs-toggle="tooltip" :title="$t('tenant_dashboard.settings.twitterLinkTooltip')">
                    <i class="fas fa-info-circle text-secondary"></i>
                  </span>
                </label>
                <input v-model="form.twitter_link" type="url" class="form-control">
              </div>
              <div class="col-md-6">
                <label class="form-label">{{ $t('tenant_dashboard.settings.linkedinLink') }}
                  <span class="ms-1" data-bs-toggle="tooltip" :title="$t('tenant_dashboard.settings.linkedinLinkTooltip')">
                    <i class="fas fa-info-circle text-secondary"></i>
                  </span>
                </label>
                <input v-model="form.linkedin_link" type="url" class="form-control">
              </div>
              <div class="col-md-6">
                <label class="form-label">{{ $t('tenant_dashboard.settings.googlePlusLink') }}
                  <span class="ms-1" data-bs-toggle="tooltip" :title="$t('tenant_dashboard.settings.googlePlusLinkTooltip')">
                    <i class="fas fa-info-circle text-secondary"></i>
                  </span>
                </label>
                <input v-model="form.google_plus_link" type="url" class="form-control">
              </div>
              <div class="col-md-6">
                <label class="form-label">{{ $t('tenant_dashboard.settings.instagramLink') }}
                  <span class="ms-1" data-bs-toggle="tooltip" :title="$t('tenant_dashboard.settings.instagramLinkTooltip')">
                    <i class="fas fa-info-circle text-secondary"></i>
                  </span>
                </label>
                <input v-model="form.instagram_link" type="url" class="form-control">
              </div>
            </div>
          </div>

          <!-- Description -->
          <div class="section mb-4">
            <h5 class="section-title">{{ $t('tenant_dashboard.settings.description') }}</h5>
            <label class="form-label">{{ $t('tenant_dashboard.settings.descriptionLabel') }}
              <span class="ms-1" data-bs-toggle="tooltip" :title="$t('tenant_dashboard.settings.descriptionTooltip')">
                <i class="fas fa-info-circle text-secondary"></i>
              </span>
            </label>
            <textarea v-model="form.description" class="form-control" rows="3"></textarea>
          </div>

          <!-- Subscribers and Contact Form Received Mail-->
          <!-- <div class="section mb-4">
            <h5 class="section-title">Subscribers</h5>
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Email</label>
                <input v-model="form.subscriber_" type="email" class="form-control">
              </div>
            </div>
          </div> -->

          <div class="text-end">
            <button type="submit" class="btn btn-primary" :disabled="saving">
              <span v-if="saving" class="spinner-border spinner-border-sm me-2" role="status"></span>
              {{ $t('tenant_dashboard.settings.saveSettings') }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted, watch } from 'vue'
import axios from 'axios'
import Swal from 'sweetalert2'
import { Tooltip } from 'bootstrap'

export default {
  name: 'Settings',
  setup() {
    const loading = ref(true)
    const saving = ref(false)
    const logoInput = ref(null)
    const staticCurrencies = [
      { name: 'USD', symbol: '$' },
      { name: 'EUR', symbol: '€' },
      { name: 'GBP', symbol: '£' },
      { name: 'INR', symbol: '₹' },
      { name: 'CAD', symbol: 'C$' },
      { name: 'AUD', symbol: 'A$' },
      { name: 'JPY', symbol: '¥' },
      // Add more as needed
    ];
    const form = ref({
      business_name: '',
      logo: '',
      address: '',
      postal_code: '',
      country: '',
      state: '',
      city: '',
      phone: '',
      email: '',
      place_id: '',
      pickup_start_end_time: '',
      latitude: null,
      longitude: null,
      currency_symbol: '',
      timezone: 'UTC',
      date_format: 'Y-m-d',
      time_format: 'H:i:s',
      is_active: true
    })

    const handleLogoUpload = async (event) => {
      const file = event.target.files[0]
      if (!file) return

      // Validate file size (2MB max)
      if (file.size > 2 * 1024 * 1024) {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Logo file size must be less than 2MB'
        })
        return
      }

      // Validate file type
      if (!file.type.startsWith('image/')) {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Please upload an image file'
        })
        return
      }

      const formData = new FormData()
      formData.append('logo', file)

      try {
        const response = await axios.post('/tenant/upload-logo', formData, {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        })

        if (response.data.success) {
          form.value.logo = response.data.url
        } else {
          throw new Error(response.data.message || 'Failed to upload logo')
        }
      } catch (error) {
        console.error('Error uploading logo:', error)
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: error.response?.data?.message || 'Failed to upload logo'
        })
      }
    }

    const fetchSettings = async () => {
      try {
        const response = await axios.get('/tenant/settings')
        if (response.data.success && response.data.data) {
          const settings = response.data.data
          form.value = {
            business_name: settings.business_name || '',
            logo: settings.logo || '',
            address: settings.address || '',
            postal_code: settings.postal_code || '',
            country: settings.country || '',
            state: settings.state || '',
            city: settings.city || '',
            phone: settings.phone || '',
            email: settings.email || '',
            place_id: settings.place_id || '',
            pickup_start_end_time: settings.pickup_start_end_time || '',
            latitude: settings.latitude || null,
            longitude: settings.longitude || null,
            currency_symbol: settings.currency_symbol || '',
            timezone: settings.timezone || 'UTC',
            date_format: settings.date_format || 'Y-m-d',
            time_format: settings.time_format || 'H:i:s',
            is_active: !!settings.is_active,
            facebook_link: settings.facebook_link || '',
            twitter_link: settings.twitter_link || '',
            linkedin_link: settings.linkedin_link || '',
            google_plus_link: settings.google_plus_link || '',
            instagram_link: settings.instagram_link || ''
          }
          // --- Fix: set currency by symbol if present ---
          if (settings.currency_symbol) {
            const found = staticCurrencies.find(c => c.symbol === settings.currency_symbol)
            if (found) {
              form.value.currency_symbol = found.symbol
            }
          }
        }
      } catch (error) {
        console.error('Error fetching settings:', error)
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Failed to fetch settings'
        })
      } finally {
        loading.value = false
      }
    }

    const saveSettings = async () => {
      saving.value = true
      try {
        const response = await axios.put('/tenant/settings', form.value)
        if (response.data.success) {
          Swal.fire({
            icon: 'success',
            title: 'Success',
            text: 'Settings updated successfully',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
          })
        } else {
          throw new Error(response.data.message || 'Failed to save settings')
        }
      } catch (error) {
        console.error('Error saving settings:', error)
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: error.response?.data?.message || 'Failed to save settings'
        })
      } finally {
        saving.value = false
      }
    }

    onMounted(() => {
      Promise.all([fetchSettings()]).then(() => {
        // setCurrencySymbol() // This function is no longer needed
      })
      document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
        new Tooltip(el)
      })
    })

    return {
      form,
      loading,
      saving,
      logoInput,
      staticCurrencies,
      handleLogoUpload,
      saveSettings
    }
  }
}
</script>

<style scoped>
.settings-page {
  padding: 20px;
  font-family: 'Inter', 'Roboto', 'Segoe UI', Arial, sans-serif;
}

.section {
  background: #fff;
  border-radius: 8px;
  padding: 1.5rem;
  box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.section-title {
  color: #2c3e50;
  font-size: 1.1rem;
  font-weight: 600;
  margin-bottom: 1.5rem;
  padding-bottom: 0.5rem;
  border-bottom: 2px solid #f0f0f0;
}

.form-label {
  font-weight: 500;
  color: #4a5568;
  margin-bottom: 0.5rem;
}

.form-control, .form-select {
  border: 1px solid #e2e8f0;
  border-radius: 6px;
  padding: 0.5rem 0.75rem;
  font-size: 0.95rem;
}

.form-control:focus, .form-select:focus {
  border-color: #4299e1;
  box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.1);
}

.btn-primary {
  background: #4299e1;
  border: none;
  padding: 0.6rem 1.5rem;
  font-weight: 500;
  border-radius: 6px;
  transition: all 0.2s;
}

.btn-primary:hover {
  background: #3182ce;
  transform: translateY(-1px);
}

.btn-primary:disabled {
  background: #a0aec0;
  cursor: not-allowed;
  transform: none;
}

.form-check-input:checked {
  background-color: #4299e1;
  border-color: #4299e1;
}

.logo-preview {
  width: 100px;
  height: 100px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #f8fafc;
  border-radius: 6px;
  overflow: hidden;
}

.logo-preview img {
  max-width: 100%;
  max-height: 100%;
  object-fit: contain;
}
</style>
