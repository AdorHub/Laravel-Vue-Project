<script setup>
	import Container from '../../Components/Container.vue';
	import InputField from '../../Components/InputField.vue';
	import PrimaryBtn from '../../Components/PrimaryBtn.vue';
	import ErrorMessages from '../../Components/ErrorMessages.vue';
	import SessionMessages from '../../Components/SessionMessages.vue';
	import { useForm } from '@inertiajs/vue3';

	defineProps({
		status: String,
	});

	const form = useForm({
		email: ''
	});

	const submit = () => {
		form.post(route('password.email'));
	}
</script>

<template>
	<Head title="| Forgot Password" />
	<Container class="w-1/2">
		<div class="mb-8 text-center">
			<p>Forgot your password? No problem. Just let us know your email address so we can send you password reset link that will allow you to reset and make new one</p>
		</div>

		<ErrorMessages :errors="form.errors" />

		<form @submit.prevent="submit" class="space-y-6">
			<InputField label="Email" icon="at" placeholder="Email" type="email" v-model="form.email" />
			<PrimaryBtn :disabled="form.processing">Send Link</PrimaryBtn>
			<SessionMessages :message="status" />
		</form>
	</Container>
</template>