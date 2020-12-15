<template>
  <a @click.stop.prevent="activeState"
    class="switchAdd">+ Add new</a>
  <form :id="unique" 
    :class="{ active: isActive }">
    <span class="text-error"
      v-if="form.errors.name"
      v-text="form.errors.name[0]"></span>
    <input name="name" 
      type="text" 
      v-model="form.name" 
      :class="form.errors.name ? 'input-error' : ''"/>
    <input type="hidden" value="ajax" />
    <button @click.stop.prevent="submit">Create</button>
  </form>
</template>
<script>
import QuickAccessForm from './QuickAccessForm';

  export default {

    props: {
      unique: {default: 'addCategory'}
    },

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
  .switchAdd{
    cursor: pointer;
  }
</style>