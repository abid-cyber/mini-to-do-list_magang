<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    username: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Daftar" />

        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-2">Buat Akun</h2>
            <p class="text-gray-500">Mulai kelola tugas Anda hari ini</p>
        </div>

        <form @submit.prevent="submit" class="flex flex-col gap-4 w-full max-w-sm mx-auto">
            
            <div class="flex flex-col gap-1.5">
                <label for="name" class="text-xs font-bold text-gray-600 tracking-wider uppercase ml-1">Nama Lengkap</label>
                <input
                    id="name"
                    type="text"
                    class="w-full bg-gray-50/50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block px-4 py-3 transition-all shadow-[inset_0_2px_4px_rgba(0,0,0,0.02)]"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                    placeholder="John Doe"
                />
                <p v-if="form.errors.name" class="text-xs text-red-500 mt-1 ml-1">{{ form.errors.name }}</p>
            </div>

            <div class="flex flex-col gap-1.5">
                <label for="username" class="text-xs font-bold text-gray-600 tracking-wider uppercase ml-1">Username</label>
                <input
                    id="username"
                    type="text"
                    class="w-full bg-gray-50/50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block px-4 py-3 transition-all shadow-[inset_0_2px_4px_rgba(0,0,0,0.02)]"
                    v-model="form.username"
                    required
                    autocomplete="username"
                    placeholder="Pilih username"
                />
                <p v-if="form.errors.username" class="text-xs text-red-500 mt-1 ml-1">{{ form.errors.username }}</p>
            </div>

            <div class="flex flex-col gap-1.5">
                <label for="password" class="text-xs font-bold text-gray-600 tracking-wider uppercase ml-1">Password</label>
                <input
                    id="password"
                    type="password"
                    class="w-full bg-gray-50/50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block px-4 py-3 transition-all shadow-[inset_0_2px_4px_rgba(0,0,0,0.02)]"
                    v-model="form.password"
                    required
                    autocomplete="new-password"
                    placeholder="Min. 8 karakter"
                />
                <p v-if="form.errors.password" class="text-xs text-red-500 mt-1 ml-1">{{ form.errors.password }}</p>
            </div>

            <div class="flex flex-col gap-1.5">
                <label for="password_confirmation" class="text-xs font-bold text-gray-600 tracking-wider uppercase ml-1">Konfirmasi Password</label>
                <input
                    id="password_confirmation"
                    type="password"
                    class="w-full bg-gray-50/50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block px-4 py-3 transition-all shadow-[inset_0_2px_4px_rgba(0,0,0,0.02)]"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                    placeholder="Ulangi password"
                />
                <p v-if="form.errors.password_confirmation" class="text-xs text-red-500 mt-1 ml-1">{{ form.errors.password_confirmation }}</p>
            </div>

            <button
                class="w-full text-white bg-[#1e1b4b] hover:bg-indigo-900 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-bold rounded-xl text-sm px-5 py-4 text-center transition-all mt-4 shadow-lg shadow-indigo-900/30 active:scale-95 disabled:opacity-50 tracking-wide uppercase"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
            >
                Daftar
            </button>

            <p class="text-sm text-center text-gray-500 mt-4">
                Sudah punya akun? 
                <Link :href="route('login')" class="font-bold text-indigo-600 hover:text-indigo-800 transition">Masuk</Link>
            </p>
        </form>
    </GuestLayout>
</template>
