<template>
  <div class="container d-flex align-items-center justify-content-center mt-5">
    <div class="col-lg-8">
      <div class="card text-black text-center" style="border-radius: 25px;">
        <div class="card-body p-md-5">
          <div class="row justify-content-center">
          <div class="col-12 col-lg-9">
            <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-registration/draw1.webp"
                 class="img-fluid" alt="Sample image">
          </div>
          </div>
          <div class="mt-3">
          <div v-if="isLoading" class="">
            <BSpinner variant="secondary" label="Spinning"></BSpinner>
          </div>
          <div v-else-if="errorMessage" class="">
            <p class="h3 mb-4">{{ errorMessage }}</p>
          </div>
          <div v-else-if="!errorMessage">
            <p class="h3 mb-4">{{ t('email.verify')}}</p>
          </div>
        </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import {onMounted, ref} from "vue";
import "@/assets/styles/RegisterForm.scss";
import {verifyEmail} from "@/api/security.ts";
import {useRoute} from "vue-router";
import {useI18n} from "vue-i18n";

const { t } = useI18n();

const route = useRoute();
const token = ref<string | string[]>('')
const errorMessage = ref<string | null>(null)
const isLoading = ref<boolean>(true)

token.value = route.params.token;

onMounted(async () => {
  try {
    const response = await verifyEmail(token.value);

    if (response.status === 'error') {
      errorMessage.value = response.message;
    }
  } catch (err: any) {
    errorMessage.value = err.message;
  } finally {
    isLoading.value = false;
  }
})

</script>
