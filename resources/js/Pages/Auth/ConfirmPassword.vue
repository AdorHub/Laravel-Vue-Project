<script setup>
	import Container from '../../Components/Container.vue';
	import InputField from '../../Components/InputField.vue';
	import PrimaryBtn from '../../Components/PrimaryBtn.vue';
	import ErrorMessages from '../../Components/ErrorMessages.vue';
	import { useForm } from '@inertiajs/vue3';

	const form = useForm({
		password: '',
	});

	const submit = () => {
		form.post(route('password.confirm'), {
			onFinish: () => {
				form.reset();
			},
		});
	}
</script>

<template>
	<Head title="| Password Confirmation" />
	<Container class="w-1/2">
		<div class="mb-8 text-center">
			<p>
				This is a secure area of the application. Please confirm your password before continuing.
			</p>
		</div>

		<ErrorMessages :errors="form.errors" />

		<form @submit.prevent="submit" class="space-y-6">
			<InputField label="Password" icon="key" placeholder="Password" type="password" v-model="form.password" />
			<PrimaryBtn :disabled="form.processing">Confirm</PrimaryBtn>
		</form>
	</Container>
</template>