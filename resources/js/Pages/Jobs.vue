<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Modal from '@/Components/Modal.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link } from '@inertiajs/vue3';
import { onMounted, ref, watch } from 'vue';
import requestHandler from '@/Services/requestHandler';
import { toast } from 'vue3-toastify';
import InputError from '@/Components/InputError.vue';

const props = defineProps({
  auth: {
    type: Object,
    default: { user: null }
  }
});
const newJobModal = ref(false);
const form = ref({
  name: '',
  description: '',
  user_id: props.auth.user?.id
});
const [response, setResponse] = [ref(false), (resp) => response.value = resp];
const [errors, setErrors] = [ref({}), (err) => errors.value = err];
const error = ref({ name: '', description: '' });
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
  (data) => jobs.value = data,
];

onMounted(() => {
  getJobs();
});

watch(() => response.value, () => {
  if (response) {
    setJobs({...jobs.value, data: [...jobs.value.data, form.value]});
    form.value = {...form.value, name: '', description: ''};
    closeNewJobModal();
    toast('Job added successfully');
  }
});

watch(() => errors.value, () => {
  if (Object.keys(errors.value).length) {
    for (const key in errors.value.errors) {
      if (Array.isArray(errors.value.errors[key]) && errors.value.errors[key].length) {
        error.value[key] = errors.value.errors[key][0];
      }
    }
  }
})

function openNewJobModal() {
  newJobModal.value = true;
}

function closeNewJobModal() {
  newJobModal.value = false;
}

function handleSubmit(e) {
  e.preventDefault();
  requestHandler.post('/api/jobs', form.value, setResponse, setErrors)
}

function getJobs() {
  requestHandler.get('/api/jobs', setJobs);
}

</script>

<template>
  <AuthenticatedLayout>
    <div class="w-full flex justify-end my-3">
      <!-- <Link as="button" class="px-6"> -->
        <PrimaryButton class="mx-6 bg-green-600 rounded text-md hover:text-gray-100 focus:text-gray-100" @click="openNewJobModal">
          Add a new Job
        </PrimaryButton>
      <!-- </Link> -->
    </div>

    <div class="mt-4">
      <div class="rounded bg-white px-5 py-4 border-b" v-for="item in jobs.data">
        <h1 class="text-lg font-semibold text-gray-800">{{ item.name }}</h1>
        <h1 class="text-md font-light text-gray-700">{{ item.description }}</h1>
      </div>
    </div>

    <Modal :show="newJobModal" @close="closeNewJobModal">
      <div>
        <div className="flex items-center justify-between p-2 md:p-3 border-b rounded-t dark:border-gray-600">
          <h3 className="text-xl font-semibold text-gray-900 dark:text-white">
            New Job
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
              <InputLabel for="name" value="Job Name / Job Title" />
              <TextInput
                id="name"
                name="name"
                class="mt-1 block w-full"
                v-model="form.name"
                required
                autofocus
              />
              
              <InputError
                class="text-red-500 my-1 py-1"
                :message="error.name"
              />
            </div>
  
            <div class="mt-4">
              <InputLabel for="description" value="Description" />
              <textarea
                rows="3"
                id="description"
                name="description"
                class="resize-none mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                v-model="form.description"
                required
                autofocus
              />
              
              <InputError class="mt-2" :message="error.description" />
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