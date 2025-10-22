<script setup lang="ts">
import ProfileController from '@/actions/App/Http/Controllers/Settings/ProfileController';
import { edit } from '@/routes/profile';
import { send } from '@/routes/verification';
import { Form, Head, Link, usePage } from '@inertiajs/vue3';

import DeleteUser from '@/components/DeleteUser.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import StrikingDashLayout from '@/layouts/StrikingDashLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';

interface Props {
    mustVerifyEmail: boolean;
    status?: string;
}

defineProps<Props>();

const page = usePage();
const user = page.props.auth.user;
</script>

<template>
    <Head title="Profile Settings" />

    <StrikingDashLayout>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-main">
                        <h4 class="text-capitalize breadcrumb-title">Profile Settings</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <!-- Profile Information Card -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <span data-feather="user" class="me-2"></span>
                                Profile Information
                            </h5>
                        </div>
                        <div class="card-body">
                            <Form
                                v-bind="ProfileController.update.form()"
                                class="space-y-6"
                                v-slot="{ errors, processing, recentlySuccessful }"
                            >
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">Full Name</label>
                                        <Input
                                            id="name"
                                            class="form-control"
                                            name="name"
                                            :default-value="user.name"
                                            required
                                            autocomplete="name"
                                            placeholder="Enter your full name"
                                        />
                                        <InputError class="mt-1 text-danger" :message="errors.name" />
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label">Email Address</label>
                                        <Input
                                            id="email"
                                            type="email"
                                            class="form-control"
                                            name="email"
                                            :default-value="user.email"
                                            required
                                            autocomplete="username"
                                            placeholder="Enter your email address"
                                        />
                                        <InputError class="mt-1 text-danger" :message="errors.email" />
                                    </div>
                                </div>

                                <!-- Email Verification Alert -->
                                <div v-if="mustVerifyEmail && !user.email_verified_at" class="alert alert-warning">
                                    <div class="d-flex align-items-start">
                                        <span data-feather="alert-triangle" class="me-2 mt-1"></span>
                                        <div>
                                            <strong>Email Verification Required</strong>
                                            <p class="mb-2">Your email address is unverified.</p>
                                            <Link
                                                :href="send()"
                                                as="button"
                                                class="btn btn-warning btn-sm"
                                            >
                                                Resend Verification Email
                                            </Link>
                                        </div>
                                    </div>

                                    <div
                                        v-if="status === 'verification-link-sent'"
                                        class="alert alert-success mt-3"
                                    >
                                        <span data-feather="check-circle" class="me-2"></span>
                                        A new verification link has been sent to your email address.
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                                    <Button
                                        type="submit"
                                        :disabled="processing"
                                        class="btn btn-primary"
                                        data-test="update-profile-button"
                                    >
                                        <span v-if="processing" class="spinner-border spinner-border-sm me-2" role="status"></span>
                                        <span data-feather="save" class="me-2"></span>
                                        {{ processing ? 'Saving...' : 'Save Changes' }}
                                    </Button>

                                    <Transition
                                        enter-active-class="transition ease-in-out"
                                        enter-from-class="opacity-0"
                                        leave-active-class="transition ease-in-out"
                                        leave-to-class="opacity-0"
                                    >
                                        <div
                                            v-show="recentlySuccessful"
                                            class="alert alert-success d-inline-flex align-items-center"
                                        >
                                            <span data-feather="check-circle" class="me-2"></span>
                                            Profile updated successfully!
                                        </div>
                                    </Transition>
                                </div>
                            </Form>
                        </div>
                    </div>

                    <!-- Settings Navigation -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <span data-feather="settings" class="me-2"></span>
                                Account Settings
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <Link 
                                        href="/settings/password" 
                                        class="btn btn-outline-primary w-100 d-flex align-items-center py-3"
                                    >
                                        <span data-feather="lock" class="me-2"></span>
                                        <div class="text-start">
                                            <div class="fw-semibold">Change Password</div>
                                            <small class="text-muted">Update your password</small>
                                        </div>
                                    </Link>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <Link 
                                        href="/settings/two-factor" 
                                        class="btn btn-outline-primary w-100 d-flex align-items-center py-3"
                                    >
                                        <span data-feather="shield" class="me-2"></span>
                                        <div class="text-start">
                                            <div class="fw-semibold">Two-Factor Auth</div>
                                            <small class="text-muted">Secure your account</small>
                                        </div>
                                    </Link>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <Link 
                                        href="/settings/appearance" 
                                        class="btn btn-outline-primary w-100 d-flex align-items-center py-3"
                                    >
                                        <span data-feather="palette" class="me-2"></span>
                                        <div class="text-start">
                                            <div class="fw-semibold">Appearance</div>
                                            <small class="text-muted">Customize your theme</small>
                                        </div>
                                    </Link>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <Link 
                                        href="/dashboard" 
                                        class="btn btn-outline-secondary w-100 d-flex align-items-center py-3"
                                    >
                                        <span data-feather="home" class="me-2"></span>
                                        <div class="text-start">
                                            <div class="fw-semibold">Back to Dashboard</div>
                                            <small class="text-muted">Return to main page</small>
                                        </div>
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </StrikingDashLayout>
</template>
