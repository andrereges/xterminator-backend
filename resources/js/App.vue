<template>
    <div class="container">
        <br>
        <navbar />
        <br>
        <command-group />
        <br>
        <router-view></router-view>
    </div>
</template>

<script>
    import Navbar from './components/Navbar';
    import CommandGroup from './components/CommandGroup';
    export default {
        name: 'App',
        components: {
            Navbar,
            CommandGroup
        }
    }
</script>
