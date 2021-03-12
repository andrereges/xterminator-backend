<template>
    <div :class="'alert alert-block alert-' + type" v-if="type && message">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ message }}</strong>
    </div>
</template>

<script>
    export default {
        name: 'FlashMessage',
        props: {
            type: String,
            message: String
        }
    }
</script>
