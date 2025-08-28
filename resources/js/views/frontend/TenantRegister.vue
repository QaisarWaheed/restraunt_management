<template>
  <!-- Banner/Breadcrumb Section (Hero) -->
  <section class="mt-5 register-banner-section position-relative d-flex align-items-center justify-content-center" style="min-height: 320px; width: 100vw; left: 50%; right: 50%; margin-left: -50vw; margin-right: -50vw; background: url('/Mox_files/homepage.jpg') center center/cover no-repeat;">
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: rgba(0,0,0,0.55); z-index: 1;"></div>
    <div class="container position-relative text-center" style="z-index: 2;">
      <h1 class="text-white fw-bold mb-2" style="font-size: 2.8rem;">Register Your Restaurant</h1>
      <div class="text-white mb-2" style="font-size: 1.1rem; font-weight: 500; letter-spacing: 0.5px;">
        We provide free, secure and instantly confirmed online registration.
      </div>
      <!-- Breadcrumbs -->
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb justify-content-center mb-0" style="background: transparent;">
          <li class="breadcrumb-item"><router-link to="/" class="text-white-50">Home</router-link></li>
          <li class="breadcrumb-item active text-white" aria-current="page">Register</li>
        </ol>
      </nav>
    </div>
  </section>
  <div class="tenant-register py-5" style="background: #fafafa; min-height: 100vh; margin-top: -60px;">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-9">
          <div class="card shadow-lg border-0 bg-white" style="border-radius: 0 0 16px 16px; background: #fff !important;">
            <div class="card-top-red-line"></div>
            <div class="card-body p-4 p-md-5">
              <div class="text-center mb-3" style="font-size: 1.1rem; color: #222;">
                Fill in the details below to create your restaurant account.
                <br>

                <!-- Location Status -->
                <div class="mb-3">
                    <div v-if="locationLoading" class="text-primary">
                    <div class="spinner-border spinner-border-sm me-2" role="status"></div>
                    <small>Getting your location...</small>
                    </div>
                    <div v-else-if="userLocation" class="text-success">
                    <i class="fas fa-map-marker-alt me-2"></i>
                    <small>Location-based suggestions enabled ({{ userLocation.lat.toFixed(4) }}, {{ userLocation.lng.toFixed(4) }})</small>
                    <button
                        type="button"
                        class="btn btn-sm btn-outline-primary ms-2"
                        @click="getUserLocation"
                        title="Refresh location"
                    >
                        <i class="fas fa-sync-alt"></i>
                    </button>
                    </div>
                    <div v-else-if="locationError" class="text-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <small>{{ locationError }}</small>
                    <button
                        type="button"
                        class="btn btn-sm btn-outline-warning ms-2"
                        @click="getUserLocation"
                        title="Try again"
                    >
                        <i class="fas fa-redo"></i>
                    </button>
                    </div>
                </div>
              </div>
              <form @submit.prevent="handleSubmit">
                <div class="row g-3">
                  <!-- Business Name with Google Places Autocomplete -->
                  <div class="col-md-6">
                    <label for="businessName" class="form-label fw-semibold">Restaurant Name*</label>


                    <div class="position-relative">
                      <input
                        type="text"
                        class="form-control"
                        id="businessName"
                        v-model="form.businessName"
                        ref="businessNameInput"
                        required
                        @input="handleInput"
                        :placeholder="userLocation ? 'Search for restaurants near you' : 'Search for your restaurant name'"
                      >
                      <!-- Autocomplete Results -->
                      <div v-if="showAutocomplete && predictions.length > 0" class="autocomplete-results">
                        <div
                          v-for="prediction in predictions"
                          :key="prediction.place_id"
                          class="autocomplete-item"
                          @click="selectPlace(prediction)"
                        >
                          {{ prediction.description }}
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- Subdomain -->
                  <div class="col-md-6">
                    <label for="subdomain" class="form-label fw-semibold">Subdomain*</label>
                    <div class="input-group">
                      <input
                        type="text"
                        class="form-control"
                        id="subdomain"
                        v-model="form.subdomain"
                        required
                        pattern="[a-z0-9-]+"
                        title="Only lowercase letters, numbers, and hyphens are allowed"
                        placeholder="your-restaurant-name"
                      >
                      <span class="input-group-text">.yourdomain.com</span>
                    </div>
                    <small class="text-muted">This will be your restaurant's unique URL</small>
                  </div>
                  <!-- Owner Name -->
                  <div class="col-md-6">
                    <label for="ownerName" class="form-label fw-semibold">Full Name*</label>
                    <input
                      type="text"
                      class="form-control"
                      id="ownerName"
                      v-model="form.ownerName"
                      required
                      placeholder="Enter your full name"
                    >
                  </div>
                  <!-- Email -->
                  <div class="col-md-6">
                    <label for="email" class="form-label fw-semibold">Email Address*</label>
                    <input
                      type="email"
                      class="form-control"
                      id="email"
                      v-model="form.email"
                      required
                      pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
                      title="Please enter a valid email address"
                      placeholder="Enter your email address"
                    >
                    <small class="text-muted">We'll never share your email with anyone else.</small>
                  </div>
                  <!-- Phone with Country Selector -->
                  <div class="col-md-6">
                    <label for="phone" class="form-label fw-semibold">Phone Number*</label>
                    <div class="phone-input-container d-flex align-items-stretch gap-2">
                      <div class="country-selector d-flex align-items-center px-2 py-1 border rounded bg-white me-2" @click="showCountryModal = true" style="cursor:pointer; min-width:100px;">
                        <div v-if="countryDetecting" class="d-flex align-items-center">
                          <div class="spinner-border spinner-border-sm me-2" role="status"></div>
                          <small class="text-muted">Detecting...</small>
                        </div>
                        <div v-else class="d-flex align-items-center">
                          <img :src="selectedCountryFlag" :alt="selectedCountry.name" class="country-flag me-2" v-if="selectedCountryFlag">
                          <span class="country-code">{{ selectedCountry.dialCode || '+1' }}</span>
                          <i class="fas fa-chevron-down ms-1"></i>
                        </div>
                      </div>
                      <input
                        type="tel"
                        class="form-control phone-number-input"
                        v-model="form.phoneNumber"
                        placeholder="Enter phone number"
                        required
                        @input="handlePhoneInput"
                      >
                    </div>
                    <!-- Country Selection Modal -->
                    <div class="country-modal" v-if="showCountryModal" @click.self="showCountryModal = false">
                      <div class="country-modal-content">
                        <div class="country-modal-header d-flex justify-content-between align-items-center">
                          <h5 class="mb-0">Select Country</h5>
                          <button type="button" class="btn-close" @click="showCountryModal = false"></button>
                        </div>
                        <div class="country-search p-2 border-bottom">
                          <div class="input-group">
                            <span class="input-group-text bg-white">
                              <i class="fas fa-search"></i>
                            </span>
                            <input
                              type="text"
                              class="form-control"
                              v-model="countrySearch"
                              placeholder="Search country or dial code..."
                              autofocus
                            >
                          </div>
                        </div>
                        <div class="country-list" style="max-height: 300px; overflow-y: auto;">
                          <div
                            v-for="country in filteredCountries"
                            :key="country.code"
                            class="country-item d-flex align-items-center px-2 py-2 border-bottom"
                            @click="selectCountry(country)"
                            style="cursor:pointer;"
                          >
                            <img :src="country.flag" :alt="country.name" class="country-flag me-2">
                            <div class="country-info flex-grow-1">
                              <span class="country-name">{{ country.name }}</span>
                              <span class="country-dial-code ms-2 text-muted">{{ country.dialCode }}</span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- Password -->
                  <div class="col-md-6">
                    <label for="password" class="form-label fw-semibold">Password*</label>
                    <input
                      type="password"
                      class="form-control"
                      id="password"
                      v-model="form.password"
                      required
                      minlength="8"
                      placeholder="Enter a strong password"
                    >
                    <small class="text-muted">Minimum 8 characters</small>
                  </div>
                  <!-- Confirm Password -->
                  <div class="col-md-6">
                    <label for="passwordConfirmation" class="form-label fw-semibold">Confirm Password*</label>
                    <input
                      type="password"
                      class="form-control"
                      id="passwordConfirmation"
                      v-model="form.passwordConfirmation"
                      required
                      placeholder="Re-enter your password"
                    >
                  </div>
                  <!-- Message -->
                  <div class="col-12">
                    <label for="message" class="form-label fw-semibold">Message (optional)</label>
                    <textarea class="form-control" id="message" v-model="form.message" placeholder="Message (optional)" rows="3"></textarea>
                  </div>
                  <!-- Terms and Conditions -->
                  <div class="col-12">
                    <div class="form-check">
                      <input
                        type="checkbox"
                        class="form-check-input"
                        id="terms"
                        v-model="form.acceptTerms"
                        required
                      >
                      <label class="form-check-label" for="terms">
                        I agree to the <a href="#" target="_blank">Terms and Conditions</a>
                      </label>
                    </div>
                  </div>
                  <!-- Submit Button -->
                  <div class="col-12 text-center mt-3">
                    <button type="submit" class="btn btn-danger px-5 py-2 fw-bold" style="border-radius: 6px; min-width: 200px;" :disabled="loading">
                      {{ loading ? 'Processing...' : 'REGISTER' }}
                    </button>
                  </div>
                </div>
              </form>
              <!-- Contact info below form -->
              <div class="text-center mt-4" style="color: #c62828; font-size: 1rem;">
                You can also contact us at <b>(+100) 123 456 7890</b> if you face any issue while registering.
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted, onUnmounted, computed } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'
import Swal from 'sweetalert2'
import { Tooltip } from 'bootstrap'
import { VueTelInput } from 'vue-tel-input'

