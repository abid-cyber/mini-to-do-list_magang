<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="flex min-h-screen bg-gray-100 items-center justify-center p-4 sm:p-8 font-sans">
        
        <!-- Main Card Container -->
        <div class="flex flex-col md:flex-row w-full max-w-5xl bg-white rounded-3xl shadow-[0_20px_50px_rgba(0,0,0,0.1)] overflow-hidden min-h-[600px] relative">
            
            <!-- Left Side: Branding / Illustration (Only visible on desktop) -->
            <div class="hidden md:flex md:w-[45%] bg-[#1e1b4b] flex-col items-center justify-center p-12 relative z-10" style="border-top-right-radius: 2rem; border-bottom-right-radius: 2rem; box-shadow: 10px 0 25px rgba(0,0,0,0.1);">
                <!-- Decorative dot pattern -->
                <div class="absolute top-10 left-10 grid grid-cols-4 gap-2 opacity-30">
                    <div v-for="i in 16" :key="i" class="w-1.5 h-1.5 bg-indigo-300 rounded-full"></div>
                </div>
                
                <div class="text-center z-10 flex flex-col items-center">
                    <div class="flex h-20 w-20 items-center justify-center rounded-2xl bg-indigo-500 shadow-lg mb-8">
                        <svg class="h-10 w-10 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15a2.25 2.25 0 0 1 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                        </svg>
                    </div>
                    
                    <h1 class="text-4xl font-extrabold text-white tracking-wider mb-4">TUNTAS</h1>
                    <p class="text-indigo-200 font-light max-w-[280px] mx-auto text-sm leading-relaxed">
                        Aplikasi To-Do List simpel yang membantu harimu jauh lebih produktif dan teratur.
                    </p>
                </div>
                
                <!-- Bottom decorative line -->
                <div class="absolute bottom-8 left-1/2 -translate-x-1/2 w-1/3 h-1.5 bg-indigo-500/40 rounded-full"></div>
            </div>
            
            <!-- Right Side: Form Content -->
            <div class="w-full md:w-[55%] flex flex-col justify-center px-8 py-16 sm:px-16 lg:px-24 bg-white relative z-0">
                <!-- Mobile Logo (shows only on small screens) -->
                <div class="flex md:hidden items-center justify-center gap-3 mb-10">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-[#1e1b4b] shadow-lg">
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15a2.25 2.25 0 0 1 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                        </svg>
                    </div>
                    <span class="text-3xl font-extrabold text-[#1e1b4b]">TUNTAS</span>
                </div>
                
                <!-- Dynamic Content (Login/Register Form) -->
                <slot />
                
            </div>
            
        </div>
    </div>
</template>
