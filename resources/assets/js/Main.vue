<template>
    <div>
        <navbar></navbar>

        <main class="py-4">
            <router-view></router-view>
        </main>

    </div>
</template>

<script>
import Navbar from "@/components/layouts/Navbar";

export default {
    name: "Main",
    components: {
        Navbar,

    },
}
</script>
<style scoped>

</style>
