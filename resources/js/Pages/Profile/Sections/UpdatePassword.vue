<script setup>
	import Container from '../../../Components/Container.vue';
	import Title from '../../../Components/Title.vue';
	import InputField from '../../../Components/InputField.vue';
	import PrimaryBtn from '../../../Components/PrimaryBtn.vue';
	import ErrorMessages from '../../../Components/ErrorMessages.vue';
	import { useForm } from '@inertiajs/vue3';

	const form = useForm({
		current_password: '',
		password: '',
		password_confirmation: '',
	});

	const submit = () => {
		form.put(route('profile.password'), {
			preserveScroll: true,
			onSuccess: () => form.reset(),
			onError: () => form.reset(),
		});
	}
</script>

<template>
	<Container class="mb-6">
		<div class="mb-6">
			<Title>Update Password</Title>
			<p>Ensure you are using a long, random password to stay secure.</p>
		</div>
		<ErrorMessages :errors="form.errors" />
		<form @submit.prevent="submit" class="space-y-6">
			<InputField class="w-1/2" label="Current Password" icon="key" placeholder="Current Password" type="password" v-model="form.current_password" />
			<InputField class="w-1/2" label="New Password" icon="key" placeholder="New Password" type="password" v-model="form.password" />
			<InputField class="w-1/2" label="Confirm New Password" icon="key" placeholder="Confirm New Password" type="password" v-model="form.password_confirmation" />
			<PrimaryBtn :disabled="form.processing">Update</PrimaryBtn>
			<p v-if="form.recentlySuccessful" class="text-green-500 font-medium">Saved!</p>
		</form>
	</Container>
</template>