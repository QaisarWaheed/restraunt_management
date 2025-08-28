<template>
  <div class="mt-5 login-page d-flex align-items-center justify-content-center min-vh-100 bg-light">
    <div class="login-card d-flex flex-row shadow  overflow-hidden bg-white">
      <!-- Left: Image -->
      <div class="login-image d-none d-md-block">
        <img src="/Mox_files/login.jpg" alt="Login Food" class="img-fluid h-100 w-100" style="object-fit: cover; min-width: 320px; min-height: 350px;" />
      </div>
      <!-- Right: Form -->
      <div class="login-form login-card-inner p-4 p-md-5 d-flex flex-column justify-content-center">
        <h2 class="text-center mb-2 login-title">{{ $t('auth.login.title') }}</h2>
      <!--  <div class="text-center mb-3 login-subtext">Don't have an account? <a href="#" class="login-link">Sign up now!</a></div> -->
      <div class="text-center mb-3 login-subtext">{{ $t('welcomeBack') || 'Welcome!' }}</div>
        <form @submit.prevent="handleLogin">
          <div class="mb-3">
            <div class="input-group">
              <span class="input-group-text bg-white"><i class="material-icons text-muted">person</i></span>
              <input type="text" class="form-control" :placeholder="$t('auth.login.email')" v-model="username" required />
            </div>
          </div>
          <div class="mb-3">
            <div class="input-group">
              <span class="input-group-text bg-white"><i class="material-icons text-muted">lock</i></span>
              <input :type="showPassword ? 'text' : 'password'" class="form-control" :placeholder="$t('auth.login.password')" v-model="password" required />
              <span class="input-group-text bg-white" style="cursor:pointer;" @click="showPassword = !showPassword">
                <i class="material-icons text-muted">{{ showPassword ? 'visibility_off' : 'visibility' }}</i>
              </span>
            </div>
          </div>
          <div class="d-flex align-items-center mb-3">
            <input type="checkbox" id="keepSignedIn" v-model="keepSignedIn" class="form-check-input me-2" />
            <label for="keepSignedIn" class="form-check-label small">{{ $t('auth.login.remember') }}</label>
          </div>
          <button type="submit" class="btn btn-success w-100 fw-bold mb-3 login-btn">{{ $t('auth.login.submit') }}</button>
        </form>
        <!-- <div class="d-flex align-items-center my-3">
          <hr class="flex-grow-1" />
          <span class="mx-2 login-or">or Sign in with one click</span>
          <hr class="flex-grow-1" />
        </div>
        <div class="d-flex justify-content-center gap-3 mb-3">
          <button class="btn btn-light shadow-sm rounded-circle p-2 login-social"><i class="fab fa-facebook-f text-danger"></i></button>
          <button class="btn btn-light shadow-sm rounded-circle p-2 login-social"><i class="fab fa-twitter text-danger"></i></button>
          <button class="btn btn-light shadow-sm rounded-circle p-2 login-social"><i class="fab fa-google text-danger"></i></button>
        </div> -->
        <div class="text-end mt-2">
          <a href="#" class="login-reset"><i class="material-icons align-middle" style="font-size: 1.1em;">key</i> {{ $t('auth.login.forgot') }}</a>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'
import Swal from 'sweetalert2'

const username = ref('')
const password = ref('')
const showPassword = ref(false)
const keepSignedIn = ref(false)
const router = useRouter()
const loading = ref(false)
const error = ref('')

async function handleLogin() {
  error.value = ''
  loading.value = true
  try {


    const response = await axios.post('/tenant/login', {
      email: username.value,
      password: password.value,
    })
    const token = response.data.token
    localStorage.setItem('token', token)
    axios.defaults.headers.common['Authorization'] = `Bearer ${token}`

    // Set axios default authorization header
    // axios.defaults.headers.common['Authorization'] = `Bearer ${response.data.token}`

    await Swal.fire({
      icon: 'success',
      title: 'Login Successful',
      text: 'Welcome back!',
      timer: 1500,
      showConfirmButton: false,
      position: 'top-end',
      toast: true
    })
    router.push('/dashboard/home')
  } catch (err) {
    error.value = err.response?.data?.message || 'Login failed. Please check your credentials.'
    Swal.fire({
      icon: 'error',
      title: 'Login Failed',
      text: error.value,
      confirmButtonColor: '#dc3545'
    })
  } finally {
    loading.value = false
  }
}
</script>

<style scoped>
.login-page {
  background: #f8f9fa;
}
.login-card {
  min-width: 1000px;
  max-width: 900px;
  min-height: 350px;
  background: #fff;
}
.login-image {
  width: 500px;
  min-height: 350px;
  background: #eee;
}
.login-form {
  flex: 1 1 0%;
  background: #fff;
  border: 1px solid #eee;
  border-radius: 12px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.07);
  min-width: 500px;
  max-width: 500px;
  align-items: center;
}
.input-group-text {
  background: #fff;
  border-right: 0;
  border-radius: 6px 0 0 6px;
}
.form-control {
  border-left: 0;
  border-radius: 0 6px 6px 0;
  box-shadow: none;
}
.btn-success {
  background: #388e3c;
  border: none;
}
.btn-success:hover {
  background: #2e7031;
  border: none;
}
.btn-light {
  background: #fff;
  border: 1px solid #eee;
}
.btn-light:hover {
  background: #f5f5f5;
}
@media (max-width: 991.98px) {
  .login-card {
    flex-direction: column;
    min-width: 320px;
    max-width: 95vw;
  }
  .login-image {
    width: 100%;
    min-height: 180px;
    max-height: 220px;
  }
}
/* Login Card Inner Styling */
.login-card-inner {
  background: #fff;
  border: 1px solid #e0e0e0;
  border-radius: 8px;
  box-shadow: 0 2px 12px rgba(0,0,0,0.07);
  min-width: 500px;
  max-width: 500px;
  margin: 0 auto;
}
.login-title {
  font-family: 'Playfair Display', serif;
  font-weight: bold;
  color: #222;
  font-size: 2rem;
}
.login-subtext {
  color: #388e3c;
  font-size: 1rem;
}
.login-link {
  color: #388e3c;
  text-decoration: none;
  font-weight: 500;
}
.login-link:hover {
  text-decoration: underline;
}
.login-btn {
  background: #43a047;
  border-color: #43a047;
  border-radius: 4px;
  font-weight: 600;
  font-size: 1.05rem;
}
.login-btn:hover {
  background: #388e3c;
  border-color: #388e3c;
}
.login-or {
  color: #888;
  font-size: 0.97rem;
}
.login-social {
  background: #fff;
  border: 1px solid #eee;
  transition: box-shadow 0.2s;
}
.login-social:hover {
  box-shadow: 0 2px 8px rgba(67,160,71,0.12);
}
.login-reset {
  color: #444;
  font-size: 0.97rem;
  text-decoration: none;
  transition: color 0.2s;
}
.login-reset:hover {
  color: #43a047;
  text-decoration: underline;
}
</style>
