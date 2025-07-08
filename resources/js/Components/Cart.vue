<script setup>
	import { router } from '@inertiajs/vue3';

	defineProps({
		listing: Object,
	});

	const params = route().params;

	const selectUser = (id) => {
		router.get(route('home'), {
			user_id: id,
			search: params.search,
			tag: params.tag,
		});
	}

	const selectTag = (tag) => {
		router.get(route('home'), {
			tag: tag,
			search: params.search,
			user_id: params.user_id,			
		});
	}
</script>

<template>
	<div class="bg-white rounded-lg shadow-lg overflow-hidden h-full flex-col justify-between">
		<div>
			<Link :href="route('listing.show', listing.id)">
				<img class="w-full h-48 bg-slate-300 object-cover object-center" :src="listing.image ? `/storage/${listing.image}` : '/storage/images/listing/default.png'">
			</Link>
			<div class="p-4">
				<h3 class="font-bold text-xl mb-2">{{ listing.title.substring(0, 40) }}...</h3>
				<p>
					Listed on {{ new Date(listing.created_at).toLocaleDateString() }} by 
					<button @click="selectUser(listing.user.id)" class="text-link">{{ listing.user.name }}</button>
				</p>
			</div>
		</div>

		<div v-if="listing.tags" class="flex items-center gap-3 px-4 pb-4">
			<div v-for="tag in listing.tags.split(',')" :key="tag">
				<button @click="selectTag(tag)" class="bg-slate-500 text-white px-2 py-px rounded-full hover:bg-slate-700 hover:cursor-pointer">{{ tag }}</button>
			</div>
		</div>
	</div>
</template>