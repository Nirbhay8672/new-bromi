<script setup lang="ts">
import { ref, onMounted, nextTick } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import StrikingDashLayout from '@/layouts/StrikingDashLayout.vue';

interface Permission {
    id: number;
    name: string;
    guard_name: string;
    created_at: string;
    updated_at: string;
    roles_count?: number;
}

const props = defineProps<{
    permissions: Permission[];
}>();

const showModal = ref(false);
const showDeleteModal = ref(false);
const editingPermission = ref<Permission | null>(null);
const deletingPermission = ref<Permission | null>(null);
const formData = ref({
    name: '',
    guard_name: 'web'
});

const formErrors = ref<Record<string, string>>({});
const isSubmitting = ref(false);

// Initialize Feather icons
onMounted(() => {
    nextTick(() => {
        if (typeof feather !== 'undefined') {
            feather.replace();
        }
    });
});

const openCreateModal = () => {
    editingPermission.value = null;
    formData.value = {
        name: '',
        guard_name: 'web'
    };
    formErrors.value = {};
    showModal.value = true;
};

const openEditModal = (permission: Permission) => {
    editingPermission.value = permission;
    formData.value = {
        name: permission.name,
        guard_name: permission.guard_name
    };
    formErrors.value = {};
    showModal.value = true;
};

const openDeleteModal = (permission: Permission) => {
    deletingPermission.value = permission;
    showDeleteModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
    editingPermission.value = null;
    formData.value = {
        name: '',
        guard_name: 'web'
    };
    formErrors.value = {};
};

const closeDeleteModal = () => {
    showDeleteModal.value = false;
    deletingPermission.value = null;
};

const submitForm = async () => {
    isSubmitting.value = true;
    formErrors.value = {};

    try {
        const url = editingPermission.value 
            ? `/admin/permissions/${editingPermission.value.id}`
            : '/admin/permissions';
        
        const method = editingPermission.value ? 'put' : 'post';

        await router[method](url, formData.value, {
            onSuccess: () => {
                closeModal();
                router.reload();
            },
            onError: (errors) => {
                formErrors.value = errors;
            }
        });
    } catch (error) {
        console.error('Error submitting form:', error);
    } finally {
        isSubmitting.value = false;
    }
};

const deletePermission = async () => {
    if (!deletingPermission.value) return;

    try {
        await router.delete(`/admin/permissions/${deletingPermission.value.id}`, {
            onSuccess: () => {
                closeDeleteModal();
                router.reload();
            }
        });
    } catch (error) {
        console.error('Error deleting permission:', error);
    }
};

const getPermissionBadgeClass = (permissionName: string) => {
    if (permissionName.includes('create')) return 'bg-success';
    if (permissionName.includes('read')) return 'bg-info';
    if (permissionName.includes('update')) return 'bg-warning text-dark';
    if (permissionName.includes('delete')) return 'bg-danger';
    if (permissionName.includes('manage')) return 'bg-primary';
    return 'bg-secondary';
};

const formatDate = (dateString: string) => {
    return new Date(dateString).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    });
};

const groupPermissions = (permissions: Permission[]) => {
    const groups: Record<string, Permission[]> = {};
    
    permissions.forEach(permission => {
        const parts = permission.name.split(' ');
        const group = parts.length > 1 ? parts[0] : 'General';
        
        if (!groups[group]) {
            groups[group] = [];
        }
        groups[group].push(permission);
    });
    
    return groups;
};
</script>

