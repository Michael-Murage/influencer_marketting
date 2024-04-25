<script setup>
import { onMounted, ref } from 'vue';

const model = defineModel({
    type: String,
    required: true,
});

const input = ref(null);

const props = defineProps({
  placeholder: {
    type: String,
    default: ''
  },
});

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});
  

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <select
      :class="`border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm ${!model ? 'text-gray-500' : ''}`"
      v-model="model"
      ref="input"
    >
      <option class="text-gray-500" value="" v-if="props.placeholder">{{ props.placeholder }}</option>
      <slot/>
    </select>
</template>
