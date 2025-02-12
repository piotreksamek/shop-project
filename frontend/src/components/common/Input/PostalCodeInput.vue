<template>
  <b-form-input
    type="text"
    @beforeinput="blockNonNumeric"
    :formatter="formatPostalCode"
    maxlength="6"
    class="border p-2 rounded"
    @input="updatePostalCode"
  />
</template>
<script setup lang="ts">
const emit = defineEmits(['update:modelValue']);

const blockNonNumeric = (event: InputEvent) => {
  if (event.data && /\D/.test(event.data)) {
    event.preventDefault();
  }
};
const updatePostalCode = (value: string) => {
  emit('update:modelValue', value);
};
const formatPostalCode = (value: string) => {
  if (value.length > 2 && value.length < 4) {
    value = value.slice(0, 2) + "-" + value.slice(2);
  }

  return value;
}
</script>
