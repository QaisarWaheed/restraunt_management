// ... existing code ...
<template>
  <div class="contact-banner-section">
    <div class="contact-banner-bg">
      <div class="contact-banner-overlay"></div>
      <div class="contact-banner-content text-center">
        <h1 class="mt-2 mb-2" style="font-family: 'Playfair Display', serif; ">{{ $t('reservation.title') }}</h1>
        <div class=" mb-3">{{ $t('reservation.subtitle') }}</div>
      </div>
    </div>
    <div class="container contact-card-container">
      <div class="contact-card mx-auto">
        <div class="row g-0 align-items-stretch">

          <div class="col-md-12 p-4 d-flex flex-column justify-content-center">
            <section class="reservation-section">
              <div class="container">
                <div class="reservation-card mx-auto">
                  <div class="text-center reservation-title mb-4">{{ $t('reservation.formTitle') }}</div>
                  <form @submit.prevent="handleReservation" autocomplete="off">
                    <div class="row g-3 mb-3">
                      <div class="col-md-4">
                        <div class="input-group">
                          <input type="text" class="form-control" v-model="reservation.full_name" required
                            :placeholder="$t('reservation.fullName')" id="reservationFullName" :disabled="reservationLoading"
                            data-bs-toggle="tooltip" :title="$t('reservation.fullNameTip')">
                          <span class="input-group-text"><i class="fas fa-user"></i></span>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="input-group">
                          <input type="text" class="form-control" v-model="reservation.phone_number" required
                            :placeholder="$t('reservation.phoneNumber')" id="reservationPhone" :disabled="reservationLoading"
                            data-bs-toggle="tooltip" :title="$t('reservation.phoneNumberTip')">
                          <span class="input-group-text"><i class="fas fa-phone"></i></span>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="input-group">
                          <input type="email" class="form-control" v-model="reservation.email" required
                            :placeholder="$t('reservation.email')" id="reservationEmail" :disabled="reservationLoading"
                            data-bs-toggle="tooltip" :title="$t('reservation.emailTip')">
                          <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="input-group">
                          <input type="date" class="form-control" v-model="reservation.date" required
                            :placeholder="$t('reservation.date')" id="reservationDate" :disabled="reservationLoading"
                            data-bs-toggle="tooltip" :title="$t('reservation.dateTip')">
                          <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="input-group">
                          <input type="time" class="form-control" v-model="reservation.time" required
                            :placeholder="$t('reservation.time')" id="reservationTime" :disabled="reservationLoading"
                            data-bs-toggle="tooltip" :title="$t('reservation.timeTip')">
                          <span class="input-group-text"><i class="fas fa-clock"></i></span>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="input-group">
                          <input type="number" min="1" class="form-control" v-model="reservation.guests" required
                            :placeholder="$t('reservation.guests')" id="reservationGuests" :disabled="reservationLoading"
                            data-bs-toggle="tooltip" :title="$t('reservation.guestsTip')">
                          <span class="input-group-text"><i class="fas fa-users"></i></span>
                        </div>
                      </div>
                    </div>
                    <div class="mb-3">
                      <textarea class="form-control" v-model="reservation.message" rows="3" required
                        :placeholder="$t('reservation.message')" id="reservationMessage" :disabled="reservationLoading"
                        data-bs-toggle="tooltip" :title="$t('reservation.messageTip')"></textarea>
                    </div>
                    <div class="d-grid mb-2">
                      <button type="submit" class="btn btn-danger" :disabled="reservationLoading">
                        <span v-if="reservationLoading"><span
                            class="spinner-border spinner-border-sm me-2"></span>{{ $t('reservation.processing') }}</span>
                        <span v-else>{{ $t('reservation.submit') }}</span>
                      </button>
                    </div>
                  </form>
                  <!-- <div class="reservation-callout text-center mt-3">
                    <span>You can also call: <span class="text-danger fw-bold">(+100) 123 456 7890</span> to make a
                      reservation</span>
                  </div> -->
                </div>
              </div>
            </section>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue'
import Swal from 'sweetalert2'
import axios from 'axios'
import { Tooltip } from 'bootstrap'
// import { useReCaptcha, VueReCaptcha } from 'vue-recaptcha-v3'

// const recaptchaSiteKey = 'YOUR_RECAPTCHA_SITE_KEY' // <-- Replace with your real site key
// const { executeRecaptcha } = useReCaptcha()

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

onMounted(() => {
  document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
    new Tooltip(el)
  })
})
</script>

<style scoped>
.contact-banner-section {
  min-height: 100vh;
  background: #f8f9fa;
  position: relative;
}

.contact-banner-bg {
  background: url('/Mox_files/reservation.jpg') center center/cover no-repeat;
  min-height: 420px;
  position: relative;
  width: 100vw;
  max-width: 100%;
}

.contact-banner-overlay {
  position: absolute;
  inset: 0;
  background: #000000b3;
  z-index: 1;
}

.contact-banner-content {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  z-index: 2;
  color: #fff;
  width: 100%;
}

.contact-card-container {
  position: relative;
  top: -120px;
  z-index: 3;
  margin-bottom: -80px;
}

.contact-card {
  background: #fff;
  border-radius: 18px;
  box-shadow: 0 6px 32px rgba(0, 0, 0, 0.18);
  padding: 0;
  max-width: 900px;
  margin: 0 auto;
  border: 2px solid #c62828;
}

.contact-form label {
  font-weight: 500;
  color: #c62828;
}

.contact-form .form-control:focus {
  border-color: #c62828;
  box-shadow: 0 0 0 0.15rem rgba(198, 40, 40, 0.12);
}

.btn-danger {
  background: #c62828;
  border: none;
  font-weight: bold;
  letter-spacing: 1px;
}

.btn-danger:hover {
  background: #b71c1c;
}

.footer-social a {
  color: #c62828;
  font-size: 1.3rem;
  background: rgba(255, 255, 255, 0.08);
  border-radius: 50%;
  width: 36px;
  height: 36px;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: background 0.2s, color 0.2s;
}

.footer-social a:hover {
  background: #c62828;
  color: #fff;
}

@media (max-width: 991.98px) {
  .contact-card {
    max-width: 98vw;
  }

  .contact-card-container {
    top: -80px;
    margin-bottom: -40px;
  }
}

@media (max-width: 767.98px) {
  .contact-banner-content h1 {
    font-size: 2.2rem;
  }

  .contact-card {
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.10);
  }

  .contact-card-container {
    top: -40px;
    margin-bottom: 0;
  }
}

.reservation-title {
  font-family: 'Playfair Display', serif;
  /* font-weight: bold; */
  color: #222;
  font-size: 1.08rem;
  margin-bottom: 0.5rem;
  border-bottom: 3px solid #c62828;
  /* display: inline-block; */
  padding-bottom: 0.2rem;
}
</style>
