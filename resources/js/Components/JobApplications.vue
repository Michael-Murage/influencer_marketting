<script setup>
const props = defineProps({
  applications: {
    type: Array,
  },
});

console.log(props.applications)
</script>
<template>
  <h1>APPLICATIONS</h1>
  <div v-for="application in props.applications">
    {{ application }}
    <h1>{{ application.application_with_user_details?.name }}</h1>
    <h1>{{ application.application_with_user_details?.username }}</h1>
  </div>
</template>