<template>
  <div class="dropdown" :style="{position}">
    
    <div @click.stop.prevent="isOpen = !isOpen" class="icon">
      <slot name="trigger">
      </slot>
    </div>
    
    <div v-show="isOpen" class="dropdown-menu">
      <slot></slot>
    </div>
    
  </div>
</template>
<script>
export default {

  props: {
    position: { default: 'relative' }
  },

  data(){
    return { isOpen: false }
  },

  methods: {
    closeIfNotFocused(event) {
      if (!event.target.closest('.dropdown')){
        this.isOpen = false;
        document.removeEventListener('click', this.closeIfNotFocused);
      }
      
    }
  },

  watch: {
     isOpen(isOpen) {
       if (isOpen){
         document.addEventListener('click', this.closeIfNotFocused);
       }
     } 
  }
  
}
</script>
<style>
  .dropdown-menu{
    position: absolute;
    width: auto;
  }

  .dropdown-menu a{
    display: block;
  }

</style>