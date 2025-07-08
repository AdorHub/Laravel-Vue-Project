<script setup>
	defineProps({
		message: String,
	});
</script>

<template>
	<div v-if="message" class="mt-4 font-medium text-sm text-green-500">{{ message }}</div>
</template>