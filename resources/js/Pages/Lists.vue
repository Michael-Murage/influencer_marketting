<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { onMounted, ref } from 'vue';
import requestHandler from '@/Services/requestHandler';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Modal from '@/Components/Modal.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import { toast } from 'vue3-toastify';

const props = defineProps({
  auth: {
    type: Object,
    default: { user: null }
  },
});

const [myLists, setMylists] = [ref([]), (data) => myLists.value = data];
const [appLists, setAppLists] = [ref([]), (data) => appLists.value = data];
const [newListModal, setNewListModal] = [ref(false), (bool) => newListModal.value = bool];
const [newListForm, setNewListForm] = [ref({
	title: '',
	user_id: '',
}), (data) => newListForm.value = data];
const [error, setError] = [ref({errors: {}}), (err) => error.value = err];
const [newListItemModal, setNewListItemModal] = [ref(false), (bool) => newListItemModal.value = bool];
const [suggested, setSuggested] = [ref({
	data: [],
  from: 1,
  last_page: 0,
  per_page: 20,
  prev_page_url: null,
  next_page_url: null,
  to: 0,
  total: 0,
}), (data) => suggested.value = data];
const [myListsModal, setMyListsModal] = [ref(false), (data) => myListsModal.value = data];
const [selectedContact, setSelectedContact] = [ref({}), (data) => selectedContact.value = data];
const [myListItems, setMyListitems] = [ref({}), (data) => myListItems.value = data]

onMounted(() => {
    // getAppLists();
    getMyLists();
		getSuggested();
});

const openNewListModal = () => setNewListModal(true);
const closeNewListModal = () => setNewListModal(false);
const openNewListItemModal = () => setNewListItemModal(true);
const closeNewListItemModal = () => setNewListItemModal(false);
const loadListModal = () => setMyListsModal(true);
const closeLoadedListModal = () => setMyListsModal(false);

function getMyLists() {
  requestHandler.get('/api/my_lists', handleFetchedMyLists);
}

function handleFetchedMyLists (data) {
  setMylists(data);
  if (data.length) {
    requestHandler.post(`/api/list_items_by_list_ids`, {lists: data.map(item => item.id)}, handleListItemFetch);
  }
}

function handleListItemFetch(data) {
  setMyListitems(data);
}

function getSuggested() {
	requestHandler.get('/api/suggested', setSuggested);
}

function getAppLists() {
    requestHandler.get('/api/lists', setAppLists);
}

function handleAddContact(member) {
  setSelectedContact(member);
  loadListModal();
}

function addToMyList(listId) {
  requestHandler.post('/api/list_items', { list_id: listId, user_id: selectedContact.value.id }, closeLoadedListModal);
}

function onCloseNewListModal() {
	toast('List added successfully');
	closeNewListModal();
	setNewListForm({
		title: '',
		user_id: '',
	});
}

function submitNewList(e) {
	e.preventDefault();
	newListForm.value.user_id = props.auth.user?.id;
	requestHandler.post('/api/short_lists', newListForm.value, onCloseNewListModal, setError);
}

</script>

