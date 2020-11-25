<template>
  <button @click.stop.prevent="activeState"
    class="switchAdd">+ Add new category</button>
  <form id="addCategory" :class="{ active: isActive }">
    <span class="text-error"
      v-if="form.errors.name"
      v-text="form.errors.name[0]"></span>
    <input name="name" 
      type="text" 
      v-model="form.name" 
      :class="form.errors.name ? 'input-error' : ''"/>
    <input type="hidden" value="ajax" />
    <button @click.stop.prevent="submit">Add</button>
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
        })
      }
    },
    methods: {
      
      async submit(){
      
        this.form.submit('/categories')
          .then(response => {
            if (!!response.data.success) location.reload();
          })
          .catch(error => console.log(error));

      },

      activeState(){

        if (!this.isActive) {
          this.isActive = true;
          return;
        }

        this.isActive = false;
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