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
    <div class="py-6 px-6 w-full flex flex-col justify-center items-center">
      <div class="">
        <img :src="user.profile_pic[0]?.name" alt="" class="w-[200px] h-[200px] rounded-full border">
      </div>
      <div class="flex flex-col">
        <div class="">
          <p class="py-3 text-center">{{ user.name }}</p>
          <!-- <span>+</span> -->
          <!-- <span class="text-xl">&#9825</span> -->
          <!-- <span>&#x2764</span> -->
        </div>
        <div>
          <p
            id="biography"
            
            class="border-gray-200 bg-transparent w-[300px]"
            
          >{{ user.bio }}</p>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
