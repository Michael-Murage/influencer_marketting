<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import SelectComp from '@/Components/SelectComp.vue';
import { ref } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import countries from '@/Assets/countries';

const props = defineProps({
  auth: {
    type: Object,
    default: { user: null }
  }
});

const pages = ref([1]);
const currentPage = ref(0);
const { auth } = props;
const form = ref({
	active_socials: [],
	name: '',
	username: '',
	gender: '',
	country: '',
	company_name: '',
	type: '',
});
const errors = ref({});
const errorsVisible = ref(false);
const data = ref(false);
const genders = ref(['Male', 'Female', 'Other']);

const showErrors = () => {
  errorsVisible.value = true

  setTimeout(() => {
    errorsVisible.value = false
  }, 5000)
}

function filterAttributes(item, attr) {
  form.value[attr] = form.value[attr].filter(elem => elem !== item);
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

// function nextPage () {
//   if (currentPage.value < pages.value.length - 1) currentPage.value = currentPage.value + 1
//   else submitInfo();
// }

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
			body: JSON.stringify({
        id: auth?.user.id
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

async function nextPage (e) {
	e.preventDefault();
	try {
		const resp = await fetch('/api/verify_info', {
			headers: { 'Content-Type': 'application/json', accept: 'application/json' },
			method: 'POST',
			body: JSON.stringify({
				name: form.name,
				username: form.username,
				page: currentPage.value,
				gender: form.gender,
				country: form.country,
				company_name: form.company_name
			}),
		});
		
		if (resp.ok && resp.status === 200) {
			if (currentPage.value < pages.value.length - 1) currentPage.value = currentPage.value + 1
		} else {
			const errJson = await resp.json();
			errors.value = errJson;
		}
	} catch (error) {
		console.warn(error.message);
	}
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

				<div class="py-3" v-if="currentPage === 0">
					<div class="flex flex-col">
						<InputLabel>Sign Up As</InputLabel>
						<div class="flex items-center mb-4">
							<TextInput id="default-radio-1" type="radio" value="" name="default-radio" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"/>
							<InputLabel for="default-radio-1" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Brand</InputLabel>
						</div>
						<div class="flex items-center">
							<TextInput checked id="default-radio-2" type="radio" value="" name="default-radio" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"/>
							<InputLabel for="default-radio-2" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Creator</InputLabel>
						</div>
					</div>
					<!-- <div id="accountType" name="accountType">
						<
							name="accountType"
							type="radio"
							class="mt-3 block w-full"
							v-model="form.type"
							autocomplete="name"
							placeholder="Sign up as"
						/>
					</div> -->
						<!-- <SelectComp v-model="form.type" class="mt-3 block w-full" placeholder="Signup ">
							<option v-for="gender in genders" :key="gender" :value="gender">
								{{ gender }}
							</option>
						</SelectComp> -->
					<div>
						<TextInput
							id="name"
							type="text"
							class="mt-3 block w-full"
							v-model="form.name"
							autocomplete="name"
							placeholder="Name"
						/>

						<InputError class="mt-2" v-for="error in (errors.name || [])" :key="error" :message="(error)" />
					</div>

					<div>
						<TextInput
							id="username"
							type="text"
							class="mt-3 block w-full"
							v-model="form.username"
							autocomplete="username"
							placeholder="Username"
						/>

						<InputError class="mt-2" v-for="error in (errors.username || [])" :key="error" :message="(error)" />
					</div>

					<div>
						<SelectComp v-model="form.gender" class="mt-3 block w-full" placeholder="Select Gender">
							<option v-for="gender in genders" :key="gender" :value="gender">
								{{ gender }}
							</option>
						</SelectComp>

						<InputError class="mt-2" v-for="error in (errors.gender || [])" :key="error" :message="(error)" />
					</div>

					<div>
						<SelectComp v-model="form.country" class="mt-3 block w-full" placeholder="Select Country">
							<option v-for="country in countries.sort((a, b) => a.name - b.name)" :value="country.name" :key="country.id">
								{{ country.emoji }}  {{ country.name }}
							</option>
						</SelectComp>

						<InputError class="mt-2" v-for="error in (errors.country || [])" :key="error" :message="(error)" />
					</div>

					<div>
						<TextInput
							id="company_name"
							type="text"
							class="mt-3 block w-full"
							v-model="form.company_name"
							autocomplete="company_name"
							placeholder="Company Name"
						/>

						<InputError class="mt-2" v-for="error in (errors.company_name || [])" :key="error" :message="(error)" />
					</div>

					<div class="flex justify-between">
						<!-- <PrimaryButton v-if="form.type === 'brand'" :class="`p-4 my-3 bg-transparent text-blue-500 text-sm hover:underline hover:bg-transparent focus:bg-transparent focus:outline-none`" @click="switchToInfluencer">
							Sign up as a Creator instead
						</PrimaryButton>

						<PrimaryButton class="p-4 my-3 bg-transparent text-sm text-gray-900 hover:bg-transparent">
							Already have an account?
							<Link href="/auth/login" v-if="form.type === 'brand'" :class="`text-blue-500 hover:underline px-2`"> Sign In!</Link>
							<Link href="/auth/login" v-else :class="`text-green-500 hover:underline px-2`"> Sign In!</Link>
						</PrimaryButton> -->
						
						<PrimaryButton v-if="form.type === 'brand'" :class="`p-4 my-3 rounded text-gray-100 bg-green-600 hover:bg-green-500`" @click="nextPage">
							CONTINUE
						</PrimaryButton>
						
						<PrimaryButton v-else :class="`p-4 my-3 rounded text-gray-100 bg-blue-600 hover:bg-blue-500`" @click="nextPage">
							CONTINUE
						</PrimaryButton>
					</div>
				</div>
	
				<!-- <div class="bg-white pt-[30px]">
					<p class="font-bold mx-6 text-[30px]" v-if="auth.user">
            Welcome <span>{{ auth.user.name }}</span>
          </p>
					// <p class="text-gray-500 mx-6 mt-4 mb-5">All fields are required</p>
	
					<div class="flex flex-col">
						<div class="flex justify-between">
							<div class="w-[45%] mx-6">
								<input-label class="text-gray-900">
									How best can you describe your role?
								</input-label>
								<select-comp class="w-full">
									<option value="business_owner">Business Owner</option>
									<option value="marketing">Marketing</option>
									// <option value="agent">Agent</option>
									<option value="youtuber">Youtuber</option>
									// <option value=""></option>
									// <option value=""></option>
								</select-comp>
							</div>

							<div class="w-[45%] mx-6">
								<input-label class="text-gray-900">
									What industry are you in?
								</input-label>
								<select-comp class="w-full">
									<option value="">Select industry</option>
									<option value="music">Music</option>
									<option value="fashion_and_design">Fashion and Design</option>
									<option value="content_creation">Content Creation</option>
									<option value="social_media">Social Media</option>
									// <option value=""></option>
									// <option value=""></option>
								</select-comp>
							</div>
						</div>
	
						<div class="flex justify-between mt-6">
							<div class="w-[45%] mx-6">
								<input-label class="text-gray-900">
									What size is your company?
								</input-label>
								<select-comp class="w-full">
									<option value="1 - 10">1 - 10 persons</option>
									<option value="10 - 50">10 - 50 persons</option>
									<option value="50 - 100">50 - 100 persons</option>
									<option value="> 100">> 100 persons</option>
									// <option value=""></option>
									// <option value=""></option>
								</select-comp>
							</div>
								
							<div class="w-[45%] mx-6">
								<input-label class="text-gray-900">
									What is your website URL?
									<span class="text-sm text-gray-500">
										(optional)
									</span>
								</input-label>
								<text-input
									placeholder="Helps us give you the best experience"
									class="w-full"
								/>
							</div>
						</div>

						<div class="flex justify-between mt-6">
							<div class="w-[45%] mx-6">
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

							<div class="w-[45%] mx-6">
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
														
              	              // <h2 className='weight-heavy py-2'>{data.title}</h2>
              	            </div>
              	            <div className="">
              	              <TextInput
              	                type="file"
              	                className="w-full px-4 py-3"
              	                label="File"
              	                name="file"
              	                required={required}
														
              	              />
														
              	              // <span className="text-red-600">
              	                {errors.file}
              	              // </span>
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
												
              	          // {progress && (
              	            // <div className="w-full bg-gray-200 rounded-full dark:bg-gray-700">
              	              <div className="bg-blue-600 text-xs font-medium text-blue-100 text-center p-0.5 leading-none rounded-full" width={progress.percentage}> </div>
              	            </div>
              	          // )}
              	        </div>
              	      </div>
              	    </div>
              	  </div>
              	</div>
							</div>
						</div>
	
						<div class="flex justify-between mt-[45px] border-t pt-[50px] pb-8">
              <div class="mx-6">
                <p class="text-gray-400 font-semibold">Step {{ currentPage + 1 }} of {{ pages.length }}</p>
              </div>
    
              <div>
                <PrimaryButton class="bg-blue-800 py-3 px-5 text-gray-100 rounded" @click="skipProcess">
                  Skip For Now
                </PrimaryButton>
              </div>
            
              <div class="mx-6">
                <PrimaryButton class="bg-green-600 py-3 px-5 text-gray-100 rounded" @click="submitInfo">
                  {{ currentPage + 1 >= pages.length ? "Finish" : "Next Step" }}
                </PrimaryButton>
              </div>
            </div>
					</div>
				</div> -->
			</div>
		</div>
	</GuestLayout>
</template>
