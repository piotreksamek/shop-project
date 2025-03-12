<template>
  <BContainer class="mt-4">
    <BForm>
      <h1 class="mb-4 text-center">Wypełnij dane adresowe</h1>

      <BRow>
        <BCol md="6">
          <BFormGroup :label="t('security.register.address.street')" label-for="street">
            <BFormInput id="street" v-model="props.form.street"></BFormInput>
            <div v-if="v$.street.$errors.length" class="text-danger small">
              {{ v$.address.street.$errors[0].$message }}
            </div>
          </BFormGroup>
        </BCol>
        <BCol md="6">
          <BFormGroup :label="t('security.register.address.city')" label-for="city">
            <BFormInput id="city" v-model="props.form.city"></BFormInput>
            <div v-if="v$.city.$errors.length" class="text-danger small">
              {{ v$.city.$errors[0].$message }}
            </div>
          </BFormGroup>
        </BCol>
      </BRow>

      <BRow>
        <BCol md="4">
          <BFormGroup :label="t('security.register.address.apartmentNumber')" label-for="apartmentNumber">
            <BFormInput id="apartmentNumber" v-model="props.form.apartmentNumber"></BFormInput>
            <div v-if="v$.apartmentNumber.$errors.length" class="text-danger small">
              {{ v$.apartmentNumber.$errors[0].$message }}
            </div>
          </BFormGroup>
        </BCol>
        <BCol md="4">
          <BFormGroup :label="t('security.register.address.number')" label-for="number">
            <BFormInput id="number" v-model="props.form.number"></BFormInput>
            <div v-if="v$.number.$errors.length" class="text-danger small">
              {{ v$.number.$errors[0].$message }}
            </div>
          </BFormGroup>
        </BCol>
        <BCol md="4">
          <BFormGroup :label="t('security.register.address.postalCode')" label-for="postalCode">
            <PostalCodeInput v-model="props.form.postalCode"></PostalCodeInput>
            <div v-if="v$.postalCode.$errors.length" class="text-danger small">
              {{ v$.postalCode.$errors[0].$message }}
            </div>
          </BFormGroup>
        </BCol>
      </BRow>

      <BRow>
        <BCol md="6">
          <BFormGroup :label="t('security.register.address.province')" label-for="province">
            <BFormInput id="province" v-model="props.form.province"></BFormInput>
            <div v-if="v$.province.$errors.length" class="text-danger small">
              {{ v$.province.$errors[0].$message }}
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
import { computed, defineProps } from "vue";
import { helpers, maxLength } from "@vuelidate/validators";
import { useVuelidate } from "@vuelidate/core";
import PostalCodeInput from "@/components/common/Input/PostalCodeInput.vue";

const props = defineProps(["form"]);
const emit = defineEmits(['validated']);
const { t } = useI18n();

const rules = computed(() => ({
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
}));

const v$ = useVuelidate(rules, props.form);

async function validate() {
  const isValid = await v$.value.$validate();
  if (!isValid) return;

  emit("validated");
}
</script>
