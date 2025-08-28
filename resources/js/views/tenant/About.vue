<template>
  <div class="about-page mt-100 mb-100">
    <div class="container py-5">
      <div class="row">
        <div class="col-lg-6 mb-4 mb-lg-0">
          <h1 class="mb-4">{{ $t('about.title') }}</h1>
          <p class="lead mb-4">
            {{ $t('about.subtitle') }}
          </p>
          <p class="mb-4">
            {{ $t('about.description') }}
          </p>
          <div class="stats row g-4 mb-4">
            <div class="col-6">
              <div class="stat-card p-3 bg-light rounded">
                <h3 class="mb-2">{{ $t('about.stat1.value') }}</h3>
                <p class="mb-0">{{ $t('about.stat1.label') }}</p>
              </div>
            </div>
            <div class="col-6">
              <div class="stat-card p-3 bg-light rounded">
                <h3 class="mb-2">{{ $t('about.stat2.value') }}</h3>
                <p class="mb-0">{{ $t('about.stat2.label') }}</p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-6">
          <img src="/mox_files/medium(2).jpg" alt="Restaurant Management" class="img-fluid rounded shadow">
        </div>
      </div>

      <div class="row mt-5">
        <div class="col-12">
          <h2 class="text-center mb-5">{{ $t('about.whyChoose') }}</h2>
        </div>
        <div class="col-md-4 mb-4">
          <div class="feature text-center">
            <i class="fas fa-rocket mb-3"></i>
            <h4>{{ $t('about.features.innovation.title') }}</h4>
            <p>{{ $t('about.features.innovation.desc') }}</p>
          </div>
        </div>
        <div class="col-md-4 mb-4">
          <div class="feature text-center">
            <i class="fas fa-headset mb-3"></i>
            <h4>{{ $t('about.features.support.title') }}</h4>
            <p>{{ $t('about.features.support.desc') }}</p>
          </div>
        </div>
        <div class="col-md-4 mb-4">
          <div class="feature text-center">
            <i class="fas fa-shield-alt mb-3"></i>
            <h4>{{ $t('about.features.reliability.title') }}</h4>
            <p>{{ $t('about.features.reliability.desc') }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
</script>

<style scoped>
.about-page {
  /* background-color: #f8f9fa; */
}

h1 {
  color: #333;
  font-weight: 600;
}

.lead {
  color: #666;
}

.stat-card {
  transition: transform 0.3s ease;
}

.stat-card:hover {
  transform: translateY(-5px);
}

.stat-card h3 {
  color: #c62828;
  font-weight: 600;
}

.feature i {
  font-size: 2.5rem;
  color: #c62828;
}

.feature h4 {
  color: #333;
  margin-bottom: 1rem;
}

.feature p {
  color: #666;
}
</style>
