<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Modal from '@/Components/Modal.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import MessageElem from '@/Components/MessageElem.vue';
import { ref, onMounted, onBeforeUnmount, watch } from 'vue';
import requestHandler from '@/Services/requestHandler';

const props = defineProps({
  auth: {
    type: Object,
    default: { user: null }
  }
});

const { auth } = props;

const newConversationModal = ref(false);
const newMessageModal = ref(false);
const users = ref([]);
const selectedUser = ref({});
const newMessage = ref('');
const conversations = ref({
  data: [],
  from: 1,
  last_page: 0,
  per_page: 20,
  prev_page_url: null,
  next_page_url: null,
  to: 0,
  total: 0
});
const selectedConversation = ref(null);
const conversationMessages = ref({
  data: [],
  from: 1,
  last_page: 0,
  per_page: 20,
  prev_page_url: null,
  next_page_url: null,
  to: 0,
  total: 0
});
const conversationUsers = ref([]);
const newChatMessage = ref('');

let channel = {};

onMounted(() => {
  fetchConversations();
});

watch(() => selectedConversation.value, () => {
  if (selectedConversation.value) {
    channel = window.Echo.channel(`private.chatmessage.${selectedConversation.value?.id}`);
    channel.subscribed().listen('.chat', (event) => {
    if (event.message) {
      conversationMessages.value.data = [...conversationMessages.value.data, event.message];
    }
  })
  }
})

onBeforeUnmount(() => {
  if (Object.keys(channel).length > 0) {
    channel.unsubscribe('.chat');
  }
});

const setUsers = (data) => users.value = data;
const setConversations = (data) => conversations.value = data;
const setConversationMessages = (data) => conversationMessages.value = data;
const setConversationUsers = (data) => conversationUsers.value = data;

function selectConversation(conversation) {
  requestHandler.get(`/api/conversation_messages/${conversation.id}`, setConversationMessages);
  requestHandler.get(`/api/conversation_users/${conversation.id}`, setConversationUsers);
  selectedConversation.value = conversation;
}

function fetchConversations() {
  requestHandler.get(`/api/conversations/${auth.user?.id}`, setConversations);
}

function openNewConversationModal() {
  newConversationModal.value = true;
  requestHandler.get('/api/users', setUsers);
}

const closeNewConversationModal = () => newConversationModal.value = false;
const openNewMessageModal = () => newMessageModal.value = true;
const closeNewMessageModal = () => newMessageModal.value = false;

function selectUser(currentUser) {
  closeNewConversationModal();
  openNewMessageModal();
  selectedUser.value = currentUser;
}

function submitNewMessage() {
  const data = { user: selectedUser.value.id, message: newMessage.value, sender: auth.user?.id };
  
  requestHandler.post('/api/conversations', data, checkResponse);
}

function submitNewChatMessage(e) {
  e.preventDefault();
  const data = {
    chat_conversation_id: selectedConversation.value.id,
    sender_id: auth.user?.id,
    user_id: conversationUsers.value[1].id,
    message: newChatMessage.value,
  };

  requestHandler.post('/api/chat_messages', data);
}

function checkResponse(resp) {
  if (resp) {
    closeNewMessageModal();
  }
}
</script>

