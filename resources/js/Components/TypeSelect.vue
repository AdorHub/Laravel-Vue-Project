<script setup>
	import { useForm } from '@inertiajs/vue3';

	const props = defineProps({
		user: Object,
	});

	const form = useForm({
		type: props.user.type,
	});

	const submit = () => {
		if (confirm(`Change the user's role to ${form.type.toUpperCase()}?`)) {
			form.put(route('admin.type', props.user.id))
		} else {
			form.type = props.user.type;
		}
	}
</script>

<template>
	<div class="flex items-center gap-2">
		<form @change="submit" class="flex items-center gap-2">
			<label for="type" class="sr-only">Type</label>
			<select v-model="form.type" id="type" class="text-slate-800 bg-slate-200 text-xs py-1 border-0 outline-0 rounded-lg">
				<option value="admin">Admin</option>
				<option value="general">General</option>
				<option value="suspended">Suspended</option>
			</select>
		</form>
	</div>
</template>