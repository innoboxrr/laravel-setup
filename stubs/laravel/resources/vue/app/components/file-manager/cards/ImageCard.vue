<template>
    <div :class="[file.current ? 'ring-2 ring-indigo-500 ring-offset-2' : 'focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 focus-within:ring-offset-gray-100 dark:focus-within:ring-offset-gray-800', 'group block w-full overflow-hidden rounded-lg bg-gray-100 dark:bg-gray-700']" style="aspect-ratio: 1 / 1;">
        <img 

            :src="file.signedUrl" 
            alt="" 
            :class="[file.current ? '' : 'group-hover:opacity-75', 'pointer-events-none object-cover w-full h-full']" />
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
