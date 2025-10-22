<script setup lang="ts">
import AuthenticatedSessionController from '@/actions/App/Http/Controllers/Auth/AuthenticatedSessionController';
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { register } from '@/routes';
import { request } from '@/routes/password';
import { Form, Head, Link } from '@inertiajs/vue3';
import { LoaderCircle, Crown, Shield } from 'lucide-vue-next';
import { ref, onMounted, nextTick } from 'vue'; 

defineProps<{
    status?: string;
    canResetPassword: boolean;
}>();

const email = ref('');
const password = ref('');

// Initialize Feather icons
onMounted(() => {
    nextTick(() => {
        // Wait for feather to be available
        const initFeather = () => {
            if (typeof feather !== 'undefined') {
                feather.replace();
                console.log('Feather icons initialized on login page');
            } else {
                // Retry after a short delay if feather is not yet loaded
                setTimeout(initFeather, 100);
            }
        };
        initFeather();
    });
});

// Also try to initialize when the window loads
if (typeof window !== 'undefined') {
    window.addEventListener('load', () => {
        if (typeof feather !== 'undefined') {
            feather.replace();
            console.log('Feather icons initialized on window load');
        }
    });
}

const loginAsSuperAdmin = () => {
    email.value = 'superadmin@gmail.com';
    password.value = 'password';
    // Trigger form submission after a brief delay to ensure fields are updated
    setTimeout(() => {
        const form = document.querySelector('form');
        if (form) {
            form.requestSubmit();
        }
    }, 100);
};

const loginAsAdmin = () => {
    email.value = 'admin@gmail.com';
    password.value = 'password';
    // Trigger form submission after a brief delay to ensure fields are updated
    setTimeout(() => {
        const form = document.querySelector('form');
        if (form) {
            form.requestSubmit();
        }
    }, 100);
};
</script>

<template>
    <Head title="Log in" />

    <div class="signUP-admin">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <!-- Left Side - Branding -->
                <div class="col-xl-4 col-lg-5 col-md-5 p-0">
                    <div class="signUP-admin-left signIn-admin-left position-relative">
                        <div class="signUP-admin-left__content">
                            <div class="text-capitalize mb-md-30 mb-15 d-flex align-items-center justify-content-md-start justify-content-center">
                                <img src="/logo4.png" alt="logo" class="img-fluid" style="max-width: 400px;" />
                            </div>
                        </div>
                        <div class="signUP-admin-left__img">
                            <img class="img-fluid svg" src="/img/svg/signupIllustration.svg" alt="img" />
                        </div>
                    </div>
                </div>

                <!-- Right Side - Login Form -->
                <div class="col-xl-8 col-lg-7 col-md-7 col-sm-8">
                    <div class="signUp-admin-right signIn-admin-right p-md-40 p-10">
                        
                        <div class="row justify-content-center">
                            <div class="col-xl-7 col-lg-8 col-md-12">
                                <div class="edit-profile mt-md-25 mt-0">
                                    <div class="card border-0">
                                        <div class="card-header border-0 pb-md-15 pb-10 pt-md-20 pt-10">
                                            <div class="edit-profile__title">
                                                <h6>Sign in to <span class="color-primary">Admin</span></h6>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="edit-profile__body">
                                                <!-- Status Message -->
                                                <div
                                                    v-if="status"
                                                    class="alert alert-success mb-3"
                                                >
                                                    {{ status }}
                                                </div>

                                                <Form
                                                    v-bind="AuthenticatedSessionController.store.form()"
                                                    :reset-on-success="['password']"
                                                    v-slot="{ errors, processing }"
                                                >
                                                    <div class="form-group mb-20">
                                                        <label for="email">Username or Email Address</label>
                                                        <Input
                                                            id="email"
                                                            v-model="email"
                                                            type="email"
                                                            name="email"
                                                            class="form-control"
                                                            required
                                                            autofocus
                                                            autocomplete="email"
                                                            placeholder="Username or Email"
                                                        />
                                                        <InputError class="mt-1 text-danger" :message="errors.email" />
                                                    </div>

                                                    <div class="form-group mb-15">
                                                        <label for="password">Password</label>
                                                        <div class="position-relative">
                                                            <Input
                                                                id="password"
                                                                v-model="password"
                                                                type="password"
                                                                name="password"
                                                                class="form-control"
                                                                required
                                                                autocomplete="current-password"
                                                                placeholder="Password"
                                                            />
                                                            <div class="fa fa-fw fa-eye-slash text-light fs-16 field-icon toggle-password2"></div>
                                                        </div>
                                                        <InputError class="mt-1 text-danger" :message="errors.password" />
                                                    </div>

                                                    <div class="signUp-condition signIn-condition">
                                                        <div class="checkbox-theme-default custom-checkbox">
                                                            <input class="checkbox" type="checkbox" id="remember" name="remember">
                                                            <label for="remember">
                                                                <span class="checkbox-text">Keep me logged in</span>
                                                            </label>
                                                        </div>
                                                        <TextLink
                                                            v-if="canResetPassword"
                                                            :href="request()"
                                                            class="color-primary"
                                                        >
                                                            Forget password
                                                        </TextLink>
                                                    </div>

                                                    <div class="button-group d-flex pt-1 justify-content-md-start justify-content-center">
                                                        <Button
                                                            type="submit"
                                                            class="btn btn-primary btn-default btn-squared me-15 text-capitalize lh-normal px-50 py-15 signIn-createBtn"
                                                            :disabled="processing"
                                                            data-test="login-button"
                                                        >
                                                            <LoaderCircle
                                                                v-if="processing"
                                                                class="h-4 w-4 animate-spin me-2"
                                                            />
                                                            Sign in
                                                        </Button>
                                                    </div>

                                                    <p class="social-connector text-center mb-sm-25 mb-15 mt-sm-30 mt-20">
                                                        <span>Or</span>
                                                    </p>

                                                    <div class="button-group d-flex align-items-center justify-content-md-start justify-content-center">
                                                        <ul class="signUp-socialBtn">
                                                            <li>
                                                                <button
                                                                    type="button"
                                                                    class="btn text-dark px-30"
                                                                    @click="loginAsSuperAdmin"
                                                                >
                                                                    <Crown class="me-2" />
                                                                    Login as Super Admin
                                                                </button>
                                                            </li>
                                                            <li>
                                                                <button
                                                                    type="button"
                                                                    class="btn text-dark px-30"
                                                                    @click="loginAsAdmin"
                                                                >
                                                                    <Shield class="me-2" />
                                                                    Login as Admin
                                                                </button>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </Form>
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
</template>
