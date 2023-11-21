<template>
    <slot />
</template>

<script setup lang="ts">
const props = defineProps({
  table_type: {
    type: String,
    default: 'simple'
  },
});
</script>

<style lang="scss">
:root {
    --inertia-table-background-color: var(--color-background);
    --inertia-table-color: var(--bs-body-color);
}
</style>