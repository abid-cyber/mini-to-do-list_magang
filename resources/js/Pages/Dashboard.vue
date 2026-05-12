<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import Modal from '@/Components/Modal.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
    tasks: {
        type: Array,
        default: () => [],
    },
});

const page = usePage();
const userName = computed(() => page.props.auth.user.name);

// Filter state
const filter = ref('all'); // 'all', 'active', 'completed'

const filteredTasks = computed(() => {
    if (filter.value === 'active') {
        return props.tasks.filter(t => !t.is_completed);
    }
    if (filter.value === 'completed') {
        return props.tasks.filter(t => t.is_completed);
    }
    return props.tasks;
});

const taskStats = computed(() => {
    const total = props.tasks.length;
    const completed = props.tasks.filter(t => t.is_completed).length;
    const active = total - completed;
    return { total, completed, active };
});

// Add task form
const showAddModal = ref(false);
const addForm = useForm({
    title: '',
    description: '',
});

const openAddModal = () => {
    addForm.reset();
    addForm.clearErrors();
    showAddModal.value = true;
};

const submitAdd = () => {
    addForm.post(route('tasks.store'), {
        preserveScroll: true,
        onSuccess: () => {
            showAddModal.value = false;
            addForm.reset();
        },
    });
};

// Edit task form
const showEditModal = ref(false);
const editingTask = ref(null);
const editForm = useForm({
    title: '',
    description: '',
});

const openEditModal = (task) => {
    editingTask.value = task;
    editForm.title = task.title;
    editForm.description = task.description || '';
    editForm.clearErrors();
    showEditModal.value = true;
};

const submitEdit = () => {
    editForm.put(route('tasks.update', editingTask.value.id), {
        preserveScroll: true,
        onSuccess: () => {
            showEditModal.value = false;
            editingTask.value = null;
            editForm.reset();
        },
    });
};

// Toggle completion
const toggleTask = (task) => {
    useForm({}).patch(route('tasks.toggle', task.id), {
        preserveScroll: true,
    });
};

// Delete task
const showDeleteModal = ref(false);
const deletingTask = ref(null);
const deleteForm = useForm({});

const openDeleteModal = (task) => {
    deletingTask.value = task;
    showDeleteModal.value = true;
};

const submitDelete = () => {
    deleteForm.delete(route('tasks.destroy', deletingTask.value.id), {
        preserveScroll: true,
        onSuccess: () => {
            showDeleteModal.value = false;
            deletingTask.value = null;
        },
    });
};

