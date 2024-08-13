<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { onMounted, watch, ref } from 'vue';
import { router } from '@inertiajs/vue3';
import requestHandler from '@/Services/requestHandler';
import JobDetails from '@/Components/JobDetails.vue';
import JobApplications from '@/Components/JobApplications.vue';

const [job, setJob] = [ref({}), (data) => job.value = data];
const [applications, setApplications] = [ref({
  data: [],
  from: 1,
  last_page: 0,
  per_page: 20,
  prev_page_url: null,
  next_page_url: null,
  to: 0,
  total: 0,
}, (data) => applications.value = data)];

onMounted(() => {
  fetchCurrentJob();
});

function fetchCurrentJob() {
  const jobId = router.page.url.split("/")[2];
  requestHandler.get(`/api/my_jobs/${jobId}`, setJob);
  requestHandler.get(`/api/job_applications/${jobId}`, setApplications);
}
</script>
<template>
  <AuthenticatedLayout>
    <div>
      <JobDetails :job="job" />
    </div>
    <div>
      <JobApplications :applications="applications.data"/>
    </div>
  </AuthenticatedLayout>
</template>