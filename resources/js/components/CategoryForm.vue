<template>
  <span @click="isActive = true"
    class="switchAdd">+ Add new category</span>
  <form id="addCategory" :class="{ active: isActive }">
    <span class="text-error"
      v-if="errors.name"
      v-text="errors.name[0]"></span>
    <input name="name" 
      type="text" 
      v-model="form.name" 
      :class="errors.name ? 'input-error' : ''"/>
    <button @click.stop.prevent="addCategory">Add</button>
  </form>
</template>
<script>
import QuickAccessForm from './QuickAccessForm';

  export default {
    data() {
      return {
        isActive: false,
        form: new QuickAccessForm({
          name: ''
        }),
        errors: {

        }
      }
    },
    methods: {
      addCategory(){
      
        this.form.submit('/categories');

      }
    }
  }
</script>
<style>
  #addCategory{
    display: none;
  }

  #addCategory.active{
    display: block;
  }

  .switchAdd{
    cursor: pointer;
  }
</style>