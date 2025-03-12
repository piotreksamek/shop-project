<template>
  <div v-if="errors.length" class="alert alert-danger">
    <ul>
      <li v-for="(error, index) in errors" :key="index">{{ error }}</li>
    </ul>
  </div>
  <div v-if="responseMessage" class="alert alert-success">
    {{ responseMessage }}
  </div>
  <div v-if="isLoading" class="loading-container">
    <BSpinner variant="secondary" label="Ładowanie..."></BSpinner>
  </div>
  <SetupUserForm v-else :form="form" :email="email" @validated="updateUserData" />
</template>

<script setup lang="ts">
import { onMounted, ref } from 'vue'
import '@/assets/styles/RegisterForm.scss'
import type { BaseInformation } from '@/types/user/BaseInformation.ts'
import { getUserInformation, updateUser } from '@/api/user.ts'
import router from '@/router'
import SetupUserForm from '@/components/user/form/SetupUserForm.vue'
import type { User } from '@/types/user/User.ts'

const errors = ref<string[]>([])
const responseMessage = ref<string | null>(null)
const isLoading = ref<boolean>(true)
const email = ref(<string | null>null)

const form = ref(<BaseInformation>{
  firstName: '',
  lastName: '',
  address: {
    street: '',
    number: '',
    city: '',
    apartmentNumber: '',
    province: '',
    postalCode: '',
  },
})

onMounted(async () => {
  try {
    const userData = await getUserInformation()

    setUserData(userData)
    email.value = userData.email
  } catch (err) {
  } finally {
    isLoading.value = false
  }
})

async function updateUserData() {
  try {
    const response = await updateUser(form.value)

    responseMessage.value = response.message

    await router.push('/user/profile/setup')
  } catch (err: any) {
    if (err?.status !== 200 && err?.violations) {
      errors.value = err.violations.map((v: any) => v.title)
    } else {
      errors.value.push('Wystąpił nieoczekiwany błąd.')
    }
  }
}

function setUserData(userData: User) {
  const baseInformation = userData.baseInformation
  const address = baseInformation.address

  form.value.firstName = baseInformation.firstName
  form.value.lastName = baseInformation.lastName
  form.value.address.street = address.street
  form.value.address.number = address.number
  form.value.address.city = address.city
  form.value.address.apartmentNumber = address.apartmentNumber
  form.value.address.province = address.province
  form.value.address.postalCode = address.postalCode
}
</script>