// Format date
const formatDate = (dateString) => {
    const date = new Date(dateString);
    return date.toLocaleDateString('id-ID', {
        day: 'numeric',
        month: 'short',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
    });
};
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-xl font-semibold leading-tight text-gray-800">
                        Tugas Saya
                    </h2>
                    <p class="mt-1 text-sm text-gray-500">
                        Halo, {{ userName }}! Kelola daftar tugasmu di sini.
                    </p>
                </div>
                <button
                    id="btn-add-task"
                    @click="openAddModal"
                    class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition-all duration-200 hover:bg-indigo-700 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:scale-95 sm:w-auto"
                >
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Tambah Tugas
                </button>
            </div>
        </template>

        <div class="py-8">
            <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
                <!-- Stats Cards -->
                <div class="mb-8 grid grid-cols-1 gap-3 sm:grid-cols-3 sm:gap-4">
                    <div class="rounded-xl border-l-4 border-indigo-500 bg-white p-5 shadow-sm transition-all duration-200 hover:shadow-md">
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-50">
                                <svg class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0ZM3.75 12h.007v.008H3.75V12Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm-.375 5.25h.007v.008H3.75v-.008Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-2xl font-bold text-gray-900">{{ taskStats.total }}</p>
                                <p class="text-xs font-medium text-gray-500">Total Tugas</p>
                            </div>
                        </div>
                    </div>
                    <div class="rounded-xl border-l-4 border-amber-400 bg-white p-5 shadow-sm transition-all duration-200 hover:shadow-md">
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-amber-50">
                                <svg class="h-5 w-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-2xl font-bold text-gray-900">{{ taskStats.active }}</p>
                                <p class="text-xs font-medium text-gray-500">Belum Selesai</p>
                            </div>
                        </div>
                    </div>
                    <div class="rounded-xl border-l-4 border-emerald-500 bg-white p-5 shadow-sm transition-all duration-200 hover:shadow-md">
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-emerald-50">
                                <svg class="h-5 w-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-2xl font-bold text-gray-900">{{ taskStats.completed }}</p>
                                <p class="text-xs font-medium text-gray-500">Selesai</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filter Tabs -->
                <div class="mb-6 flex gap-1 rounded-lg bg-indigo-50/70 p-1">
                    <button
                        id="filter-all"
                        @click="filter = 'all'"
                        :class="[
                            'flex-1 rounded-md px-4 py-2 text-sm font-medium transition-all duration-200',
                            filter === 'all'
                                ? 'bg-white text-indigo-700 shadow-sm'
                                : 'text-gray-500 hover:text-indigo-600',
                        ]"
                    >
                        Semua ({{ taskStats.total }})
                    </button>
                    <button
                        id="filter-active"
                        @click="filter = 'active'"
                        :class="[
                            'flex-1 rounded-md px-4 py-2 text-sm font-medium transition-all duration-200',
                            filter === 'active'
                                ? 'bg-white text-indigo-700 shadow-sm'
                                : 'text-gray-500 hover:text-indigo-600',
                        ]"
                    >
                        Aktif ({{ taskStats.active }})
                    </button>
                    <button
                        id="filter-completed"
                        @click="filter = 'completed'"
                        :class="[
                            'flex-1 rounded-md px-4 py-2 text-sm font-medium transition-all duration-200',
                            filter === 'completed'
                                ? 'bg-white text-indigo-700 shadow-sm'
                                : 'text-gray-500 hover:text-indigo-600',
                        ]"
                    >
                        Selesai ({{ taskStats.completed }})
                    </button>
                </div>

                <!-- Task List -->
                <div class="space-y-3">
                    <!-- Empty State -->
                    <div
                        v-if="filteredTasks.length === 0"
                        class="flex flex-col items-center justify-center rounded-xl bg-white py-16 shadow-sm ring-1 ring-gray-100"
                    >
                        <div class="flex h-16 w-16 items-center justify-center rounded-full bg-gray-50">
                            <svg class="h-8 w-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15a2.25 2.25 0 0 1 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                            </svg>
                        </div>
                        <p class="mt-4 text-sm font-medium text-gray-500">
                            {{ filter === 'all' ? 'Belum ada tugas. Yuk mulai tambahkan!' : filter === 'active' ? 'Semua tugas sudah selesai! 🎉' : 'Belum ada tugas yang diselesaikan.' }}
                        </p>
                        <button
                            v-if="filter === 'all'"
                            @click="openAddModal"
                            class="mt-4 inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition-all duration-200 hover:bg-indigo-700 active:scale-95"
                        >
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            Tambah Tugas Pertama
                        </button>
                    </div>

                    <!-- Task Items -->
                    <div
                        v-for="task in filteredTasks"
                        :key="task.id"
                        :id="'task-' + task.id"
                        class="group relative rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-100 transition-all duration-200 hover:shadow-md"
                        :class="{ 'bg-gray-50/50': task.is_completed }"
                    >
                        <div class="flex items-start gap-4">
                            <!-- Checkbox -->
                            <button
                                :id="'toggle-task-' + task.id"
                                @click="toggleTask(task)"
                                class="mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-full border-2 transition-all duration-200"
                                :class="task.is_completed
                                    ? 'border-emerald-500 bg-emerald-500 text-white'
                                    : 'border-gray-300 hover:border-indigo-400 hover:bg-indigo-50'"
                            >
                                <svg v-if="task.is_completed" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                </svg>
                            </button>

                            <!-- Content -->
                            <div class="min-w-0 flex-1">
                                <h3
                                    class="text-base font-semibold transition-all duration-200"
                                    :class="task.is_completed ? 'text-gray-400 line-through' : 'text-gray-900'"
                                >
                                    {{ task.title }}
                                </h3>
                                <p
                                    v-if="task.description"
                                    class="mt-1 text-sm leading-relaxed"
                                    :class="task.is_completed ? 'text-gray-300' : 'text-gray-500'"
                                >
                                    {{ task.description }}
                                </p>
                                <p class="mt-2 text-xs text-gray-300">
                                    {{ formatDate(task.created_at) }}
                                </p>
                            </div>

                            <!-- Actions -->
                            <div class="flex shrink-0 gap-1">
                                <button
                                    :id="'edit-task-' + task.id"
                                    @click="openEditModal(task)"
                                    class="rounded-lg p-2 text-gray-400 transition-colors duration-150 hover:bg-indigo-50 hover:text-indigo-600"
                                    title="Edit tugas"
                                >
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                </button>
                                <button
                                    :id="'delete-task-' + task.id"
                                    @click="openDeleteModal(task)"
                                    class="rounded-lg p-2 text-gray-400 transition-colors duration-150 hover:bg-red-50 hover:text-red-600"
                                    title="Hapus tugas"
                                >
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Task Modal -->
        <Modal :show="showAddModal" @close="showAddModal = false" max-width="lg">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900">Tambah Tugas Baru</h3>
                <p class="mt-1 text-sm text-gray-500">Isi detail tugas yang ingin kamu tambahkan.</p>

                <form @submit.prevent="submitAdd" class="mt-6 space-y-4">
                    <div>
                        <label for="add-title" class="block text-sm font-medium text-gray-700">
                            Judul Tugas <span class="text-red-500">*</span>
                        </label>
                        <input
                            id="add-title"
                            v-model="addForm.title"
                            type="text"
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm transition-colors focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            placeholder="Contoh: Belajar Laravel"
                            required
                        />
                        <InputError class="mt-1" :message="addForm.errors.title" />
                    </div>

                    <div>
                        <label for="add-description" class="block text-sm font-medium text-gray-700">
                            Deskripsi <span class="text-gray-400">(opsional)</span>
                        </label>
                        <textarea
                            id="add-description"
                            v-model="addForm.description"
                            rows="3"
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm transition-colors focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            placeholder="Tambahkan detail tugas..."
                        ></textarea>
                        <InputError class="mt-1" :message="addForm.errors.description" />
                    </div>

                    <div class="flex justify-end gap-3 pt-2">
                        <button type="button" @click="showAddModal = false" class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-50">Batal</button>
                        <button type="submit" :disabled="addForm.processing" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition-all duration-200 hover:bg-indigo-700 disabled:opacity-50 active:scale-95">
                            {{ addForm.processing ? 'Menyimpan...' : 'Simpan Tugas' }}
                        </button>
                    </div>
                </form>
            </div>
        </Modal>

        <!-- Edit Task Modal -->
        <Modal :show="showEditModal" @close="showEditModal = false" max-width="lg">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900">Edit Tugas</h3>
                <p class="mt-1 text-sm text-gray-500">Perbarui detail tugas kamu.</p>

                <form @submit.prevent="submitEdit" class="mt-6 space-y-4">
                    <div>
                        <label for="edit-title" class="block text-sm font-medium text-gray-700">
                            Judul Tugas <span class="text-red-500">*</span>
                        </label>
                        <input
                            id="edit-title"
                            v-model="editForm.title"
                            type="text"
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm transition-colors focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            required
                        />
                        <InputError class="mt-1" :message="editForm.errors.title" />
                    </div>

                    <div>
                        <label for="edit-description" class="block text-sm font-medium text-gray-700">
                            Deskripsi <span class="text-gray-400">(opsional)</span>
                        </label>
                        <textarea
                            id="edit-description"
                            v-model="editForm.description"
                            rows="3"
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm transition-colors focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        ></textarea>
                        <InputError class="mt-1" :message="editForm.errors.description" />
                    </div>

                    <div class="flex justify-end gap-3 pt-2">
                        <button type="button" @click="showEditModal = false" class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-50">Batal</button>
                        <button type="submit" :disabled="editForm.processing" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition-all duration-200 hover:bg-indigo-700 disabled:opacity-50 active:scale-95">
                            {{ editForm.processing ? 'Menyimpan...' : 'Perbarui Tugas' }}
                        </button>
                    </div>
                </form>
            </div>
        </Modal>

        <!-- Delete Confirmation Modal -->
        <Modal :show="showDeleteModal" @close="showDeleteModal = false" max-width="sm">
            <div class="p-6">
                <div class="flex items-center gap-4">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-red-100">
                        <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Hapus Tugas</h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Yakin ingin menghapus "<strong>{{ deletingTask?.title }}</strong>"? Tindakan ini tidak bisa dibatalkan.
                        </p>
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" @click="showDeleteModal = false" class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-50">Batal</button>
                    <button @click="submitDelete" :disabled="deleteForm.processing" class="rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white transition-all duration-200 hover:bg-red-700 disabled:opacity-50 active:scale-95">
                        {{ deleteForm.processing ? 'Menghapus...' : 'Ya, Hapus' }}
                    </button>
                </div>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>
