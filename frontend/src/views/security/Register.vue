<template>
  <div class="container d-flex align-items-center justify-content-center mt-5">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-lg-12 col-xl-11">
        <div class="card text-black" style="border-radius: 25px;">
          <div class="card-body p-md-5 position-relative">
            <div v-if="errors.length" class="alert alert-danger">
              <ul>
                <li v-for="(error, index) in errors" :key="index">{{ error }}</li>
              </ul>
            </div>
            <div v-if="responseMessage" class="alert alert-success">
              {{ responseMessage }}
            </div>
            <div class="row justify-content-center">
              <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">
                <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">{{ t('security.register.label') }}</p>
                <transition name="fade-slide" mode="out-in">
                  <div>
                    <RegisterForm :form="form" @validated="register"/>
                  </div>
                </transition>
              </div>
              <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">
                <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-registration/draw1.webp"
                     class="img-fluid" alt="Sample image">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from "vue";
import { useI18n } from "vue-i18n";
import RegisterForm from "@/components/security/form/RegisterForm.vue";
import type { RegisterType } from "@/types/security/RegisterType.ts";
import "@/assets/styles/RegisterForm.scss";
import { createUser } from "@/api/security.ts";
import type {LoginType} from "@/types/security/LoginType.ts";
import {useAuthStore} from "@/stores/authStore.ts";
import router from "@/router";

const { t } = useI18n();

const form = ref<RegisterType>({
  firstName: '',
  lastName: '',
  email: '',
  password: '',
  confirmPassword: '',
  terms: false,
});
const errors = ref<string[]>([]);
const responseMessage = ref<string | null>(null);
const authStore = useAuthStore();

async function register() {
  try {
    const response = await createUser(form.value);

    responseMessage.value = response.message;

    await authStore.login(<LoginType>{
      username: form.value.email,
      password: form.value.password
    });

    await router.push('/register/address')
  } catch (err: any) {
    if (err?.status !== 200 && err?.violations) {
      errors.value = err.violations.map((v: any) => v.title);
    } else {
      errors.value.push("Wystąpił nieoczekiwany błąd.");
    }
  }
}
</script>
