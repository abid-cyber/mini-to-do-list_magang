<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: { type: Boolean },
    canRegister: { type: Boolean },
});
</script>

<template>
    <Head title="Tuntas — Kelola Tugasmu" />
    <div class="min-h-screen bg-gradient-to-b from-blue-50 via-slate-50 to-blue-50">
        <!-- Navigation -->
        <nav class="relative z-10 px-6 py-5">
            <div class="mx-auto flex max-w-6xl items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-600 shadow-lg shadow-indigo-200">
                        <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15a2.25 2.25 0 0 1 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                        </svg>
                    </div>
                    <span class="text-xl font-bold text-gray-900">Tuntas</span>
                </div>
                <div v-if="canLogin" class="flex items-center gap-3">
                    <Link v-if="$page.props.auth.user" :href="route('dashboard')" class="rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition-all duration-200 hover:bg-indigo-700 hover:shadow-md">Dashboard</Link>
                    <template v-else>
                        <Link :href="route('login')" class="rounded-lg px-5 py-2.5 text-sm font-semibold text-gray-700 transition-all duration-200 hover:bg-gray-100">Masuk</Link>
                        <Link v-if="canRegister" :href="route('register')" class="rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition-all duration-200 hover:bg-indigo-700 hover:shadow-md">Daftar</Link>
                    </template>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <main class="relative overflow-hidden">
            <div class="absolute -top-20 right-0 h-96 w-96 rounded-full bg-blue-100 opacity-50 blur-3xl"></div>
            <div class="absolute -bottom-20 left-0 h-96 w-96 rounded-full bg-indigo-100 opacity-50 blur-3xl"></div>

            <div class="relative mx-auto max-w-6xl px-6 py-20 lg:py-32">
                <div class="mx-auto max-w-3xl text-center">
                    <!-- Badge -->
                    <div class="mb-8 inline-flex items-center gap-2 rounded-full bg-indigo-50 px-4 py-2 text-sm font-medium text-indigo-700 ring-1 ring-indigo-100">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09Z" />
                        </svg>
                        Sederhana, Cepat &amp; Aman
                    </div>

                    <!-- Heading -->
                    <h1 class="text-5xl font-extrabold tracking-tight text-gray-900 sm:text-6xl lg:text-7xl">
                        Kelola Tugasmu
                        <span class="text-indigo-600">dengan Mudah</span>
                    </h1>

                    <!-- Subtitle -->
                    <p class="mx-auto mt-6 max-w-2xl text-lg leading-relaxed text-gray-600">
                        Aplikasi To-Do List yang simpel dan intuitif. Tambah, edit, hapus, dan tandai tugas yang sudah selesai — semua dalam satu tempat yang aman dan privat.
                    </p>

                    <!-- CTA Buttons -->
                    <div class="mt-10 flex flex-col items-center justify-center gap-4 sm:flex-row">
                        <Link v-if="canRegister && !$page.props.auth.user" :href="route('register')" class="group inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-8 py-4 text-base font-semibold text-white shadow-lg shadow-indigo-200 transition-all duration-300 hover:bg-indigo-700 hover:shadow-xl hover:shadow-indigo-300 active:scale-95">
                            Mulai Sekarang
                            <svg class="h-5 w-5 transition-transform duration-300 group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" /></svg>
                        </Link>
                        <Link v-if="$page.props.auth.user" :href="route('dashboard')" class="group inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-8 py-4 text-base font-semibold text-white shadow-lg shadow-indigo-200 transition-all duration-300 hover:bg-indigo-700 hover:shadow-xl hover:shadow-indigo-300 active:scale-95">
                            Buka Dashboard
                            <svg class="h-5 w-5 transition-transform duration-300 group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" /></svg>
                        </Link>
                        <Link v-if="canLogin && !$page.props.auth.user" :href="route('login')" class="inline-flex items-center gap-2 rounded-xl border border-gray-200 bg-white px-8 py-4 text-base font-semibold text-gray-700 shadow-sm transition-all duration-200 hover:border-gray-300 hover:shadow-md">Sudah Punya Akun</Link>
                    </div>
                </div>

                <!-- Feature Cards -->
                <div class="mx-auto mt-24 grid max-w-4xl gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    <div class="rounded-2xl bg-white/80 p-6 shadow-sm ring-1 ring-gray-100 backdrop-blur-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-lg">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-50">
                            <svg class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                        </div>
                        <h3 class="mt-4 text-base font-semibold text-gray-900">Manajemen Tugas</h3>
                        <p class="mt-2 text-sm leading-relaxed text-gray-500">Tambah, edit, dan hapus tugas dengan mudah. Tandai tugas yang sudah selesai dengan satu klik.</p>
                    </div>
                    <div class="rounded-2xl bg-white/80 p-6 shadow-sm ring-1 ring-gray-100 backdrop-blur-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-lg">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50">
                            <svg class="h-6 w-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" /></svg>
                        </div>
                        <h3 class="mt-4 text-base font-semibold text-gray-900">Data Privat &amp; Aman</h3>
                        <p class="mt-2 text-sm leading-relaxed text-gray-500">Setiap pengguna hanya bisa melihat dan mengelola tugas milik mereka sendiri.</p>
                    </div>
                    <div class="rounded-2xl bg-white/80 p-6 shadow-sm ring-1 ring-gray-100 backdrop-blur-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-lg sm:col-span-2 lg:col-span-1">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-purple-50">
                            <svg class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" /></svg>
                        </div>
                        <h3 class="mt-4 text-base font-semibold text-gray-900">Autentikasi Mudah</h3>
                        <p class="mt-2 text-sm leading-relaxed text-gray-500">Daftar dan masuk hanya dengan username dan password. Simpel tanpa ribet.</p>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="border-t border-blue-100 bg-white/60 px-6 py-8 text-center text-sm text-gray-500">
            &copy;{{ new Date().getFullYear() }} Tuntas — Sistem To Do List
        </footer>
    </div>
</template>
