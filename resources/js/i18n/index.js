import { createI18n } from 'vue-i18n';
import en from './locales/en';
import de from './locales/de';

// Get the stored language or default to English
const storedLang = localStorage.getItem('language') || 'en';

const i18n = createI18n({
    legacy: false,
    locale: storedLang,
    fallbackLocale: 'en',
    messages: {
        en,
        de
    }
});

export default i18n;

// Helper function to change language
export const setLanguage = (lang) => {
    i18n.global.locale.value = lang;
    localStorage.setItem('language', lang);
    document.documentElement.lang = lang;
}; 