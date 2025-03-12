<template>
  <BContainer fluid class="vh-100">
    <BRow class="h-100">
      <LeftSidebar />
      <BCol>
        <BCard>
          <router-view />
        </BCard>
      </BCol>
    </BRow>
  </BContainer>
</template>

<script lang="ts" setup>
import LeftSidebar from '@/views/user/LeftSidebar.vue'
</script>

<style scoped></style>
