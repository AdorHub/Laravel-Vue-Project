<script setup>
	import { ref } from 'vue';

	const model = defineModel();

	defineProps({
		label: String,
		icon: String,
		placeholder: {
			type: String,
			default: '',
		},
	});

	const focused = ref(false);
</script>

<template>
	<div>
		<label :for="label" class="block text-sm font-medium text-slate-700">{{ label }}</label>
		<div class="relative mt-1 rounded-md">
			<div class="pointer-events-none absolute top-3 left-0 flex items-center pl-3" >
				<span class="grid place-content-center text-sm" >
					<i :class="[{'text-indigo-500' : focused, 'text-slate-400' : !focused}, `fa-solid fa-${icon}`]"></i>
				</span>
			</div>
			<textarea @focus="focused = true" @blur="focused = false" :id="label" :placeholder="placeholder" v-model="model" rows="6" class="block w-full rounded-md pr-3 pl-9 text-sm outline-slate-400 outline-1 focus:ring-1 focus:ring-inset focus:ring-indigo-400 focus:outline-indigo-400 placeholder:text-slate-400 p-2">
			</textarea>
		</div>
	</div>
</template>