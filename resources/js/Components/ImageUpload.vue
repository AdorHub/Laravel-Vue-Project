<script setup>
	import { ref } from 'vue';

	const emit = defineEmits([
		'image'
	]);

	const props = defineProps({
		listingImage: String,
	});
	
	const currentImage = props.listingImage ? `/storage/${props.listingImage}` : null;

	const preview = ref(currentImage);
	const isImageOversized = ref(false);
	const showRevertBtn = ref(true);

	const imageSelected = (e) => {
		preview.value = URL.createObjectURL(e.target.files[0]);
		isImageOversized.value = e.target.files[0].size > 3145728;
		showRevertBtn.value = true;
		emit('image', e.target.files[0]);
	}

	const resetSelectedImage = () => {
		showRevertBtn.value = false;
		preview.value = currentImage;
		isImageOversized.value = false;
		emit('image', null); //event for reset	
	}
</script>

<template>
	<div>
		<span class="block text-sm font-medium text-slate-700" :class="{'!text-red-500': isImageOversized }">{{ isImageOversized ? 'Selected image is over 3Mb' : 'Image (Max size: 3Mb)' }}</span>
		<label for="image" class="block rounded-md mt-1 bg-slate-300 h-[137px] overflow-hidden cursor-pointer border-slate-300 border relative" :class="{'!border-red-500': isImageOversized }">
			<img :src="preview ?? '/storage/images/listing/default.png'" class="object-cover object-center h-full w-full">
			<button @click.prevent="resetSelectedImage" v-if="showRevertBtn" type="button" class="absolute top-2 right-2 bg-white/75 w-8 h-8 rounded-full grid place-items-center text-slate-700">
				<i class="fa-solid fa-rotate-left"></i>
			</button>
		</label>
		<input @input="imageSelected" type="file" id="image" hidden>
	</div>
</template>