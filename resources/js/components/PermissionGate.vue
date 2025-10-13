<template>
  <div>
    <!-- Example of using permission-based rendering -->
    <div v-if="canViewDashboard" class="bg-green-100 p-4 rounded">
      <h3 class="text-lg font-semibold">Dashboard Access</h3>
      <p>You have permission to view the dashboard.</p>
    </div>

    <div v-if="canManageUsers" class="bg-blue-100 p-4 rounded mt-4">
      <h3 class="text-lg font-semibold">User Management</h3>
      <p>You can manage users.</p>
      <button class="bg-blue-500 text-white px-4 py-2 rounded mt-2">
        Manage Users
      </button>
    </div>

    <div v-if="canManageRoles" class="bg-purple-100 p-4 rounded mt-4">
      <h3 class="text-lg font-semibold">Role Management</h3>
      <p>You can manage roles and permissions.</p>
      <button class="bg-purple-500 text-white px-4 py-2 rounded mt-2">
        Manage Roles
      </button>
    </div>

    <div v-if="isAdmin" class="bg-red-100 p-4 rounded mt-4">
      <h3 class="text-lg font-semibold">Admin Access</h3>
      <p>You have full admin access.</p>
    </div>

    <!-- User role display -->
    <div class="mt-6 p-4 bg-gray-100 rounded">
      <h3 class="text-lg font-semibold">Your Roles & Permissions</h3>
      <div v-if="userRoles.length > 0">
        <p class="font-medium">Roles:</p>
        <ul class="list-disc list-inside ml-4">
          <li v-for="role in userRoles" :key="role" class="text-sm">
            {{ role }}
          </li>
        </ul>
      </div>
      <div v-if="userPermissions.length > 0" class="mt-2">
        <p class="font-medium">Permissions:</p>
        <ul class="list-disc list-inside ml-4">
          <li v-for="permission in userPermissions" :key="permission" class="text-sm">
            {{ permission }}
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'

const page = usePage()

// Get user data from the page props
const user = computed(() => page.props.auth?.user)

// Check permissions
const canViewDashboard = computed(() => user.value?.can?.('view-dashboard') ?? false)
const canManageUsers = computed(() => user.value?.can?.('manage-users') ?? false)
const canManageRoles = computed(() => user.value?.can?.('manage-roles') ?? false)
const isAdmin = computed(() => user.value?.hasRole?.('admin') ?? false)

// Get user roles and permissions
const userRoles = computed(() => user.value?.roles?.map((role: any) => role.name) ?? [])
const userPermissions = computed(() => user.value?.permissions?.map((permission: any) => permission.name) ?? [])
</script>
