<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { router } from '@inertiajs/vue3';

function registerByEmail () {
	router.visit('/register');
}

function registerByGoogle () {
	router.visit('/auth/google');
}
</script>

<template>
  <div class="py-3 flex justify-center items-center w-full h-screen bg-gray-100">
		<div class="border p-16 shadow-lg rounded-lg bg-white w-[80%] flex flex-col justify-center">
			<h1 class="text-gray-900 dark:text-gray-100 text-[25px] font-bold mb-8 text-center">
				Sign up to Fuss
			</h1>

			<a
				class="text-gray-100 text-md bg-gray-900 hover:bg-gray-700 justify-center rounded-full w-full h-[50px] lg:px-[120px] md:px-3 sm:px-3 py-4 text-xs tracking-tight uppercase text-center"
				href="/auth/google"
			>
				<span class="mx-2">
					<img src="/icons/google.svg" alt="google logo" class="inline">
				</span>
				<span class="mx-2 font-semibold">Sign up with Google</span>
			</a>

			<div class="flex justify-center items-center my-9">
				<hr class="border-gray-300 w-[40%] mr-auto"/>
				<span>or</span>
				<hr class="border-gray-300 w-[40%] ml-auto"/>
			</div>

			<SecondaryButton
				class="bg-transparent text-gray-900 dark:text-gray-100 hover:shadow-lg h-[50px] w-full flex justify-center items-center rounded-full border tracking-tight"
				@click="registerByEmail"
			>
				Continue with email
			</SecondaryButton>
		</div>
	</div>
</template>
