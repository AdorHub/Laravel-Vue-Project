<script setup>
	import { useForm } from '@inertiajs/vue3';
	import Container from '../../Components/Container.vue';
	import PrimaryBtn from '../../Components/PrimaryBtn.vue';
	import SessionMessages from '../../Components/SessionMessages.vue';

	defineProps({
		status: String,
	})

	const form = useForm({});
	const submit = () => {
		form.post(route('verification.send'));
	}
</script>

<template>
	<Head title="| Verify Email" />
	<Container class="w-1/2">
		<div class="mb-8">
			<p>Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send another to you!</p>
		</div>
		<form @submit.prevent="submit">
			<PrimaryBtn :disabled="form.processing">Resend Verification Email</PrimaryBtn>
		</form>
		<SessionMessages :message="status" />
	</Container>
</template>