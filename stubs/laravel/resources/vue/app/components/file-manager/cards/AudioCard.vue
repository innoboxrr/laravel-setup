<template>
    <div :class="[file.current ? 'ring-2 ring-indigo-500 ring-offset-2' : 'focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 focus-within:ring-offset-gray-100 dark:focus-within:ring-offset-gray-800', 'group block w-full overflow-hidden rounded-lg bg-gray-100 dark:bg-gray-700']" style="aspect-ratio: 1 / 1;">
        <div class="flex items-center justify-center h-full">
            <span class="text-4xl">🎵</span>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        file: {
            type: Object,
            required: true
        }
    }
}
</script>
