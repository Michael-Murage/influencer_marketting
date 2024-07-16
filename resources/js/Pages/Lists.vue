<!-- <script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
</script>

<template>
  <AuthenticatedLayout>
    <div class="px-8">
      <div>
        <h1 class="font-semibold text-lg">
          Popular
        </h1>
      </div>
      <div>
        <h1 class="font-semibold text-lg">
          My List
        </h1>
      </div>
    </div>
  </AuthenticatedLayout>
</template> -->

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref,  } from 'vue';
import requestHandler from '@/Services/requestHandler';

const [myLists, setMylists] = [ref([]), (data) => myLists.value = data];
const [appLists, setAppLists] = [ref([]), (data) => appLists.value = data];

// onMounted(() => {
//     getAppLists();
//     getMyLists();
// });

function getMyLists() {
    requestHandler.get('/api/myLists', setMylists);
}

function getAppLists() {
    requestHandler.get('/api/lists', setAppLists);
}

function addToMyList() {

}
</script>

<template>
  <AuthenticatedLayout>
    <div>
        <div class="flex flex-col items-center">
            <h1>Popular</h1>
            <div class="flex">
                <div
                    v-for="list in appLists"
                    class="flex flex-col mx-4 my-3"
                >
                    <h1>{{ list.name }}</h1>
                    <ul>
                        <li
                            v-for="item in (Array.isArray(list.content) ? list.content : [])"
                            class="flex justify-between w-full"
                        >
                            <span>{{ item }}</span>
                            <span
                                @click="addToMyList"
                                class=""
                            >
                                {{ "+" }}
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="flex flex-col items-center">
            <h1>My lists:</h1>
            
            <div class="flex items-center">
                <div
                    v-for="list in myLists"
                    class="flex flex-col mx-4 my-3"
                >
                    <h1>{{ list.name }}</h1>
                    <ul>
                        <li
                            v-for="item in (Array.isArray(list.content) ? list.content : [])"
                            class=""
                        >
                            {{ item }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
  </AuthenticatedLayout>
</template>