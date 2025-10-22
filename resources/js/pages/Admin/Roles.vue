<script setup lang="ts">
import { ref, onMounted, nextTick } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import StrikingDashLayout from '@/layouts/StrikingDashLayout.vue';
import { Input } from '@/components/ui/input';

interface Role {
    id: number;
    name: string;
    guard_name: string;
    created_at: string;
    updated_at: string;
    permissions: Permission[];
    users_count?: number;
}

interface Permission {
    id: number;
    name: string;
    guard_name: string;
}

const props = defineProps<{
    roles: Role[];
    permissions: Permission[];
}>();

const showModal = ref(false);
const showDeleteModal = ref(false);
const editingRole = ref<Role | null>(null);
const deletingRole = ref<Role | null>(null);
const formData = ref({
    name: '',
    permissions: [] as number[]
});

const formErrors = ref<Record<string, string>>({});
const isSubmitting = ref(false);

// No need to initialize icons - using Font Awesome classes directly

const openCreateModal = () => {
    editingRole.value = null;
    formData.value = {
        name: '',
        permissions: []
    };
    formErrors.value = {};
    showModal.value = true;
};

const openEditModal = (role: Role) => {
    editingRole.value = role;
    formData.value = {
        name: role.name,
        permissions: role.permissions.map(p => p.id)
    };
    formErrors.value = {};
    showModal.value = true;
    
    console.log('Opening edit modal for role:', {
        role,
        formData: formData.value,
        permissions: role.permissions
    });
};

const openDeleteModal = (role: Role) => {
    deletingRole.value = role;
    showDeleteModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
    editingRole.value = null;
    formData.value = {
        name: '',
        permissions: []
    };
    formErrors.value = {};
    // Remove body scroll lock
    document.body.classList.remove('modal-open');
};

const closeDeleteModal = () => {
    showDeleteModal.value = false;
    deletingRole.value = null;
};

const submitForm = async () => {
    // Clear previous errors
    formErrors.value = {};
    
    // Client-side validation
    if (!formData.value.name || formData.value.name.trim() === '') {
        formErrors.value.name = 'Role name is required.';
        return;
    }

    if (formData.value.name.length < 2) {
        formErrors.value.name = 'Role name must be at least 2 characters long.';
        return;
    }

    if (formData.value.name.length > 255) {
        formErrors.value.name = 'Role name must not exceed 255 characters.';
        return;
    }

    // Check for valid characters (letters, numbers, hyphens, underscores)
    const validNamePattern = /^[a-zA-Z0-9\s\-_]+$/;
    if (!validNamePattern.test(formData.value.name)) {
        formErrors.value.name = 'Role name can only contain letters, numbers, spaces, hyphens, and underscores.';
        return;
    }

    isSubmitting.value = true;

    try {
        const url = editingRole.value 
            ? `/admin/roles/${editingRole.value.id}`
            : '/admin/roles';
        
        const method = editingRole.value ? 'put' : 'post';

        console.log('Submitting role:', {
            url,
            method,
            data: formData.value
        });

        await router[method](url, formData.value, {
            onSuccess: (page) => {
                console.log('Role saved successfully:', page);
                closeModal();
                router.reload();
            },
            onError: (errors) => {
                console.error('Validation errors:', errors);
                formErrors.value = errors;
            },
            onFinish: () => {
                console.log('Request finished');
            }
        });
    } catch (error) {
        console.error('Error submitting form:', error);
        formErrors.value.general = 'An error occurred while saving the role. Please try again.';
    } finally {
        isSubmitting.value = false;
    }
};

const deleteRole = async () => {
    if (!deletingRole.value) return;

    try {
        await router.delete(`/admin/roles/${deletingRole.value.id}`, {
            onSuccess: () => {
                closeDeleteModal();
                router.reload();
            }
        });
    } catch (error) {
        console.error('Error deleting role:', error);
    }
};

const togglePermission = (permissionId: number) => {
    const index = formData.value.permissions.indexOf(permissionId);
    if (index > -1) {
        formData.value.permissions.splice(index, 1);
    } else {
        formData.value.permissions.push(permissionId);
    }
    console.log('Permission toggled:', permissionId, 'Current permissions:', formData.value.permissions);
};

const isPermissionSelected = (permissionId: number) => {
    return formData.value.permissions.includes(permissionId);
};

const getRoleBadgeClass = (roleName: string) => {
    switch (roleName.toLowerCase()) {
        case 'super-admin':
            return 'bg-danger';
        case 'admin':
            return 'bg-warning text-dark';
        case 'user':
            return 'bg-primary';
        default:
            return 'bg-secondary';
    }
};

const formatDate = (dateString: string) => {
    return new Date(dateString).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    });
};

const getGeneralPermissions = (permissions: Permission[]) => {
    return permissions.filter(permission => {
        const parts = permission.name.split(' ');
        return parts.length === 1 || !['create', 'read', 'update', 'delete', 'manage'].includes(parts[0]);
    });
};

</script>

