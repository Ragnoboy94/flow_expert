<template>
    <router-view></router-view>
</template>

<script>
import { mapActions } from 'vuex';

export default {
    name: 'App',
    created() {
        this.checkAuthentication();
    },
    methods: {
        ...mapActions('auth', ['checkAuthentication']),
    }
}
</script>

<style>
body  {
    background-color: gainsboro;
}
</style>
