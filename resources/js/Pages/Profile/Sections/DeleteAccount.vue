<script setup>
	import Container from '../../../Components/Container.vue';
	import Title from '../../../Components/Title.vue';
	import InputField from '../../../Components/InputField.vue';
	import PrimaryBtn from '../../../Components/PrimaryBtn.vue';
	import ErrorMessages from '../../../Components/ErrorMessages.vue';
	import { useForm } from '@inertiajs/vue3';
	import { ref } from 'vue';

	const form = useForm({
		password: '',
	});

	const showConfirmDelete = ref(false);

	const submit = () => {
		form.delete(route('profile.destroy'), {
			preserveScroll: true,
			onError: () => form.reset()
		});
	}
</script>

<template>
	<Container class="mb-6">
		<div class="mb-6">
			<Title>Delete Account</Title>
			<p>Once your account is deleted, all resourses data will be permanently deleted. This action cannot be undone.</p>
		</div>
		<ErrorMessages :errors="form.errors" />
		<div v-if="showConfirmDelete">
			<form @submit.prevent="submit" class="flex items-end gap-4">
				<InputField class="w-1/2" label="Password" icon="key" placeholder="Password" v-model="form.password" />
				<PrimaryBtn :disabled="form.processing">Confirm</PrimaryBtn>
				<button @click="showConfirmDelete = false" class="px-6 py-2 rounded-lg bg-indigo-500 text-white hover:cursor-pointer hover:bg-indigo-400">Cancel</button>
			</form>
		</div>
		
		<button v-if="!showConfirmDelete" @click="showConfirmDelete = true" class="px-6 py-2 rounded-lg bg-red-500 text-white hover:cursor-pointer hover:bg-red-600">
			<i class="fa-solid fa-triangle-exclamation mr-2"></i>
			Delete Account
		</button>
	</Container>
</template>