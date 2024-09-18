<template>
    <div>
        <search-default-template />
    </div>
</template>
<script>
    import { DefaultTemplate } from '@app/components/algolia';

    export default {
        components: {
            SearchDefaultTemplate: DefaultTemplate
        },
    }
</script>