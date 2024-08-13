<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { router } from "@inertiajs/vue3";
import { onMounted, onUnmounted, ref } from "vue";
import requestHandler from "@/Services/requestHandler";
import Modal from "@/Components/Modal.vue";
import { toast } from "vue3-toastify";
import JobDetails from '@/Components/JobDetails.vue';

const [job, setJob] = [ref({}), (data) => (job.value = data)];
const confirmModal = ref(false);
const [jobApplied, setJobApplied] = [ref({}), (data) => jobApplied.value = data];

let timeoutId;

onMounted(() => {
  fetchCurrentJob();

  timeoutId = setTimeout(() => {
    fetchWhetherJobApplied();
  }, 200);
});

onUnmounted(() => {
  if (timeoutId) clearTimeout(timeoutId);
});

function fetchCurrentJob() {
  const jobId = router.page.url.split("/")[2];
  requestHandler.get(`/api/jobs/${jobId}`, setJob);
}

function fetchWhetherJobApplied() {
  requestHandler.get(`/api/job_applied/${job.value.id}`, setJobApplied);
}

const openConfirmModal = () => (confirmModal.value = true);
const closeConfirmModal = () => (confirmModal.value = false);

function handleConfirmJobApplication() {
  requestHandler.post('/api/apply_job', {jobId: job.value.id});
  closeConfirmModal();
  toast('Application sent');
}
</script>
<template>
  <AuthenticatedLayout>
    <JobDetails :job="job"/>

    <div class="my-4 mx-5 flex">
      <button
        @click="openConfirmModal()"
        class="bg-blue-500 hover:bg-blue-600 text-gray-200 hover:text-gray-300 shadow hover:shadow-lg font-bold py-2 px-6 rounded-md ml-auto"
        :disabled="jobApplied.status"
      >
        {{ jobApplied.status ? 'ALREADY APPLIED' : 'APPLY' }}
      </button>
    </div>

    <Modal :show="confirmModal" @close="closeConfirmModal">
      <div>
        <div
          className="flex items-center justify-between p-2 md:p-3 border-b rounded-t dark:border-gray-600"
        >
          <button
            type="button"
            className="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
            @click="closeConfirmModal"
          >
            <svg
              className="w-0.5 h-0.5"
              aria-hidden="true"
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 14 14"
            >
              <path
                stroke="currentColor"
                strokeLinecap="round"
                strokeLinejoin="round"
                strokeWidth="0.5"
                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"
              />
            </svg>
            <span className="sr-only">Close modal</span>
          </button>
        </div>

        <div class="p-5 text-center">
          <p>Please confirm submitting your application for the job</p>
          <p class="font-bold">"{{ job.name }}"</p>
        </div>

        <div class="flex justify-between items-center my-4 px-8">
          <button
            class="bg-green-500 hover:opacity-80 hover:scale-105 px-4 py-2 rounded-md cursor-pointer"
            @click="handleConfirmJobApplication"
          >
            CONFIRM
          </button>
          <button
            class="bg-red-500 hover:opacity-80 hover:scale-105 px-4 py-2 rounded-md cursor-pointer"
            @click="closeConfirmModal"
          >
            CANCEL
          </button>
        </div>
      </div>
    </Modal>
  </AuthenticatedLayout>
</template>