<template>
    <Head title="Roles Management" />

    <StrikingDashLayout>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-main d-flex align-items-center justify-content-between">
                        <h4 class="text-capitalize breadcrumb-title mb-0">Roles Management</h4>
                        <button @click="openCreateModal" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>
                            Add Role
                        </button>
                    </div>
                </div>
            </div>

            <!-- Roles Table -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0 d-flex align-items-center">
                        <i class="fas fa-shield-alt me-2 text-primary"></i>
                        Roles & Permissions
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div v-if="props.roles.length === 0" class="text-center py-5">
                        <i class="fas fa-shield-alt text-muted mb-3" style="font-size: 48px;"></i>
                        <h6 class="text-muted">No roles found</h6>
                        <p class="text-muted mb-0">Click "Add Role" to create your first role.</p>
                    </div>

                    <div v-else class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0 fw-semibold">Role</th>
                                    <th class="border-0 fw-semibold">Permissions</th>
                                    <th class="border-0 fw-semibold">Users</th>
                                    <th class="border-0 fw-semibold">Created</th>
                                    <th class="border-0 fw-semibold">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="role in props.roles" :key="role.id" class="align-middle">
                                    <td class="border-0">
                                        <div class="d-flex align-items-center">
                                            <div class="me-3">
                                                <div class="avatar-title bg-primary bg-gradient rounded-circle d-flex align-items-center justify-content-center"
                                                     style="width: 40px; height: 40px;">
                                                    <i class="fas fa-shield-alt text-white" style="font-size: 20px;"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-semibold">
                                                    <span 
                                                        class="badge me-1"
                                                        :class="getRoleBadgeClass(role.name)"
                                                    >
                                                        {{ role.name.replace('-', ' ').toUpperCase() }}
                                                    </span>
                                                </h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="border-0">
                                        <div class="d-flex flex-wrap gap-1">
                                            <span 
                                                v-for="permission in getGeneralPermissions(role.permissions).slice(0, 3)" 
                                                :key="permission.id"
                                                class="badge bg-light text-dark border"
                                            >
                                                {{ permission.name.replace('-', ' ').replace(/\b\w/g, l => l.toUpperCase()) }}
                                            </span>
                                            <span 
                                                v-if="getGeneralPermissions(role.permissions).length > 3"
                                                class="badge bg-secondary"
                                            >
                                                +{{ getGeneralPermissions(role.permissions).length - 3 }} more
                                            </span>
                                            <span 
                                                v-if="getGeneralPermissions(role.permissions).length === 0"
                                                class="text-muted small"
                                            >
                                                No general permissions
                                            </span>
                                        </div>
                                    </td>
                                    <td class="border-0">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-users me-2 text-muted"></i>
                                            <span class="badge bg-primary">
                                                {{ role.users_count || 0 }} users
                                            </span>
                                        </div>
                                    </td>
                                    <td class="border-0">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-calendar me-2 text-muted"></i>
                                            <span class="text-dark">
                                                {{ formatDate(role.created_at) }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="border-0">
                                        <div class="d-flex gap-2">
                                            <button
                                                @click="openEditModal(role)"
                                                class="btn btn-outline-primary btn-sm"
                                                title="Edit Role"
                                            >
                                                <i class="fas fa-edit me-1"></i>
                                                Edit
                                            </button>
                                            <button
                                                @click="openDeleteModal(role)"
                                                class="btn btn-outline-danger btn-sm"
                                                :disabled="role.name === 'super-admin'"
                                                :title="role.name === 'super-admin' ? 'Cannot delete super admin role' : 'Delete Role'"
                                            >
                                                <i class="fas fa-trash me-1"></i>
                                                Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr v-if="props.roles.length === 0">
                                    <td colspan="5" class="text-center py-5">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="fas fa-shield-alt text-muted mb-3" style="font-size: 48px;"></i>
                                            <h6 class="text-muted">No roles found</h6>
                                            <p class="text-muted mb-0">Click "Add Role" to create your first role.</p>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Create/Edit Role Modal -->
        <div 
            v-if="showModal" 
            class="modal fade show d-block" 
            tabindex="-1" 
            role="dialog"
            @click.self="closeModal"
        >
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            {{ editingRole ? 'Edit Role' : 'Add New Role' }}
                        </h5>
                        <button 
                            type="button" 
                            class="btn-close" 
                            @click="closeModal"
                        ></button>
                    </div>
                    <div class="modal-body">
                        <!-- General Error Alert -->
                        <div v-if="formErrors.general" class="alert alert-danger" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            {{ formErrors.general }}
                        </div>

                        <form @submit.prevent="submitForm">
                            <div class="mb-3">
                                <label for="roleName" class="form-label">
                                    Role Name <span class="text-danger">*</span>
                                </label>
                                <Input
                                    id="roleName"
                                    v-model="formData.name"
                                    type="text"
                                    class="form-control"
                                    :class="{ 'is-invalid': formErrors.name }"
                                    placeholder="Enter role name (e.g., manager, editor, viewer)"
                                    required
                                    maxlength="255"
                                />
                                <div v-if="formErrors.name" class="invalid-feedback d-block">
                                    <i class="fas fa-exclamation-circle me-1"></i>
                                    {{ formErrors.name }}
                                </div>
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Use descriptive names like "manager", "editor", or "viewer". Only letters, numbers, spaces, hyphens, and underscores are allowed.
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">
                                    Permissions 
                                    <span class="badge bg-primary ms-2">{{ formData.permissions.length }} selected</span>
                                </label>
                                <div class="row">
                                    <div 
                                        v-for="permission in getGeneralPermissions(props.permissions)" 
                                        :key="permission.id"
                                        class="col-md-6 col-lg-4 mb-2"
                                    >
                                        <div class="form-check">
                                            <input
                                                :id="`permission-${permission.id}`"
                                                :checked="formData.permissions.includes(permission.id)"
                                                @change="togglePermission(permission.id)"
                                                type="checkbox"
                                                class="form-check-input"
                                            />
                                            <label 
                                                :for="`permission-${permission.id}`"
                                                class="form-check-label"
                                            >
                                                {{ permission.name.replace('-', ' ').replace(/\b\w/g, l => l.toUpperCase()) }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div v-if="getGeneralPermissions(props.permissions).length === 0" class="text-muted">
                                    No general permissions available.
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button 
                            type="button" 
                            class="btn btn-secondary" 
                            @click="closeModal"
                        >
                            Cancel
                        </button>
                        <button 
                            type="button" 
                            class="btn btn-primary"
                            @click="submitForm"
                            :disabled="isSubmitting || !formData.name.trim()"
                        >
                            <span v-if="isSubmitting" class="spinner-border spinner-border-sm me-2" role="status"></span>
                            <i class="fas fa-save me-2" v-if="!isSubmitting"></i>
                            {{ isSubmitting ? 'Saving...' : (editingRole ? 'Update Role' : 'Create Role') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div 
            v-if="showDeleteModal" 
            class="modal fade show d-block" 
            tabindex="-1" 
            role="dialog"
            @click.self="closeDeleteModal"
        >
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-danger">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Delete Role
                        </h5>
                        <button 
                            type="button" 
                            class="btn-close" 
                            @click="closeDeleteModal"
                        ></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-warning">
                            <div class="d-flex align-items-start">
                                <i class="fas fa-exclamation-triangle me-2 mt-1"></i>
                                <div>
                                    <strong>Warning:</strong> This action cannot be undone.
                                    <p class="mb-0 mt-2">
                                        Are you sure you want to delete the role 
                                        <strong>"{{ deletingRole?.name }}"</strong>? 
                                        All users with this role will lose their permissions.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button 
                            type="button" 
                            class="btn btn-secondary" 
                            @click="closeDeleteModal"
                        >
                            Cancel
                        </button>
                        <button 
                            type="button" 
                            class="btn btn-danger"
                            @click="deleteRole"
                        >
                            <i class="fas fa-trash me-2"></i>
                            Delete Role
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Backdrop -->
        <div v-if="showModal || showDeleteModal" class="modal-backdrop fade show"></div>
    </StrikingDashLayout>
</template>

<style scoped>
.modal {
    z-index: 1055;
}

.modal-backdrop {
    z-index: 1050;
}

.table th {
    border-top: none;
    font-weight: 600;
    color: #495057;
}

.table td {
    vertical-align: middle;
}

.badge {
    font-size: 0.75rem;
    font-weight: 500;
}

.form-check-input:checked {
    background-color: #007bff;
    border-color: #007bff;
}

.btn-sm {
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
}

.modal-lg {
    max-width: 800px;
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

.modal-open {
    overflow: hidden;
}

.modal-dialog {
    max-width: 500px;
}

.modal-dialog.modal-lg {
    max-width: 800px;
}

.modal-dialog-centered {
    display: flex;
    align-items: center;
    min-height: calc(100% - 1rem);
}

@media (min-width: 576px) {
    .modal-dialog-centered {
        min-height: calc(100% - 3.5rem);
    }
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

/* Validation Styles */
.form-control.is-invalid {
    border-color: #dc3545;
    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
}

.invalid-feedback {
    display: block;
    width: 100%;
    margin-top: 0.25rem;
    font-size: 0.875rem;
    color: #dc3545;
}

.invalid-feedback span {
    width: 14px;
    height: 14px;
    vertical-align: middle;
}

.form-text {
    font-size: 0.875rem;
    color: #6c757d;
    margin-top: 0.25rem;
}

.form-text span {
    width: 14px;
    height: 14px;
    vertical-align: middle;
}

.alert-danger {
    background-color: #f8d7da;
    border-color: #f5c6cb;
    color: #721c24;
    border-radius: 0.375rem;
    padding: 0.75rem 1rem;
    margin-bottom: 1rem;
}

.alert-danger span {
    width: 16px;
    height: 16px;
    vertical-align: middle;
}

/* Button disabled state */
.btn:disabled {
    opacity: 0.65;
    cursor: not-allowed;
}
</style>
