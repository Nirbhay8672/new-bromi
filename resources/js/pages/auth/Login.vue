<script setup lang="ts">
import AuthenticatedSessionController from '@/actions/App/Http/Controllers/Auth/AuthenticatedSessionController';
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import StrikingDashAuthLayout from '@/layouts/auth/StrikingDashAuthLayout.vue';
import { register } from '@/routes';
import { request } from '@/routes/password';
import { Form, Head } from '@inertiajs/vue3';
import { LoaderCircle, Crown, Shield } from 'lucide-vue-next';
import { ref } from 'vue';

defineProps<{
    status?: string;
    canResetPassword: boolean;
}>();

const email = ref('');
const password = ref('');
const isSubmitting = ref(false);

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
    <AuthBase
        title="Log in to your account"
        description="Enter your email and password below to log in"
    >
        <Head title="Log in" />

        <div
            v-if="status"
            class="mb-4 text-center text-sm font-medium text-green-600"
        >
            {{ status }}
        </div>

        <Form
            v-bind="AuthenticatedSessionController.store.form()"
            :reset-on-success="['password']"
            v-slot="{ errors, processing }"
            class="flex flex-col gap-6"
        >
            <div class="grid gap-6">
                <div class="grid gap-2">
                    <Label for="email">Email address</Label>
                    <Input
                        id="email"
                        v-model="email"
                        type="email"
                        name="email"
                        required
                        autofocus
                        :tabindex="1"
                        autocomplete="email"
                        placeholder="email@example.com"
                    />
                    <InputError :message="errors.email" />
                </div>

                <div class="grid gap-2">
                    <div class="flex items-center justify-between">
                        <Label for="password">Password</Label>
                        <TextLink
                            v-if="canResetPassword"
                            :href="request()"
                            class="text-sm"
                            :tabindex="5"
                        >
                            Forgot password?
                        </TextLink>
                    </div>
                    <Input
                        id="password"
                        v-model="password"
                        type="password"
                        name="password"
                        required
                        :tabindex="2"
                        autocomplete="current-password"
                        placeholder="Password"
                    />
                    <InputError :message="errors.password" />
                </div>

                <div class="flex items-center justify-between">
                    <Label for="remember" class="flex items-center space-x-3">
                        <Checkbox id="remember" name="remember" :tabindex="3" />
                        <span>Remember me</span>
                    </Label>
                </div>

                <Button
                    type="submit"
                    class="mt-4 w-full"
                    :tabindex="4"
                    :disabled="processing"
                    data-test="login-button"
                >
                    <LoaderCircle
                        v-if="processing"
                        class="h-4 w-4 animate-spin"
                    />
                    Log in
                </Button>
            </div>

            <div class="text-center text-sm text-muted-foreground">
                Don't have an account?
                <TextLink :href="register()" :tabindex="5">Sign up</TextLink>
            </div>
        </Form>

        <!-- Direct Login Buttons -->
        <div class="mt-8">
            <div class="relative">
                <div class="absolute inset-0 flex items-center">
                    <span class="w-full border-t" />
                </div>
                <div class="relative flex justify-center text-xs uppercase">
                    <span class="bg-background px-2 text-muted-foreground">Quick Login</span>
                </div>
            </div>
            
            <div class="mt-6 grid grid-cols-1 gap-3">
                <Button
                    type="button"
                    variant="outline"
                    class="w-full"
                    @click="loginAsSuperAdmin"
                >
                    <Crown class="mr-2 h-4 w-4" />
                    Login as Super Admin
                </Button>
                
                <Button
                    type="button"
                    variant="outline"
                    class="w-full"
                    @click="loginAsAdmin"
                >
                    <Shield class="mr-2 h-4 w-4" />
                    Login as Admin
                </Button>
            </div>
        </div>
    </AuthBase>
</template>
