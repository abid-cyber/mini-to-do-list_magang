<script setup>
import { ref, onMounted } from 'vue';
import { Head, useForm, Link } from '@inertiajs/vue3';

const props = defineProps({
    initialMode: { type: String, default: 'login' },
    status: { type: String },
    canResetPassword: { type: Boolean },
});

const isLogin = ref(true);

onMounted(() => {
    isLogin.value = props.initialMode === 'login';
});

const loginForm = useForm({ username: '', password: '', remember: false });
const registerForm = useForm({ name: '', username: '', password: '', password_confirmation: '' });

const submitLogin = () => {
    loginForm.post(route('login'), {
        onFinish: () => loginForm.reset('password'),
    });
};

const submitRegister = () => {
    registerForm.post(route('register'), {
        onFinish: () => registerForm.reset('password', 'password_confirmation'),
    });
};

const togglePanel = () => {
    isLogin.value = !isLogin.value;
};
</script>

<template>
    <Head :title="isLogin ? 'Masuk — Tuntas' : 'Daftar — Tuntas'" />

    <div class="auth-wrapper flex items-center justify-center min-h-screen bg-gradient-to-b from-blue-50 via-slate-50 to-blue-50 p-4 font-sans relative">
        
        <!-- Tombol Kembali ke Beranda -->
        <Link href="/" class="absolute top-6 left-6 md:top-8 md:left-8 flex items-center gap-2 text-gray-500 hover:text-indigo-600 transition-colors font-medium z-50 bg-white/80 md:bg-transparent backdrop-blur-sm md:backdrop-blur-none px-4 py-2 md:p-0 rounded-full md:rounded-none shadow-sm md:shadow-none border border-gray-200 md:border-none">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span class="text-sm">Beranda</span>
        </Link>

        <div class="container bg-white shadow-[0_20px_50px_rgba(0,0,0,0.1)] rounded-[2rem] overflow-hidden" :class="{ 'right-panel-active': !isLogin }">
            
            <!-- ================= SIGN UP FORM (Register) ================= -->
            <div class="form-container sign-up-container bg-white">
                <form @submit.prevent="submitRegister" class="flex flex-col justify-center h-full px-8 md:px-14 w-full max-w-md mx-auto">
                    <div class="text-center mb-6">
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">Buat Akun</h1>
                        <span class="text-sm text-gray-500">Mulai kelola tugas Anda hari ini</span>
                    </div>
                    
                    <div class="flex flex-col gap-1.5 mb-3">
                        <label class="text-xs font-bold text-gray-600 tracking-wider uppercase ml-1">Nama Lengkap</label>
                        <input v-model="registerForm.name" type="text" placeholder="John Doe" class="w-full bg-gray-50/50 border border-gray-200 text-gray-900 text-sm rounded-xl px-4 py-3 focus:ring-indigo-500 focus:border-indigo-500 transition-all shadow-[inset_0_2px_4px_rgba(0,0,0,0.02)] outline-none" required />
                        <p v-if="registerForm.errors.name" class="text-xs text-red-500 mt-1 ml-1">{{ registerForm.errors.name }}</p>
                    </div>

                    <div class="flex flex-col gap-1.5 mb-3">
                        <label class="text-xs font-bold text-gray-600 tracking-wider uppercase ml-1">Username</label>
                        <input v-model="registerForm.username" type="text" placeholder="Pilih username" class="w-full bg-gray-50/50 border border-gray-200 text-gray-900 text-sm rounded-xl px-4 py-3 focus:ring-indigo-500 focus:border-indigo-500 transition-all shadow-[inset_0_2px_4px_rgba(0,0,0,0.02)] outline-none" required />
                        <p v-if="registerForm.errors.username" class="text-xs text-red-500 mt-1 ml-1">{{ registerForm.errors.username }}</p>
                    </div>
                    
                    <div class="flex flex-col gap-1.5 mb-3">
                        <label class="text-xs font-bold text-gray-600 tracking-wider uppercase ml-1">Password</label>
                        <input v-model="registerForm.password" type="password" placeholder="Min. 8 karakter" class="w-full bg-gray-50/50 border border-gray-200 text-gray-900 text-sm rounded-xl px-4 py-3 focus:ring-indigo-500 focus:border-indigo-500 transition-all shadow-[inset_0_2px_4px_rgba(0,0,0,0.02)] outline-none" required />
                        <p v-if="registerForm.errors.password" class="text-xs text-red-500 mt-1 ml-1">{{ registerForm.errors.password }}</p>
                    </div>
                    
                    <div class="flex flex-col gap-1.5 mb-6">
                        <label class="text-xs font-bold text-gray-600 tracking-wider uppercase ml-1">Konfirmasi Password</label>
                        <input v-model="registerForm.password_confirmation" type="password" placeholder="Ulangi password" class="w-full bg-gray-50/50 border border-gray-200 text-gray-900 text-sm rounded-xl px-4 py-3 focus:ring-indigo-500 focus:border-indigo-500 transition-all shadow-[inset_0_2px_4px_rgba(0,0,0,0.02)] outline-none" required />
                    </div>
                    
                    <button type="submit" :disabled="registerForm.processing" class="w-full text-white bg-indigo-600 hover:bg-indigo-700 font-bold rounded-xl text-sm px-5 py-4 text-center transition-all shadow-lg shadow-indigo-600/30 active:scale-95 disabled:opacity-50 tracking-wide uppercase">Daftar</button>
                    
                    <!-- Mobile toggle -->
                    <p class="mt-6 text-sm text-center text-gray-500 md:hidden block">
                        Sudah punya akun? <a href="#" @click.prevent="togglePanel" class="text-indigo-600 font-bold hover:underline">Masuk</a>
                    </p>
                </form>
            </div>
            
            <!-- ================= SIGN IN FORM (Login) ================= -->
            <div class="form-container sign-in-container bg-white">
                <form @submit.prevent="submitLogin" class="flex flex-col justify-center h-full px-8 md:px-14 w-full max-w-md mx-auto">
                    <div class="text-center mb-8">
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">Selamat Datang!</h1>
                        <span class="text-sm text-gray-500">Silakan masuk ke akun Anda</span>
                    </div>
                    
                    <div v-if="status" class="mb-6 font-medium text-sm text-emerald-600 bg-emerald-50 p-4 rounded-xl text-center">{{ status }}</div>
                    
                    <div class="flex flex-col gap-1.5 mb-4">
                        <label class="text-xs font-bold text-gray-600 tracking-wider uppercase ml-1">Username</label>
                        <input v-model="loginForm.username" type="text" placeholder="Masukkan username" class="w-full bg-gray-50/50 border border-gray-200 text-gray-900 text-sm rounded-xl px-4 py-3.5 focus:ring-indigo-500 focus:border-indigo-500 transition-all shadow-[inset_0_2px_4px_rgba(0,0,0,0.02)] outline-none" required />
                        <p v-if="loginForm.errors.username" class="text-xs text-red-500 mt-1 ml-1">{{ loginForm.errors.username }}</p>
                    </div>
                    
                    <div class="flex flex-col gap-1.5 mb-6">
                        <label class="text-xs font-bold text-gray-600 tracking-wider uppercase ml-1">Password</label>
                        <input v-model="loginForm.password" type="password" placeholder="••••••••" class="w-full bg-gray-50/50 border border-gray-200 text-gray-900 text-sm rounded-xl px-4 py-3.5 focus:ring-indigo-500 focus:border-indigo-500 transition-all shadow-[inset_0_2px_4px_rgba(0,0,0,0.02)] outline-none" required />
                        <p v-if="loginForm.errors.password" class="text-xs text-red-500 mt-1 ml-1">{{ loginForm.errors.password }}</p>
                    </div>

                    <div class="flex items-center mb-6 ml-1">
                        <label class="flex items-center cursor-pointer group">
                            <input type="checkbox" v-model="loginForm.remember" class="w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 rounded focus:ring-indigo-600 focus:ring-2">
                            <span class="ml-2 text-sm text-gray-500 group-hover:text-gray-700 transition">Ingat saya</span>
                        </label>
                    </div>
                    
                    <button type="submit" :disabled="loginForm.processing" class="w-full text-white bg-indigo-600 hover:bg-indigo-700 font-bold rounded-xl text-sm px-5 py-4 text-center transition-all shadow-lg shadow-indigo-600/30 active:scale-95 disabled:opacity-50 tracking-wide uppercase">Masuk</button>
                    
                    <!-- Mobile toggle -->
                    <p class="mt-6 text-sm text-center text-gray-500 md:hidden block">
                        Belum punya akun? <a href="#" @click.prevent="togglePanel" class="text-indigo-600 font-bold hover:underline">Daftar</a>
                    </p>
                </form>
            </div>
            
            <!-- ================= THE SLIDING OVERLAY (Desktop Only) ================= -->
            <div class="overlay-container hidden md:block">
                <!-- Panel warna utama (Sesuai tema Welcome.vue) -->
                <div class="overlay bg-indigo-600 bg-gradient-to-br from-indigo-500 to-indigo-700">
                    
                    <!-- Dekorasi Titik -->
                    <div class="absolute top-10 left-10 grid grid-cols-4 gap-2 opacity-30 z-0">
                        <div v-for="i in 16" :key="`l-${i}`" class="w-1.5 h-1.5 bg-indigo-300 rounded-full"></div>
                    </div>
                    <div class="absolute bottom-10 right-10 grid grid-cols-4 gap-2 opacity-30 z-0">
                        <div v-for="i in 16" :key="`r-${i}`" class="w-1.5 h-1.5 bg-indigo-300 rounded-full"></div>
                    </div>

                    <!-- Teks Kiri (Tampil saat form Register aktif) -->
                    <div class="overlay-panel overlay-left z-10">
                        <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-indigo-500/20 shadow-lg mb-6 backdrop-blur-sm border border-indigo-400/20">
                            <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15a2.25 2.25 0 0 1 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                            </svg>
                        </div>
                        <h1 class="text-4xl font-bold text-white mb-4 tracking-wide">TUNTAS</h1>
                        <p class="text-indigo-200 mb-10 px-4 leading-relaxed max-w-[280px] text-sm">
                            Aplikasi To-Do List simpel yang membantu harimu jauh lebih produktif dan teratur.
                        </p>
                        <button class="ghost border border-white/50 bg-white/5 text-white rounded-xl py-3.5 px-12 font-bold uppercase tracking-wide text-sm transition hover:bg-white hover:text-indigo-700 active:scale-95" @click="togglePanel">
                            Masuk
                        </button>
                    </div>
                    
                    <!-- Teks Kanan (Tampil saat form Login aktif) -->
                    <div class="overlay-panel overlay-right z-10">
                        <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-indigo-500/20 shadow-lg mb-6 backdrop-blur-sm border border-indigo-400/20">
                            <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15a2.25 2.25 0 0 1 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                            </svg>
                        </div>
                        <h1 class="text-4xl font-bold text-white mb-4 tracking-wide">TUNTAS</h1>
                        <p class="text-indigo-200 mb-10 px-4 leading-relaxed max-w-[280px] text-sm">
                            Daftarkan dirimu secara gratis dan rasakan kemudahan mengelola produktivitas harianmu.
                        </p>
                        <button class="ghost border border-white/50 bg-white/5 text-white rounded-xl py-3.5 px-12 font-bold uppercase tracking-wide text-sm transition hover:bg-white hover:text-indigo-700 active:scale-95" @click="togglePanel">
                            Daftar
                        </button>
                    </div>
                </div>
            </div>
            
        </div>
        
    </div>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

