<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import requestHandler from '@/Services/requestHandler';
import { Head, Link, router } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';

const props = defineProps({
  auth: {
    type: Object,
    default: { user: null }
  }
});

const [newCampaignModal, setNewCampaignModal] = [ ref(false), (bool) => newCampaignModal.value = bool];
const [formData, setFormData] = [
  {
    name: '',
    description: '',
    role: '',
    qualifications: '',
    user_id: null,
  }, 
  (data) => formData.value = data
];
const [error, setError] = [ref({}), (err) => error.value = err];
const [campaigns, setCampaigns] = [ref({
  current_page: 0,
  data: [],
  from: 1,
  last_page: 0,
  per_page: 20,
  prev_page_url: null,
  next_page_url: null,
  to: 0,
  total: 0
}), (data) => campaigns.value = data];

onMounted(() => {
  if (props.auth.user && !props.auth.user.email_verified_at) {
    router.visit('/email/verify');
  }
  if (props.auth.user && !props.auth.user.info_gathering_prompted) {
    if (props.auth.user.user_type === 1) router.visit('/influencer/extra_info');
    else router.visit('/brand/extra_info');
  }

  getJobs();
});

function getJobs() {
  requestHandler.get('/api/jobs', setCampaigns);
}

function openNewCampaignModal() {
  setNewCampaignModal(true);
}

function closeNewCampaignModal() {
  setNewCampaignModal(false);
}

function handleSubmit(e) {
  e.preventDefault();
  setFormData({...formData, user_id: props.auth.user?.id});
  requestHandler.post('/api/jobs', formData.value, afterSuccessfulCampaignCreation, setError);
}

function afterSuccessfulCampaignCreation() {
  setFormData({
    name: '',
    description: '',
    role: '',
    qualifications: '',
    user_id: null,
  });
  closeNewCampaignModal();
}
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
          <div class="p-6 text-gray-900 dark:text-gray-100 flex justify-between items-center">
            <p>Suggested:</p>

            <PrimaryButton
              class="ml-auto rounded text-gray-900 hover:text-gray-100 dark:text-gray-100 bg-green-500 dark:bg-green-600"
              @click="openNewCampaignModal"
            >
              New Campaign
            </PrimaryButton>
          </div>
        </div>
      </div>
    </div>

    <div class="flex align-center">
      <div
        v-for="campaign in campaigns.data"
        class="shadow-md rounded-md bg-white min-h-[150px] w-[250px] m-4 px-4 py-2"
      >
        <Link :href="`/jobs/${campaign.id}`">
          <h1 class="font-bold text-lg">{{ campaign.name }}</h1>
          <div class="h-full w-full">
            <p>{{ campaign.description.slice(0, 100) }}...</p>
          </div>
        </Link>
      </div>
    </div>

    <Modal
      :show="newCampaignModal"
      @close="closeNewCampaignModal"
    >
      <div>
        <div className="flex items-center justify-between p-2 md:p-3 border-b rounded-t dark:border-gray-600">
          <h3 className="text-xl font-semibold text-gray-900 dark:text-white">
            New Campaign
          </h3>

          <button
            type="button"
            className="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
            @click="closeNewJobModal"
          >
            <svg className="w-0.5 h-0.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
              <path stroke="currentColor" strokeLinecap="round" strokeLinejoin="round" strokeWidth="0.5" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
            </svg>
            <span className="sr-only">Close modal</span>
          </button>
        </div>

        <form @submit.prevent="submitNewJob">
          <div class="p-6">

            <div class="">
              <InputLabel for="name" value="Campaign Title" />
              <TextInput
                id="name"
                name="name"
                class="mt-1 block w-full"
                v-model="formData.name"
                required
                autofocus
              />
              
              <InputError
                class="text-red-500 my-1 py-1"
                :message="error.name"
              />
            </div>

            <div class="mt-4">
              <InputLabel for="role" value="Role" />
              <TextInput
                id="role"
                name="role"
                class="mt-1 block w-full"
                v-model="formData.role"
                required
                autofocus
              />
              
              <InputError
                class="text-red-500 my-1 py-1"
                :message="error.role"
              />
            </div>
  
            <div class="mt-4">
              <InputLabel for="description" value="Description" />
              <textarea
                rows="3"
                id="description"
                name="description"
                class="resize-none mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                v-model="formData.description"
                required
                autofocus
              />
              
              <InputError class="mt-2" :message="error.description" />
            </div>

            <div class="mt-4">
              <InputLabel for="qualifications" value="Qualifications" />
              <textarea
                rows="3"
                id="qualifications"
                name="qualifications"
                class="resize-none mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                v-model="formData.qualifications"
                required
                autofocus
              />
              
              <InputError class="mt-2" :message="error.qualifications" />
            </div>
          </div>
  
          <div class="flex justify-end mt-4">
            <PrimaryButton
              class="m-4 py-2 px-3.5 rounded bg-green-500 text-lg text-gray-800 hover:bg-green-600 hover:text-gray-100"
              @click="(e) => handleSubmit(e)"
            >
              Submit
            </PrimaryButton>
          </div>
        </form>

      </div>
    </Modal>
  </AuthenticatedLayout>
</template>
