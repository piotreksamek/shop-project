<template>
  <div v-if="isLoading" class="loading-container">
    <BSpinner variant="secondary" label="Ładowanie..."></BSpinner>
  </div>

  <BContainer class="product-detail custom-container" v-else>
    <BRow class="justify-content-between">
      <BCol md="2" class="d-flex flex-column align-items-start">
        <div v-for="(image, index) in detail?.images" :key="index" class="thumbnail-container mb-3">
          <img
            :src="getImageUrl(image.path)"
            :alt="'Thumbnail ' + index"
            class="img-fluid small-image"
            @click="setMainImage(image.path)"
          />
        </div>
      </BCol>

      <b-col md="6" class="text-left">
        <img v-if="detail?.images?.length" :src="getImageUrl(mainImage)"
             alt="Product image" class="img-fluid large-image"/>
      </b-col>

      <BCol md="3">
        <BCard class="h-100">
          <BCardBody class="d-flex flex-column justify-content-between">
            <div>
              <h2>{{ detail?.name }}</h2>
              <p class="short-description">{{ detail?.shortDescription }}</p>
              <p class="price">200.99 zł</p>
            </div>

            <div class="d-flex flex-column justify-content-between mt-auto">
              <BButton variant="primary" class="w-75">Dodaj do koszyka</BButton>
              <div class="d-flex justify-content-between mt-2">
                <BButton variant="outline-danger" class="bi bi-heart heart-button"></BButton>
              </div>
            </div>
          </BCardBody>
        </BCard>
      </BCol>
    </BRow>

    <BCard class="mt-5">
      <b-row>
        <b-col>
          <h4>Opis produktu</h4>
          <p>{{ detail?.description }}</p>
        </b-col>
      </b-row>
    </BCard>
  </BContainer>
</template>

<script lang="ts" setup>
import { getProductDetail } from "@/api/product";
import { onMounted, ref } from "vue";
import type { ProductDetail } from "@/types/product/ProductDetail.ts";
import {useRoute} from "vue-router";

const detail = ref<ProductDetail | null>(null);
const isLoading = ref<boolean>(true);
const mainImage = ref<string>("");
const route = useRoute();

async function getDetail() {
  let response: ProductDetail | null = null;

  const productId = route.params.id;

  console.log(productId);
  try {
    response = await getProductDetail(productId);
    console.log(response);
  } catch (err) {
    console.log(err);
  } finally {
    isLoading.value = false;
    if (response) {
      detail.value = response;
      if (response.images?.length) {
        mainImage.value = response.images[0].path;
      }
    }
  }
}

function setMainImage(imagePath: string) {
  mainImage.value = imagePath;
}

function getImageUrl(path: string): string {
  return `${import.meta.env.VITE_APP_BASE_URL}${path}`;
}

onMounted(async () => {
  await getDetail();
});
</script>

<style scoped>
.large-image, .small-image {
  object-fit: cover;
  width: 100%;
  height: 100%;
}

.small-image {
  cursor: pointer;
  width: 80px;
  height: 80px;
  margin-bottom: 10px;
  border-radius: 8px;
}

.thumbnail-container {
  cursor: pointer;
  display: flex;
  justify-content: center;
  margin-bottom: 5px;
}

.b-row {
  gap: 5px;
}

.large-image {
  width: 700px;
  height: 700px;
  border-radius: 8px;
}

.short-description {
  font-size: 1.1rem;
  color: #555;
  text-align: center;
}

.price {
  font-size: 1.3rem;
  font-weight: bold;
  margin-top: 10px;
}

.bg-white {
  background-color: #fff;
}

.b-card {
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.b-card-body {
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  padding: 20px;
}

.custom-container {
  max-width: 1800px;
  margin: 0 auto;
  padding: 20px;
}

.heart-button {
  font-size: 1.5rem;
  padding: 10px;
}

.w-100 {
  width: 100%;
}

.d-flex .mt-2 {
  margin-top: 10px;
}
</style>