export default {
  name: 'TenantRegister',
  components: {
    VueTelInput
  },
  setup() {
    const router = useRouter()
    const loading = ref(false)
    const predictions = ref([])
    const showAutocomplete = ref(false)
    const businessNameInput = ref(null)
    const autocompleteService = ref(null)
    const placesService = ref(null)
    let debounceTimer = null
    let tooltips = []
    const showCountryModal = ref(false)
    const countrySearch = ref('')
    const selectedCountry = ref({
      name: 'United States',
      code: 'US',
      dialCode: '+1',
      flag: 'https://flagcdn.com/us.svg'
    })

    const countries = ref([
      {
        name: 'United States',
        code: 'US',
        dialCode: '+1',
        flag: 'https://flagcdn.com/us.svg'
      },
      {
        name: 'United Kingdom',
        code: 'GB',
        dialCode: '+44',
        flag: 'https://flagcdn.com/gb.svg'
      },
      {
        name: 'Canada',
        code: 'CA',
        dialCode: '+1',
        flag: 'https://flagcdn.com/ca.svg'
      },
      {
        name: 'Afghanistan',
        code: 'AF',
        dialCode: '+93',
        flag: 'https://flagcdn.com/af.svg'
      },
      {
        name: 'Albania',
        code: 'AL',
        dialCode: '+355',
        flag: 'https://flagcdn.com/al.svg'
      },
      {
        name: 'Algeria',
        code: 'DZ',
        dialCode: '+213',
        flag: 'https://flagcdn.com/dz.svg'
      },
      {
        name: 'Argentina',
        code: 'AR',
        dialCode: '+54',
        flag: 'https://flagcdn.com/ar.svg'
      },
      {
        name: 'Australia',
        code: 'AU',
        dialCode: '+61',
        flag: 'https://flagcdn.com/au.svg'
      },
      {
        name: 'Austria',
        code: 'AT',
        dialCode: '+43',
        flag: 'https://flagcdn.com/at.svg'
      },
      {
        name: 'Belgium',
        code: 'BE',
        dialCode: '+32',
        flag: 'https://flagcdn.com/be.svg'
      },
      {
        name: 'Brazil',
        code: 'BR',
        dialCode: '+55',
        flag: 'https://flagcdn.com/br.svg'
      },
      {
        name: 'China',
        code: 'CN',
        dialCode: '+86',
        flag: 'https://flagcdn.com/cn.svg'
      },
      {
        name: 'Denmark',
        code: 'DK',
        dialCode: '+45',
        flag: 'https://flagcdn.com/dk.svg'
      },
      {
        name: 'Egypt',
        code: 'EG',
        dialCode: '+20',
        flag: 'https://flagcdn.com/eg.svg'
      },
      {
        name: 'France',
        code: 'FR',
        dialCode: '+33',
        flag: 'https://flagcdn.com/fr.svg'
      },
      {
        name: 'Germany',
        code: 'DE',
        dialCode: '+49',
        flag: 'https://flagcdn.com/de.svg'
      },
      {
        name: 'Greece',
        code: 'GR',
        dialCode: '+30',
        flag: 'https://flagcdn.com/gr.svg'
      },
      {
        name: 'India',
        code: 'IN',
        dialCode: '+91',
        flag: 'https://flagcdn.com/in.svg'
      },
      {
        name: 'Indonesia',
        code: 'ID',
        dialCode: '+62',
        flag: 'https://flagcdn.com/id.svg'
      },
      {
        name: 'Ireland',
        code: 'IE',
        dialCode: '+353',
        flag: 'https://flagcdn.com/ie.svg'
      },
      {
        name: 'Italy',
        code: 'IT',
        dialCode: '+39',
        flag: 'https://flagcdn.com/it.svg'
      },
      {
        name: 'Japan',
        code: 'JP',
        dialCode: '+81',
        flag: 'https://flagcdn.com/jp.svg'
      },
      {
        name: 'Malaysia',
        code: 'MY',
        dialCode: '+60',
        flag: 'https://flagcdn.com/my.svg'
      },
      {
        name: 'Mexico',
        code: 'MX',
        dialCode: '+52',
        flag: 'https://flagcdn.com/mx.svg'
      },
      {
        name: 'Netherlands',
        code: 'NL',
        dialCode: '+31',
        flag: 'https://flagcdn.com/nl.svg'
      },
      {
        name: 'New Zealand',
        code: 'NZ',
        dialCode: '+64',
        flag: 'https://flagcdn.com/nz.svg'
      },
      {
        name: 'Norway',
        code: 'NO',
        dialCode: '+47',
        flag: 'https://flagcdn.com/no.svg'
      },
      {
        name: 'Pakistan',
        code: 'PK',
        dialCode: '+92',
        flag: 'https://flagcdn.com/pk.svg'
      },
      {
        name: 'Philippines',
        code: 'PH',
        dialCode: '+63',
        flag: 'https://flagcdn.com/ph.svg'
      },
      {
        name: 'Poland',
        code: 'PL',
        dialCode: '+48',
        flag: 'https://flagcdn.com/pl.svg'
      },
      {
        name: 'Portugal',
        code: 'PT',
        dialCode: '+351',
        flag: 'https://flagcdn.com/pt.svg'
      },
      {
        name: 'Russia',
        code: 'RU',
        dialCode: '+7',
        flag: 'https://flagcdn.com/ru.svg'
      },
      {
        name: 'Saudi Arabia',
        code: 'SA',
        dialCode: '+966',
        flag: 'https://flagcdn.com/sa.svg'
      },
      {
        name: 'Singapore',
        code: 'SG',
        dialCode: '+65',
        flag: 'https://flagcdn.com/sg.svg'
      },
      {
        name: 'South Africa',
        code: 'ZA',
        dialCode: '+27',
        flag: 'https://flagcdn.com/za.svg'
      },
      {
        name: 'South Korea',
        code: 'KR',
        dialCode: '+82',
        flag: 'https://flagcdn.com/kr.svg'
      },
      {
        name: 'Spain',
        code: 'ES',
        dialCode: '+34',
        flag: 'https://flagcdn.com/es.svg'
      },
      {
        name: 'Sweden',
        code: 'SE',
        dialCode: '+46',
        flag: 'https://flagcdn.com/se.svg'
      },
      {
        name: 'Switzerland',
        code: 'CH',
        dialCode: '+41',
        flag: 'https://flagcdn.com/ch.svg'
      },
      {
        name: 'Thailand',
        code: 'TH',
        dialCode: '+66',
        flag: 'https://flagcdn.com/th.svg'
      },
      {
        name: 'Turkey',
        code: 'TR',
        dialCode: '+90',
        flag: 'https://flagcdn.com/tr.svg'
      },
      {
        name: 'Ukraine',
        code: 'UA',
        dialCode: '+380',
        flag: 'https://flagcdn.com/ua.svg'
      },
      {
        name: 'United Arab Emirates',
        code: 'AE',
        dialCode: '+971',
        flag: 'https://flagcdn.com/ae.svg'
      },
      {
        name: 'Vietnam',
        code: 'VN',
        dialCode: '+84',
        flag: 'https://flagcdn.com/vn.svg'
      }
    ])

    const filteredCountries = computed(() => {
      if (!countrySearch.value) return countries.value
      const search = countrySearch.value.toLowerCase()
      return countries.value.filter(country =>
        country.name.toLowerCase().includes(search) ||
        country.dialCode.includes(search)
      )
    })

    const form = ref({
      businessName: '',
      subdomain: '',
      ownerName: '',
      email: '',
      phone: '',
      phoneNumber: '',
      phoneCountry: '',
      phoneFormatted: '',
      password: '',
      passwordConfirmation: '',
      acceptTerms: false,
      placeId: null,
      location: null
    })

    // User location state
    const userLocation = ref(null)
    const locationLoading = ref(false)
    const locationError = ref(null)
    const countryDetecting = ref(false)

    // Initialize tooltips
    const initTooltips = () => {
      // Dispose existing tooltips
      tooltips.forEach(tooltip => tooltip.dispose())
      tooltips = []

      // Initialize new tooltips
      document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
        tooltips.push(new Tooltip(el))
      })
    }

    const initGooglePlaces = () => {
      if (window.google && window.google.maps && window.google.maps.places) {
        autocompleteService.value = new window.google.maps.places.AutocompleteService()
        placesService.value = new window.google.maps.places.PlacesService(document.createElement('div'))
      }
    }

    const loadGooglePlacesScript = () => {
      const script = document.createElement('script')
      script.src = `https://maps.google.com/maps/api/js?key=AIzaSyCZDgTTb7vm0co-2yHGinkgSs_yDTNtbSo&libraries=places`
      script.async = true
      script.defer = true
      script.onload = initGooglePlaces
      document.head.appendChild(script)
    }

        // Get user's current location
    const getUserLocation = () => {
      locationLoading.value = true
      locationError.value = null

      if (!navigator.geolocation) {
        locationError.value = 'Geolocation is not supported by this browser.'
        locationLoading.value = false
        return
      }

      navigator.geolocation.getCurrentPosition(
        (position) => {
          userLocation.value = {
            lat: position.coords.latitude,
            lng: position.coords.longitude
          }
          locationLoading.value = false
          console.log('User location obtained:', userLocation.value)

          // Get country from coordinates and set phone country
          getCountryFromCoordinates(userLocation.value.lat, userLocation.value.lng)
        },
        (error) => {
          locationError.value = 'Unable to get your location. Please enable location services.'
          locationLoading.value = false
          console.error('Location error:', error)
        },
        {
          enableHighAccuracy: true,
          timeout: 10000,
          maximumAge: 300000 // 5 minutes
        }
      )
    }

    // Get country from coordinates using reverse geocoding
    const getCountryFromCoordinates = (lat, lng) => {
      countryDetecting.value = true

      // Try Google Maps first
      if (window.google && window.google.maps) {
        const geocoder = new window.google.maps.Geocoder()
        geocoder.geocode(
          { location: { lat, lng } },
          (results, status) => {
            countryDetecting.value = false
            if (status === 'OK' && results[0]) {
              const addressComponents = results[0].address_components
              let countryCode = null

              // Find country component
              for (const component of addressComponents) {
                if (component.types.includes('country')) {
                  countryCode = component.short_name
                  break
                }
              }

              if (countryCode) {
                console.log('Country detected via Google Maps:', countryCode)
                setCountryByCode(countryCode)
                return
              }
            }
            // Fallback to free geocoding service
            fallbackGeocoding(lat, lng)
          }
        )
      } else {
        // Google Maps not available, use fallback
        console.log('Google Maps not loaded, using fallback geocoding...')
        fallbackGeocoding(lat, lng)
      }
    }

    // Fallback geocoding using free service
    const fallbackGeocoding = async (lat, lng) => {
      try {
        const response = await fetch(`https://api.bigdatacloud.net/data/reverse-geocode-client?latitude=${lat}&longitude=${lng}&localityLanguage=en`)
        const data = await response.json()

        if (data.countryCode) {
          console.log('Country detected via fallback service:', data.countryCode)
          setCountryByCode(data.countryCode)
        }
      } catch (error) {
        console.error('Fallback geocoding failed:', error)
      } finally {
        countryDetecting.value = false
      }
    }

    // Set country by country code
    const setCountryByCode = (countryCode) => {
      const country = countries.value.find(c => c.code === countryCode)
      if (country) {
        selectedCountry.value = country
        form.value.phoneCountry = country.code
        console.log('Country set to:', country.name, 'with dial code:', country.dialCode)
      } else {
        console.log('Country not found for code:', countryCode)
      }
    }

    const handleInput = () => {
      if (debounceTimer) clearTimeout(debounceTimer)

      if (!form.value.businessName) {
        predictions.value = []
        showAutocomplete.value = false
        return
      }

      debounceTimer = setTimeout(() => {
        if (autocompleteService.value) {
          // Use user location if available, otherwise use default
          const request = {
            input: form.value.businessName,
            types: ['establishment'],
            componentRestrictions: { country: 'us' } // Default restriction
          }

          // If user location is available, add location bias
          if (userLocation.value) {
            request.location = new window.google.maps.LatLng(userLocation.value.lat, userLocation.value.lng)
            request.radius = 50000 // 50km radius
            delete request.componentRestrictions // Remove country restriction when using location
          }

          autocompleteService.value.getPlacePredictions(
            request,
            (results, status) => {
              if (status === window.google.maps.places.PlacesServiceStatus.OK) {
                predictions.value = results
                showAutocomplete.value = true
              }
            }
          )
        }
      }, 300)
    }

    const selectPlace = (prediction) => {
      form.value.businessName = prediction.description
      form.value.placeId = prediction.place_id
      showAutocomplete.value = false

      // Get additional place details
      if (placesService.value) {
        placesService.value.getDetails(
          {
            placeId: prediction.place_id,
            fields: [
              'name',
              'geometry',
              'formatted_address',
              'address_components',
              'place_id'
            ]
          },
          (place, status) => {
            if (status === window.google.maps.places.PlacesServiceStatus.OK) {
              // Extract address components
              const addressComponents = {}
              place.address_components.forEach(component => {
                const type = component.types[0]
                addressComponents[type] = component.long_name
                if (type === 'country') {
                  addressComponents.country_code = component.short_name
                }
              })

              form.value.location = {
                lat: place.geometry.location.lat(),
                lng: place.geometry.location.lng(),
                formatted_address: place.formatted_address,
                postal_code: addressComponents.postal_code || '',
                country: addressComponents.country || '',
                state: addressComponents.administrative_area_level_1 || '',
                city: addressComponents.locality || addressComponents.administrative_area_level_2 || ''
              }

              // Auto-generate subdomain from business name
              form.value.subdomain = place.name
                .toLowerCase()
                .replace(/[^a-z0-9]/g, '-')
                .replace(/-+/g, '-')
                .replace(/^-|-$/g, '')
            }
          }
        )
      }
    }

    // Close autocomplete when clicking outside
    const handleClickOutside = (event) => {
      if (businessNameInput.value && !businessNameInput.value.contains(event.target)) {
        showAutocomplete.value = false
      }
    }

    const formatPhoneNumber = (number) => {
      // Remove all non-digits
      const cleaned = number.replace(/\D/g, '')

      // Format based on country
      if (selectedCountry.value.code === 'US' || selectedCountry.value.code === 'CA') {
        if (cleaned.length <= 3) return cleaned
        if (cleaned.length <= 6) return `(${cleaned.slice(0, 3)}) ${cleaned.slice(3)}`
        return `(${cleaned.slice(0, 3)}) ${cleaned.slice(3, 6)}-${cleaned.slice(6, 10)}`
      }

      // Default international format
      return cleaned.replace(/(\d{3})(?=\d)/g, '$1 ').trim()
    }

    const handlePhoneInput = (event) => {
      let value = event.target.value.replace(/\D/g, '')
      form.value.phoneNumber = formatPhoneNumber(value)
      form.value.phone = selectedCountry.value.dialCode + value
    }

    const selectCountry = (country) => {
      selectedCountry.value = country
      form.value.phoneCountry = country.code
      // Update the full phone number with new country code
      const number = form.value.phoneNumber ? form.value.phoneNumber.replace(/\D/g, '') : ''
      form.value.phone = number ? country.dialCode + number : ''
      showCountryModal.value = false
    }

    const selectedCountryFlag = computed(() => selectedCountry.value?.flag)

    onMounted(() => {
      loadGooglePlacesScript()
      document.addEventListener('click', handleClickOutside)
      initTooltips()
      // Get user location when component mounts
      getUserLocation()
    })

    onUnmounted(() => {
      document.removeEventListener('click', handleClickOutside)
      tooltips.forEach(tooltip => tooltip.dispose())
    })

    const handleSubmit = async () => {
      if (loading.value) return;
      if (form.value.password !== form.value.passwordConfirmation) {
        Swal.fire({
          icon: 'error',
          title: 'Password Mismatch',
          text: 'Password and confirmation do not match'
        });
        return;
      }

      loading.value = true;
      try {
        const response = await axios.post('/tenants/register', {
          business_name: form.value.businessName,
          subdomain: form.value.subdomain,
          owner_name: form.value.ownerName,
          owner_email: form.value.email,
          owner_phone: form.value.phone,
          password: form.value.password,
          password_confirmation: form.value.passwordConfirmation,
          location: {
            address: form.value.location.formatted_address,
            latitude: form.value.location.lat,
            longitude: form.value.location.lng,
            country: form.value.location.country,
            state: form.value.location.state,
            city: form.value.location.city,
            postal_code: form.value.location.postal_code,
            place_id: form.value.placeId
          }
        });

        if (response.data.success) {
          await Swal.fire({
            icon: 'success',
            title: 'Registration Successful',
            text: 'Your restaurant has been registered successfully. You will be redirected to login.',
            timer: 2000,
            showConfirmButton: false
          });

          // Redirect to the tenant's login page
          const domain = response.data.domain;
          window.location.href = `${window.location.protocol}//${domain}/login`;
        }
      } catch (error) {
        console.error('Registration error:', error);
        const message = error.response?.data?.message || 'An error occurred during registration';
        Swal.fire({
          icon: 'error',
          title: 'Registration Failed',
          text: message
        });
      } finally {
        loading.value = false;
      }
    };

    return {
      form,
      loading,
      handleSubmit,
      predictions,
      showAutocomplete,
      businessNameInput,
      handleInput,
      selectPlace,
      handlePhoneInput,
      showCountryModal,
      countrySearch,
      selectedCountry,
      filteredCountries,
      selectCountry,
      selectedCountryFlag,
      userLocation,
      locationLoading,
      locationError,
      countryDetecting,
      getUserLocation,
      getCountryFromCoordinates,
      setCountryByCode,
      fallbackGeocoding
    }
  }
}
</script>

