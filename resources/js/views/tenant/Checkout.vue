<template>
  <div class="container mt-100">
    <div class="checkout-page container py-4">
      <div class="row">
        <div class="col-lg-8 mb-4">
          <!-- Stepper -->
          <div class="checkout-steps mb-4 d-flex flex-wrap justify-content-between">
            <div v-for="(step, idx) in steps" :key="step.key" class="checkout-step flex-fill text-center mb-2" :class="{active: currentStep === idx, done: idx < currentStep}">
              <span class="step-index">{{ idx + 1 }}</span>
              <span class="step-title">{{ step.title }}</span>
            </div>
          </div>
          <!-- Step Content -->
          <div class="checkout-step-content p-4 bg-white rounded shadow-sm mb-3">
            <!-- Delivery Address -->
            <form v-if="currentStep === 0" @submit.prevent="nextStep">
              <h4 class="mb-3">Delivery Address</h4>
              <div class="row g-3">
                <div class="col-md-6 col-12">
                  <label class="form-label">First Name*</label>
                  <input v-model="address.firstName" class="form-control" required />
                </div>
                <div class="col-md-6 col-12">
                  <label class="form-label">Last Name*</label>
                  <input v-model="address.lastName" class="form-control" required />
                </div>
                <div class="col-md-6 col-12">
                  <label class="form-label">Email*</label>
                  <input v-model="address.email" type="email" class="form-control" required />
                </div>
                <div class="col-md-6 col-12">
                  <label class="form-label">Phone*</label>
                  <input v-model="address.phone" class="form-control" type="tel" pattern="[0-9\-\+\s]*" inputmode="tel" required />
                </div>
                <div class="col-12">
                  <label class="form-label">Address*</label>
                  <textarea v-model="address.address" class="form-control" required></textarea>
                </div>
              </div>
              <div class="d-flex justify-content-end mt-4">
                <button class="btn btn-danger w-100 w-md-auto" type="submit">Next</button>
              </div>
            </form>
            <!-- Delivery Method -->
            <form v-else-if="currentStep === 1" @submit.prevent="nextStep">
              <h4 class="mb-3">Delivery Method</h4>
              <div class="form-check mb-2">
                <input class="form-check-input" type="radio" id="free" value="free" v-model="deliveryMethod" required />
                <label class="form-check-label" for="free">
                  <b>Free Delivery</b> 0.00 / Delivery in 7 to 14 business Days
                </label>
              </div>
              <div class="d-flex justify-content-between mt-4">
                <button class="btn btn-secondary w-50 me-2" type="button" @click="prevStep">Back</button>
                <button class="btn btn-danger w-50" type="submit">Next</button>
              </div>
            </form>
            <!-- Order Review & Confirmation -->
            <div v-else-if="currentStep === 2">
              <template v-if="!orderPlaced">
                <h4 class="mb-3">Order Review</h4>
                <div class="mb-3">
                  <b>Delivery Address:</b>
                  <div>{{ address.firstName }} {{ address.lastName }}, {{ address.email }}, {{ address.phone }}</div>
                  <div>{{ address.address }}</div>
                </div>
                <div class="mb-3">
                  <b>Delivery Method:</b> {{ deliveryMethodLabel }}
                </div>
                <div class="mb-3">
                  <b>Shopping Cart:</b>
                  <table class="table table-sm">
                    <thead>
                      <tr>
                        <th>Name</th><th>Unit Price</th><th>Quantity</th><th>Total</th></tr></thead>
                    <tbody>
                      <tr v-for="item in cart.cart.items" :key="item.id">
                        <td>{{ item.name }}</td>
                        <td>{{ settings.currency_symbol || '$' }}&nbsp;{{ item.price }}</td>
                        <td>{{ item.quantity }}</td>
                        <td>{{ settings.currency_symbol || '$' }}&nbsp;{{ (item.price * item.quantity).toFixed(2) }}</td>
                      </tr>
                    </tbody>
                  </table>
                  <div class="d-flex justify-content-end">
                    <div>
                      <div>SubTotal: {{ settings.currency_symbol || '$' }}&nbsp;{{ subtotal.toFixed(2) }}</div>
                      <div>Discount: {{ settings.discount }}%</div>
                      <div class="fw-bold">Grand total: {{ settings.currency_symbol || '$' }}&nbsp;{{ grandTotal.toFixed(2) }}</div>
                    </div>
                  </div>
                </div>
                <div class="d-flex justify-content-between mt-4 flex-wrap">
                  <button class="btn btn-secondary w-50 me-2 mb-2 mb-md-0" type="button" @click="prevStep">Back</button>
                  <button class="btn btn-danger w-50" @click="placeOrder">Place Order Now</button>
                </div>
              </template>
              <template v-else>
                <div class="text-center py-5">
                  <h3 class="mb-3 text-success">Thank You!</h3>
                  <p>Your order has been processed.</p>
                  <button class="btn btn-danger mt-3" @click="goToShop">Return to Shop</button>
                </div>
              </template>
            </div>
          </div>
        </div>
        <!-- Order Summary Sidebar -->
        <div class="col-lg-4">
          <div class="order-summary bg-white rounded shadow-sm p-3 mb-4">
            <h5 class="mb-3"><i class="fas fa-list-alt me-2"></i>Order Summary</h5>
            <div v-if="cart.cart.items.length">
              <div v-for="item in cart.cart.items" :key="item.id" class="d-flex align-items-center mb-2">
                <div class="ms-2 flex-grow-1">
                  <div>{{ item.name }}</div>
                  <div class="text-muted" style="font-size:0.95em;">{{ settings.currency_symbol || '$' }}&nbsp;{{ item.price }} x {{ item.quantity }}</div>
                </div>
                <div class="fw-bold">{{ settings.currency_symbol || '$' }}&nbsp;{{ (item.price * item.quantity).toFixed(2) }}</div>
              </div>
              <div class="border-top pt-2 mt-2">
                <div class="d-flex justify-content-between"><span>SubTotal:</span><span>{{ settings.currency_symbol || '$' }}&nbsp;{{ subtotal.toFixed(2) }}</span></div>
                <div class="d-flex justify-content-between"><span>Discount:</span><span>{{ settings.discount }}%</span></div>
                <div class="d-flex justify-content-between fw-bold"><span>Grand total:</span><span>{{ settings.currency_symbol || '$' }}&nbsp;{{ grandTotal.toFixed(2) }}</span></div>
              </div>
            </div>
            <div v-else class="text-muted text-center py-4">
              Your Cart Is Currently Empty!
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, inject, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { useCart } from '../../composables/useCart'
import axios from 'axios'
import Swal from 'sweetalert2'

