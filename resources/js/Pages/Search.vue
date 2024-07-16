<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import requestHandler from '@/Services/requestHandler';
import { ref, watch } from 'vue';

const searchText = ref('');
const [usersSearched, setUsersSearched] = [ref([]), (data) => usersSearched.value = data]

watch(() => searchText.value, () => {
  if (searchText.value.length > 2) {
    fetchSearchResult();
  }
});

function navigateBack() {
  window.history.back();
}

function fetchSearchResult() {
  setTimeout(() => {
    requestHandler.get(`/api/search_users?search=${searchText.value}`, setUsersSearched);
  }, 800);
}
</script>
<template>
  <AuthenticatedLayout>
    <section class="flex h-full min-h-0 overflow-hidden flex-1 p-6">
      <div class="flex flex-col w-full bg-white dark:bg-slate-900">
        <div class="flex p-4">
          <button
            type="button"
            @click="navigateBack"
            class="flex justify-between items-center bg-gray-100 hover:bg-transparent hover:text-green-500 px-6 rounded py-2 text-gray-900"
          >
            <svg
              width="16"
              height="16"
              fill="none"
              viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg"
              class="text-woot-400 dark:text-woot-500 icon--font chevron-left"
            >
              <path
                d="M15.53 4.22a.75.75 0 0 1 0 1.06L8.81 12l6.72 6.72a.75.75 0 1 1-1.06 1.06l-7.25-7.25a.75.75 0 0 1 0-1.06l7.25-7.25a.75.75 0 0 1 1.06 0Z"
                fill="currentColor"
                class="chevron-left-1"
              />
            </svg>
            <p class="p-0 m-0">
              Back
            </p>
          </button>
        </div>
        
        <section
          class="flex my-0 p-4 relative mx-auto max-w-[45rem] min-h-[20rem] flex-col w-full h-full bg-white dark:bg-slate-900"
        >
          <header>
            <div class="relative flex items-center py-2 px-4 rounded-sm border border-solid border-slate-100 dark:border-slate-800">
              <div class="flex items-center">
                <svg
                  width="20"
                  height="20"
                  fill="none"
                  viewBox="0 0 24 24"
                  xmlns="http://www.w3.org/2000/svg"
                  aria-hidden="true"
                  class="text-slate-400"
                >
                  <path
                    d="M10 2.75a7.25 7.25 0 0 1 5.63 11.819l4.9 4.9a.75.75 0 0 1-.976 1.134l-.084-.073-4.901-4.9A7.25 7.25 0 1 1 10 2.75Zm0 1.5a5.75 5.75 0 1 0 0 11.5 5.75 5.75 0 0 0 0-11.5Z"
                    fill="currentColor"
                    class="search-1"
                  />
                </svg>
              </div>
              <input
                type="search"
                placeholder="Type 3 or more characters to search"
                class="w-full m-0 shadow-none border-transparent active:border-transparent active:shadow-none hover:border-transparent hover:shadow-none focus:border-transparent focus:shadow-none"
                v-model="searchText"
              />
              <div
                title=""
                class="m-0 label   small"
              >
                <!-- <span>/ to focus</span> -->
              </div>
            </div>
          </header>
          <div class="flex-grow h-full overflow-y-auto py-0 px-2">
            <div v-if="usersSearched.length === 0" class="flex flex-col items-center justify-center py-6 px-4 rounded-md mt-8 text-center">
              <p class="text-center margin-bottom-0">
                <svg
                  width="24px"
                  height="24px"
                  fill="none"
                  viewBox="0 0 24 24"
                  xmlns="http://www.w3.org/2000/svg"
                  class="text-slate-500 dark:text-slate-400"
                >
                  <path
                    d="M10 2.75a7.25 7.25 0 0 1 5.63 11.819l4.9 4.9a.75.75 0 0 1-.976 1.134l-.084-.073-4.901-4.9A7.25 7.25 0 1 1 10 2.75Zm0 1.5a5.75 5.75 0 1 0 0 11.5 5.75 5.75 0 0 0 0-11.5Z" 
                    fill="currentColor"
                    class="search-1"
                  />
                </svg>
              </p>
              <p class="text-center text-slate-500 dark:text-slate-400 m-2">
                Search people
              </p>
            </div>

            <div class="mt-16">
              <div
                v-for="result in usersSearched"
                class="w-full bg-transparent hover:bg-gray-100 rounded py-2 px-4 text-gray-600 flex"
              >
                <div class="w-10 h-10 bg-gray-100 mx-3">
                  
                </div>
                <p class="flex flex-col">
                  <span>
                    {{ result.name }} {{ `@${result.username}` }}
                  </span>
                  <span>{{ result.email }}</span>
                </p>
              </div>
            </div>
          </div>
        </section>
      </div>
    </section>
  </AuthenticatedLayout>
</template>
