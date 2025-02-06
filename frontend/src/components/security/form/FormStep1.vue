<template>
  <b-form class="mx-1 mx-md-4">
    <b-form-group :label="t('security.register.form.email')" label-for="email" class="mb-4">
      <b-form-input id="email" type="email" v-model="props.form.email" required></b-form-input>
      <div v-if="v$.email.$errors.length" class="text-danger">
        {{ v$.email.$errors[0].$message }}
      </div>
    </b-form-group>

    <b-form-group :label="t('security.register.form.password')" label-for="password" class="mb-4">
      <b-form-input id="password" type="password" v-model="props.form.password" required></b-form-input>
      <div v-if="v$.password.$errors.length" class="text-danger">
        {{ v$.password.$errors[0].$message }}
      </div>
    </b-form-group>

    <b-form-group :label="t('security.register.form.confirmPassword')" label-for="confirmPassword" class="mb-4">
      <b-form-input id="confirmPassword" type="password" v-model="props.form.confirmPassword" required></b-form-input>
      <div v-if="v$.confirmPassword.$errors.length" class="text-danger">
        {{ v$.confirmPassword.$errors[0].$message }}
      </div>
    </b-form-group>

    <b-form-checkbox id="terms" v-model="props.form.terms" class="mb-5">
      <div class="ms-2">{{ t('security.register.form.terms') }}</div>
      <div v-if="v$.terms.$errors.length" class="text-danger">
        {{ v$.terms.$errors[0].$message }}
      </div>
    </b-form-checkbox>

    <b-button variant="success" class="mt-4" @click="validateFirstStep" block>{{ t('security.register.form.register') }}</b-button>
  </b-form>
</template>

<script setup lang="ts">
import { useI18n } from "vue-i18n";
import {computed, defineProps} from "vue";
import {email, helpers, minLength, required, sameAs} from "@vuelidate/validators";
import {useVuelidate} from "@vuelidate/core";
const { t } = useI18n();

const props = defineProps(["form"]);
const emit = defineEmits(["validated"]);

const rules = computed(() => ({
  email: {
    required: helpers.withMessage(t("validation.required"), required),
    email: helpers.withMessage(t("validation.email"), email)
  },
  password: {
    required: helpers.withMessage(t("validation.required"), required),
    minLength: helpers.withMessage(t("validation.minLength", { min: 8 }), minLength(8))
  },
  confirmPassword: {
    required: helpers.withMessage(t("validation.required"), required),
    sameAsPassword: helpers.withMessage(t("validation.sameAsPassword"), sameAs(props.form.password))
  },
  terms: {
    required: helpers.withMessage(t("validation.acceptTerms"),
      value => value === true)
  }
}));

const v$ = useVuelidate(rules, props.form);

async function validateFirstStep() {
  const isValid = await v$.value.$validate();
  if (!isValid) return;

  emit('validated');
}
</script>
