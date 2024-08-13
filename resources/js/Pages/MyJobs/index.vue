<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import requestHandler from '@/Services/requestHandler';
import { Link, router } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';

const [jobs, setJobs] = [
  ref({
    data: [],
    from: 1,
    last_page: 0,
    per_page: 20,
    prev_page_url: null,
    next_page_url: null,
    to: 0,
    total: 0,
  }),
  (data) => jobs.value = data
];

onMounted(() => {
  fetchMyJobs();
});

function fetchMyJobs() {
  requestHandler.get('/api/my_jobs', setJobs);
}

function navigateToPage(id) {
  router.visit(`/my_jobs/${id}`)
}
</script>
<template>
  <AuthenticatedLayout>
    <div>
      <div class="mt-4 mx-4 rounded-xl" v-if="jobs.data.length">
        <div
          class="rounded-xl bg-white px-5 py-4 border-b flex items-center h-[100px] hover:cursor-pointer"
          v-for="item in jobs.data"
          @click="navigateToPage(item.id)"
        >
          <div class="h-full">
            <img :src="item.user_information?.profile_pic[0]?.name" alt="Profile picture" class="h-full w-[80px]">
          </div>
          <div class="mx-6">
            <Link :href="`/jobs/${item.id}`">
              <h1 class="text-lg font-semibold text-gray-800 hover:underline hover:text-blue-500">{{ item.name }}</h1>
            </Link>
            <h1 class="text-md font-light text-gray-700">{{ item.role }}</h1>
          </div>
          <PrimaryButton class="ml-auto bg-blue-500 hover:bg-blue-600 hover:text-gray-200 rounded">
            View Applicants
          </PrimaryButton>
        </div>
      </div>
      <div v-else class="flex justify-center items-center mt-8">
        <h1 class="font-semibold text-[35px] text-gray-400">No Items Available</h1>
      </div>
    </div>
  </AuthenticatedLayout>
</template>