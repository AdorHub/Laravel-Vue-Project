<script setup>
	import Container from '../../../Components/Container.vue';
	import Title from '../../../Components/Title.vue';
	import InputField from '../../../Components/InputField.vue';
	import PrimaryBtn from '../../../Components/PrimaryBtn.vue';
	import ErrorMessages from '../../../Components/ErrorMessages.vue';
	import SessionMessages from '../../../Components/SessionMessages.vue';
	import { router, useForm } from '@inertiajs/vue3';

	const props = defineProps({
		user: Object,
		status: String,
	});

	const form = useForm({
		name: props.user.name,
		email: props.user.email,
	});

	const resendEmail = (e) => {
		router.post(route('verification.send'), {}, {
			preserveScroll: true,
			onStart: () => e.target.disabled = true,
			onFinish: () => e.target.disabled = false,
		});
	}
</script>

<template>
	<Container class="mb-6">
		<div class="mb-6">
			<Title>Update Information</Title>
			<p>Update your account's profile information and email address.</p>
		</div>
		<ErrorMessages :errors="form.errors" />
		<form @submit.prevent="form.patch(route('profile.info'))" class="space-y-6">
			<InputField class="w-1/2" label="Name" icon="id-badge" placeholder="Name" v-model="form.name" />
			<InputField class="w-1/2" label="Email" icon="at" placeholder="Email" v-model="form.email" />
			<div v-if="user.email_verified_at === null">
				<p>
					Your email address is unverified
					<button @click="resendEmail" class="text-indigo-500 font-medium underline cursor-pointer disabled:text-slate-400 disabled:cursor-wait">Click here to resend the verification email.</button>
				</p>
				<SessionMessages :message="status" />
			</div>
			<PrimaryBtn :disabled="form.processing">Update</PrimaryBtn>
			<p v-if="form.recentlySuccessful" class="text-green-500 font-medium">Saved!</p>
		</form>
	</Container>
</template>