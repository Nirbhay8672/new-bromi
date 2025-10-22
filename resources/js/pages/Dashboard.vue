<script setup lang="ts">
import StrikingDashLayout from '@/layouts/StrikingDashLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps<{
    totalUsers: number;
}>();
</script>

<template>
    <Head title="Dashboard" />

            <StrikingDashLayout>
            <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="breadcrumb-main">
                        <h4 class="text-capitalize breadcrumb-title">Dashboard</h4>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <!-- User Card - Left Side -->
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body text-center py-4">
                            <!-- Users Icon -->
                            <div class="mb-3">
                                <div class="d-inline-flex align-items-center justify-content-center bg-primary bg-gradient rounded-circle mb-2" style="width: 60px; height: 60px;">
                                    <span data-feather="users" class="text-white" style="width: 30px; height: 30px;"></span>
                            </div>
                        </div>

                            <!-- Title -->
                            <h5 class="mb-2 text-dark fw-bold">Total Users</h5>
                            
                            <!-- User Count -->
                            <div class="h2 text-primary mb-3 fw-bold">
                                {{ props.totalUsers }}
                    </div>

                            <!-- Action Button -->
                            <Link 
                                href="/admin/users" 
                                class="btn btn-primary btn-sm px-3 py-2 rounded-pill"
                            >
                                <span data-feather="users" class="me-1"></span>
                                View Users
                            </Link>
                                </div>
                            </div>
                        </div>

                <!-- Right Side - Additional Content Space -->
                <div class="col-lg-8 col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body d-flex align-items-center justify-content-center">
                            <div class="text-center">
                                <h4 class="text-muted mb-3">Welcome to Dashboard</h4>
                                <p class="text-muted mb-0">Manage your application from here</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </StrikingDashLayout>
</template>

<style scoped>
.h2 {
    font-size: 2.5rem;
    font-weight: 700;
    line-height: 1;
    text-shadow: 0 1px 2px rgba(0,0,0,0.1);
}

.card {
    transition: all 0.3s ease-in-out;
    border-radius: 20px;
    background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.1) !important;
}

.btn-sm {
    padding: 0.5rem 1.5rem;
    font-size: 0.9rem;
    font-weight: 600;
    border-radius: 50px;
    transition: all 0.3s ease;
}

.btn-sm:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 15px rgba(13, 110, 253, 0.3);
}

.bg-gradient {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%) !important;
}

.fs-5 {
    font-size: 1.1rem !important;
}

/* Icon animation */
@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

.bg-gradient {
    animation: pulse 2s infinite;
}
</style>
