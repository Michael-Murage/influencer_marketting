<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import requestHandler from '@/Services/requestHandler';
import { onMounted, ref } from 'vue';

const [user, setUser] = [ref({profile_pic: []}), (data) => user.value = data];

onMounted(() => {
  requestHandler.get('/auth/user', setUser);
})
</script>
<template>
  <AuthenticatedLayout>
    <div class="bg-gray-100 min-h-screen p-6">
      <header class="shadow p-4 rounded-lg mb-6">
        <h1 class="text-3xl font-bold text-gray-800 text-center">User Profile</h1>
      </header>

      <div class="max-w-3xl mx-auto bg-white shadow-md rounded-lg overflow-hidden">
        <div class="flex items-center p-4">
          <img
            :src="user.profile_pic[0]?.name"
            alt="Profile Picture"
            class="w-24 h-24 object-cover rounded-full border-2 border-gray-300"
          />
          <div class="ml-4">
            <h2 class="text-2xl font-bold text-gray-800">{{ user.name }}</h2>
            <p class="text-gray-600">{{ user.bio && user.bio.length > 150 ? user.bio?.slice(0, 150).concat('...') : user.bio }}</p>
            <p class="text-gray-600 py-2">{{ user.email }}</p>
          </div>
        </div>

        <div class="p-4 border-t border-gray-200">
          <h3 class="text-lg font-semibold text-gray-800">Links</h3>
          <div class="flex mt-2">
            <a
              
              :href="'https://johndoe.com'"
              target="_blank"
              class="text-blue-500 hover:underline mr-4"
            >
              Website
            </a>
            <a
              
              :href="'https://instagram.com/johndoe'"
              target="_blank"
              class="text-blue-500 hover:underline"
            >
              Instagram
            </a>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
