<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import SelectComp from '@/Components/SelectComp.vue';
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
  auth: {
    type: Object,
    default: { user: null }
  }
});

const { auth } = props;

// const pages = ref([1, 2, 3, 4, 5]);
const pages = ref([1, 2, 3, 4]);
const currentPage = ref(0);
const form = ref({
  id: auth.user.id,
  profession: [],
  interest: [],
  active_socials: [],
  profile_pic: '',
  pic_1: '',
  pic_2: '',
  pic_3: '',
});
const otherValue = ref('');
const errors = ref({});
const errorsVisible = ref(false);
const data = ref(false);

const showErrors = () => {
  errorsVisible.value = true

  setTimeout(() => {
    errorsVisible.value = false
  }, 5000)
}

function handleArrayChange(e, attr) {
  if (e.currentTarget.checked) {
    if (attr === 'profession' || attr === 'interest') {
      if (form.value[attr].length < 3) {
        form.value[attr] = [...form.value[attr], e.target.value];
      } else {
        e.currentTarget.checked = false;
        errors.value[attr] = ['Maximum values reached'];
        showErrors();
      }
    } else if (attr === 'active_socials') {
      form.value[attr] = [...form.value[attr], e.target.value];
    }
  } else {
    filterAttributes(e.target.value, attr);
  }
}

function appendToOthers(attr) {
  if (attr === 'profession' || attr === 'interest') {
    handleArrayChange({target: {value: otherValue.value}, currentTarget: {checked: true}}, attr);
  }
  otherValue.value = '';
}

function toggleOtherProfessionFalse() {
  // otherProfessionToggle.value = false;
  handleArrayChange({target: {}}, 'profession');
  otherValue.value = '';
}

function prevPage () {
	if (currentPage.value > 0) currentPage.value = currentPage.value - 1;
}

function nextPage () {
  if (currentPage.value < pages.value.length - 1) currentPage.value = currentPage.value + 1
  else submitInfo();
}

async function skipProcess () {
  // console.log(auth.user.id)
  try {
		const resp = await fetch(`/api/skip_extra_info/${auth.user.id}`, {
			headers: { 'Content-Type': 'application/json', accept: 'application/json' },
			method: 'POST',
			body: JSON.stringify({
        id: auth.user.id
      }),
		})
		
		if (resp.ok && resp.status === 200) {
      router.visit('/dashboard')
    } else {
			const errJson = await resp.json();
			console.warn(errJson);
			errors.value = errJson;
		}
	} catch (error) {
		console.warn(error.message);
	}
}

async function submitInfo () {
  try {
		const resp = await fetch('/api/submit_extra_info', {
			headers: { 'Content-Type': 'application/json', accept: 'application/json' },
			method: 'POST',
			body: JSON.stringify(form),
		})
		
		if (resp.ok && resp.status === 200) {
      router.visit('/dashboard')
    } else {
			const errJson = await resp.json();
			console.warn(errJson);
			errors.value = errJson;
		}
	} catch (error) {
		console.warn(error.message);
	}
}

function filterAttributes(item, attr) {
  form.value[attr] = form.value[attr].filter(elem => elem !== item);
}
</script>