const cart = inject('cart', useCart())
const router = useRouter()

const steps = [
  { key: 'address', title: 'Delivery Address' },
  { key: 'delivery', title: 'Delivery Method' },
  { key: 'review', title: 'Order Review' }
]
const currentStep = ref(0)
const orderPlaced = ref(false)

const address = ref({
  firstName: '', lastName: '', middleName: '', company: '', email: '', phone: '', country: '', city: '', place: '', postalCode: '', address: ''
})
const deliveryMethod = ref('free')
const paymentMethod = ref('credit')
const payment = ref({ cardName: '', cardNumber: '', expMonth: '', expYear: '', cvv: '' })

const settings = ref({ currency: 'USD', discount: 0 })

onMounted(async () => {
  // Try to load from sessionStorage first
  const cached = sessionStorage.getItem('tenant_settings')
  if (cached) {
    try {
      settings.value = JSON.parse(cached)
    } catch {}
  }
  // Always fetch latest from API
  try {
    const response = await axios.get('/tenant/get-tenant-details')
    if (response.data.success && response.data.data) {
      // Set both code and symbol from API
      settings.value.currency_symbol = response.data.data.currency_symbol || '$'
      settings.value.discount = response.data.data.discount || 0
      sessionStorage.setItem('tenant_settings', JSON.stringify(settings.value))
    }
  } catch {}
})

const deliveryMethodLabel = computed(() => {
  switch (deliveryMethod.value) {
    case 'free': return 'Free Delivery (0.00, 7-14 days)'
    case 'standard': return 'Standard Delivery (7.99, 5-7 days)'
    case 'express': return 'Express Delivery (29.99, 1 day)'
    default: return ''
  }
})

const subtotal = computed(() => cart.cart.items.reduce((sum, item) => sum + item.price * item.quantity, 0))
const discountAmount = computed(() => subtotal.value * (settings.value.discount / 100))
const grandTotal = computed(() => subtotal.value - discountAmount.value)

