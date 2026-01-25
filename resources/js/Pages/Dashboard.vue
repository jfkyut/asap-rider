<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    stats: {
        type: Object,
        default: () => ({
            completed: 0,
            in_progress: 0,
            pending: 0,
            accepted: 0,
        })
    }
});

// Stats cards data
const statCards = computed(() => [
    {
        id: 'completed',
        label: 'Completed Rides',
        value: props.stats.completed || 0,
        color: 'blue',
        icon: 'ri-checkbox-circle-line',
        subtitle: 'Great performance!'
    },
    {
        id: 'in_progress',
        label: 'Active Rides',
        value: props.stats.in_progress || 0,
        color: 'purple',
        icon: 'ri-riding-line',
        subtitle: 'Currently delivering',
        pulse: true
    }
]);

// Action buttons data
const actionButtons = computed(() => [
    {
        id: 'available',
        label: 'Available',
        icon: 'ri-file-list-3-line',
        color: 'emerald',
        route: 'delivery.create',
        count: props.stats.pending || 0,
        description: 'Available delivery requests'
    },
    {
        id: 'in_progress',
        label: 'In Progress',
        icon: 'ri-map-pin-line',
        color: 'purple',
        route: 'delivery.index',
        count: props.stats.in_progress || 0,
        description: 'Track active deliveries',
        pulse: true
    },
    {
        id: 'completed',
        label: 'Completed',
        icon: 'ri-check-double-line',
        color: 'blue',
        route: 'delivery.index',
        count: props.stats.completed || 0,
        description: 'View completed deliveries'
    }
]);

// Ride overview data
const rideOverview = computed(() => [
    {
        id: 'open',
        label: 'Open',
        icon: 'ri-map-pin-time-line',
        color: 'yellow',
        count: props.stats.pending || 0
    },
    {
        id: 'ready',
        label: 'Ready to Pickup',
        icon: 'ri-check-line',
        color: 'blue',
        count: props.stats.accepted || 0
    },
    {
        id: 'delivering',
        label: 'Currently Delivering',
        icon: 'ri-map-pin-line',
        color: 'purple',
        count: props.stats.in_progress || 0,
        pulse: true
    },
    {
        id: 'completed',
        label: 'Completed Today',
        icon: 'ri-check-double-line',
        color: 'green',
        count: props.stats.completed || 0
    }
]);

const getColorClasses = (color, type = 'bg') => {
    const colors = {
        emerald: { bg: 'bg-emerald-100 dark:bg-emerald-900/30', text: 'text-emerald-600 dark:text-emerald-400', border: 'border-emerald-300 dark:border-emerald-700', btn: 'bg-emerald-500', lightBg: 'from-emerald-50 to-teal-100 dark:from-emerald-900/30 dark:to-teal-900/50', btnBorder: 'border-emerald-400 dark:border-emerald-600', btnText: 'text-emerald-900 dark:text-emerald-100', overlay: 'bg-emerald-200 dark:bg-emerald-700' },
        blue: { bg: 'bg-blue-100 dark:bg-blue-900/30', text: 'text-blue-600 dark:text-blue-400', border: 'border-blue-300 dark:border-blue-700', btn: 'bg-blue-500', lightBg: 'from-blue-50 to-cyan-100 dark:from-blue-900/30 dark:to-cyan-900/50', btnBorder: 'border-blue-400 dark:border-blue-600', btnText: 'text-blue-900 dark:text-blue-100', overlay: 'bg-blue-200 dark:bg-blue-700' },
        purple: { bg: 'bg-purple-100 dark:bg-purple-900/30', text: 'text-purple-600 dark:text-purple-400', border: 'border-purple-300 dark:border-purple-700', btn: 'bg-purple-500', lightBg: 'from-purple-50 to-pink-100 dark:from-purple-900/30 dark:to-pink-900/50', btnBorder: 'border-purple-400 dark:border-purple-600', btnText: 'text-purple-900 dark:text-purple-100', overlay: 'bg-purple-200 dark:bg-purple-700' },
        yellow: { text: 'text-yellow-600 dark:text-yellow-400', color: 'text-yellow-600 dark:text-yellow-400' },
        green: { text: 'text-green-600 dark:text-green-400', color: 'text-green-600 dark:text-green-400' },
        orange: { text: 'text-orange-600 dark:text-orange-400' }
    };
    return colors[color];
};

</script>