<style scoped>
.tenant-register {
  background: #fafafa;
}
.card {
  border-radius: 0 0 16px 16px;
  /* Only bottom corners rounded */
}
.card-top-red-line {
  height: 4px;
  background: #c62828;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
  border-bottom-left-radius: 0;
  border-bottom-right-radius: 0;
}
.input-group-text {
  background: #fff;
  border-right: 0;
}
.input-group .form-control {
  border-left: 0;
}
.btn-danger {
  background: #c62828;
  border: none;
}
.btn-danger:hover {
  background: #b71c1c;
}
.country-flag {
  width: 24px;
  height: 16px;
  object-fit: cover;
  border-radius: 2px;
  box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
}
.country-modal {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1050;
}
.country-modal-content {
  background: white;
  border-radius: 8px;
  width: 90%;
  max-width: 400px;
  max-height: 85vh;
  display: flex;
  flex-direction: column;
  box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}
.country-modal-header h5 {
  margin: 0;
  font-size: 1.1rem;
  font-weight: 500;
}
.country-item:hover {
  background-color: #f8f9fa;
}
@media (max-width: 991.98px) {
  .card-body {
    padding: 2rem 1rem !important;
  }
}
.autocomplete-results {
  position: absolute;
  z-index: 1000;
  width: 100%;
  max-height: 260px;
  overflow-y: auto;
  background: #fff;
  border: 1px solid #ddd;
  border-radius: 0 0 4px 4px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

/* Location status styles */
.location-status {
  font-size: 0.875rem;
  padding: 0.5rem;
  border-radius: 4px;
  margin-bottom: 0.5rem;
}

.location-status .btn-sm {
  padding: 0.25rem 0.5rem;
  font-size: 0.75rem;
}

.autocomplete-item {
  padding: 12px 18px;
  cursor: pointer;
  border-bottom: 1px solid #f2f2f2;
  transition: background 0.15s;
  color: #222;
}
.autocomplete-item:last-child {
  border-bottom: none;
}
.autocomplete-item:hover {
  background: #f8f9fa;
  color: #c62828;
}
</style>
