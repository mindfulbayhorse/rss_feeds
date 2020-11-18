require('./bootstrap');

window.Vue = require('vue');

import { createApp } from 'vue';
import categoryForm from './components/categoryForm.vue';


createApp({
  components: {
    categoryForm,
  }
}).mount('#app');
