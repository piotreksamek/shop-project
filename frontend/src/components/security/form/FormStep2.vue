<template>
  <b-form class="mx-1 mx-md-4">
    <b-form-group :label="t('security.register.form.firstName')" label-for="firstName">
      <b-form-input id="firstName" v-model="props.form.firstName" required></b-form-input>
    </b-form-group>

    <b-form-group :label="t('security.register.form.lastName')" label-for="lastName">
      <b-form-input id="lastName" v-model="props.form.lastName" required></b-form-input>
    </b-form-group>

    <b-button variant="success" @click="validateSecondStep" block>{{ t('actions.saveData') }}</b-button>
  </b-form>
</template>

<script setup lang="ts">
import { useI18n } from "vue-i18n";
import {computed, defineProps} from "vue";
import {helpers, maxLength, required} from "@vuelidate/validators";
import {useVuelidate} from "@vuelidate/core";

const props = defineProps(["form"]);
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
  }
}));

const v$ = useVuelidate(rules, props.form);

async function validateSecondStep() {
  const isValid = await v$.value.$validate();
  if (!isValid) return;

  emit("validated");
}
</script>
