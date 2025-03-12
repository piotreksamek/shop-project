<template>
  <BContainer fluid>
    <BRow class="flex-nowrap">
      <BButton
        v-if="!isSidebarVisible"
        class="menu-button d-md-none"
        variant="primary"
        @click="isSidebarVisible = true"
      >
        ☰ Menu
      </BButton>

      <LeftSidebar v-if="isSidebarVisible" class="sidebar d-none d-md-block d-lg-block"/>

      <BCol
        :md="isSidebarVisible ? 9 : 12"
        class="content-area"
      >
        <BRow>
          <div v-if="isLoading" class="loading-container">
            <BSpinner variant="secondary" label="Ładowanie..."></BSpinner>
          </div>

          <BCol
            v-else
            v-for="(product, index) in products"
            :key="product.id"
            cols="12" md="6" lg="4" xl="3"
            class="mb-4 d-flex flex-column"
          >
            <div
              class="product-image-wrapper"
              @mouseenter="showArrowsForProduct[index] = true"
              @mouseleave="showArrowsForProduct[index] = false"
            >
              <router-link :to="`/product/${product.id}`">
              <img
                v-if="product.images && product.images.length > 0"
                :src="getImageUrl(product.images[currentImageIndex[index]].path)"
                alt="Product Image"
                class="img-fluid product-image"
              />
              </router-link>
              <div v-if="showArrowsForProduct[index]" class="arrow-buttons">
                <button @click="prevImage(index)" class="arrow-button left">
                  ←
                </button>
                <button @click="nextImage(index)" class="arrow-button right">
                  →
                </button>
              </div>
            </div>
            <h4 class="product-name text-center">{{ product.name }}</h4>
            <h5 class="product-name mb-2 text-center">120.20zł</h5>
            <BButton variant="primary">Dodaj do koszyka</BButton>
          </BCol>
        </BRow>
      </BCol>
    </BRow>
  </BContainer>
</template>

<script lang="ts" setup>
import { getProductsList } from "@/api/product";
import LeftSidebar from "@/views/product/list/LeftSidebar.vue";
import { onMounted, ref } from "vue";

const products = ref([]);
const isLoading = ref<boolean>(true);
const isSidebarVisible = ref<boolean>(window.innerWidth >= 768);
const showArrowsForProduct = ref<boolean[]>([]);
const currentImageIndex = ref<number[]>([]);

function getImageUrl(path: string): string {
  return `${import.meta.env.VITE_APP_BASE_URL}${path}`;
}

async function getProducts() {
  try {
    let response = await getProductsList();
    products.value = response;
    showArrowsForProduct.value = Array(products.value.length).fill(false);
    currentImageIndex.value = Array(products.value.length).fill(0);
  } catch (err) {
    console.error("Błąd podczas pobierania produktów:", err);
  } finally {
    isLoading.value = false;
  }
}

function prevImage(index: number) {
  if (currentImageIndex.value[index] > 0) {
    currentImageIndex.value[index]--;
  } else {
    currentImageIndex.value[index] = products.value[index].images.length - 1;
  }
}

function nextImage(index: number) {
  if (currentImageIndex.value[index] < products.value[index].images.length - 1) {
    currentImageIndex.value[index]++;
  } else {
    currentImageIndex.value[index] = 0;
  }
}

window.addEventListener("resize", () => {
  isSidebarVisible.value = window.innerWidth >= 768;
});

onMounted(() => {
  getProducts();
});
</script>

<style scoped>
.left-sidebar {
  height: 50vh;
  overflow-y: auto;
}

.product-image-wrapper {
  position: relative;
  width: 100%;
  padding-top: 100%;
  overflow: hidden;
  cursor: pointer;
}

.product-image {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.arrow-buttons {
  position: absolute;
  top: 50%;
  left: 0;
  right: 0;
  transform: translateY(-50%);
  display: flex;
  justify-content: space-between;
  width: 100%;
  z-index: 2;
}

.arrow-button {
  background: rgba(0, 0, 0, 0.5);
  color: white;
  border: none;
  padding: 10px;
  font-size: 18px;
  cursor: pointer;
  transition: background 0.3s;
}

.arrow-button:hover {
  background: rgba(0, 0, 0, 0.8);
}

.left {
  left: 10px;
}

.right {
  right: 10px;
}

.menu-button {
  position: absolute;
  top: 10px;
  left: 10px;
  z-index: 1000;
}

.content-area {
  padding: 20px;
}

.loading-container {
  width: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 50px 0;
}

b-card {
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  transition: transform 0.2s ease-in-out;
}

b-card:hover {
  transform: scale(1.03);
}
</style>
