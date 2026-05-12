<script setup>
import { onMounted, ref } from 'vue';

const model = defineModel({
    type: String,
    required: true,
});

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <input
        class="w-full bg-gray-50/50 border border-gray-200 text-gray-900 text-sm rounded-xl px-4 py-3 focus:ring-indigo-500 focus:border-indigo-500 transition-all shadow-[inset_0_2px_4px_rgba(0,0,0,0.02)] outline-none"
        v-model="model"
        ref="input"
    />
</template>
