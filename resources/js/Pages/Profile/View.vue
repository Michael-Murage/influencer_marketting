<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import requestHandler from '@/Services/requestHandler';
import { onMounted, ref } from 'vue';

const [user, setUser] = [ref({}), (data) => user.value = data];

onMounted(() => {
  requestHandler.get('/auth/user', setUser);
})
</script>
<template>
  <AuthenticatedLayout>
    <div class="py-6 px-6 w-full flex flex-col justify-center items-center">
      <div class="border rounded-full h-[200px] w-[200px]">
        
      </div>
      <div class="flex flex-col">
        <div class="flex justify-between items-center">
          <p class="py-3">First Second Name</p>
          <!-- <span>+</span> -->
          <!-- <span class="text-xl">&#9825</span> -->
          <!-- <span>&#x2764</span> -->
        </div>
        <div>
          <textarea
            id="biography"
            rows="4"
            class="outline-none resize-none border-gray-200 bg-transparent"
            disabled
          >Rolihlahla Mandela was born into the Madiba clan in the village of Mvezo, in the Eastern Cape, on 18 July 1918. His mother was Nonqaphi Nosekeni and his father was Nkosi Mphakanyiswa Gadla Mandela, principal counsellor to the Acting King of the Thembu people, Jongintaba Dalindyebo. In 1930, when he was 12 years old, his father died and the young Rolihlahla became a ward of Jongintaba at the Great Place in Mqhekezweni1.

Hearing the elders’ stories of his ancestors’ valour during the wars of resistance, he dreamed also of making his own contribution to the freedom struggle of his people.

Video Overlay Mandela
He attended primary school in Qunu where his teacher, Miss Mdingane, gave him the name Nelson, in accordance with the custom of giving all schoolchildren “Christian” names.
          </textarea>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
