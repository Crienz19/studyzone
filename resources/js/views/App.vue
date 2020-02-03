<template>
    <component :is="layout">
        <slot />
    </component>
</template>

<script>
export default {
    computed: {
        layout () {
            return this.$store.getters['global/GET_LAYOUT'];
        }
    },
}
</script>

<style>

</style>