<template>
    <Head title="Permissions Management" />

    <StrikingDashLayout>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-main">
                        <h4 class="text-capitalize breadcrumb-title">Permissions Management</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <!-- Permissions Card -->
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center justify-content-between">
                                <h5 class="mb-0">
                                    <span data-feather="key" class="me-2"></span>
                                    System Permissions
                                </h5>
                                <button 
                                    @click="openCreateModal"
                                    class="btn btn-primary"
                                >
                                    <span data-feather="plus" class="me-2"></span>
                                    Add Permission
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div v-if="props.permissions.length === 0" class="text-center py-5">
                                <span data-feather="key" class="text-muted mb-3" style="width: 48px; height: 48px;"></span>
                                <h6 class="text-muted">No permissions found</h6>
                                <p class="text-muted mb-0">Click "Add Permission" to create your first permission.</p>
                            </div>

                            <div v-else>
                                <div 
                                    v-for="(groupPermissions, groupName) in groupPermissions(props.permissions)" 
                                    :key="groupName"
                                    class="mb-4"
                                >
                                    <h6 class="text-muted mb-3 text-uppercase">
                                        <span data-feather="folder" class="me-2"></span>
                                        {{ groupName }} Permissions
                                    </h6>
                                    
                                    <div class="row">
                                        <div 
                                            v-for="permission in groupPermissions" 
                                            :key="permission.id"
                                            class="col-md-6 col-lg-4 mb-3"
                                        >
                                            <div class="card border-0 shadow-sm h-100">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                                        <span 
                                                            class="badge"
                                                            :class="getPermissionBadgeClass(permission.name)"
                                                        >
                                                            {{ permission.name.split(' ')[0] }}
                                                        </span>
                                                        <div class="dropdown">
                                                            <button 
                                                                class="btn btn-sm btn-outline-secondary dropdown-toggle" 
                                                                type="button" 
                                                                data-bs-toggle="dropdown"
                                                            >
                                                                <span data-feather="more-vertical"></span>
                                                            </button>
                                                            <ul class="dropdown-menu">
                                                                <li>
                                                                    <button 
                                                                        @click="openEditModal(permission)"
                                                                        class="dropdown-item"
                                                                    >
                                                                        <span data-feather="edit" class="me-2"></span>
                                                                        Edit
                                                                    </button>
                                                                </li>
                                                                <li>
                                                                    <button 
                                                                        @click="openDeleteModal(permission)"
                                                                        class="dropdown-item text-danger"
                                                                    >
                                                                        <span data-feather="trash-2" class="me-2"></span>
                                                                        Delete
                                                                    </button>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    
                                                    <h6 class="card-title mb-2">{{ permission.name }}</h6>
                                                    
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <small class="text-muted">
                                                            {{ permission.roles_count || 0 }} roles
                                                        </small>
                                                        <small class="text-muted">
                                                            {{ formatDate(permission.created_at) }}
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Create/Edit Permission Modal -->
        <div 
            v-if="showModal" 
            class="modal fade show d-block" 
            tabindex="-1" 
            role="dialog"
            @click.self="closeModal"
        >
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <span data-feather="key" class="me-2"></span>
                            {{ editingPermission ? 'Edit Permission' : 'Create New Permission' }}
                        </h5>
                        <button 
                            type="button" 
                            class="btn-close" 
                            @click="closeModal"
                        ></button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="submitForm">
                            <div class="mb-3">
                                <label for="permissionName" class="form-label">Permission Name</label>
                                <input
                                    id="permissionName"
                                    v-model="formData.name"
                                    type="text"
                                    class="form-control"
                                    :class="{ 'is-invalid': formErrors.name }"
                                    placeholder="e.g., create users, manage roles"
                                    required
                                />
                                <div v-if="formErrors.name" class="invalid-feedback">
                                    {{ formErrors.name }}
                                </div>
                                <div class="form-text">
                                    Use descriptive names like "create users", "manage roles", etc.
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="guardName" class="form-label">Guard Name</label>
                                <select
                                    id="guardName"
                                    v-model="formData.guard_name"
                                    class="form-select"
                                    :class="{ 'is-invalid': formErrors.guard_name }"
                                >
                                    <option value="web">Web</option>
                                    <option value="api">API</option>
                                </select>
                                <div v-if="formErrors.guard_name" class="invalid-feedback">
                                    {{ formErrors.guard_name }}
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
                            :disabled="isSubmitting"
                        >
                            <span v-if="isSubmitting" class="spinner-border spinner-border-sm me-2" role="status"></span>
                            <span data-feather="save" class="me-2"></span>
                            {{ isSubmitting ? 'Saving...' : (editingPermission ? 'Update Permission' : 'Create Permission') }}
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
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-danger">
                            <span data-feather="alert-triangle" class="me-2"></span>
                            Delete Permission
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
                                <span data-feather="alert-triangle" class="me-2 mt-1"></span>
                                <div>
                                    <strong>Warning:</strong> This action cannot be undone.
                                    <p class="mb-0 mt-2">
                                        Are you sure you want to delete the permission 
                                        <strong>"{{ deletingPermission?.name }}"</strong>? 
                                        This will remove the permission from all roles.
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
                            @click="deletePermission"
                        >
                            <span data-feather="trash-2" class="me-2"></span>
                            Delete Permission
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

.card {
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1) !important;
}

.badge {
    font-size: 0.75rem;
    font-weight: 500;
}

.dropdown-toggle::after {
    display: none;
}

.btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
}
</style>