<template>
	<GuestLayout>
		<div class="min-h-screen flex justify-center bg-gray-400">
			<div action="" class="rounded-lg w-[95%] my-[20px]">
				<div class="bg-gray-300 flex justify-between">
					<div class="mr-auto ml-6">
						<h1 class="text-[45px] font-bold text-left py-3 tracking-wide">How do you plan to use FUSS?</h1>
						<h3 class="text-lg font-semibold text-left py-3 tracking-widest">We'll use this to recommend the best path for getting started.</h3>
					</div>
	
					<div class="bg-gray-200 w-[300px] h-[200px] mx-[30px] my-[10px] rounded-lg"></div>
				</div>
	
				<div class="bg-white pt-[30px]">
					<p class="font-bold mx-6 text-[30px]" v-if="auth.user">
            Welcome <span>{{ auth.user.name }}</span>
          </p>
					<!-- <p class="text-gray-500 mx-6 mt-4 mb-5">All fields are required</p> -->

          <div class="py-3 ml-6">
            <div class="py-3 ml-6" v-if="currentPage === 0">
              <div>
                <div v-if="errors.profession && errorsVisible">
                  <p v-for="(error, ind) in errors.profession" :key="ind" class="text-red-500 text-md">
                    {{ error }}
                  </p>
                </div>
                <h1 class="text-xl">I am a ? <span class="text-gray-500 text-md">(choose at most 3)</span></h1>
                <div class="flex" v-if="form.profession.length">
                  <div v-for="(item, ind) in form.profession" :key="ind" class="mx-2 px-3 flex bg-green-400 items-center justify-between rounded-lg">
                    <p class="text-sm">
                      {{ item?.split('_').join(' ').toUpperCase() || 'None added' }}
                    </p>
                    <p title="Remove item" class="hover:scale-110 hover:font-bold text-xs text-red-500 ml-3 cursor-pointer" @click="filterAttributes(item, 'profession')">
                      x
                    </p>
                  </div>
                </div>
                <div v-else>
                  <p class="text-gray-500">None added</p>
                </div>
              </div>
              
  
              <div class="">
                <div class="block my-2">
                  <TextInput
                    type="checkbox"
                    id="profession_1"
                    name="profession_1"
                    class="inline"
                    value="content_creator"
                    @change="(e) => handleArrayChange(e, 'profession')"
                  />
                  <InputLabel for="profession_1" class="inline mx-3">
                    Content Creator
                  </InputLabel>
                </div>
  
                <div class="block my-2">
                  <TextInput
                    type="checkbox"
                    id="profession_2"
                    name="profession_2"
                    class="inline"
                    value="podcasts"
                    @change="(e) => handleArrayChange(e, 'profession')"
                  />
                  <InputLabel for="profession_2" class="inline mx-3">
                    Podcasts
                  </InputLabel>
                </div>
  
                <div class="block my-2">
                  <TextInput
                    type="checkbox"
                    id="profession_3"
                    name="profession_3"
                    class="inline"
                    value="youtube_channel"
                    @change="(e) => handleArrayChange(e, 'profession')"
                  />
                  <InputLabel for="profession_3" class="inline mx-3">
                    Youtube Channel
                  </InputLabel>
                </div>
  
                <div class="block my-2">
                  <TextInput
                    type="checkbox"
                    id="profession_4"
                    name="profession_4"
                    class="inline"
                    value="musician"
                    @change="(e) => handleArrayChange(e, 'profession')"
                  />
                  <InputLabel for="profession_4" class="inline mx-3">
                    Musician
                  </InputLabel>
                </div>
  
                <div class="block my-2">
                  <TextInput
                    id="profession_3"
                    name="profession_3"
                    class="inline"
                    v-model="otherValue"
                  />
                  <InputLabel v-if="!otherValue" for="profession_3" class="inline mx-3">
                    Other (specify)
                  </InputLabel>
                  <PrimaryButton v-if="otherValue" @click="appendToOthers('profession')" class="bg-green-500 hover:opacity-70 text-gray-900 mx-3">
                    Add
                  </PrimaryButton>
                </div>
              </div>
            </div>
  
            <div class="py-3 ml-6" v-if="currentPage === 1">
              <div>
                <div v-if="errors.interest && errorsVisible">
                  <p v-for="(error, ind) in errors.interest" :key="ind" class="text-red-500 text-md">
                    {{ error }}
                  </p>
                </div>
                <h1 class="text-xl">Tell us about your interest <span class="text-gray-500 text-md">(choose at most 3)</span></h1>
                <div class="flex" v-if="form.interest.length">
                  <div v-for="(item, ind) in form.interest" :key="ind" class="mx-2 px-3 flex bg-green-400 items-center justify-between rounded-lg">
                    <p class="text-sm">
                      {{ item?.split('_').join(' ').toUpperCase() || 'None added' }}
                    </p>
                    <p title="Remove item" class="hover:scale-110 hover:font-bold text-xs text-red-500 ml-3 cursor-pointer" @click="filterAttributes(item, 'interest')">
                      x
                    </p>
                  </div>
                </div>
                <div v-else>
                  <p class="text-gray-500">None added</p>
                </div>
              </div>
              
  
              <div class="">
                <div class="block my-2">
                  <TextInput
                    type="checkbox"
                    id="interest_1"
                    name="interest_1"
                    class="inline"
                    value="personal_finance"
                    @change="(e) => handleArrayChange(e, 'interest')"
                  />
                  <InputLabel for="interest_1" class="inline mx-3">
                    Personal Finance
                  </InputLabel>
                </div>
  
                <div class="block my-2">
                  <TextInput
                    type="checkbox"
                    id="interest_2"
                    name="interest_2"
                    class="inline"
                    value="fashion"
                    @change="(e) => handleArrayChange(e, 'interest')"
                  />
                  <InputLabel for="interest_2" class="inline mx-3">
                    Fashion
                  </InputLabel>
                </div>
  
                <div class="block my-2">
                  <TextInput
                    type="checkbox"
                    id="interest_3"
                    name="interest_3"
                    class="inline"
                    value="music"
                    @change="(e) => handleArrayChange(e, 'interest')"
                  />
                  <InputLabel for="interest_3" class="inline mx-3">
                    Music
                  </InputLabel>
                </div>
  
                <div class="block my-2">
                  <TextInput
                    type="checkbox"
                    id="interest_4"
                    name="interest_4"
                    class="inline"
                    value="lifestyle"
                    @change="(e) => handleArrayChange(e, 'interest')"
                  />
                  <InputLabel for="interest_4" class="inline mx-3">
                    Lifestyle
                  </InputLabel>
                </div>
  
                <div class="block my-2">
                  <TextInput
                    type="checkbox"
                    id="interest_5"
                    name="interest_5"
                    class="inline"
                    value="fitness"
                    @change="(e) => handleArrayChange(e, 'interest')"
                  />
                  <InputLabel for="interest_5" class="inline mx-3">
                    Fitness
                  </InputLabel>
                </div>
  
                <div class="block my-2">
                  <TextInput
                    type="checkbox"
                    id="interest_6"
                    name="interest_6"
                    class="inline"
                    value="cars"
                    @change="(e) => handleArrayChange(e, 'interest')"
                  />
                  <InputLabel for="interest_6" class="inline mx-3">
                    Cars
                  </InputLabel>
                </div>
  
                <div class="block my-2">
                  <TextInput
                    id="interest_7"
                    name="interest_7"
                    class="inline"
                    v-model="otherValue"
                  />
                  <InputLabel v-if="!otherValue" for="interest_7" class="inline mx-3">
                    Other (specify)
                  </InputLabel>
                  <PrimaryButton v-if="otherValue" @click="appendToOthers('interest')" class="bg-green-500 hover:opacity-70 text-gray-900 mx-3">
                    Add
                  </PrimaryButton>
                </div>
              </div>
            </div>
  
            <div class="py-3 ml-6" v-if="currentPage === 2">
              <div>
                <div v-if="errors.active_socials && errorsVisible">
                  <p v-for="(error, ind) in errors.active_socials" :key="ind" class="text-red-500 text-md">
                    {{ error }}
                  </p>
                </div>
                <h1 class="text-xl">What social media are you active on?</h1>
                <div class="flex" v-if="form.active_socials.length">
                  <div v-for="(item, ind) in form.active_socials" :key="ind" class="mx-2 px-3 flex bg-green-400 items-center justify-between rounded-lg">
                    <p class="text-sm">
                      {{ item?.split('_').join(' ').toUpperCase() || 'None added' }}
                    </p>
                    <p title="Remove item" class="hover:scale-110 hover:font-bold text-xs text-red-500 ml-3 cursor-pointer" @click="filterAttributes(item, 'interest')">
                      x
                    </p>
                  </div>
                </div>
                <div v-else>
                  <p class="text-gray-500">None added</p>
                </div>
              </div>
              
  
              <div class="">
                <div class="block my-2">
                  <TextInput
                    type="checkbox"
                    id="active_socials_1"
                    name="active_socials_1"
                    class="inline"
                    value="X"
                    @change="(e) => handleArrayChange(e, 'active_socials')"
                  />
                  <InputLabel for="active_socials_1" class="inline mx-3">
                    X
                  </InputLabel>
                </div>
  
                <div class="block my-2">
                  <TextInput
                    type="checkbox"
                    id="active_socials_2"
                    name="active_socials_2"
                    class="inline"
                    value="tiktok"
                    @change="(e) => handleArrayChange(e, 'active_socials')"
                  />
                  <InputLabel for="active_socials_2" class="inline mx-3">
                    Tiktok
                  </InputLabel>
                </div>
  
                <div class="block my-2">
                  <TextInput
                    type="checkbox"
                    id="active_socials_3"
                    name="active_socials_3"
                    class="inline"
                    value="youtube"
                    @change="(e) => handleArrayChange(e, 'active_socials')"
                  />
                  <InputLabel for="active_socials_3" class="inline mx-3">
                    Youtube
                  </InputLabel>
                </div>
  
                <div class="block my-2">
                  <TextInput
                    type="checkbox"
                    id="active_socials_4"
                    name="active_socials_4"
                    class="inline"
                    value="facebook"
                    @change="(e) => handleArrayChange(e, 'active_socials')"
                  />
                  <InputLabel for="active_socials_4" class="inline mx-3">
                    Facebook
                  </InputLabel>
                </div>
  
                <div class="block my-2">
                  <TextInput
                    type="checkbox"
                    id="active_socials_5"
                    name="active_socials_5"
                    class="inline"
                    value="instagram"
                    @change="(e) => handleArrayChange(e, 'active_socials')"
                  />
                  <InputLabel for="active_socials_5" class="inline mx-3">
                    Instagram
                  </InputLabel>
                </div>
              </div>
            </div>
  
            <div class="py-3 ml-6" v-if="currentPage === 3">
              <div>
                <div v-if="errors.profile_pic && errorsVisible">
                  <p v-for="(error, ind) in errors.profile_pic" :key="ind" class="text-red-500 text-md">
                    {{ error }}
                  </p>
                </div>
                <h1 class="text-xl">Upload a profile picture</h1>
              
                <div className="py-1">
                  <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                      <div className="p-6 bg-white border-b border-gray-200">
                          
                        <div className="flex flex-row">
                          <div className="py-2">
  
                            <!-- <h2 className='weight-heavy py-2'>{data.title}</h2> -->
                          </div>
                          <div className="">
                            <TextInput
                              type="file"
                              className="w-full px-4 py-3"
                              label="File"
                              name="file"
                              required={required}
                              
                            />
  
                            <!-- <span className="text-red-600">
                              {errors.file}
                            </span> -->
                          </div>
                                    
                          <div className="my-2 mx-4">
                            <button
                              type="submit"
                              class="px-6 py-2 font-bold text-white bg-green-600 rounded-md hover:text-green-600 hover:bg-gray-100"
                            >
                              Save
                            </button>
                          </div>
                        </div>

                        <!-- {progress && ( -->
                          <!-- <div className="w-full bg-gray-200 rounded-full dark:bg-gray-700">
                            <div className="bg-blue-600 text-xs font-medium text-blue-100 text-center p-0.5 leading-none rounded-full" width={progress.percentage}> </div>
                          </div> -->
                        <!-- )} -->
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="flex justify-between mt-[30px] border-t pt-[50px] pb-8">
              <div class="mx-6">
                <p class="text-gray-400 font-semibold">Step {{ currentPage + 1 }} of {{ pages.length }}</p>
              </div>
    
              <div>
                <PrimaryButton class="bg-blue-800 py-3 px-5 rounded text-gray-100" @click="skipProcess">
                  Skip For Now
                </PrimaryButton>
              </div>
            
              <div class="mx-6">
                <PrimaryButton class="bg-green-600 py-3 px-5 rounded text-gray-100" @click="nextPage">
                  {{ currentPage + 1 >= pages.length ? "Finish" : "Next Step" }}
                </PrimaryButton>
              </div>
            </div>
          </div>
				</div>

			</div>
		</div>
	</GuestLayout>
</template>

<style scoped>
.hideMe {
  -moz-animation: cssAnimation 0s ease-in 5s forwards;
  /* Firefox */
  -webkit-animation: cssAnimation 0s ease-in 5s forwards;
  /* Safari and Chrome */
  -o-animation: cssAnimation 0s ease-in 5s forwards;
  /* Opera */
  animation: cssAnimation 0s ease-in 5s forwards;
  -webkit-animation-fill-mode: forwards;
  animation-fill-mode: forwards;
}
@keyframes cssAnimation {
  to {
    width:0;
    height:0;
    overflow:hidden;
  }
}
@-webkit-keyframes cssAnimation {
  to {
    width:0;
    height:0;
    visibility:hidden;
  }
}
</style>