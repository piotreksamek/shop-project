<template>
  <BContainer class="mt-4">
    <BForm>
      <h4>Twoje dane</h4>
      <BRow>
        <BCol md="6">
          <BFormGroup :label="t('security.register.form.firstName')" label-for="firstName">
            <BFormInput id="firstName" v-model="props.form.firstName" required></BFormInput>
            <div v-if="v$.firstName.$errors.length" class="text-danger small">
              {{ v$.firstName.$errors[0].$message }}
            </div>
          </BFormGroup>
        </BCol>
        <BCol md="6">
          <BFormGroup :label="t('security.register.form.lastName')" label-for="lastName">
            <BFormInput id="lastName" v-model="props.form.lastName" required></BFormInput>
            <div v-if="v$.lastName.$errors.length" class="text-danger small">
              {{ v$.lastName.$errors[0].$message }}
            </div>
          </BFormGroup>
        </BCol>
      </BRow>

      <div class="mt-2">
        <h4>Adres email</h4>
        <BRow>
          <h5>{{ props.email }}</h5>
        </BRow>
      </div>

      <div class="mt-2">
        <h4>Numer telefonu</h4>
        <BRow>
          <h5>866555444</h5>
        </BRow>
      </div>

      <h4>{{ t('security.register.address.label') }}</h4>

      <BRow>
        <BCol md="6">
          <BFormGroup :label="t('security.register.address.street')" label-for="street">
            <BFormInput id="street" v-model="props.form.address.street"></BFormInput>
            <div v-if="v$.address.street.$errors.length" class="text-danger small">
              {{ v$.address.street.$errors[0].$message }}
            </div>
          </BFormGroup>
        </BCol>
        <BCol md="6">
          <BFormGroup :label="t('security.register.address.city')" label-for="city">
            <BFormInput id="city" v-model="props.form.address.city"></BFormInput>
            <div v-if="v$.address.city.$errors.length" class="text-danger small">
              {{ v$.address.city.$errors[0].$message }}
            </div>
          </BFormGroup>
        </BCol>
      </BRow>

      <BRow>
        <BCol md="4">
          <BFormGroup :label="t('security.register.address.apartmentNumber')" label-for="apartmentNumber">
            <BFormInput id="apartmentNumber" v-model="props.form.address.apartmentNumber"></BFormInput>
            <div v-if="v$.address.apartmentNumber.$errors.length" class="text-danger small">
              {{ v$.address.apartmentNumber.$errors[0].$message }}
            </div>
          </BFormGroup>
        </BCol>
        <BCol md="4">
          <BFormGroup :label="t('security.register.address.number')" label-for="number">
            <BFormInput id="number" v-model="props.form.address.number"></BFormInput>
            <div v-if="v$.address.number.$errors.length" class="text-danger small">
              {{ v$.address.number.$errors[0].$message }}
            </div>
          </BFormGroup>
        </BCol>
        <BCol md="4">
          <BFormGroup :label="t('security.register.address.postalCode')" label-for="postalCode">
            <PostalCodeInput v-model="props.form.address.postalCode"></PostalCodeInput>
            <div v-if="v$.address.postalCode.$errors.length" class="text-danger small">
              {{ v$.address.postalCode.$errors[0].$message }}
            </div>
          </BFormGroup>
        </BCol>
      </BRow>

      <BRow>
        <BCol md="6">
          <BFormGroup :label="t('security.register.address.province')" label-for="province">
            <BFormInput id="province" v-model="props.form.address.province"></BFormInput>
            <div v-if="v$.address.province.$errors.length" class="text-danger small">
              {{ v$.address.province.$errors[0].$message }}
            </div>
          </BFormGroup>
        </BCol>
      </BRow>

      <BButton variant="secondary" @click="validate" block class="mt-3 w-25">
        {{ t('actions.saveData') }}
      </BButton>
    </BForm>
  </BContainer>
</template>

<script setup lang="ts">
import { useI18n } from "vue-i18n";
import {computed, defineProps} from "vue";
import { helpers, maxLength, required } from "@vuelidate/validators";
import { useVuelidate } from "@vuelidate/core";
import PostalCodeInput from "@/components/common/Input/PostalCodeInput.vue";
const props = defineProps(["form", "email"]);
const emit = defineEmits(['validated']);
const { t } = useI18n();

const rules = computed(() => ({
  firstName: {
    required: helpers.withMessage(t("validation.required"), required),
    maxLength: helpers.withMessage(t("validation.maxLength", { max: 20 }), maxLength(20))
  },
  lastName: {
    required: helpers.withMessage(t("validation.required"), required),
    maxLength: helpers.withMessage(t("validation.maxLength", { max: 20 }), maxLength(20))
  },
  address: {
    street: {
      maxLength: helpers.withMessage(t("validation.maxLength", { max: 100 }), maxLength(100))
    },
    apartmentNumber: {
      maxLength: helpers.withMessage(t("validation.maxLength", { max: 10 }), maxLength(10))
    },
    number: {
      maxLength: helpers.withMessage(t("validation.maxLength", { max: 10 }), maxLength(10))
    },
    city: {
      maxLength: helpers.withMessage(t("validation.maxLength", { max: 100 }), maxLength(100))
    },
    province: {
      maxLength: helpers.withMessage(t("validation.maxLength", { max: 100 }), maxLength(100))
    },
    postalCode: {
      maxLength: helpers.withMessage(t("validation.maxLength", { max: 6 }), maxLength(6)),
      pattern: helpers.withMessage(t("validation.postalCode"), helpers.regex(/^\d{2}-\d{3}$/))
    },
  }
}));

const v$ = useVuelidate(rules, props.form);

async function validate() {
  const isValid = await v$.value.$validate();
  if (!isValid) return;

  emit("validated");
}
</script>
