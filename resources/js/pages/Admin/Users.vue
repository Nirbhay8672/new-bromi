<script setup lang="ts">
import StrikingDashLayout from '@/layouts/StrikingDashLayout.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Head, router } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import { Plus, Edit, Trash2, LoaderCircle } from 'lucide-vue-next';
import axios from 'axios';

const props = defineProps<{
    users: Array<{
        id: number;
        name: string;
        email: string;
        profile_photo_url?: string;
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
});

// Close modal
const closeModal = () => {
    showModal.value = false;
    formData.value = {
        user_id: null,
        name: '',
        email: '',
        password: ''
    };
    // Remove body scroll lock
    document.body.classList.remove('modal-open');
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
    // Add body scroll lock
    document.body.classList.add('modal-open');
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
    // Add body scroll lock
    document.body.classList.add('modal-open');
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
            router.reload();
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
            router.reload();
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

<style scoped>
.modal {
    z-index: 1055;
}

.modal-backdrop {
    z-index: 1050;
}

.modal-open {
    overflow: hidden;
}

.modal-dialog {
    max-width: 500px;
}

.btn-close {
    background: none;
    border: none;
    font-size: 1.5rem;
    font-weight: 700;
    line-height: 1;
    color: #000;
    text-shadow: 0 1px 0 #fff;
    opacity: 0.5;
}

.btn-close:hover {
    color: #000;
    text-decoration: none;
    opacity: 0.75;
}

.btn-close:focus {
    outline: none;
    box-shadow: none;
}

/* Profile Image Styles */
.rounded-circle {
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
}

.rounded-circle:hover {
    border-color: #007bff;
    transform: scale(1.05);
}

.avatar-title {
    font-size: 14px;
    font-weight: 600;
}

/* Badge Styles */
.badge {
    border-radius: 0.375rem !important;
    font-size: 0.75rem;
    font-weight: 500;
    padding: 0.35em 0.65em;
    line-height: 1;
}

.badge.bg-danger {
    background-color: #dc3545 !important;
    color: #fff !important;
}

.badge.bg-warning {
    background-color: #ffc107 !important;
    color: #000 !important;
}

.badge.bg-primary {
    background-color: #0d6efd !important;
    color: #fff !important;
}

.badge.bg-secondary {
    background-color: #6c757d !important;
    color: #fff !important;
}

.badge.bg-success {
    background-color: #198754 !important;
    color: #fff !important;
}

.badge.bg-light {
    background-color: #f8f9fa !important;
    color: #000 !important;
    border: 1px solid #dee2e6 !important;
}
</style>

<template>
    <Head title="User Management" />
    
    <StrikingDashLayout>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-main d-flex align-items-center justify-content-between">
                        <h4 class="text-capitalize breadcrumb-title mb-0">User Management</h4>
                        <button @click="openAddModal" class="btn btn-primary">
                            <span data-feather="plus" class="me-2"></span>
                            Add User
                        </button>
                    </div>
                </div>
            </div>

            <!-- Users Table -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0 d-flex align-items-center">
                        <span data-feather="users" class="me-2 text-primary"></span>
                        Users List
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0 fw-semibold">User</th>
                                    <th class="border-0 fw-semibold">Email</th>
                                    <th class="border-0 fw-semibold">Role</th>
                                    <th class="border-0 fw-semibold">Status</th>
                                    <th class="border-0 fw-semibold">Created</th>
                                    <th class="border-0 fw-semibold">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="user in props.users" :key="user.id" class="align-middle">
                                        <td class="border-0">
                                            <div class="d-flex align-items-center">
                                                <div class="me-3">
                                                    <img 
                                                        v-if="user.profile_photo_url" 
                                                        :src="user.profile_photo_url" 
                                                        :alt="user.name || 'User'"
                                                        class="rounded-circle"
                                                        style="width: 40px; height: 40px; object-fit: cover;"
                                                    />
                                                    <div 
                                                        v-else
                                                        class="avatar-title bg-primary bg-gradient rounded-circle d-flex align-items-center justify-content-center"
                                                        style="width: 40px; height: 40px;"
                                                    >
                                                        <span class="text-white fw-semibold">
                                                            {{ user.name ? user.name.charAt(0).toUpperCase() : 'U' }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0 fw-semibold">{{ user.name || 'No Name' }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                    <td class="border-0">
                                        <div class="d-flex align-items-center">
                                            <span data-feather="mail" class="me-2 text-muted"></span>
                                            <span class="text-dark">{{ user.email || 'No Email' }}</span>
                                        </div>
                                    </td>
                                        <td class="border-0">
                                            <div v-if="user.id === 1">
                                                <span class="badge bg-danger me-1">
                                                    SUPER ADMIN
                                                </span>
                                            </div>
                                            <div v-else-if="user.roles && user.roles.length > 0">
                                                <span v-for="role in user.roles" :key="role.name"
                                                      class="badge me-1"
                                                      :class="{
                                                          'bg-danger': role.name === 'super-admin',
                                                          'bg-warning text-dark': role.name === 'admin',
                                                          'bg-primary': role.name === 'user',
                                                          'bg-secondary': !['super-admin', 'admin', 'user'].includes(role.name)
                                                      }">
                                                    {{ role.name.replace('-', ' ').toUpperCase() }}
                                                </span>
                                            </div>
                                            <span v-else class="badge bg-light text-dark border">
                                                No Role
                                            </span>
                                        </td>
                                    <td class="border-0">
                                        <span class="badge bg-success">
                                            Active
                                        </span>
                                    </td>
                                    <td class="border-0">
                                        <div class="d-flex align-items-center">
                                            <span data-feather="calendar" class="me-2 text-muted"></span>
                                            <span class="text-dark">
                                                {{ user.created_at ? new Date(user.created_at).toLocaleDateString('en-US', {
                                                    year: 'numeric',
                                                    month: 'short',
                                                    day: 'numeric'
                                                }) : 'Unknown' }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="border-0">
                                        <div class="d-flex gap-2">
                                            <button 
                                                @click="openEditModal(user)" 
                                                class="btn btn-outline-primary btn-sm"
                                                title="Edit User"
                                            >
                                                <span data-feather="edit" class="me-1"></span>
                                                Edit
                                            </button>
                                            <button 
                                                @click="deleteUser(user.id)" 
                                                class="btn btn-outline-danger btn-sm"
                                                :disabled="user.roles && user.roles.some(role => role.name === 'super-admin')"
                                                :title="user.roles && user.roles.some(role => role.name === 'super-admin') ? 'Cannot delete super admin' : 'Delete User'"
                                            >
                                                <span data-feather="trash-2" class="me-1"></span>
                                                Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr v-if="props.users.length === 0">
                                    <td colspan="6" class="text-center py-5">
                                        <div class="d-flex flex-column align-items-center">
                                            <span data-feather="users" class="text-muted mb-3" style="width: 48px; height: 48px;"></span>
                                            <h6 class="text-muted">No users found</h6>
                                            <p class="text-muted mb-0">Click "Add User" to create your first user.</p>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Bootstrap Modal -->
            <div v-if="showModal" class="modal fade show" style="display: block;" tabindex="-1" role="dialog" @click.self="closeModal">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                {{ isEdit ? 'Edit User' : 'Add New User' }}
                            </h5>
                            <button type="button" class="btn-close" @click="closeModal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form @submit.prevent="saveUser">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <Input
                                        id="name"
                                        v-model="formData.name"
                                        type="text"
                                        class="form-control"
                                        required
                                        placeholder="Enter user name"
                                    />
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <Input
                                        id="email"
                                        v-model="formData.email"
                                        type="email"
                                        class="form-control"
                                        required
                                        placeholder="Enter email address"
                                    />
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">
                                        Password
                                        <span v-if="isEdit" class="text-muted">(leave blank to keep current)</span>
                                    </label>
                                    <Input
                                        id="password"
                                        v-model="formData.password"
                                        type="password"
                                        class="form-control"
                                        :required="!isEdit"
                                        placeholder="Enter password"
                                    />
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="closeModal">
                                Cancel
                            </button>
                            <button 
                                type="button" 
                                class="btn btn-primary" 
                                @click="saveUser"
                                :disabled="loading"
                            >
                                <span v-if="loading" class="spinner-border spinner-border-sm me-2" role="status"></span>
                                {{ loading ? 'Saving...' : (isEdit ? 'Update' : 'Create') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Modal Backdrop -->
            <div v-if="showModal" class="modal-backdrop fade show" @click="closeModal"></div>
        </div>
    </StrikingDashLayout>
</template>

