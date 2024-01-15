<template>
  <div class="card mb-4">

    <div class="card-body">
      <h5 class="card-title">{{ title?.substring(0, 50) + '...' }}</h5>
      <p class="card-text">{{ content?.substring(0, 200) + '...' }}</p>
    </div>

    <div class="card-footer">
      <router-link :to="`articles/${id}`" class="btn btn-primary">Read More</router-link> 
    </div>
  </div>
</template>
  
<script lang="ts">
export default {
  props: {
    id: Number,
    title: String,
    content: String
  }
}
</script>


  
  