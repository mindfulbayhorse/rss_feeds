<template>
  <span @click="isActive = true"
    class="switchAdd">+ Add new category</span>
  <form action="/categories" id="addCategory" :class="{ active: isActive }">
    <input type="text" value="" />
    <input type="submit" value="add" />
  </form>
</template>
<script>
  export default {
    data() {
      return {
        isActive: false
      }
    },
    methods: {
      addCategory(){
        alert('new category is added');
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