<template>
    <Head title="Rider Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            Dashboard
        </template>

        <div class="sm:p-6 max-w-7xl mx-auto px-2 py-2 sm:py-6">
            <!-- Welcome Card with Profile -->
            <div class="border border-emerald-500 dark:border-emerald-800 p-2 rounded-lg flex justify-between items-center mb-4 bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-900/20 dark:to-teal-900/20">
                <div>
                    <div class="text-xs capitalize font-bold text-zinc-900 dark:text-zinc-100">
                        Welcome back, {{ $page.props.auth.user.name }}!
                    </div>
                    <p class="text-xs text-zinc-600 dark:text-zinc-400 mt-0.5">Ready to earn today?</p>
                </div>
                <div>
                    <ApplicationLogo class="w-8" />
                </div>
            </div>

            <!-- Quick Stats Grid -->
            <div class="grid grid-cols-2 gap-1 mb-4">
                <div
                    v-for="stat in statCards"
                    :key="stat.id"
                    :class="['bg-gradient-to-br rounded-lg p-2.5 border', getColorClasses(stat.color).lightBg, getColorClasses(stat.color).border]"
                >
                    <div class="flex items-start justify-between">
                        <div>
                            <p :class="['text-xs font-semibold mb-0.5', getColorClasses(stat.color).text]">{{ stat.label }}</p>
                            <p :class="['text-sm font-bold', `text-${stat.color}-900 dark:text-${stat.color}-100`]">{{ stat.value }}</p>
                            <p :class="['text-xs mt-0.5', getColorClasses(stat.color).text]">{{ stat.subtitle }}</p>
                        </div>
                        <div :class="['w-8 h-8 rounded-full flex items-center justify-center text-white text-sm', getColorClasses(stat.color).btn, stat.pulse ? 'animate-pulse' : '']">
                            <i :class="stat.icon"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mb-4">
                <h3 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100 mb-2">Quick Actions</h3>
                <div class="grid grid-cols-2 gap-1">
                    <div
                        v-for="action in actionButtons"
                        :key="action.id"
                        @click="router.get(route(action.route))"
                        :class="['group relative overflow-hidden rounded-lg border-2 p-3 hover:shadow-lg transition-all duration-300 cursor-pointer', getColorClasses(action.color).btnBorder, getColorClasses(action.color).lightBg]"
                    >
                        <div :class="['absolute top-0 right-0 w-12 h-12 rounded-full -mr-4 -mt-4 opacity-50 group-hover:opacity-75 transition-opacity', getColorClasses(action.color).overlay]"></div>

                        <div class="relative z-10">
                            <div class="flex items-center mb-2">
                                <div :class="['w-8 h-8 rounded-lg flex items-center justify-center text-white text-sm mr-1.5', getColorClasses(action.color).btn]">
                                    <i :class="action.icon"></i>
                                </div>
                                <span :class="['font-semibold text-xs', getColorClasses(action.color).btnText]">{{ action.label }}</span>
                                <span :class="['ml-auto text-white text-xs px-1.5 py-0.5 rounded-full font-bold', getColorClasses(action.color).btn]">{{ action.count }}</span>
                            </div>

                            <p class="text-zinc-700 dark:text-zinc-300 mb-1.5 text-xs leading-tight">
                                {{ action.description }}
                            </p>

                            <div :class="['flex items-center font-semibold text-xs hover:translate-x-1 transition-transform', getColorClasses(action.color).text]">
                                {{ action.label === 'Available' ? 'See jobs' : action.label === 'In Progress' ? 'Track now' : 'View history' }} <i class="ri-arrow-right-s-line ml-1"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ride Status Summary -->
            <div class="mb-4">
                <h3 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100 mb-2">Ride Overview</h3>
                <div class="bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 p-3">
                    <div class="space-y-2">
                        <div
                            v-for="item in rideOverview"
                            :key="item.id"
                            class="flex items-center justify-between"
                        >
                            <div class="flex items-center">
                                <div :class="['w-6 h-6 rounded-full flex items-center justify-center mr-2', getColorClasses(item.color).bg, item.pulse ? 'animate-pulse' : '']">
                                    <i :class="['text-xs', item.icon, getColorClasses(item.color).text]"></i>
                                </div>
                                <span class="text-xs font-medium text-zinc-900 dark:text-zinc-100">{{ item.label }}</span>
                            </div>
                            <span :class="['text-sm font-bold', getColorClasses(item.color).color || getColorClasses(item.color).text]">{{ item.count }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
