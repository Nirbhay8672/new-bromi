<script setup lang="ts">
import TwoFactorRecoveryCodes from '@/components/TwoFactorRecoveryCodes.vue';
import TwoFactorSetupModal from '@/components/TwoFactorSetupModal.vue';
import { Button } from '@/components/ui/button';
import { useTwoFactorAuth } from '@/composables/useTwoFactorAuth';
import StrikingDashLayout from '@/layouts/StrikingDashLayout.vue';
import { disable, enable, show } from '@/routes/two-factor';
import { Form, Head } from '@inertiajs/vue3';
import { ShieldBan, ShieldCheck } from 'lucide-vue-next';
import { onUnmounted, ref } from 'vue';

interface Props {
    requiresConfirmation?: boolean;
    twoFactorEnabled?: boolean;
}

withDefaults(defineProps<Props>(), {
    requiresConfirmation: false,
    twoFactorEnabled: false,
});

const { hasSetupData, clearTwoFactorAuthData } = useTwoFactorAuth();
const showSetupModal = ref<boolean>(false);

onUnmounted(() => {
    clearTwoFactorAuthData();
});
</script>

<template>
    <Head title="Two-Factor Authentication" />

    <StrikingDashLayout>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-main">
                        <h4 class="text-capitalize breadcrumb-title">Two-Factor Authentication</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <!-- Two-Factor Authentication Card -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <span data-feather="shield" class="me-2"></span>
                                Two-Factor Authentication
                            </h5>
                        </div>
                        <div class="card-body">
                            <div v-if="!twoFactorEnabled">
                                <div class="d-flex align-items-center mb-3">
                                    <span class="badge bg-danger me-2">Disabled</span>
                                </div>

                                <p class="text-muted mb-4">
                                    When you enable two-factor authentication, you will be prompted for a secure pin during login. 
                                    This pin can be retrieved from a TOTP-supported application on your phone.
                                </p>

                                <div>
                                    <Button
                                        v-if="hasSetupData"
                                        @click="showSetupModal = true"
                                        class="btn btn-primary"
                                    >
                                        <ShieldCheck class="me-2" />
                                        Continue Setup
                                    </Button>
                                    <Form
                                        v-else
                                        v-bind="enable.form()"
                                        @success="showSetupModal = true"
                                        #default="{ processing }"
                                    >
                                        <Button type="submit" :disabled="processing" class="btn btn-primary">
                                            <ShieldCheck class="me-2" />
                                            Enable 2FA
                                        </Button>
                                    </Form>
                                </div>
                            </div>

                            <div v-else>
                                <div class="d-flex align-items-center mb-3">
                                    <span class="badge bg-success me-2">Enabled</span>
                                </div>

                                <p class="text-muted mb-4">
                                    With two-factor authentication enabled, you will be prompted for a secure, random pin during login, 
                                    which you can retrieve from the TOTP-supported application on your phone.
                                </p>

                                <TwoFactorRecoveryCodes />

                                <div class="mt-4">
                                    <Form v-bind="disable.form()" #default="{ processing }">
                                        <Button
                                            variant="destructive"
                                            type="submit"
                                            :disabled="processing"
                                            class="btn btn-danger"
                                        >
                                            <ShieldBan class="me-2" />
                                            Disable 2FA
                                        </Button>
                                    </Form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <TwoFactorSetupModal
            v-model:isOpen="showSetupModal"
            :requiresConfirmation="requiresConfirmation"
            :twoFactorEnabled="twoFactorEnabled"
        />
    </StrikingDashLayout>
</template>