function nextStep() {
  if (currentStep.value < steps.length - 1) currentStep.value++
}
function prevStep() {
  if (currentStep.value > 0) currentStep.value--
}
async function placeOrder() {
  try {
    // 1. Gather customer info
    const customer = {
      name: address.value.firstName + ' ' + (address.value.lastName || ''),
      email: address.value.email,
      address: address.value.address,
      phone: address.value.phone,
      device_info: navigator.userAgent,
      status: 'active'
    };
    // 2. Gather order info
    const order = {
      total_amount: grandTotal.value,
      status: 'pending',
      delivery_address: address.value.address,
      currency_symbol: settings.value.currency_symbol || '$'
    };
    // 3. Gather order details
    const order_details = cart.cart.items.map(item => ({
      product_id: item.id,
      quantity: item.quantity,
      price: item.price
    }));
    // 4. Send to API
    const response = await axios.post('/tenant/save-order', {
      customer,
      order,
      order_details
    });
    // 5. Handle response
    if (response.data.success) {
      // Show star rating prompt
      await Swal.fire({
        title: 'Thank you!',
        text: 'Please rate your experience.',
        icon: 'success',
        html: `<div id='swal-stars' style='font-size:2rem; color: #f6c700; display: flex; justify-content: center;'>
          <i class='fa fa-star' data-value='1'></i>
          <i class='fa fa-star' data-value='2'></i>
          <i class='fa fa-star' data-value='3'></i>
          <i class='fa fa-star' data-value='4'></i>
          <i class='fa fa-star' data-value='5'></i>
        </div>`,
        showConfirmButton: true,
        confirmButtonText: 'Submit',
        didOpen: () => {
          let selected = 5;
          const stars = Swal.getHtmlContainer().querySelectorAll('.fa-star');
          stars.forEach((star, idx) => {
            star.addEventListener('mouseenter', () => {
              stars.forEach((s, i) => s.style.color = i <= idx ? '#f6c700' : '#ccc');
            });
            star.addEventListener('mouseleave', () => {
              stars.forEach((s, i) => s.style.color = i < selected ? '#f6c700' : '#ccc');
            });
            star.addEventListener('click', () => {
              selected = idx + 1;
              stars.forEach((s, i) => s.style.color = i < selected ? '#f6c700' : '#ccc');
              Swal.setInputValue(selected);
            });
          });
          Swal.setInputValue(selected);
        },
        preConfirm: () => {
          return Swal.getInput().value;
        },
        input: 'hidden',
        inputValue: 5
      });
      cart.clearCart();
      orderPlaced.value = true;
    } else {
      throw new Error(response.data.message || 'Order not saved');
    }
  } catch (error) {
    Swal.fire({
      icon: 'error',
      title: 'Order Failed',
      text: error.message || 'Could not save your order. Please try again.'
    });
  }
}
function goToShop() {
  router.push({ name: 'tenant-landing' })
}
</script>

<style scoped>
.checkout-page {
  background: #f8f9fa;
}
.checkout-steps {
  display: flex;
  gap: 1.5rem;
  margin-bottom: 2rem;
  flex-wrap: wrap;
}
.checkout-step {
  display: flex;
  flex-direction: column;
  align-items: center;
  opacity: 0.5;
  transition: opacity 0.2s;
  min-width: 100px;
}
.checkout-step.active {
  opacity: 1;
  font-weight: bold;
}
.checkout-step.done {
  opacity: 0.8;
}
.step-index {
  background: #c62828;
  color: #fff;
  border-radius: 50%;
  width: 32px;
  height: 32px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.1rem;
  margin-bottom: 0.3rem;
}
.checkout-step-title {
  font-size: 1rem;
}
.checkout-step-content {
  min-height: 350px;
}
.order-summary {
  min-width: 260px;
}
@media (max-width: 991.98px) {
  .checkout-page .row {
    flex-direction: column;
  }
  .order-summary {
    margin-top: 2rem;
    min-width: 100%;
  }
}
@media (max-width: 767.98px) {
  .checkout-step {
    min-width: 80px;
    font-size: 0.95rem;
  }
  .checkout-step-content {
    padding: 1rem !important;
  }
  .order-summary {
    padding: 1rem !important;
  }
}
</style>

