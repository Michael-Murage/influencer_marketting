<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Modal from '@/Components/Modal.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';

const newJobModal = ref(true);
const form = ref({});

function openNewJobModal() {
  newJobModal.value = true;
}

function closeNewJobModal() {
  newJobModal.value = false;
}

</script>

<template>
  <AuthenticatedLayout>
    <div class="w-full flex justify-between">
      <h1>Jobs</h1>
  
      <!-- <Link as="button" class="px-6"> -->
        <PrimaryButton class="mx-6 bg-green-600 rounded text-md hover:text-gray-100 focus:text-gray-100" @click="openNewJobModal">
          Add a new Job
        </PrimaryButton>
      <!-- </Link> -->
    </div>

    <Modal :show="newJobModal" @close="closeNewJobModal">
      <form @submit.prevent="submitNewJob">
        <div class="p-6">
          <h2 class="text-lg text-center font-semibold text-gray-900 dark:text-gray-100">
            New Job
          </h2>

          <!-- <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            Once your account is deleted, all of its resources and data will be permanently deleted. Please
            enter your password to confirm you would like to permanently delete your account.
          </p> -->
        
          <div>
            <InputLabel for="name" value="Description" />
            <TextInput
              id="name"
              class="mt-1 block w-full"
              v-model="form.name"
              required
              autofocus
            />
            
            <!-- <InputError class="mt-2" :message="form.errors.password" /> -->
          </div>

          <div>
            <InputLabel for="description" value="Job Name / Job Title" />
            <TextInput
              id="description"
              class="mt-1 block w-full"
              v-model="form.description"
              required
              autofocus
            />
            
            <!-- <InputError class="mt-2" :message="form.errors.password" /> -->
          </div>
        </div>

        <div class="flex justify-end mt-4">
          <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
            Confirm
          </PrimaryButton>
        </div>
      </form>
    </Modal>
  </AuthenticatedLayout>
</template>