<script setup>
	import PaginatorLinks from '../../Components/PaginatorLinks.vue';
	import Title from '../../Components/Title.vue';
	import InputField from '../../Components/InputField.vue';
	import SessionMessages from '../../Components/SessionMessages.vue';
	import { router } from '@inertiajs/vue3';
	import { ref, watch } from 'vue';

	const props = defineProps({
		user: Object,
		listings: Object,
		status: String,
	});

	const params = route().params;

	const search = ref(params.search);

	//debouncing
	let timeoutId = null;
	watch(search, (q) => {
		clearTimeout(timeoutId);
		timeoutId = setTimeout(() => {
			router.get(route('admin.user.show', {
				user: props.user.id,
				search: q,
				disapproved: params.disapproved,
			}));
		});
	})

	const showDisapproved = (e) => {
		if (e.target.checked) {
			router.get(route('admin.user.show', {
				search: params.search,
				user: props.user.id,
				disapproved: true,
			}));
		} else {
			router.get(route('admin.user.show', {
				search: params.search,
				user: props.user.id,
				disapproved: null,
			}));
		}
	}

	const toggleApprove = (listing) => {
		let msg = listing.approved ? 'Disapprove this listing?' : 'Approve this listing?';
		if (confirm(msg)) {
			router.put(route('admin.approve', listing.id));
		}		
	}
</script>

<template>
	<Head :title="`| ${user.name} Listings`" />
	<SessionMessages :message="status" class="mb-6" />
	<div class="mb-6">
		<Title>{{ user.name }} latest listings:</Title>
		<div class="flex items-end justify-between mb-4">
			<div class="flex items-end gap-2">
				<form @submit.prevent="search">
					<InputField label="" icon="magnifying-glass" placeholder="Search..." v-model="search"/>
				</form>
				<Link v-if="params.search" :href="route('admin.user.show', {...params, search: null, page: null, user: user.id})" class="px-2 py-[6px] rounded-md bg-indigo-500 text-white flex items-center gap-2">
					{{ params.search }}
					<i class="fa-solid fa-xmark"></i>
				</Link>
			</div>
			<div class="flex items-center gap-1 text-xs hover:bg-slate-300 px-2 py-1 rounded-md">
				<input @input="showDisapproved" :checked="params.disapproved" type="checkbox" id="showDisapproved" class="rounded-md border-1 outline-0 text-indigo-500 ring-indigo-500 border-slate-700 cursor-pointer">
				<label for="showDisapproved" class="block text-sm font-medium text-slate-700 cursor-pointer">Only disapproved listings</label>
			</div>		
		</div>
		<table class="bg-white w-full rounded-lg overflow-hidden ring-1 ring-slate-300">
			<thead>
				<tr class="bg-slate-600 text-slate-300 uppercase text-xs text-left">
					<th class="w-3/6 p-3">Title</th>
					<th class="w-2/6 p-3 text-center">Approved</th>
					<th class="w-1/6 p-3 text-right">View</th>
				</tr>
			</thead>
			<tbody class="devide-y devide-slate-300 divide-dashed">
				<tr v-for="listing in listings.data" :key="listing.id">
					<td class="py-5 px-3">{{ listing.title }}</td>
					<td class="pt-5 px-3 text-2xl text-center">
						<button @click.prevent="toggleApprove(listing)" class="cursor-pointer">
							<i :class="`fa-solid fa-${listing.approved ? 'circle-check text-green-500' : 'circle-xmark text-red-500'}`"></i>
						</button>
					</td>
					<td class="w-1/6 py-5 px-3 text-right">
						<Link :href="route('listing.show', listing.id)" class="fa-solid fa-up-right-from-square px-3 text-indigo-400" />
					</td>
				</tr>
			</tbody>
		</table>
		<div class="mt-6">
			<PaginatorLinks :paginator="listings" />
		</div>
	</div>
</template>