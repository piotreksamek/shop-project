<template>
  <BForm @submit="onSubmit" v-if="show">
    <div v-if="errorMessage" class="alert alert-danger">{{ errorMessage }}</div>

    <BFormGroup :label="$t('product.form.create.fields.name.label')">
      <BFormInput
        id="name"
        v-model="form.name"
        :placeholder="$t('product.form.create.fields.name.placeholder')"
        :state="validationState($v.name)"
        required
      ></BFormInput>
      <div v-if="$v.name.$error" class="text-danger small">Name field has an error.</div>
    </BFormGroup>

    <BFormGroup :label="$t('product.form.create.fields.shortDescription.label')">
      <BFormInput
        id="shortDescription"
        v-model="form.shortDescription"
        :placeholder="$t('product.form.create.fields.shortDescription.placeholder')"
        :state="validationState($v.shortDescription)"
      ></BFormInput>
      <div v-if="$v.shortDescription.$error" class="text-danger small">Short description field has an error.</div>
    </BFormGroup>

    <BFormGroup :label="$t('product.form.create.fields.description.label')">
      <BFormTextarea
        id="description"
        v-model="form.description"
        :placeholder="$t('product.form.create.fields.description.placeholder')"
        :state="validationState($v.description)"
        required
      ></BFormTextarea>
      <div v-if="$v.description.$error" class="text-danger small">Description field has an error.</div>
    </BFormGroup>

    <BFormGroup :label="$t('product.form.create.fields.images.label')">
      <BFormFile
        id="images"
        v-model="form.images"
        :state="validationState($v.images)"
        @change="previewImages"
        accept="image/*"
        multiple
        required
      ></BFormFile>
      <div v-if="$v.images.$error" class="text-danger small">At least one image is required.</div>


      <div class="d-flex flex-wrap mt-2">
        <div
          v-for="(image, index) in imagePreviews"
          :key="index"
          class="position-relative mr-2 mb-2"
        >
          <img
            :src="image"
            alt="Image Preview"
            class="img-thumbnail"
            style="width: 100px; height: 100px; object-fit: cover;"
            @click="openModal(image)"
          />
          <BButton
            variant="danger"
            size="sm"
            @click="removeImage(index)"
            class="position-absolute top-0 right-0"
            style="z-index: 1;"
          >
            X
          </BButton>
        </div>
      </div>
    </BFormGroup>

    <BButton type="submit" variant="primary">{{ $t('actions.save') }}</BButton>
  </BForm>

  <BModal v-model="showModal" size="lg" no-footer centered>
    <img :src="currentImage" class="img-fluid w-100" />
  </BModal>
</template>

<script lang="ts" setup>
import { ref } from 'vue';
import type { ProductCreate } from "@/types/product/ProductCreate.ts";
import { createProduct } from "@/api/product.ts";
import { useVuelidate } from "@vuelidate/core";
import { required, maxLength } from "@vuelidate/validators";
import router from "@/router";

const show = ref(true);
const form = ref<ProductCreate>({
  name: '',
  description: '',
  shortDescription: '',
  images: [],
});

const imagePreviews = ref<string[]>([]);
const showModal = ref(false);
const currentImage = ref<string>('');
const errorMessage = ref<string | null>(null);

const rules = {
  name: { required, maxLength: maxLength(50) },
  description: { required, maxLength: maxLength(2000) },
  shortDescription: { maxLength: maxLength(200) },
  images: { required },
};

const $v = useVuelidate(rules, form);

const previewImages = (event: Event) => {
  const fileInput = event.target as HTMLInputElement;
  const files = fileInput.files;

  if (files) {
    for (let i = 0; i < files.length; i++) {
      const file = files[i];
      const reader = new FileReader();
      reader.onload = (e) => {
        imagePreviews.value.push(e.target?.result as string);
      };
      reader.readAsDataURL(file);
    }
  }
};

const removeImage = (index: number) => {
  imagePreviews.value.splice(index, 1);
  form.value.images.splice(index, 1);
};

const openModal = (image: string) => {
  currentImage.value = image;
  showModal.value = true;
};

const onSubmit = async (event: Event) => {
  event.preventDefault();

  const isValid = await $v.value.$validate();
  if (!isValid) {
    return;
  }

  try {
    const response = await createProduct(form.value);

    router.push(`/product/${response.data.id}`)
  } catch (err) {
    errorMessage.value = "Wystąpił błąd podczas dodawania produktu. Proszę spróbować ponownie.";

    return;
  }
};

const validationState = (field: any) => {
  if (!field.$dirty) return null;
  return !field.$error;
};
</script>
