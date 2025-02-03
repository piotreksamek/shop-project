<template>
  <div>
    <b-form @submit="onSubmit" v-if="show">
      <b-form-group
        :label="$t('product.form.create.fields.name.label')"
      >
        <b-form-input
          id="name"
          v-model="form.name"
          :placeholder="$t('product.form.create.fields.name.placeholder')"
          :state="validationState($v.name)"
          required
        ></b-form-input>
        <div v-if="$v.name.$error" class="text-danger small">Name field has an error.</div>
      </b-form-group>

      <b-form-group
        :label="$t('product.form.create.fields.shortDescription.label')"
      >
        <b-form-input
          id="shortDescription"
          v-model="form.shortDescription"
          :placeholder="$t('product.form.create.fields.shortDescription.placeholder')"
          :state="validationState($v.shortDescription)"
        ></b-form-input>
        <div v-if="$v.shortDescription.$error" class="text-danger small">Name field has an error.</div>
      </b-form-group>

      <b-form-group
        :label="$t('product.form.create.fields.description.label')"
      >
        <b-form-input
          id="description"
          v-model="form.description"
          :placeholder="$t('product.form.create.fields.description.placeholder')"
          :state="validationState($v.description)"
          required
        ></b-form-input>
        <div v-if="$v.description.$error" class="text-danger small">Name field has an error.</div>
      </b-form-group>

      <b-button type="submit" variant="primary">{{ $t('actions.save') }}</b-button>
    </b-form>
  </div>
</template>

<script lang="ts" setup>
import { ref } from 'vue';
import type { ProductCreate } from "@/types/ProductCreate.ts";
import {createProduct} from "@/api/product.ts";
import {useVuelidate} from "@vuelidate/core";
import {required, maxLength} from "@vuelidate/validators";

const show = ref(true);
const form = ref<ProductCreate>({
  name: '',
  description: '',
  shortDescription: '',
});

const rules = {
  name: { required, minLength: maxLength(50) },
  description: { required, maxLength: maxLength(2000) },
  shortDescription: { maxLength: maxLength(200) },
};

const $v = useVuelidate(rules, form);

const onSubmit = async () => {
  const isValid = await $v.value.$validate();
  if (!isValid) {
    return;
  }
  createProduct(form.value)
};

const validationState = (field: any) => {
  if (!field.$dirty) return null;
  return !field.$error;
};

</script>
