<script setup>
import { computed } from 'vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
  status: {
    type: String,
  },
});

const form = useForm({});

const submit = (e) => {
	e.preventDefault();
  form.post(route('verification.send'));
};

const verificationLinkSent = computed(() => props.status === 'verification-link-sent');
</script>

<template>
  <GuestLayout>
    <Head title="Email Verification" />

    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400 text-center">
      Thanks for signing up! Before getting started, could you verify your email address by clicking on the link
      we just emailed to you? If you didn't receive the email, we will gladly send you another.
    </div>

    <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400 text-center" v-if="verificationLinkSent">
      A new verification link has been sent to the email address you provided during registration.
    </div>

    <form @submit.prevent="submit">
      <div class="mt-8 flex flex-col items-center justify-center">
        <!-- <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
            Resend Verification Email
        </PrimaryButton> -->

				<div class="flex justify-between items-center">
					<PrimaryButton
						@click="submit"
						class="bg-green-500 mx-4 text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
					>
						Resend Verification Link
					</PrimaryButton>
					<Link
						:href="route('logout')"
						method="post"
						as="button"
						class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
					>
						Log In
					</Link>
				</div>
      </div>
    </form>
  </GuestLayout>
</template>
