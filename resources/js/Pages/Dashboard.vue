<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { onMounted } from 'vue';

const props = defineProps({
  auth: {
    type: Object,
    default: { user: null }
  }
});

onMounted(() => {
  if (props.auth.user && !props.auth.user.email_verified_at) {
    router.visit('/email/verify');
  }
  if (props.auth.user && !props.auth.user.info_gathering_prompted) {
    if (props.auth.user.user_type === 1) router.visit('/influencer/extra_info');
    else router.visit('/brand/extra_info');
  }
});
</script>

<template>
  <Head title="Dashboard" />

  <AuthenticatedLayout>
    <!-- <template #header>
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Dashboard</h2>
    </template> -->

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
          <!-- <div class="p-6 text-gray-900 dark:text-gray-100">You're logged in!</div> -->
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
