<script setup>
import { ref, watch } from 'vue';

const props = defineProps({
  conversationUsers: {
    type: Array,
    default: () => [],
  },
  message: {
    type: Object,
    default: {
      content: '',
      message_status: '',
    }
  },
  currentUserId: {
    type: Number,
    default: null,
  },
});

const { message, currentUserId } = props;
const conversationUsers = ref(props.conversationUsers);

watch(() => props.conversationUsers, () => {
  conversationUsers.value = props.conversationUsers;
})

function parseMessageSender() {
  const sender = conversationUsers.value.find(user => user.id === message.sender_id);
  return sender?.name;
}

function parseCreatedAtDate(date) {
  const createdAt = new Date(date); 
  return createdAt.toLocaleDateString('en-UK');
}

function parseCreatedAtTime(date) {
  const createdAt = new Date(date); 
  return createdAt.toLocaleTimeString('en-UK');
}
</script>

<template>
  <div :class="`flex items-start gap-2.5 py-3 px-2.5 w-fit ${currentUserId === message.sender_id ? 'ml-auto' : 'mr-auto'}`">
    <div class="flex flex-col w-full max-w-[320px] leading-1.5 p-4 border-gray-200 bg-white rounded-e-xl rounded-es-xl dark:bg-gray-700">
        <div class="flex items-center space-x-2 rtl:space-x-reverse">
          <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ parseMessageSender() }}</span>
          <span class="text-sm font-normal text-gray-500 dark:text-gray-400">{{ parseCreatedAtDate(message.created_at) }}</span>
        </div>
        <p class="text-sm font-normal py-2.5 text-gray-900 dark:text-white">{{ message.content }}</p>
        <span class="text-sm font-normal text-gray-500 dark:text-gray-400">{{ parseCreatedAtTime(message.created_at) }} Delivered</span>
    </div>
    <button id="dropdownMenuIconButton" data-dropdown-toggle="dropdownDots" data-dropdown-placement="bottom-start" class="inline-flex self-center items-center p-2 text-sm font-medium text-center text-gray-900 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-900 dark:hover:bg-gray-800 dark:focus:ring-gray-600" type="button">
        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 4 15">
          <path d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"/>
        </svg>
    </button>
    <div id="dropdownDots" class="`z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-40 dark:bg-gray-700 dark:divide-gray-600 ${}`">
      <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownMenuIconButton">
        <li>
            <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Reply</a>
        </li>
        <li>
            <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Forward</a>
        </li>
        <li>
            <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Copy</a>
        </li>
        <li>
            <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Report</a>
        </li>
        <li>
            <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Delete</a>
        </li>
      </ul>
    </div>
  </div>
</template>