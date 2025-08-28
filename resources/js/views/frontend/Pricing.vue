<template>
  <div class="pricing-page">
    <section class="pricing-header pt-100">
      <div class="container mt-100">
        <h1 class="text-center">Simple, Transparent Pricing</h1>
        <p class="text-center lead">Choose the plan that best fits your business needs</p>
      </div>
    </section>

    <section class="pricing-plans">
      <div class="container">
        <div class="row">
          <!-- Basic Plan -->
          <div class="col-md-4">
            <div class="pricing-card">
              <div class="pricing-header">
                <h3>Basic</h3>
                <div class="price">
                  <span class="currency">$</span>
                  <span class="amount">29</span>
                  <span class="period">/month</span>
                </div>
              </div>
              <div class="pricing-features">
                <ul>
                  <li><i class="fas fa-check"></i> Single Restaurant</li>
                  <li><i class="fas fa-check"></i> Basic Menu Management</li>
                  <li><i class="fas fa-check"></i> Order Processing</li>
                  <li><i class="fas fa-check"></i> Email Support</li>
                </ul>
              </div>
              <div class="pricing-footer">
                <router-link to="/register" class="btn btn-outline-primary">Get Started</router-link>
              </div>
            </div>
          </div>

          <!-- Professional Plan -->
          <div class="col-md-4">
            <div class="pricing-card featured">
              <div class="pricing-header">
                <h3>Professional</h3>
                <div class="price">
                  <span class="currency">$</span>
                  <span class="amount">79</span>
                  <span class="period">/month</span>
                </div>
              </div>
              <div class="pricing-features">
                <ul>
                  <li><i class="fas fa-check"></i> Up to 3 Restaurants</li>
                  <li><i class="fas fa-check"></i> Advanced Menu Management</li>
                  <li><i class="fas fa-check"></i> Order Processing</li>
                  <li><i class="fas fa-check"></i> Analytics Dashboard</li>
                  <li><i class="fas fa-check"></i> 24/7 Support</li>
                </ul>
              </div>
              <div class="pricing-footer">
                <router-link to="/register" class="btn btn-primary">Get Started</router-link>
              </div>
            </div>
          </div>

          <!-- Enterprise Plan -->
          <div class="col-md-4">
            <div class="pricing-card">
              <div class="pricing-header">
                <h3>Enterprise</h3>
                <div class="price">
                  <span class="currency">$</span>
                  <span class="amount">199</span>
                  <span class="period">/month</span>
                </div>
              </div>
              <div class="pricing-features">
                <ul>
                  <li><i class="fas fa-check"></i> Unlimited Restaurants</li>
                  <li><i class="fas fa-check"></i> Custom Features</li>
                  <li><i class="fas fa-check"></i> Priority Support</li>
                  <li><i class="fas fa-check"></i> API Access</li>
                  <li><i class="fas fa-check"></i> White Label Option</li>
                </ul>
              </div>
              <div class="pricing-footer">
                <router-link to="/register" class="btn btn-outline-primary">Contact Sales</router-link>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="faq-section">
      <div class="container">
        <h2 class="text-center mb-5">Frequently Asked Questions</h2>
        <div class="row">
          <div class="col-md-6">
            <div class="faq-item">
              <h4>Can I upgrade my plan later?</h4>
              <p>Yes, you can upgrade or downgrade your plan at any time. Changes will be reflected in your next billing cycle.</p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="faq-item">
              <h4>Is there a free trial?</h4>
              <p>Yes, all plans come with a 14-day free trial. No credit card required.</p>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
export default {
  name: 'Pricing'
}
</script>

<style scoped>
.pricing-page {
  padding-top: 60px;
}

.pricing-header {
  padding: 80px 0;
  background-color: var(--light-bg);
}

.pricing-header h1 {
  font-size: 3rem;
  color: var(--secondary-color);
  margin-bottom: 1rem;
}

.pricing-plans {
  padding: 80px 0;
}

.pricing-card {
  background: white;
  border-radius: 10px;
  box-shadow: 0 5px 15px rgba(0,0,0,0.05);
  padding: 2rem;
  height: 100%;
  transition: transform 0.3s;
}

.pricing-card:hover {
  transform: translateY(-5px);
}

.pricing-card.featured {
  border: 2px solid var(--primary-color);
  transform: scale(1.05);
}

.pricing-card.featured:hover {
  transform: scale(1.05) translateY(-5px);
}

.pricing-header h3 {
  font-size: 1.5rem;
  color: var(--secondary-color);
  margin-bottom: 1rem;
}

.price {
  font-size: 2.5rem;
  color: var(--primary-color);
  margin-bottom: 2rem;
}

.price .currency {
  font-size: 1.5rem;
  vertical-align: super;
}

.price .period {
  font-size: 1rem;
  color: #666;
}

.pricing-features {
  margin-bottom: 2rem;
}

.pricing-features ul {
  list-style: none;
  padding: 0;
  margin: 0;
}

.pricing-features li {
  margin-bottom: 1rem;
  display: flex;
  align-items: center;
}

.pricing-features i {
  color: var(--primary-color);
  margin-right: 0.5rem;
}

.pricing-footer {
  text-align: center;
}

.faq-section {
  padding: 80px 0;
  background-color: var(--light-bg);
}

.faq-item {
  margin-bottom: 2rem;
}

.faq-item h4 {
  color: var(--secondary-color);
  margin-bottom: 1rem;
}

@media (max-width: 991.98px) {
  .pricing-card.featured {
    transform: none;
    margin: 2rem 0;
  }

  .pricing-card.featured:hover {
    transform: translateY(-5px);
  }
}
</style>