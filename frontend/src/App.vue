<template>
  <Navbar />
  <div class="m-3">
    <RouterView></RouterView>
  </div>
</template>
<script setup lang="ts">
import Navbar from '@/components/Navbar.vue'
import { useAuthStore } from '@/stores/authStore'
import { onMounted } from 'vue'
import VueCookies from 'vue-cookies'

const authStore = useAuthStore()

onMounted(async () => {
  if (VueCookies.get('auth_token')) {
    await authStore.fetchUser()
  } else {
    authStore.logout()
  }
})
</script>
