<template>
  <div class="privacy-page mt-100 mb-100">
    <div class="container py-5">
      <h1 class="mb-4">{{ $t('privacy.title') }}</h1>
      <p class="lead mb-5">{{ $t('privacy.lastUpdated') }}</p>

      <div class="policy-section mb-5">
        <h2 class="mb-4">{{ $t('privacy.section1Title') }}</h2>
        <p>{{ $t('privacy.section1Intro') }}</p>
        <ul>
          <li>{{ $t('privacy.section1Item1') }}</li>
          <li>{{ $t('privacy.section1Item2') }}</li>
          <li>{{ $t('privacy.section1Item3') }}</li>
          <li>{{ $t('privacy.section1Item4') }}</li>
        </ul>
      </div>

      <div class="policy-section mb-5">
        <h2 class="mb-4">{{ $t('privacy.section2Title') }}</h2>
        <p>{{ $t('privacy.section2Intro') }}</p>
        <ul>
          <li>{{ $t('privacy.section2Item1') }}</li>
          <li>{{ $t('privacy.section2Item2') }}</li>
          <li>{{ $t('privacy.section2Item3') }}</li>
          <li>{{ $t('privacy.section2Item4') }}</li>
          <li>{{ $t('privacy.section2Item5') }}</li>
        </ul>
      </div>

      <div class="policy-section mb-5">
        <h2 class="mb-4">{{ $t('privacy.section3Title') }}</h2>
        <p>{{ $t('privacy.section3Intro') }}</p>
        <ul>
          <li>{{ $t('privacy.section3Item1') }}</li>
          <li>{{ $t('privacy.section3Item2') }}</li>
          <li>{{ $t('privacy.section3Item3') }}</li>
        </ul>
      </div>

      <div class="policy-section mb-5">
        <h2 class="mb-4">{{ $t('privacy.section4Title') }}</h2>
        <p>{{ $t('privacy.section4Intro') }}</p>
        <ul>
          <li>{{ $t('privacy.section4Item1') }}</li>
          <li>{{ $t('privacy.section4Item2') }}</li>
          <li>{{ $t('privacy.section4Item3') }}</li>
          <li>{{ $t('privacy.section4Item4') }}</li>
        </ul>
      </div>

      <div class="policy-section mb-5">
        <h2 class="mb-4">{{ $t('privacy.section5Title') }}</h2>
        <p>{{ $t('privacy.section5Intro') }}</p>
        <ul>
          <li>{{ $t('privacy.section5Item1') }}</li>
          <li>{{ $t('privacy.section5Item2') }}</li>
          <li>{{ $t('privacy.section5Item3') }}</li>
          <li>{{ $t('privacy.section5Item4') }}</li>
        </ul>
      </div>

      <div class="policy-section">
        <h2 class="mb-4">{{ $t('privacy.section6Title') }}</h2>
        <p>{{ $t('privacy.section6Intro') }}</p>
        <ul>
          <li>{{ $t('privacy.email') }}: {{ contactEmail }}</li>
          <li>{{ $t('privacy.phone') }}: {{ contactPhone }}</li>
          <li>{{ $t('privacy.address') }}: {{ contactAddress }}</li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script setup>
import { contactEmail, contactPhone, contactAddress } from '../../utils/contact.js'
</script>

<style scoped>


h1 {
  color: #333;
  font-weight: 600;
}

.lead {
  color: #666;
}

.policy-section h2 {
  color: #333;
  font-size: 1.5rem;
  font-weight: 600;
}

.policy-section p {
  color: #666;
  line-height: 1.6;
}

.policy-section ul {
  color: #666;
  padding-left: 1.5rem;
}

.policy-section li {
  margin-bottom: 0.5rem;
}
</style>
