<script setup>
	import Container from '../../Components/Container.vue';
	import Title from '../../Components/Title.vue';
	import TextLink from '../../Components/TextLink.vue';
	import InputField from '../../Components/InputField.vue';
	import PrimaryBtn from '../../Components/PrimaryBtn.vue';
	import ErrorMessages from '../../Components/ErrorMessages.vue';
	import Checkbox from '../../Components/Checkbox.vue';
	import { useForm } from '@inertiajs/vue3';
	import SessionMessages from '../../Components/SessionMessages.vue';

	defineProps({
		status: String,
	});

	const form = useForm({
		email: '',
		password: '',
		remember: null,
	});

	const submit = () => {
		form.post(route('login.store'), {
			onFinish: () => {
				form.reset('password');
			},
		});
	}
</script>

<template>
	<Head title="| Login" />
	<Container class="w-1/2">
		<div class="mb-8 text-center">
			<Title>Login to your account</Title>
			<p>
				Don't have an account?
				<TextLink routeName="register" label="Register" />
			</p>
		</div>

		<ErrorMessages :errors="form.errors" />

		<form @submit.prevent="submit" class="space-y-6">
			<InputField label="Email" icon="at" placeholder="Email" type="email" v-model="form.email" />
			<InputField label="Password" icon="key" placeholder="Password" type="password" v-model="form.password" />
			<div class="flex items-center justify-between">
				<Checkbox name="remember" v-model="form.remember">Remember me</Checkbox>
				<TextLink routeName="password.request" label="Forgot Password?" />
			</div>
			<PrimaryBtn :disabled="form.processing">Login</PrimaryBtn>
		</form>
		<SessionMessages :message="status" />
	</Container>
</template>