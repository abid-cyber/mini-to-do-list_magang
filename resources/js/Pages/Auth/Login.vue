<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    username: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Masuk" />

        <div v-if="status" class="mb-6 font-medium text-sm text-emerald-600 bg-emerald-50 p-4 rounded-xl text-center">
            {{ status }}
        </div>

        <div class="text-center mb-10">
            <h2 class="text-3xl font-bold text-gray-900 mb-2">Selamat Datang!</h2>
            <p class="text-gray-500">Silakan masuk ke akun Anda</p>
        </div>

        <form @submit.prevent="submit" class="flex flex-col gap-5 w-full max-w-sm mx-auto">
            
            <div class="flex flex-col gap-1.5">
                <label for="username" class="text-xs font-bold text-gray-600 tracking-wider uppercase ml-1">Username</label>
                <input
                    id="username"
                    type="text"
                    class="w-full bg-gray-50/50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block px-4 py-3.5 transition-all shadow-[inset_0_2px_4px_rgba(0,0,0,0.02)]"
                    v-model="form.username"
                    required
                    autofocus
                    autocomplete="username"
                    placeholder="Masukkan username"
                />
                <p v-if="form.errors.username" class="text-xs text-red-500 mt-1 ml-1">{{ form.errors.username }}</p>
            </div>

            <div class="flex flex-col gap-1.5">
                <label for="password" class="text-xs font-bold text-gray-600 tracking-wider uppercase ml-1">Password</label>
                <input
                    id="password"
                    type="password"
                    class="w-full bg-gray-50/50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block px-4 py-3.5 transition-all shadow-[inset_0_2px_4px_rgba(0,0,0,0.02)]"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                    placeholder="••••••••"
                />
                <p v-if="form.errors.password" class="text-xs text-red-500 mt-1 ml-1">{{ form.errors.password }}</p>
            </div>

            <div class="flex items-center justify-between mt-2">
                <label class="flex items-center cursor-pointer group">
                    <input name="remember" type="checkbox" v-model="form.remember" class="w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 rounded focus:ring-indigo-500 focus:ring-2">
                    <span class="ml-2 text-sm text-gray-500 group-hover:text-gray-700 transition">Ingat saya</span>
                </label>
            </div>

            <button
                class="w-full text-white bg-[#1e1b4b] hover:bg-indigo-900 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-bold rounded-xl text-sm px-5 py-4 text-center transition-all mt-4 shadow-lg shadow-indigo-900/30 active:scale-95 disabled:opacity-50 tracking-wide uppercase"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
            >
                Masuk
            </button>

            <p class="text-sm text-center text-gray-500 mt-6">
                Belum punya akun? 
                <Link :href="route('register')" class="font-bold text-indigo-600 hover:text-indigo-800 transition">Daftar sekarang</Link>
            </p>
        </form>
    </GuestLayout>
</template>
