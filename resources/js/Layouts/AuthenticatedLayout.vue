<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import TextInput from '@/Components/TextInput.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link, router } from '@inertiajs/vue3';

const showingNavigationDropdown = ref(false);

function showData(data) {
	if (data !== null) return data;
	else router.visit('/login');
}
</script>

<template>
  <div>
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
      <nav class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 fixed w-full">
    	  <!-- Primary Navigation Menu -->
    	  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    	    <div class="flex justify-end h-16">
    	      <div class="flex mr-auto">
    	        <!-- Logo -->
    	        <div class="shrink-0 flex items-center">
    	          <NavLink :href="route('dashboard')">
    	            <ApplicationLogo
    	      				class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200"
    	            />
    	          </NavLink>
    	        </div>

    	        <!-- Navigation Links -->
    	        <!-- <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
    	          <NavLink :href="route('dashboard')" :active="route().current('dashboard')">
    	            Dashboard
    	          </NavLink>
    	        </div> -->
    	      </div>

						<div class="flex items-center mx-3">
							<TextInput
								type="search"
								name=""
								id=""
								placeholder="Search"
								class="w-[350px]"
							/>
						</div>

						<div class="flex items-center mx-2">
							<Link
								href="/notifications"
							>
								<svg
    	            class="ms-2 -me-0.5 h-4 w-4"
    	            xmlns="http://www.w3.org/2000/svg"
    	            viewBox="0 0 448 512"
    	            fill="currentColor"
    	          >
    	            <path
    	              fill-rule="evenodd"
    	              d="M224 0c-17.7 0-32 14.3-32 32V51.2C119 66 64 130.6 64 208v25.4c0 45.4-15.5 89.5-43.8 124.9L5.3 377c-5.8 7.2-6.9 17.1-2.9 25.4S14.8 416 24 416H424c9.2 0 17.6-5.3 21.6-13.6s2.9-18.2-2.9-25.4l-14.9-18.6C399.5 322.9 384 278.8 384 233.4V208c0-77.4-55-142-128-156.8V32c0-17.7-14.3-32-32-32zm0 96c61.9 0 112 50.1 112 112v25.4c0 47.9 13.9 94.6 39.7 134.6H72.3C98.1 328 112 281.3 112 233.4V208c0-61.9 50.1-112 112-112zm64 352H224 160c0 17 6.7 33.3 18.7 45.3s28.3 18.7 45.3 18.7s33.3-6.7 45.3-18.7s18.7-28.3 18.7-45.3z"
    	              clip-rule="evenodd"
    	            />
    	          </svg>
							</Link>
						</div>

    	      <div class="hidden sm:flex sm:items-center sm:ms-6">
    	        <!-- Settings Dropdown -->
    	        <div class="ms-3 relative">
    	          <Dropdown align="right" width="48">
    	            <template #trigger>
    	              <span class="inline-flex rounded-md">
    	                <button
    	                  type="button"
    	                  class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150"
    	                >
    	                  {{ showData($page.props.auth.user?.name) }}

    	                  <svg
    	                    class="ms-2 -me-0.5 h-4 w-4"
    	                    xmlns="http://www.w3.org/2000/svg"
    	                    viewBox="0 0 20 20"
    	                    fill="currentColor"
    	                  >
    	                    <path
    	                      fill-rule="evenodd"
    	                      d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
    	                      clip-rule="evenodd"
    	                    />
    	                  </svg>
    	                </button>
    	              </span>
    	            </template>

    	            <template #content>
    	              <DropdownLink :href="route('profile.edit')"> Profile </DropdownLink>
    	              <DropdownLink :href="route('logout')" method="post" as="button">
    	                Log Out
    	              </DropdownLink>
    	            </template>
    	          </Dropdown>
    	        </div>
    	      </div>

    	      <!-- Hamburger -->
    	      <div class="-me-2 flex items-center sm:hidden">
    	        <button
    	          @click="showingNavigationDropdown = !showingNavigationDropdown"
    	          class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out"
    	        >
    	          <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
    	            <path
    	              :class="{
    	                hidden: showingNavigationDropdown,
    	                'inline-flex': !showingNavigationDropdown,
    	              }"
    	              stroke-linecap="round"
    	              stroke-linejoin="round"
    	              stroke-width="2"
    	              d="M4 6h16M4 12h16M4 18h16"
    	            />
    	            <path
    	              :class="{
    	                hidden: !showingNavigationDropdown,
    	                'inline-flex': showingNavigationDropdown,
    	              }"
    	              stroke-linecap="round"
    	              stroke-linejoin="round"
    	              stroke-width="2"
    	              d="M6 18L18 6M6 6l12 12"
    	            />
    	          </svg>
    	        </button>
    	      </div>
    	    </div>
    	  </div>

    	  <!-- Responsive Navigation Menu -->
    	  <div
    	    :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }"
    	    class="sm:hidden"
    	  >
    	    <div class="pt-2 pb-3 space-y-1">
    	      <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
							Dashboard
    	      </ResponsiveNavLink>
    	    </div>

    	    <!-- Responsive Settings Options -->
    	    <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
    	      <div class="px-4">
							<div class="font-medium text-base text-gray-800 dark:text-gray-200">
    						{{ showData($page.props.auth?.name) }}
							</div>
							<div class="font-medium text-sm text-gray-500">{{ showData($page.props.auth?.email) }}</div>
    	      </div>

    	      <div class="mt-3 space-y-1">
							<ResponsiveNavLink :href="route('profile.edit')"> Profile </ResponsiveNavLink>
							<ResponsiveNavLink :href="route('logout')" method="post" as="button">
    						Log Out
							</ResponsiveNavLink>
    	      </div>
    	    </div>
    	  </div>
      </nav>

			<div class="flex">
				<nav class="bg-white h-screen w-[10%] py-[70px] pl-3 flex flex-col shadow-sm">
					<NavLink :href="route('dashboard')" class="my-3">
            Home
          </NavLink>
					<NavLink href='/profile' class="my-3">
            Profile
          </NavLink>
					<NavLink href='/messages' class="my-3">
            Messages
          </NavLink>
					<NavLink href='/jobs' class="my-3">
            Jobs
          </NavLink>
					<NavLink href='/lists' class="my-3 text-gray-500">
            Lists
          </NavLink>
					<Link
						href='#'
						class="inline-flex items-center px-1 py-2.5 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-700 focus:outline-none focus:text-gray-700 dark:focus:text-gray-300 focus:border-gray-300 dark:focus:border-gray-700 transition duration-150 ease-in-out"
					>
            Campaigns
          </Link>
					<Link
						href='#'
						class="inline-flex items-center px-1 py-2.5 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-700 focus:outline-none focus:text-gray-700 dark:focus:text-gray-300 focus:border-gray-300 dark:focus:border-gray-700 transition duration-150 ease-in-out"
					>
            Connections
          </Link>

					<!-- <div class="relative">
            <Dropdown align="right" width="48" class="relative">
              <template #trigger>
                <span class="inline-flex rounded-md">
                  <button
                    type="button"
                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150"
                  >
                    {{ showData($page.props.auth.user?.name) }}

                    <svg
                      class="ms-2 -me-0.5 h-4 w-4"
                      xmlns="http://www.w3.org/2000/svg"
                      viewBox="0 0 20 20"
                      fill="currentColor"
                    >
                      <path
                        fill-rule="evenodd"
                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                        clip-rule="evenodd"
                      />
                    </svg>
                  </button>
                </span>
              </template>

              <template #content>
                <DropdownLink :href="route('profile.edit')"> Profile </DropdownLink>
                <DropdownLink :href="route('logout')" method="post" as="button">
                  Log Out
                </DropdownLink>
              </template>
            </Dropdown>
					</div> -->

					<!-- <NavLink href='/profile' class="my-3 fixed bottom-0">
            Profile
          </NavLink> -->
				</nav>

				<!-- Page Content -->
				<main class="w-[90%] py-[70px]">
					<slot />
				</main>
			</div>

    </div>
  </div>
</template>