<template>
  <AuthenticatedLayout>
    <div class="flex justify-start items-center">
      <div class="w-[40%] h-[100vh] border-r border-gray-500">
        <div>
          <h1 class="text-lg font-bold text-center">Messages</h1>
        </div>
        <div class="w-full flex justify-end items-center">
          <button @click="openNewConversationModal">
            <svg viewBox="0 0 24 24" class="w-7 h-7 mx-4"><g><path d="M1.998 5.5c0-1.381 1.119-2.5 2.5-2.5h15c1.381 0 2.5 1.119 2.5 2.5V12h-2v-1.537l-8 3.635-8-3.635V18.5c0 .276.224.5.5.5H13v2H4.498c-1.381 0-2.5-1.119-2.5-2.5v-13zm2 2.766l8 3.635 8-3.635V5.5c0-.276-.224-.5-.5-.5h-15c-.276 0-.5.224-.5.5v2.766zM19 18v-3h2v3h3v2h-3v3h-2v-3h-3v-2h3z"></path></g></svg>
          </button>
        </div>
        <div class="my-4">
          <div
            v-for="conversation in conversations.data"
            class="flex justify-start items-center hover:bg-white border border-hidden hover:border w-full cursor-pointer"
            @click="selectConversation(conversation)"
          >
            <div class="pl-4 pr-3">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 512 512"
                class="w-10 h-10"
                fill="rgb(55 65 81)"
              >
                <path d="M399 384.2C376.9 345.8 335.4 320 288 320H224c-47.4 0-88.9 25.8-111 64.2c35.2 39.2 86.2 63.8 143 63.8s107.8-24.7 143-63.8zM0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256zm256 16a72 72 0 1 0 0-144 72 72 0 1 0 0 144z"/>
              </svg>
            </div>
            
            <div class="py-3 flex flex-col">
              <div class="flex justify-start items-center">
                <h1 class="text-lg font-bold px-2">
                  {{ conversation.user_1_name === auth.user?.name ? conversation.user_2_name : conversation.user_1_name }}
                </h1>
                <h1 v-if="conversation.user_1_name === conversation.user_2_name" class="text-md text-gray-500 px-1">(yourself)</h1>
              </div>
  
              <div class="px-2">
                <p>{{ conversation.latest_message?.content.slice(0, 150) }}</p>
              </div>
            </div>
          </div>

          
        </div>
      </div>
      <div class="w-[60%] h-[100vh]">
        <div class="w-full bg-white py-3">
          <h1 class="font-bold text-lg text-center" v-if="selectedConversation">
            {{ selectedConversation.user_1_name === auth.user?.name ? selectedConversation.user_2_name : selectedConversation.user_1_name }}
          </h1>
          <h1 class="font-bold text-lg text-center" v-else>Chats</h1>
        </div>
    
        <div class="w-full">
          <div class="w-full rounded-md bg-gray-100 dark:bg-gray-900 h-[calc(100vh-200px)] overflow-y-scroll" ref='chatContainer'>
            <div v-if="selectedConversation">
              <MessageElem
                v-for="message in conversationMessages.data"
                :conversationUsers="conversationUsers"
                :message="message"
                :currentUserId="auth.user?.id"
              />
            </div>

            <div v-else class="flex justify-center items-center h-full">
              <h1>Select a conversation to continue</h1>
            </div>
            
            <div ref='messagesEnd' />
          </div>
  
            <form
              class='w-full md:pt-0 dark:border-white/20 md:border-transparent md:dark:border-transparent md:w-[calc(100%-.5rem)] juice:w-full shadow-md flex justify-start'
              v-if="selectedConversation"
              @submit="(e) => submitNewChatMessage(e)"
            >
              <textarea
                name="new-message"
                rows="2"
                placeholder='Enter your message'
                v-model="newChatMessage"
                class="block p-2.5 w-full text-sm text-gray-900 outline-none bg-transparent rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-50 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
              />
              <button
                type="submit"
                class="text-gray-900 focus:scale-90 focus:ring-2 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
              >
                Send
                <!-- <Icon src='send' class='h-4 w-4' fill='var(--gray)'/> -->
              </button>
            </form>
        </div>
      </div>
    </div>

    <Modal :show="newConversationModal" @close="closeNewConversationModal">
      <div class="px-2 py-5">
        <h1 class="text-lg font-bold text-center">New Message</h1>

        <div>
          <div
            v-for="user in (Array.isArray(users) ? users : [])"
            :key="user.id"
            class="w-full border rounded-lg border-hidden hover:bg-gray-300 py-3"
            @click="() => selectUser(user)"
          >
            <div class="flex justify-start items-center">
              <h1 class="text-lg font-bold px-2">{{ user.name }}</h1>
              <h1 class="text-md text-gray-500 px-1">@{{ user.username }}</h1>
            </div>
          </div>
        </div>
      </div>
    </Modal>

    <Modal :show="newMessageModal" @close="closeNewMessageModal">
      <form class="px-2 py-5 flex flex-col justify-center items-center" @submit.prevent="submitNewMessage">
        <h1 class="font-bold text-lg py-3 text-center">{{ selectedUser.name }}</h1>

        <TextInput
          placeholder="Enter your message"
          v-model="newMessage"
          class="w-full"
        />

        <PrimaryButton class="py-2 px-4 my-4 bg-blue-600 hover:bg-blue-500 text-gray-100 rounded hover:cursor-pointer text-lg">
          Send
        </PrimaryButton>
      </form>
    </Modal>
  </AuthenticatedLayout>
</template>