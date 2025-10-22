<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import StrikingDashLayout from '@/layouts/StrikingDashLayout.vue';
import { store } from '@/routes/password/confirm';
import { Form, Head } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';
</script>

<template>
    <Head title="Confirm password" />

    <StrikingDashLayout>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-main">
                        <h4 class="text-capitalize breadcrumb-title">Confirm Password</h4>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <!-- Password Confirmation Card -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <span data-feather="lock" class="me-2"></span>
                                Confirm Your Password
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info">
                                <div class="d-flex align-items-start">
                                    <span data-feather="info" class="me-2 mt-1"></span>
                                    <div>
                                        <strong>Secure Area</strong>
                                        <p class="mb-0">This is a secure area of the application. Please confirm your password before continuing.</p>
                                    </div>
                                </div>
                            </div>

                            <Form
                                v-bind="store.form()"
                                reset-on-success
                                v-slot="{ errors, processing }"
                            >
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <Input
                                        id="password"
                                        type="password"
                                        name="password"
                                        class="form-control"
                                        required
                                        autocomplete="current-password"
                                        autofocus
                                        placeholder="Enter your current password"
                                    />
                                    <InputError class="mt-1 text-danger" :message="errors.password" />
                                </div>

                                <div class="d-grid">
                                    <Button
                                        type="submit"
                                        class="btn btn-primary"
                                        :disabled="processing"
                                        data-test="confirm-password-button"
                                    >
                                        <LoaderCircle
                                            v-if="processing"
                                            class="h-4 w-4 animate-spin me-2"
                                        />
                                        <span data-feather="check" class="me-2"></span>
                                        Confirm Password
                                    </Button>
                                </div>
                            </Form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </StrikingDashLayout>
</template>
