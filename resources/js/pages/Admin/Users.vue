<script setup lang="ts">
import StrikingDashLayout from '@/layouts/StrikingDashLayout.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Head } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import { Plus, Edit, Trash2, LoaderCircle } from 'lucide-vue-next';
import axios from 'axios';

defineProps<{
    users: Array<{
        id: number;
        name: string;
        email: string;
        roles: Array<{ name: string }>;
        created_at: string;
    }>;
}>();

// Modal state
const showModal = ref(false);
const isEdit = ref(false);
const loading = ref(false);
const formData = ref({
    user_id: null as number | null,
    name: '',
    email: '',
    password: ''
});

// Users list
const users = ref([]);

// CSRF token
const csrfToken = ref('');

// Initialize
onMounted(() => {
    // Get CSRF token from meta tag
    const token = document.querySelector('meta[name="csrf-token"]');
    if (token) {
        csrfToken.value = token.getAttribute('content') || '';
    }
    
    // Set up axios defaults
    axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken.value;
    axios.defaults.headers.common['Content-Type'] = 'application/json';
    axios.defaults.headers.common['Accept'] = 'application/json';
    
    // Load users
    loadUsers();
});

// Load users
const loadUsers = async () => {
    try {
        const response = await axios.get('/admin/users');
        users.value = response.data.users || [];
    } catch (error) {
        console.error('Error loading users:', error);
        showAlert('Error loading users', 'error');
    }
};

// Open modal for add
const openAddModal = () => {
    isEdit.value = false;
    formData.value = {
        user_id: null,
        name: '',
        email: '',
        password: ''
    };
    showModal.value = true;
};

// Open modal for edit
const openEditModal = (user: any) => {
    isEdit.value = true;
    formData.value = {
        user_id: user.id,
        name: user.name,
        email: user.email,
        password: ''
    };
    showModal.value = true;
};

// Close modal
const closeModal = () => {
    showModal.value = false;
    formData.value = {
        user_id: null,
        name: '',
        email: '',
        password: ''
    };
};

// Save user (add or update)
const saveUser = async () => {
    try {
        loading.value = true;
        
        const url = isEdit.value 
            ? `/admin/users/${formData.value.user_id}`
            : '/admin/users';
        
        const method = isEdit.value ? 'put' : 'post';
        
        const response = await axios[method](url, formData.value);
        
        if (response.data.success) {
            showAlert(response.data.message, 'success');
            closeModal();
            loadUsers();
        } else {
            showAlert(response.data.message, 'error');
        }
    } catch (error: any) {
        console.error('Error saving user:', error);
        if (error.response?.data?.errors) {
            showAlert('Validation errors: ' + JSON.stringify(error.response.data.errors), 'error');
        } else {
            showAlert(error.response?.data?.message || 'Error saving user', 'error');
        }
    } finally {
        loading.value = false;
    }
};

// Delete user
const deleteUser = async (userId: number) => {
    if (!confirm('Are you sure you want to delete this user?')) {
        return;
    }
    
    try {
        const response = await axios.delete(`/admin/users/${userId}`);
        
        if (response.data.success) {
            showAlert(response.data.message, 'success');
            loadUsers();
        } else {
            showAlert(response.data.message, 'error');
        }
    } catch (error: any) {
        console.error('Error deleting user:', error);
        showAlert(error.response?.data?.message || 'Error deleting user', 'error');
    }
};

// Show alert
const showAlert = (message: string, type: 'success' | 'error') => {
    // Simple alert for now - you can replace with a proper toast notification
    alert(`${type.toUpperCase()}: ${message}`);
};
</script>

<template>
    <Head title="User Management" />
    
    <StrikingDashLayout>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-main">
                        <h4 class="text-capitalize breadcrumb-title">User Management</h4>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold">User Management</h1>
                    <Button @click="openAddModal" class="flex items-center gap-2">
                        <Plus class="h-4 w-4" />
                        Add User
                    </Button>
                </div>

            <!-- Users Table -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Name
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Email
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Roles
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Created
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="user in users" :key="user.id">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ user.name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ user.email }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <span v-for="role in user.roles" :key="role.name" 
                                      class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mr-1">
                                    {{ role.name }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ new Date(user.created_at).toLocaleDateString() }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <Button 
                                        @click="openEditModal(user)" 
                                        variant="outline" 
                                        size="sm"
                                        class="flex items-center gap-1"
                                    >
                                        <Edit class="h-3 w-3" />
                                        Edit
                                    </Button>
                                    <Button 
                                        @click="deleteUser(user.id)" 
                                        variant="outline" 
                                        size="sm"
                                        class="flex items-center gap-1 text-red-600 hover:text-red-700"
                                        :disabled="user.roles.some(role => role.name === 'super-admin')"
                                    >
                                        <Trash2 class="h-3 w-3" />
                                        Delete
                                    </Button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Bootstrap Modal -->
            <div v-if="showModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
                <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                    <div class="mt-3">
                        <!-- Modal Header -->
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium text-gray-900">
                                {{ isEdit ? 'Edit User' : 'Add New User' }}
                            </h3>
                            <button @click="closeModal" class="text-gray-400 hover:text-gray-600">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <!-- Modal Body -->
                        <form @submit.prevent="saveUser" class="space-y-4">
                            <div>
                                <Label for="name">Name</Label>
                                <Input
                                    id="name"
                                    v-model="formData.name"
                                    type="text"
                                    required
                                    placeholder="Enter user name"
                                />
                            </div>

                            <div>
                                <Label for="email">Email</Label>
                                <Input
                                    id="email"
                                    v-model="formData.email"
                                    type="email"
                                    required
                                    placeholder="Enter email address"
                                />
                            </div>

                            <div>
                                <Label for="password">
                                    Password
                                    <span v-if="isEdit" class="text-sm text-gray-500">(leave blank to keep current)</span>
                                </Label>
                                <Input
                                    id="password"
                                    v-model="formData.password"
                                    type="password"
                                    :required="!isEdit"
                                    placeholder="Enter password"
                                />
                            </div>

                            <!-- Modal Footer -->
                            <div class="flex justify-end space-x-3 pt-4">
                                <Button type="button" variant="outline" @click="closeModal">
                                    Cancel
                                </Button>
                                <Button type="submit" :disabled="loading" class="flex items-center gap-2">
                                    <LoaderCircle v-if="loading" class="h-4 w-4 animate-spin" />
                                    {{ loading ? 'Saving...' : (isEdit ? 'Update' : 'Create') }}
                                </Button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </StrikingDashLayout>
</template>

