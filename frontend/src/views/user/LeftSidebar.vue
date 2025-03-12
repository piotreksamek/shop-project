<template>
  <BCol cols="3" class="d-flex flex-column" style="height: 500px">
    <BNav vertical>
      <BListGroup class="mt-3">
        <BListGroupItem class="bg-secondary text-white" disabled>Panel konta</BListGroupItem>
        <BListGroupItem
          :class="{ 'fw-bold': isActive('/user/profile/setup'), 'cursor-pointer': true }"
          @click="navigate('/user/profile/setup')"
        >
          Moje dane
        </BListGroupItem>
        <BListGroupItem
          :class="{ 'fw-bold': isActive('/user/orders'), 'cursor-pointer': true }"
          @click="navigate('/user/orders')"
        >
          Zamówienia
        </BListGroupItem>

        <BListGroupItem class="bg-secondary text-white" disabled>Panel sprzedaży</BListGroupItem>
        <BListGroupItem
          :class="{ 'fw-bold': isActive('/user/product/create'), 'cursor-pointer': true }"
          @click="navigate('/user/product/create')"
        >
          Wystaw nowy produkt
        </BListGroupItem>
        <BListGroupItem
          :class="{ 'fw-bold': isActive('/user/products'), 'cursor-pointer': true }"
          @click="navigate('/user/products')"
        >
          Twoje produkty
        </BListGroupItem>
      </BListGroup>
    </BNav>
  </BCol>
</template>

<script setup lang="ts">
import { useRouter, useRoute } from 'vue-router'

const router = useRouter()
const route = useRoute()

const navigate = (path: string) => {
  if (route.path !== path) {
    router.push(path)
  }
}

const isActive = (path: string) => route.path === path
</script>

<style scoped>
.cursor-pointer {
  cursor: pointer;
}
</style>
