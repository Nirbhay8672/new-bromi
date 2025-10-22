<script setup lang="ts">
import ProfileController from '@/actions/App/Http/Controllers/Settings/ProfileController';
import { Form } from '@inertiajs/vue3';
import { ref, onMounted, nextTick } from 'vue';

// Components
import HeadingSmall from '@/components/HeadingSmall.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

const passwordInput = ref<InstanceType<typeof Input> | null>(null);

// Initialize Feather icons
onMounted(() => {
    nextTick(() => {
        if (typeof feather !== 'undefined') {
            feather.replace();
        }
    });
});
</script>

<style scoped>
.delete-account-section {
    background: #fff;
    border-radius: 12px;
    padding: 2rem;
    border: 1px solid #e9ecef;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.delete-account-header {
    border-bottom: 1px solid #e9ecef;
    padding-bottom: 1.5rem;
    margin-bottom: 1.5rem;
}

.delete-icon {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 12px rgba(220, 53, 69, 0.2);
}

.delete-icon span {
    width: 24px;
    height: 24px;
    color: white;
}

.alert-danger {
    background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
    border-left: 4px solid #dc3545;
    border-radius: 8px;
}

.alert-danger .alert-heading {
    color: #721c24;
    font-weight: 600;
}

.alert-danger ul {
    color: #721c24;
}

.alert-danger ul li {
    margin-bottom: 0.25rem;
}

.delete-account-actions {
    text-align: center;
    padding-top: 1rem;
}

.btn-danger {
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
    border: none;
    border-radius: 8px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
}

.btn-danger:hover {
    background: linear-gradient(135deg, #c82333 0%, #a71e2a 100%);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(220, 53, 69, 0.4);
}

.btn-danger:active {
    transform: translateY(0);
    box-shadow: 0 2px 8px rgba(220, 53, 69, 0.3);
}

/* Modal Styles */
.delete-confirmation-modal {
    max-width: 500px;
    border-radius: 12px;
    border: none;
    box-shadow: 0 20px 40px rgba(0,0,0,0.15);
}

.delete-modal-icon {
    width: 64px;
    height: 64px;
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    box-shadow: 0 8px 24px rgba(220, 53, 69, 0.3);
}

.delete-modal-icon span {
    width: 32px;
    height: 32px;
    color: white;
}

.confirmation-form {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 1.5rem;
    margin: 1rem 0;
}

.form-control-lg {
    border-radius: 8px;
    border: 2px solid #e9ecef;
    padding: 0.75rem 1rem;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.form-control-lg:focus {
    border-color: #dc3545;
    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
}

.alert-warning {
    background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
    border-left: 4px solid #ffc107;
    border-radius: 6px;
}

.btn-outline-secondary {
    border: 2px solid #6c757d;
    color: #6c757d;
    font-weight: 600;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.btn-outline-secondary:hover {
    background: #6c757d;
    border-color: #6c757d;
    color: white;
    transform: translateY(-1px);
}

/* Responsive Design */
@media (max-width: 768px) {
    .delete-account-section {
        padding: 1.5rem;
        margin: 1rem;
    }
    
    .delete-account-header {
        text-align: center;
    }
    
    .delete-icon {
        margin: 0 auto 1rem auto;
    }
}
</style>

<template>
    <div class="delete-account-section">
        <!-- Header Section -->
        <div class="delete-account-header">
            <div class="d-flex align-items-center mb-3">
                <div class="delete-icon me-3">
                    <span data-feather="trash-2"></span>
                </div>
                <div>
                    <h5 class="mb-1 text-danger fw-bold">Delete Account</h5>
                    <p class="text-muted mb-0">Permanently delete your account and all of its data</p>
                </div>
            </div>
        </div>

        <!-- Warning Section -->
        <div class="alert alert-danger border-0 mb-4">
            <div class="d-flex align-items-start">
                <span data-feather="alert-triangle" class="me-3 mt-1 flex-shrink-0"></span>
                <div>
                    <h6 class="alert-heading mb-2">Warning: This action cannot be undone</h6>
                    <p class="mb-2">
                        Once you delete your account, all of your data, settings, and information will be permanently removed. 
                        This includes:
                    </p>
                    <ul class="mb-0 ps-3">
                        <li>Your profile information and settings</li>
                        <li>All your personal data and preferences</li>
                        <li>Account history and activity logs</li>
                        <li>Any associated files or content</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Action Section -->
        <div class="delete-account-actions">
            <Dialog>
                <DialogTrigger as-child>
                    <button 
                        class="btn btn-danger btn-lg px-4 py-3"
                        data-test="delete-user-button"
                    >
                        <span data-feather="trash-2" class="me-2"></span>
                        Delete My Account
                    </button>
                </DialogTrigger>
                <DialogContent class="delete-confirmation-modal">
                    <Form
                        v-bind="ProfileController.destroy.form()"
                        reset-on-success
                        @error="() => passwordInput?.$el?.focus()"
                        :options="{
                            preserveScroll: true,
                        }"
                        class="space-y-6"
                        v-slot="{ errors, processing, reset, clearErrors }"
                    >
                        <DialogHeader class="text-center mb-4">
                            <div class="delete-modal-icon mb-3">
                                <span data-feather="alert-triangle"></span>
                            </div>
                            <DialogTitle class="h4 text-danger mb-3">
                                Are you absolutely sure?
                            </DialogTitle>
                            <DialogDescription class="text-muted">
                                This action cannot be undone. This will permanently delete your account 
                                and remove all data from our servers.
                            </DialogDescription>
                        </DialogHeader>

                        <div class="confirmation-form">
                            <div class="mb-4">
                                <Label for="password" class="form-label fw-semibold">
                                    <span data-feather="lock" class="me-2"></span>
                                    Enter your password to confirm
                                </Label>
                                <Input
                                    id="password"
                                    type="password"
                                    name="password"
                                    ref="passwordInput"
                                    class="form-control form-control-lg"
                                    placeholder="Enter your current password"
                                    required
                                />
                                <InputError :message="errors.password" class="mt-2" />
                            </div>

                            <div class="alert alert-warning border-0">
                                <div class="d-flex align-items-center">
                                    <span data-feather="info" class="me-2"></span>
                                    <small>
                                        <strong>Final confirmation:</strong> Type "DELETE" in the box below to confirm you understand this action is irreversible.
                                    </small>
                                </div>
                            </div>

                            <div class="mb-4">
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    placeholder="Type DELETE to confirm"
                                    required
                                    pattern="DELETE"
                                    title="Please type DELETE to confirm"
                                />
                            </div>
                        </div>

                        <DialogFooter class="gap-3 justify-content-center">
                            <DialogClose as-child>
                                <button
                                    type="button"
                                    class="btn btn-outline-secondary btn-lg px-4"
                                    @click="
                                        () => {
                                            clearErrors();
                                            reset();
                                        }
                                    "
                                >
                                    <span data-feather="x" class="me-2"></span>
                                    Cancel
                                </button>
                            </DialogClose>

                            <button
                                type="submit"
                                class="btn btn-danger btn-lg px-4"
                                :disabled="processing"
                                data-test="confirm-delete-user-button"
                            >
                                <span v-if="processing" class="spinner-border spinner-border-sm me-2" role="status"></span>
                                <span data-feather="trash-2" class="me-2"></span>
                                {{ processing ? 'Deleting...' : 'Yes, Delete My Account' }}
                            </button>
                        </DialogFooter>
                    </Form>
                </DialogContent>
            </Dialog>
        </div>
    </div>
</template>
