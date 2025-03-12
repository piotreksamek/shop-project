<template>
  <div class="container d-flex align-items-center justify-content-center mt-5">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-lg-12 col-xl-11">
        <div class="card text-black" style="border-radius: 25px">
          <div class="card-body p-md-5 position-relative">
            <div v-if="error" class="alert alert-danger">
              {{ t('login.error') }}
            </div>
            <div class="row justify-content-center">
              <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">
                <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">
                  {{ t('security.login.label') }}
                </p>
                <transition name="fade-slide" mode="out-in">
                  <BForm class="mx-1 mx-md-4">
                    <BFormGroup :label="t('security.register.form.email')" label-for="firstName">
                      <BFormInput id="firstName" v-model="form.username" required></BFormInput>
                    </BFormGroup>

                    <BFormGroup :label="t('security.register.form.password')" label-for="lastName">
                      <BFormInput
                        type="password"
                        id="lastName"
                        v-model="form.password"
                        required
                      ></BFormInput>
                    </BFormGroup>

                    <BButton class="mt-5" variant="success" @click="login" block>{{
                      t('actions.login')
                    }}</BButton>
                  </BForm>
                </transition>
              </div>
              <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">
                <img
                  src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-registration/draw1.webp"
                  class="img-fluid"
                  alt="Sample image"
                />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { useI18n } from 'vue-i18n'
const { t } = useI18n()
import '@/assets/styles/RegisterForm.scss'
import type { LoginType } from '@/types/security/LoginType.ts'
import { useAuthStore } from '@/stores/authStore.ts'
import router from '@/router'

const error = ref(false)

const form = ref<LoginType>({
  username: '',
  password: '',
})

const authStore = useAuthStore()

async function login() {
  try {
    await authStore.login(form.value)

    return router.push('home')
  } catch (err: unknown) {
    error.value = true
  }
}
</script>
