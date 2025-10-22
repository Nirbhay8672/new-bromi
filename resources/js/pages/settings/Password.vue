<script setup lang="ts">
import PasswordController from '@/actions/App/Http/Controllers/Settings/PasswordController';
import InputError from '@/components/InputError.vue';
import StrikingDashLayout from '@/layouts/StrikingDashLayout.vue';
import { edit } from '@/routes/password';
import { Form, Head } from '@inertiajs/vue3';
import { ref } from 'vue';

import HeadingSmall from '@/components/HeadingSmall.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { type BreadcrumbItem } from '@/types';

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Password settings',
        href: edit().url,
    },
];

const passwordInput = ref<HTMLInputElement | null>(null);
const currentPasswordInput = ref<HTMLInputElement | null>(null);
</script>

<template>
    <Head title="Password Settings" />

    <StrikingDashLayout>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-main">
                        <h4 class="text-capitalize breadcrumb-title">Password Settings</h4>
                        <div class="breadcrumb-action justify-content-center flex-wrap">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <Link href="/dashboard" class="text-primary">
                                            <span data-feather="home"></span> Dashboard
                                        </Link>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <Link href="/settings/profile" class="text-primary">Settings</Link>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">Password</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-3">
                    <div class="card border-0">
                        <div class="card-header">
                            <h6>Settings Menu</h6>
                        </div>
                        <div class="card-body p-0">
                            <div class="settings-menu">
                                <ul class="nav nav-tabs flex-column" role="tablist">
                                    <li class="nav-item">
                                        <Link 
                                            href="/settings/profile" 
                                            class="nav-link"
                                            :class="{ 'active': $page.url === '/settings/profile' }"
                                        >
                                            <span data-feather="user" class="nav-icon"></span>
                                            Profile Information
                                        </Link>
                                    </li>
                                    <li class="nav-item">
                                        <Link 
                                            href="/settings/password" 
                                            class="nav-link active"
                                            :class="{ 'active': $page.url === '/settings/password' }"
                                        >
                                            <span data-feather="lock" class="nav-icon"></span>
                                            Password
                                        </Link>
                                    </li>
                                    <li class="nav-item">
                                        <Link 
                                            href="/settings/two-factor" 
                                            class="nav-link"
                                            :class="{ 'active': $page.url === '/settings/two-factor' }"
                                        >
                                            <span data-feather="shield" class="nav-icon"></span>
                                            Two-Factor Authentication
                                        </Link>
                                    </li>
                                    <li class="nav-item">
                                        <Link 
                                            href="/settings/appearance" 
                                            class="nav-link"
                                            :class="{ 'active': $page.url === '/settings/appearance' }"
                                        >
                                            <span data-feather="palette" class="nav-icon"></span>
                                            Appearance
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
                                        <span data-feather="lock" class="text-white"></span>
                                    </div>
                                </div>
                                <div>
                                    <h6 class="mb-1">Update Password</h6>
                                    <p class="text-muted mb-0">Ensure your account is using a long, random password to stay secure</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <Form
                                v-bind="PasswordController.update.form()"
                                :options="{
                                    preserveScroll: true,
                                }"
                                reset-on-success
                                :reset-on-error="[
                                    'password',
                                    'password_confirmation',
                                    'current_password',
                                ]"
                                class="space-y-6"
                                v-slot="{ errors, processing, recentlySuccessful }"
                            >
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group mb-4">
                                            <Label for="current_password" class="form-label fw-semibold">
                                                <span data-feather="key" class="me-2"></span>
                                                Current Password
                                            </Label>
                                            <Input
                                                id="current_password"
                                                ref="currentPasswordInput"
                                                name="current_password"
                                                type="password"
                                                class="form-control form-control-lg"
                                                autocomplete="current-password"
                                                placeholder="Enter your current password"
                                            />
                                            <InputError class="mt-2 text-danger" :message="errors.current_password" />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-4">
                                            <Label for="password" class="form-label fw-semibold">
                                                <span data-feather="lock" class="me-2"></span>
                                                New Password
                                            </Label>
                                            <Input
                                                id="password"
                                                ref="passwordInput"
                                                name="password"
                                                type="password"
                                                class="form-control form-control-lg"
                                                autocomplete="new-password"
                                                placeholder="Enter new password"
                                            />
                                            <InputError class="mt-2 text-danger" :message="errors.password" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-4">
                                            <Label for="password_confirmation" class="form-label fw-semibold">
                                                <span data-feather="check-circle" class="me-2"></span>
                                                Confirm New Password
                                            </Label>
                                            <Input
                                                id="password_confirmation"
                                                name="password_confirmation"
                                                type="password"
                                                class="form-control form-control-lg"
                                                autocomplete="new-password"
                                                placeholder="Confirm new password"
                                            />
                                            <InputError class="mt-2 text-danger" :message="errors.password_confirmation" />
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                                    <div>
                                        <Button
                                            type="submit"
                                            :disabled="processing"
                                            class="btn btn-primary btn-lg px-4"
                                            data-test="update-password-button"
                                        >
                                            <span v-if="processing" class="spinner-border spinner-border-sm me-2" role="status"></span>
                                            <span data-feather="save" class="me-2"></span>
                                            {{ processing ? 'Updating...' : 'Update Password' }}
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
                                            Password updated successfully!
                                        </div>
                                    </Transition>
                                </div>
                            </Form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </StrikingDashLayout>
</template>
