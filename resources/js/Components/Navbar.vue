<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
  canLogin: {
    type: Boolean,
  },
  canRegister: {
    type: Boolean,
  },
  // laravelVersion: {
  //   type: String,
  //   required: true,
  // },
  // phpVersion: {
  //   type: String,
  //   required: true,
  // },
});

</script>
<template>
  <div
    class="shadow-md selection:text-white fixed w-full bg-white"
  >
    <div v-if="canLogin" class="flex items-center mx-4">
      <h1 class="text-[35px] font-bold mr-auto">FUSS</h1>
      <Link
        v-if="$page.props.auth.user"
        :href="route('dashboard')"
        class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
      >
        Dashboard
      </Link>

      <div v-else>
        <Link
          :href="route('login')"
          class="font-semibold hover:text-gray-600 text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
        >
          Log in
        </Link>

        <Link
          v-if="canRegister"
          :href="route('choose_signup')"
          class="ms-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
        >
          <span class="px-5 py-3 bg-gray-900 hover:bg-gray-600 text-gray-100 rounded-full">
            Sign Up
          </span>
        </Link>
      </div>
    </div>
  </div>
</template>