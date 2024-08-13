<script setup>
defineProps({
  job: {
    type: Object
  }
});

function parseTime(time) {
  const date = new Date(time);

  const monthDifference = Math.floor((Date.now() - date) / 2592000000); // months
  if (monthDifference) return `${monthDifference} months ago`;

  const dayDifference = Math.floor((Date.now() - date) / 86400000); // Days
  if (dayDifference) return `${dayDifference} days ago`;

  const hoursDifference = Math.floor((Date.now() - date) / 3600000); // Hours
  if (hoursDifference) return `${hoursDifference} hours ago`;

  const minuteDifference = Math.floor((Date.now() - date) / 600000); // Minutes
  if (minuteDifference) return `${minuteDifference} minutes ago`;

  return "Just Now";
}
</script>

<template>
  <div class="px-6 py-4">
    <div class="flex justify-center items-center">
      <img
        :src="job.user_information?.profile_pic[0]?.name"
        alt=""
        class="w-[80px] mx-4"
      />
      <h1>{{ job.user_information?.name }}</h1>
    </div>

    <div>
      <h1 class="font-bold text-xl">{{ job.name }}</h1>
      <p class="py-2">{{ job.description }}</p>
    </div>

    <div class="my-4">
      <h1 class=""><span class="font-bold text-lg">Role: </span>{{ job.role }}</h1>
    </div>

    <div class="my-4">
      <h1 class="font-bold text-xl">Qualifications</h1>
      <p>{{ job.qualifications }}</p>
    </div>

    <h1 class="my-4">
      <span class="font-bold">Job Posted: </span>{{ parseTime(job.created_at) }}
    </h1>
  </div>
</template>