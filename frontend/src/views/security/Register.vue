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
                <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">{{ step === 1 ? t('security.register.label') : t('security.register.extraData') }}</p>
                <transition name="fade-slide" mode="out-in">
                  <div :key="step">
                    <FormStep1 v-if="step === 1" :form="form" @validated="register"/>
                    <FormStep2 v-if="step === 2" :form="form" @validated="updateUserData"/>
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
import FormStep1 from "@/components/security/form/FormStep1.vue";
import FormStep2 from "@/components/security/form/FormStep2.vue";
import type { RegisterType } from "@/types/security/RegisterType.ts";
import "@/assets/styles/RegisterForm.scss";
import { createUser } from "@/api/security.ts";

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
const step = ref(1);
const responseMessage = ref<string | null>(null);

function nextStep() {
  step.value++;
}
async function register() {
  try {
    const response = await createUser(form.value);

    if (!response) {
      errors.value.push("Wystąpił nieoczekiwany błąd.");
    }

    responseMessage.value = response.message;
    errors.value = [];
    nextStep()
  } catch (err: unknown) {
    if (err?.status !== 200 && err?.violations) {
      errors.value = err.violations.map((v: any) => v.title);
    } else {
      errors.value.push("Wystąpił nieoczekiwany błąd.");
    }
  }
}
async function updateUserData() {
  console.log('asd');
}
</script>
