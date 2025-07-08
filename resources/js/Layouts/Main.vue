<script setup>
	import NavLink from '../Components/NavLink.vue';
	import { usePage } from '@inertiajs/vue3';
	import { computed, ref } from 'vue';

	const page = usePage();
	const user = computed(() => page.props.auth.user);

	const show = ref(false);
</script>

<template>
	<div @click="show = false" v-show="show" class="fixed inset-0 z-40"></div>

	<header class="bg-slate-800 text-white">
		<nav class="p-6 mx-auto max-w-screen-lg flex items-center justify-between">
			<NavLink routeName="home" componentName="Home">Home</NavLink>
			<div class="flex items-center space-x-6">
				<div v-if="user" class="relative flex items-center gap-4">					
					<div @click="show = !show" class="flex items-center gap-2 px-3 py-1 rounded-lg hover:bg-slate-700 cursor-pointer" :class="{'bg-slate-700': show}">
						<p>{{ user.name }}</p>
						<i class="fa-solid fa-angle-down"></i>
					</div>
					<Link v-if="user.type === 'admin'" :href="route('admin.index')" class="flex items-center gap-2 px-3 py-1 rounded-lg hover:bg-slate-700 cursor-pointer" :class="{'bg-slate-700' : $page.component === 'Admin/AdminDashboard' || $page.component === 'Admin/UserPage'}">
						<p>Admin Panel</p>
						<i class="fa-solid fa-lock"></i>
					</Link>
					<div @click="show = false" v-show="show" class="absolute z-50 top-16 right-0 bg-slate-800 text-white rounded-lg border-slate-200 border overflow-hidden w-40">
						<Link class="block w-full px-6 py-3 hover:bg-slate-300 text-left" as="button" :href="route('listing.create')">New Listing</Link>
						<Link class="block w-full px-6 py-3 hover:bg-slate-300 text-left" as="button" :href="route('profile.edit')">Profile</Link>
						<Link class="block w-full px-6 py-3 hover:bg-slate-300 text-left" as="button" :href="route('dashboard')">Dashboard</Link>
						<Link class="block w-full px-6 py-3 hover:bg-slate-300 text-left" as="button" method="post" :href="route('logout')">Logout</Link>
					</div>
				</div>
				<div v-else class="space-x-6">
					<NavLink routeName="login" componentName="Auth/Login">Login</NavLink>
					<NavLink routeName="register" componentName="Auth/Register">Register</NavLink>
				</div>
			</div>
		</nav>
	</header>

	<main class="p-6 mx-auto max-w-screen-lg">
		<slot></slot>
	</main>
</template>