<template>
  <div class="container d-flex align-items-center justify-content-center mt-5">
    <div class="col-lg-8">
      <div class="card text-black text-center" style="border-radius: 25px;">
        <div class="card-body p-md-5">
          <div class="mt-3">
            <div v-if="errors.length" class="alert alert-danger">
              <ul>
                <li v-for="(error, index) in errors" :key="index">{{ error }}</li>
              </ul>
            </div>
            <div v-if="responseMessage" class="alert alert-success">
              {{ responseMessage }}
            </div>
            <SetupUserForm :form="form" @validated="updateUserData"/>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from "vue";
import "@/assets/styles/RegisterForm.scss";
import SetupUserForm from "@/components/security/form/SetupUserForm.vue";
import {updateUser } from "@/api/user.ts";
import router from "@/router";
import type {Address} from "@/types/user/Address.ts";

const errors = ref<string[]>([]);
const responseMessage = ref<string | null>(null);

const form = ref(<Address>{
    street: '',
    number: '',
    city: '',
    apartmentNumber: '',
    province: '',
    postalCode: '',
})

async function updateUserData() {
  try {
    const response = await updateUser(form.value);

    responseMessage.value = response.message;

    await router.push('/');
  } catch (err: any) {
    if (err?.status !== 200 && err?.violations) {
      errors.value = err.violations.map((v: any) => v.title);
    } else {
      errors.value.push("Wystąpił nieoczekiwany błąd.");
    }
  }
}
</script>
