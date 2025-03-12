<template>
  <BForm class="mx-1 mx-md-4">
    <BRow>
      <BCol>
        <BFormGroup label="Imię" label-for="firstName" class="mb-4">
          <BFormInput id="firstName" type="text" v-model="props.form.firstName"
                      required></BFormInput>
          <div v-if="v$.firstName.$errors.length" class="text-danger">
            {{ v$.firstName.$errors[0].$message }}
          </div>
        </BFormGroup>
      </BCol>
      <BCol>
        <BFormGroup label="Nazwisko" label-for="lastName" class="mb-4">
          <BFormInput id="lastName" type="text" v-model="props.form.lastName"
                      required></BFormInput>
          <div v-if="v$.lastName.$errors.length" class="text-danger">
            {{ v$.lastName.$errors[0].$message }}
          </div>
        </BFormGroup>
      </BCol>
    </BRow>

    <BFormGroup :label="t('security.register.form.email')" label-for="email" class="mb-4">
      <BFormInput id="email" type="email" v-model="props.form.email" required></BFormInput>
      <div v-if="v$.email.$errors.length" class="text-danger">
        {{ v$.email.$errors[0].$message }}
      </div>
    </BFormGroup>

    <BFormGroup :label="t('security.register.form.password')" label-for="password" class="mb-4">
      <BFormInput id="password" type="password" v-model="props.form.password"
                  required></BFormInput>
      <div v-if="v$.password.$errors.length" class="text-danger">
        {{ v$.password.$errors[0].$message }}
      </div>
    </BFormGroup>

    <BFormGroup :label="t('security.register.form.confirmPassword')" label-for="confirmPassword"
                class="mb-4">
      <BFormInput id="confirmPassword" type="password" v-model="props.form.confirmPassword"
                  required></BFormInput>
      <div v-if="v$.confirmPassword.$errors.length" class="text-danger">
        {{ v$.confirmPassword.$errors[0].$message }}
      </div>
    </BFormGroup>

    <BFormCheckbox id="terms" v-model="props.form.terms" class="mb-5">
      <div class="ms-2">{{ t('security.register.form.terms') }}</div>
      <div v-if="v$.terms.$errors.length" class="text-danger">
        {{ v$.terms.$errors[0].$message }}
      </div>
    </BFormCheckbox>

    <BButton variant="success" class="mt-4" @click="validateFirstStep" block>
      {{ t('security.register.form.register') }}
    </BButton>
  </BForm>
</template>


<script setup lang="ts">
import {useI18n} from "vue-i18n";
import {computed, defineProps} from "vue";
import {email, helpers, minLength, required, sameAs} from "@vuelidate/validators";
import {useVuelidate} from "@vuelidate/core";

const {t} = useI18n();

const props = defineProps(["form"]);
const emit = defineEmits(["validated"]);

const rules = computed(() => ({
  firstName: {
    required: helpers.withMessage(t("validation.required"), required),
  },
  lastName: {
    required: helpers.withMessage(t("validation.required"), required),
  },
  email: {
    required: helpers.withMessage(t("validation.required"), required),
    email: helpers.withMessage(t("validation.email"), email)
  },
  password: {
    required: helpers.withMessage(t("validation.required"), required),
    minLength: helpers.withMessage(t("validation.minLength", {min: 8}), minLength(8))
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
