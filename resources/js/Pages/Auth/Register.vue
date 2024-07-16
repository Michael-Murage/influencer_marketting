<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import SelectComp from '@/Components/SelectComp.vue';
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import countries from '@/Assets/countries';
import SecondaryButton from '@/Components/SecondaryButton.vue';

const props = defineProps({
	page: {
		type: Number,
		default: 0,
	},
});

const pages = ref([1, 2]);
const genders = ref(['Male', 'Female', 'Other']);
const currentPage = ref(props.page);
const form = useForm({
  name: '',
	username: '',
	company_name: '',
  email: '',
	country: '',
	gender: '',
	country_code: '',
	phone_number: null,
	type: 'brand',
  password: '',
  password_confirmation: '',
	terms_and_conditions: false,
});

const token = document.head.querySelector('meta[name="csrf-token"]').content;

const errors = ref({});

function switchToInfluencer (e) {
	e.preventDefault();
	form.type = 'influencer';
}

const submit = async (e) => {
	e.preventDefault();

	// form.post(route('register'), {
  //   onFinish: () => form.reset('password', 'password_confirmation'),
  // });
	// debugger

	try {
		const resp = await fetch('register', {
			headers: { 'Content-Type': 'application/json', accept: 'application/json', 'X-CSRF-TOKEN': token },
			method: 'POST',
			body: JSON.stringify(form)
		})
		
		if (resp.ok && resp.status === 200) {
			router.visit('/email/verify');
		} else {
			const errJson = await resp.json();
			console.warn(errJson);
			errors.value = errJson;
		}
	} catch (error) {
		console.warn(error.message);
	}
};

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
			console.warn(errJson);
			errors.value = errJson;
		}
	} catch (error) {
		console.warn(error.message);
	}
}

function prevPage () {
	if (currentPage.value > 0) currentPage.value = currentPage.value - 1;
}

function handleChecked (e) {
	form.terms_and_conditions = e.target.checked;
}
</script>

<template>
  <GuestLayout>
    <Head title="Register" />

    <div class="min-h-screen flex justify-center items-center bg-gray-100">
			<form action="" class="rounded-lg w-[55%] my-[15px]">

				<div class="text-center">
					<h1 :class="`text-[40px] font-semibold font-[Helvetica]`">
						<span v-if="form.type === 'brand'" class="text-green-600">BRAND ONBOARDING</span>
						<span v-else class="text-blue-600">INFLUENCER ONBOARDING</span>
					</h1>
				</div>

				<div class="py-3" v-if="currentPage === 0">
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
						<PrimaryButton v-if="form.type === 'brand'" :class="`p-4 my-3 bg-transparent text-blue-500 text-sm hover:underline hover:bg-transparent focus:bg-transparent focus:outline-none`" @click="switchToInfluencer">
							Sign up as an Influencer instead
						</PrimaryButton>

						<PrimaryButton class="p-4 my-3 bg-transparent text-sm text-gray-900 hover:bg-transparent">
							Already have an account?
							<Link href="/auth/login" v-if="form.type === 'brand'" :class="`text-blue-500 hover:underline px-2`"> Sign In!</Link>
							<Link href="/auth/login" v-else :class="`text-green-500 hover:underline px-2`"> Sign In!</Link>
						</PrimaryButton>
						
						<PrimaryButton v-if="form.type === 'brand'" :class="`p-4 my-3 rounded text-gray-100 bg-green-600 hover:bg-green-500`" @click="nextPage">
							CONTINUE
						</PrimaryButton>
						
						<PrimaryButton v-else :class="`p-4 my-3 rounded text-gray-100 bg-blue-600 hover:bg-blue-500`" @click="nextPage">
							CONTINUE
						</PrimaryButton>
					</div>
				</div>

				<div class="py-3" v-else-if="currentPage === 1">
					<div>
						<div class="ml-auto">
							<SelectComp v-model="form.country_code" class="w-[30%]" placeholder="Code">
								<option v-for="country in countries.sort((a,b) => a.dial_code - b.dial_code)" :value="country.dial_code" :key="country.id">
									{{ country.emoji }} {{ country.dial_code }}
								</option>
							</SelectComp>
		
							<TextInput
								id="phone_number"
								type="number"
								class="mx-3 w-fit min-w-[60%]"
								v-model="form.phone_number"
								autocomplete="name"
								placeholder="Phone number"
							/>
						</div>

						<InputError class="mt-2" v-for="error in (errors.country_code || errors.phone_number || [])" :key="error" :message="(error)" />
					</div>

					<div>
						<TextInput
							id="email"
							type="email"
							class="mt-3 block w-full"
							v-model="form.email"
							autocomplete="email"
							placeholder="Enter Your Email"
						/>

						<InputError class="mt-2" v-for="error in (errors.email || [])" :key="error" :message="(error)" />
					</div>

					<div>
						<TextInput
							id="password"
							type="password"
							class="mt-3 block w-full"
							v-model="form.password"
							autocomplete="new-password"
							placeholder="Password"
						/>

						<InputError class="mt-2" v-for="error in (errors.password || errors.errors?.password || [])" :key="error" :message="(error)" />
					</div>

					<div>
						<TextInput
							id="password_confirmation"
							type="password"
							class="mt-3 block w-full"
							v-model="form.password_confirmation"
							autocomplete="new-password"
							placeholder="Confirm Your Password"
						/>

						<InputError class="mt-2" v-for="error in (errors.password_confirmation || [])" :key="error" :message="(error)" />
					</div>

					<div class="flex justify-between">
						<PrimaryButton class="p-4 my-8 bg-gray-500 text-gray-100 rounded" @click="prevPage">
							Previous Page
						</PrimaryButton>

						<PrimaryButton v-if="form.type === 'brand'" :class="`p-4 my-8 rounded text-gray-100 bg-green-600 hover:bg-green-500`" @click="submit">
							CREATE ACCOUNT
						</PrimaryButton>
						
						<PrimaryButton v-else :class="`p-4 my-8 rounded text-gray-100 bg-blue-600 hover:bg-blue-500`" @click="submit">
							CREATE ACCOUNT
						</PrimaryButton>
					</div>
					<div class="flex flex-col">
						<div class="flex justify-start items-center">
							<TextInput
								id="terms_and_conditions"
								type="checkbox"
								name="terms_and_conditions"
								class=""
								@change="handleChecked"
								autocomplete="terms_and_conditions"
							/>
	
							<InputLabel class="px-3">
								Read and Accept our <a href="#" class="text-blue-500 hover:underline">terms and conditions</a>
							</InputLabel>
						</div>

						<InputError class="mt-2" v-for="error in (errors.terms_and_conditions || [])" :key="error" message="Please read and accept the terms and conditions to continue" />
					</div>
				</div>
			</form>
        
    </div>
  </GuestLayout>
</template>

<style>
input[type="number"]::-webkit-inner-spin-button,
input[type="number"]::-webkit-outer-spin-button {
  -webkit-appearance: none;
}
</style>