.auth-wrapper {
    font-family: 'Inter', sans-serif;
}

/* Base Container */
.container {
    position: relative;
    width: 900px;
    max-width: 100%;
    min-height: 600px;
}

/* Form Containers (Mobile Default) */
.form-container {
    position: absolute;
    top: 0;
    height: 100%;
    transition: all 0.6s ease-in-out;
}

/* Sign In on Mobile */
.sign-in-container {
    left: 0;
    width: 100%;
    z-index: 2;
}

/* Sign Up on Mobile */
.sign-up-container {
    left: 0;
    width: 100%;
    opacity: 0;
    z-index: 1;
    display: none;
}

/* Right Panel Active on Mobile */
.container.right-panel-active .sign-in-container {
    transform: translateX(100%);
    opacity: 0;
    display: none;
}

.container.right-panel-active .sign-up-container {
    transform: translateX(0%);
    opacity: 1;
    z-index: 5;
    animation: show 0.6s;
    display: block;
}

@keyframes show {
    0%, 49.99% { opacity: 0; z-index: 1; }
    50%, 100% { opacity: 1; z-index: 5; }
}

/* ==========================================
   DESKTOP ANIMATION LOGIC (min-width 768px)
   ========================================== */
@media (min-width: 768px) {
    .sign-in-container {
        width: 50%;
    }
    
    .container.right-panel-active .sign-in-container {
        transform: translateX(100%);
        display: block;
        opacity: 0;
    }
    
    .sign-up-container {
        width: 50%;
        display: block;
        opacity: 0;
        z-index: 1;
    }
    
    .container.right-panel-active .sign-up-container {
        transform: translateX(100%);
        opacity: 1;
        z-index: 5;
    }

    .overlay-container {
        position: absolute;
        top: 0;
        left: 50%;
        width: 50%;
        height: 100%;
        overflow: hidden;
        transition: transform 0.6s ease-in-out;
        z-index: 100;
    }

    .container.right-panel-active .overlay-container{
        transform: translateX(-100%);
    }

    /* Solid Dark Blue Panel */
    .overlay {
        position: relative;
        left: -100%;
        height: 100%;
        width: 200%;
        transform: translateX(0);
        transition: transform 0.6s ease-in-out;
    }

    .container.right-panel-active .overlay {
        transform: translateX(50%);
    }

    .overlay-panel {
        position: absolute;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        text-align: center;
        top: 0;
        height: 100%;
        width: 50%;
        transform: translateX(0);
        transition: transform 0.6s ease-in-out;
    }

    .overlay-left {
        transform: translateX(-20%);
    }

    .container.right-panel-active .overlay-left {
        transform: translateX(0);
    }

    .overlay-right {
        right: 0;
        transform: translateX(0);
    }

    .container.right-panel-active .overlay-right {
        transform: translateX(20%);
    }
}
</style>
