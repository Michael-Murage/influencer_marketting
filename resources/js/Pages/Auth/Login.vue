<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
		type: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Log in" />

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

				
        <form @submit.prevent="submit" class="h-screen flex flex-col justify-center mx-auto w-[80%]">
			    <Link href="/">
            <h1 class="text-[40px] font-[900] text-center hover:underline">Sign In to Fuss</h1>
          </Link>

          <div class="mb-12 mt-6 flex justify-center items-center">
            <a
			      	class="text-gray-900 hover:text-gray-100 dark:text-gray-100 border shadow-md hover:shadow-lg text-md bg-white dark:bg-gray-900 hover:bg-gray-700 justify-center rounded-full w-full max-w-[300px] h-[50px] md:px-3 sm:px-3 py-4 text-xs tracking-tight uppercase text-center"
			      	href="/auth/google"
			      >
			      	<span class="mx-2">
			      		<img src="/icons/google.svg" alt="google logo" class="inline">
			      	</span>
			      	<span class="mx-2 font-semibold">Sign In with Google</span>
			      </a>
          </div>

          <div class="flex justify-center items-center my-9">
			    	<hr class="border-gray-300 w-[20%] sm:w-[30%] md:w-[30%] lg:[40%] mr-auto"/>
			    	<span class="text-gray-500">or sign in with email</span>
			    	<hr class="border-gray-300 w-[20%] sm:w-[30%] md:w-[30%] lg:[40%] ml-auto"/>
			    </div>

					<div>
            <InputLabel for="email" value="Email" />

            <TextInput
              id="email"
              type="email"
              class="mt-1 block w-full"
              v-model="form.email"
              required
              autofocus
              autocomplete="username"
            />

            <InputError class="mt-2" :message="form.errors.email" />
          </div>

            <div class="mt-4">
              <InputLabel for="password" value="Password" />

              <TextInput
                id="password"
                type="password"
                class="mt-1 block w-full"
                v-model="form.password"
                required
                autocomplete="current-password"
              />

              <InputError class="mt-2" :message="form.errors.password" />
            </div>


						<div class="block mt-4">
              <label class="flex items-center">
                <Checkbox name="remember" v-model:checked="form.remember" />
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">Remember me</span>
              </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                >
                    Forgot your password?
                </Link>

                <PrimaryButton class="ms-4 bg-green-600 hover:bg-green-500 text-gray-100 rounded" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Log in
                </PrimaryButton>
            </div>

        </form>
    </GuestLayout>
</template>
