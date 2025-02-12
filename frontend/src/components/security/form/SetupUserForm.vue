<template>
  <b-container class="mt-4">
      <b-form>
        <h1 class="mb-4 text-center">{{ t('security.register.extraData') }}</h1>
        <h4>{{ t('security.register.information') }}</h4>

        <b-row>
          <b-col md="6">
            <b-form-group :label="t('security.register.form.firstName')" label-for="firstName">
              <b-form-input id="firstName" v-model="props.form.firstName" required></b-form-input>
              <div v-if="v$.firstName.$errors.length" class="text-danger small">
                {{ v$.firstName.$errors[0].$message }}
              </div>
            </b-form-group>
          </b-col>
          <b-col md="6">
            <b-form-group :label="t('security.register.form.lastName')" label-for="lastName">
              <b-form-input id="lastName" v-model="props.form.lastName" required></b-form-input>
              <div v-if="v$.lastName.$errors.length" class="text-danger small">
                {{ v$.lastName.$errors[0].$message }}
              </div>
            </b-form-group>
          </b-col>
        </b-row>
        <h4>{{ t('security.register.address.label') }}</h4>

        <b-row>
          <b-col md="6">
            <b-form-group :label="t('security.register.address.street')" label-for="street">
              <b-form-input id="street" v-model="props.form.address.street"></b-form-input>
              <div v-if="v$.address.street.$errors.length" class="text-danger small">
                {{ v$.address.street.$errors[0].$message }}
              </div>
            </b-form-group>
          </b-col>
          <b-col md="6">
            <b-form-group :label="t('security.register.address.city')" label-for="city">
              <b-form-input id="city" v-model="props.form.address.city"></b-form-input>
              <div v-if="v$.address.city.$errors.length" class="text-danger small">
                {{ v$.address.city.$errors[0].$message }}
              </div>
            </b-form-group>
          </b-col>
        </b-row>
        <b-row>
          <b-col md="4">
            <b-form-group :label="t('security.register.address.apartmentNumber')" label-for="apartmentNumber">
              <b-form-input id="apartmentNumber" v-model="props.form.address.apartmentNumber"></b-form-input>
              <div v-if="v$.address.apartmentNumber.$errors.length" class="text-danger small">
                {{ v$.address.apartmentNumber.$errors[0].$message }}
              </div>
            </b-form-group>
          </b-col>
          <b-col md="4">
            <b-form-group :label="t('security.register.address.number')" label-for="number">
              <b-form-input id="number" v-model="props.form.address.number"></b-form-input>
              <div v-if="v$.address.number.$errors.length" class="text-danger small">
                {{ v$.address.number.$errors[0].$message }}
              </div>
            </b-form-group>
          </b-col>
          <b-col md="4">
            <b-form-group :label="t('security.register.address.postalCode')" label-for="postalCode">
              <PostalCodeInput v-model="props.form.address.postalCode"></PostalCodeInput>
              <div v-if="v$.address.postalCode.$errors.length" class="text-danger small">
                {{ v$.address.postalCode.$errors[0].$message }}
              </div>
            </b-form-group>
          </b-col>
        </b-row>

        <b-row>
          <b-col md="6">
            <b-form-group :label="t('security.register.address.province')" label-for="province">
              <b-form-input id="province" v-model="props.form.address.province"></b-form-input>
              <div v-if="v$.address.province.$errors.length" class="text-danger small">
                {{ v$.address.province.$errors[0].$message }}
              </div>
            </b-form-group>
          </b-col>
        </b-row>

        <b-button variant="success" @click="validate" block class="mt-3">
          {{ t('actions.saveData') }}
        </b-button>
      </b-form>
  </b-container>

</template>

<script setup lang="ts">
import { useI18n } from "vue-i18n";
import { computed, defineProps } from "vue";
import { helpers, maxLength, required } from "@vuelidate/validators";
import { useVuelidate } from "@vuelidate/core";
import PostalCodeInput from "@/components/common/Input/PostalCodeInput.vue";

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
