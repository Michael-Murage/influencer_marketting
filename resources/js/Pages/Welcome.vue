<script setup>
import { Head, Link } from '@inertiajs/vue3';
import Navbar from '@/Components/Navbar.vue';

defineProps({
  canLogin: {
    type: Boolean,
  },
  canRegister: {
    type: Boolean,
  },
  laravelVersion: {
    type: String,
    required: true,
  },
  phpVersion: {
    type: String,
    required: true,
  },
});
</script>

<template>
  <Head title="Welcome" />

	<div class="">
		<Navbar
			:canLogin="canLogin"
			:canRegister="canRegister"
		/>
		
		<div class="px-16 pt-16">
			<div class="text-center">
				<h1 class="text-[85px]">FUSS</h1>
				<h3 class="">
					Embrace the noise, 
					<span class="text-yellow-500"> make a fuss!!!</span>
				</h3>
			</div>

			<div>
				<div>
					<h1 class="font-bold my-4">
						Unleash the Power of Content Creation: Revolutionize Your Marketing Strategy
					</h1>
	
					<p>
						Are you prepared to redefine the rules of influencer marketing? Your
						journey to unparalleled success begins here. Welcome to our pioneering
						platform, where ambitious small online stores, big brands, and
						top-tier marketing agencies alike converge to wield the unmatched
						power of content creation. Get ready to disrupt the status quo and
						optimize your campaigns like never before, all while saving half your
						budget!
					</p>
				</div>

				<div>
					<h1 class="font-bold my-4">Collaborate with Unrivaled Talent</h1>
	
					<p>
						Experience the fusion of innovation and disruption at Fuss. We're
						dedicated to catalyzing bold collaborations that redefine industry
						standards. Whether you're a burgeoning online store, a renowned brand,
						or a leading marketing agency, our platform connects you with a
						curated selection of influencers whose impact knows no bounds. From
						Instagram sensations to YouTube titans, unleash their transformative
						potential to amplify your brand's voice to unprecedented heights.
					</p>
				</div>

				<div>
					<h1 class="font-bold my-4">Break Barriers, Ignite Success</h1>

					<p>
						Our platform empowers you to forge genuine connections with the most
						influential voices across various industries. Let's transcend mere
						engagement and cultivate unwavering loyalty among your target
						audience, paving the way for unparalleled success in a fiercely
						competitive landscape.
					</p>
				</div>

				<div>
					<h1 class="font-bold my-4">Seize Your Competitive Edge</h1>

					<p>
						Embrace innovation with fervor and embrace the extraordinary. With our
						disruptive platform, gain exclusive access to a diverse array of
						content creators whose boundless creativity and influence will propel
						your brand to unparalleled success. Say goodbye to mundane campaigns
						and welcome a new era of dynamic, conversation-sparking content that
						sets your brand apart from the competition.
					</p>
				</div>

				<div>
					<h1 class="font-bold my-4">Unleash Your Brand's Potential Today</h1>

					<p>
						The time to unleash your Brand's full potential is now. Embrace the
						paradigm shift in advertising and immerse yourself in the realm of
						content creators. Join forces with \[BrandName] today and i
					</p>
				</div>

				<div id="footer">
					<h1 class="font-bold my-4">FUSS</h1>
					<h1 class="font-bold my-4">The era of innovation beckons</h1>
					<p>Ignite a revolution that will set your brand ablaze with success</p>
				</div>
			</div>
		</div>
	</div>
  
</template>

<style>
.bg-dots-darker {
  background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E");
}
@media (prefers-color-scheme: dark) {
  .dark\:bg-dots-lighter {
    background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E");
  }
}
</style>
