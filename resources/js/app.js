require('./bootstrap');
require('alpinejs');

window.Vue = require('vue');

import { createApp } from 'vue';
import categoryForm from './components/categoryForm.vue';
import dropdown from './components/Dropdown.vue';


createApp({
  components: {
    categoryForm,
    dropdown
  }
}).mount('#rss_app');
