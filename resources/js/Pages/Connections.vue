<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref } from 'vue';

const [connections, setConnections] = [ref([]), (data) => connections.value = data];
</script>

<template>
  <AuthenticatedLayout>
    <div class="w-full mb-4">
      <div class="bg-white rounded-md m-3">
        <div class="border-b py-2 px-4">
          <h1>Pending Connections</h1>
        </div>
        <div class="px-4 py-2 flex">
          <div class="h-10 w-10 rounded-full bg-gray-200 mr-4"></div>
          <p class="flex flex-col">
            <span>Michael Murage @mickey</span>
            <span>mike@mail.net</span>
          </p>
          <div class="ml-auto my-auto">
            <button class="bg-blue-500 text-gray-100 hover:bg-green-500 hover:shadow-md px-5 py-2 rounded-full">
              Accept
            </button>
          </div>
        </div>
      </div>
    </div>

    <div class="w-full">
      <div class="bg-white rounded-md m-3">
        <div class="border-b py-2 px-4">
          <h1>Connections</h1>
        </div>
        <div class="px-4 py-2 flex">
          <div class="h-10 w-10 rounded-full bg-gray-200 mr-4"></div>
          <p class="flex flex-col">
            <span>Michael Murage @mickey</span>
            <span>mike@mail.net</span>
          </p>
          <div class="ml-auto my-auto">
            <button class="bg-blue-500 text-gray-100 hover:bg-green-500 hover:shadow-md px-5 py-2 rounded-full">
              Connect
            </button>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>