<script setup>
	import Cart from '../Components/Cart.vue';
	import PaginatorLinks from '../Components/PaginatorLinks.vue';
	import InputField from '../Components/InputField.vue';
	import { router } from '@inertiajs/vue3';
	import { watch, ref } from 'vue';

	const props = defineProps({
		listings: Object
	});

	const params = route().params;

	const search = ref(params.search);

	//debouncing
	let timeoutId = null;
	watch(search, (q) => {
		clearTimeout(timeoutId);
		timeoutId = setTimeout(() => {
			router.get(route('home'), {
				search: q,
				user_id: params.user_id,
				tag: params.tag,
			});
		}, 300);
	});

	const username = params.user_id 
		? props.listings.data.find((i) => i.user_id === Number(params.user_id)).user.name
		: null;
</script>

<template>
	<Head title="| Latest Listings" />
	<div class="flex items-center justify-between mb-4">
		<div class="flex items-center gap-2">
			<Link v-if="params.tag" :href="route('home', {...params, tag: null, page: null})" class="px-2 py-1 rounded-md bg-indigo-500 text-white flex items-center gap-2">
				{{ params.tag }}
				<i class="fa-solid fa-xmark"></i>
			</Link>
			<Link v-if="params.search" :href="route('home', {...params, search: null, page: null})" class="px-2 py-1 rounded-md bg-indigo-500 text-white flex items-center gap-2">
				{{ params.search }}
				<i class="fa-solid fa-xmark"></i>
			</Link>
			<Link v-if="params.user_id" :href="route('home', {...params, user_id: null, page: null})" class="px-2 py-1 rounded-md bg-indigo-500 text-white flex items-center gap-2">
				{{ username }}
				<i class="fa-solid fa-xmark"></i>
			</Link>
		</div>
		<div class="w-1/4">
			<form>
				<InputField type="search" label="" icon="magnifying-glass" placeholder="Search..." v-model="search" :v-html="search" />
			</form>
		</div>
	</div>
	<div v-if="Object.keys(listings.data).length">
		<div class="grid grid-cols-3 gap-4">
			<div v-for="listing in listings.data" :key="listing.id">
				<Cart :listing="listing" />
			</div>
		</div>
		<div class="mt-8">
			<PaginatorLinks :paginator="listings" />
		</div>
	</div>
	<div v-else>
		There are no listings yet...
	</div>
</template>