<script setup>
	import PaginatorLinks from '../../Components/PaginatorLinks.vue';
	import TypeSelect from '../../Components/TypeSelect.vue';
	import SessionMessages from '../../Components/SessionMessages.vue';
	import InputField from '../../Components/InputField.vue';
	import { router } from '@inertiajs/vue3';
	import { watch, ref} from 'vue';

	const props = defineProps({
		users: Object,
		status: String,
	});

	const params = route().params;

	const search = ref(params.search)

	//debouncing
	let timeoutId = null;
	watch(search, (q) => {
		clearTimeout(timeoutId);
		timeoutId = setTimeout(() => {
			router.get(route('admin.index'), {
				search: q,
				user_type: params.user_type,
			});
		}, 300);
	})

	const toggleType = (e) => {
		if (e.target.checked) {
			router.get(route('admin.index', {
			search: params.search,
			user_type: 'suspended',
		}));
		} else {
			router.get(route('admin.index', {
				search: params.search,
				user_type: null,
			}));
		}
	}
	
</script>

<template>
	<Head title="| Admin" />

	<SessionMessages :message="status" />

	<div class="flex items-end justify-between mb-4">
		<div class="flex items-end gap-2">
			<form @submit.prevent="search">
				<InputField label="" icon="magnifying-glass" placeholder="Search..." v-model="search"/>
			</form>
			<Link v-if="params.search" :href="route('admin.index', {...params, search: null, page: null})" class="px-2 py-[6px] rounded-md bg-indigo-500 text-white flex items-center gap-2">
				{{ params.search }}
				<i class="fa-solid fa-xmark"></i>
			</Link>
		</div>

		<div class="flex items-center gap-1 text-xs hover:bg-slate-300 px-2 py-1 rounded-md">
			<input @input="toggleType" :checked="params.user_type" type="checkbox" id="toggleType" class="rounded-md border-1 outline-0 text-indigo-500 ring-indigo-500 border-slate-700 cursor-pointer">
			<label for="toggleType" class="block text-sm font-medium text-slate-700 cursor-pointer">Only suspended users</label>
		</div>
	</div>

	<table class="bg-white w-full rounded-lg overflow-hidden ring-1 ring-slate-300">
		<thead>
			<tr class="bg-slate-600 text-slate-300 uppercase text-xs text-left">
				<th class="w-3/6 p-3">Name</th>
				<th class="w-2/6 p-3">Type</th>
				<th class="w-1/6 p-3">Listings</th>
				<th class="w-1/6 p-3 text-right">View</th>
			</tr>
		</thead>
		<tbody class="divide-y divide-slate-300 divide-dashed">
			<tr v-for="user in users.data" :key="user.id">
				<td class="w-3/6 py-5 px-3">
					<p class="font-bold mb-1">{{ user.name }}</p>
					<p class="font-light text-xs">{{ user.email }}</p>
				</td>
				<td class="w-2/6 py-5 px-3">
					<TypeSelect :user="user"/>
				</td>
				<td class="w-1/6 py-5 px-3">
					<div class="flex items-center gap-6">
						<div class="flex items-center gap-1">
							<p>{{ user.listings.filter(l => l.approved).length }}</p>
							<i class="fa-solid fa-circle-check text-green-500"></i>
						</div>
						<div class="flex items-center gap-1">
							<p>{{ user.listings.filter(l => !l.approved).length }}</p>
							<i class="fa-solid fa-circle-xmark text-red-500"></i>
						</div>
					</div>
				</td>
				<td class="w-1/6 py-5 px-3 text-right">
					<Link :href="route('admin.user.show', user.id)" class="fa-solid fa-up-right-from-square px-3 text-indigo-400" />
				</td>
			</tr>
		</tbody>
	</table>
	<div class="mt-6">
		<PaginatorLinks :paginator="users" />
	</div>
</template>