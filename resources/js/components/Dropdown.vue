<template>
  <div class="dropdown" :style="{position}">
    
    <div @click.prevent="isOpen = !isOpen" class="icon">
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