<template>
This is the home of facility {{ route.params.id }}
</template>
<script setup>
import { useRoute } from 'vue-router'

const route = useRoute()
console.log(route.params.id);
</script>
<style scoped>

</style>
