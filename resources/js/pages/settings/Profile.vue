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
                        <div class="breadcrumb-action justify-content-center flex-wrap">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <Link href="/dashboard" class="text-primary">
                                            <span data-feather="home"></span> Dashboard
                                        </Link>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">Profile Settings</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0">
                                <span data-feather="settings" class="me-2"></span>
                                Settings Menu
                            </h6>
                        </div>
                        <div class="card-body p-0">
                            <div class="settings-menu">
                                <ul class="nav nav-pills flex-column" role="tablist">
                                    <li class="nav-item">
                                        <Link 
                                            href="/settings/profile" 
                                            class="nav-link d-flex align-items-center py-3 px-4"
                                            :class="{ 'active': $page.url === '/settings/profile' }"
                                        >
                                            <span data-feather="user" class="nav-icon me-3"></span>
                                            <div>
                                                <div class="fw-semibold">Profile Information</div>
                                                <small class="text-muted">Update your personal details</small>
                                            </div>
                                        </Link>
                                    </li>
                                    <li class="nav-item">
                                        <Link 
                                            href="/settings/password" 
                                            class="nav-link d-flex align-items-center py-3 px-4"
                                            :class="{ 'active': $page.url === '/settings/password' }"
                                        >
                                            <span data-feather="lock" class="nav-icon me-3"></span>
                                            <div>
                                                <div class="fw-semibold">Password</div>
                                                <small class="text-muted">Change your password</small>
                                            </div>
                                        </Link>
                                    </li>
                                    <li class="nav-item">
                                        <Link 
                                            href="/settings/two-factor" 
                                            class="nav-link d-flex align-items-center py-3 px-4"
                                            :class="{ 'active': $page.url === '/settings/two-factor' }"
                                        >
                                            <span data-feather="shield" class="nav-icon me-3"></span>
                                            <div>
                                                <div class="fw-semibold">Two-Factor Auth</div>
                                                <small class="text-muted">Secure your account</small>
                                            </div>
                                        </Link>
                                    </li>
                                    <li class="nav-item">
                                        <Link 
                                            href="/settings/appearance" 
                                            class="nav-link d-flex align-items-center py-3 px-4"
                                            :class="{ 'active': $page.url === '/settings/appearance' }"
                                        >
                                            <span data-feather="palette" class="nav-icon me-3"></span>
                                            <div>
                                                <div class="fw-semibold">Appearance</div>
                                                <small class="text-muted">Customize your theme</small>
                                            </div>
                                        </Link>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-9">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-light">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm me-3">
                                    <div class="avatar-title bg-primary rounded-circle">
                                        <span data-feather="user" class="text-white"></span>
                                    </div>
                                </div>
                                <div>
                                    <h6 class="mb-1">Profile Information</h6>
                                    <p class="text-muted mb-0">Update your name and email address</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <Form
                                v-bind="ProfileController.update.form()"
                                class="space-y-6"
                                v-slot="{ errors, processing, recentlySuccessful }"
                            >
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-4">
                                            <Label for="name" class="form-label fw-semibold">
                                                <span data-feather="user" class="me-2"></span>
                                                Full Name
                                            </Label>
                                            <Input
                                                id="name"
                                                class="form-control form-control-lg"
                                                name="name"
                                                :default-value="user.name"
                                                required
                                                autocomplete="name"
                                                placeholder="Enter your full name"
                                            />
                                            <InputError class="mt-2 text-danger" :message="errors.name" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-4">
                                            <Label for="email" class="form-label fw-semibold">
                                                <span data-feather="mail" class="me-2"></span>
                                                Email Address
                                            </Label>
                                            <Input
                                                id="email"
                                                type="email"
                                                class="form-control form-control-lg"
                                                name="email"
                                                :default-value="user.email"
                                                required
                                                autocomplete="username"
                                                placeholder="Enter your email address"
                                            />
                                            <InputError class="mt-2 text-danger" :message="errors.email" />
                                        </div>
                                    </div>
                                </div>

                                <div v-if="mustVerifyEmail && !user.email_verified_at" class="alert alert-warning">
                                    <div class="d-flex align-items-center">
                                        <span data-feather="alert-triangle" class="me-2"></span>
                                        <div>
                                            <strong>Email Verification Required</strong>
                                            <p class="mb-0">Your email address is unverified.
                                                <Link
                                                    :href="send()"
                                                    as="button"
                                                    class="btn btn-link p-0 text-decoration-underline"
                                                >
                                                    Click here to resend the verification email.
                                                </Link>
                                            </p>
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

                                <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                                    <div>
                                        <Button
                                            type="submit"
                                            :disabled="processing"
                                            class="btn btn-primary btn-lg px-4"
                                            data-test="update-profile-button"
                                        >
                                            <span v-if="processing" class="spinner-border spinner-border-sm me-2" role="status"></span>
                                            <span data-feather="save" class="me-2"></span>
                                            {{ processing ? 'Saving...' : 'Save Changes' }}
                                        </Button>
                                    </div>

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

                    <!-- Delete Account Section -->
                    <div class="card border-0 mt-4 shadow-sm">
                        <div class="card-header bg-danger text-white">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm me-3">
                                    <div class="avatar-title bg-white rounded-circle">
                                        <span data-feather="trash-2" class="text-danger"></span>
                                    </div>
                                </div>
                                <div>
                                    <h6 class="mb-1">Delete Account</h6>
                                    <p class="mb-0 opacity-75">Permanently delete your account and all of its data</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <DeleteUser />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </StrikingDashLayout>
</template>