<template>
  <AuthenticatedLayout>
    <div>
      <div class="flex flex-col items-center">
				<div class="flex w-full px-8 items-center">
					<h1>Popular</h1>
				</div>
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
        
      <div class="flex flex-col justify-center">
				<div class="flex px-8 items-center w-full">
          <h1>My lists:</h1>
					<div class="ml-auto">
						<PrimaryButton
							class="rounded text-gray-900 hover:text-gray-100 dark:text-gray-100 bg-green-500 dark:bg-green-600 mr-4"
							@click="openNewListModal"
						>
							Create New List
						</PrimaryButton>
					</div>
				</div>
          
        <div class="flex px-8">
          <div
            v-for="list in myLists"
            :class="`flex flex-col mx-4 my-3 px-3 py-2 ${myListItems[list.id]?.length ? 'shadow bg-white' : ''}`"
          >
            <h1 class="font-bold text-lg">{{ list.title }}</h1>
            <ul>
              <li
                v-for="(item, idx) in (Array.isArray(myListItems[list.id]) ? myListItems[list.id] : [])"
                class=""
              >
                <span>{{ idx + 1 }}. </span>
                <span class="hover:underline hover:cursor-pointer">{{ ' ' + item.user.name }}</span>
                <span class="text-gray-400 hover:underline hover:cursor-pointer"> @{{ item.user.username }}</span>
              </li>
            </ul>
          </div>
        </div>
      </div>

			<div class="flex flex-col justify-center">
				<div class="flex px-8 items-center w-full">
          <h1>Suggested:</h1>
					
				</div>
          
        <div class="flex overflow-x-auto px-8 py-4">
          <div
            v-for="member in suggested.data"
            :key="member.id"
            class="flex flex-col flex-grow-0 flex-shrink-0 basis-auto justify-center items-center mt-4 mx-4 bg-white rounded-md shadow-md px-3 pt-2 w-[250px] min-h-[150px]"
          >
						<div class="">
							<img
								v-if="member.profile_pic.length"
								:src="member.profile_pic[0]?.name"
								alt="Profile picture"
								class="rounded-full w-[100px] h-[100px]"
							/>

						</div>
            <h1 class="font-bold text-[24px]">{{ member.name }}</h1>
						<div class="w-full">
              <div v-if="member.profession">
                <span v-for="(profession, idx) in member.profession.split(',')" class="capitalize text-sm">
                  {{ profession.split('_').join(' ') }}
                  {{ `${member.profession.split(',')[idx + 1] ? ' | ' : ''}` }}
                </span>
              </div>
							<h1 v-else class="text-center text-gray-400">(None Selected)</h1>
						</div>

            <div class="ml-auto">
              <button
                class="hover:scale-95 bg-blue-500 text-gray-100 hover:text-gray-200 px-4 py-0.5 rounded shadow mt-3"
                @click="handleAddContact(member)"
              >
                Add
              </button>
            </div>
          </div>
        </div>
      </div>

    </div>

    <Modal
      :show="myListsModal"
      @close="closeLoadedListModal"
    >
      <div>
        <div className="flex items-center justify-between p-2 md:p-3 border-b rounded-t dark:border-gray-600">
          <h3 className="text-xl font-semibold text-gray-900 dark:text-white">
            New List
          </h3>

          <button
            type="button"
            className="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
            @click="closeLoadedListModal"
          >
            <svg className="w-0.5 h-0.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
              <path stroke="currentColor" strokeLinecap="round" strokeLinejoin="round" strokeWidth="0.5" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
            </svg>
            <span className="sr-only">Close modal</span>
          </button>
        </div>

        <div class="">
          <h1 v-for="list in myLists" :key="list.id" class="text-lg hover:bg-blue-200 px-3 py-2 cursor-pointer focus:scale-90" @click="addToMyList(list.id)">
            {{ list.title }}
          </h1>
        </div>
      </div>
    </Modal>


		<Modal
      :show="newListModal"
      @close="closeNewListModal"
    >
      <div>
        <div className="flex items-center justify-between p-2 md:p-3 border-b rounded-t dark:border-gray-600">
          <h3 className="text-xl font-semibold text-gray-900 dark:text-white">
            New List
          </h3>

          <button
            type="button"
            className="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
            @click="closeNewListModal"
          >
            <svg className="w-0.5 h-0.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
              <path stroke="currentColor" strokeLinecap="round" strokeLinejoin="round" strokeWidth="0.5" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
            </svg>
            <span className="sr-only">Close modal</span>
          </button>
        </div>

        <form @submit.prevent="submitNewList">
          <div class="p-6">

            <div class="">
              <InputLabel for="title" value="Name" />
              <TextInput
                id="title"
                name="title"
                class="mt-1 block w-full"
                v-model="newListForm.title"
                required
              />
              
              <InputError
                class="text-red-500 my-1 py-1"
                :message="error.errors.title && error.errors.title[0]"
              />
            </div>
          </div>
  
          <div class="flex justify-end mt-4">
            <PrimaryButton
              class="m-4 py-2 px-3.5 rounded bg-green-500 text-lg text-gray-800 hover:bg-green-600 hover:text-gray-100"
              @click="submitNewList"
            >
              Submit
            </PrimaryButton>
          </div>
        </form>
      </div>
    </Modal>
  </AuthenticatedLayout>
</template>