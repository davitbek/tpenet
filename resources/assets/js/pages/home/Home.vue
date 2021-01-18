<template>
    <div>
        <navbar></navbar>
        <div class="container">
            <div class="row justify-content-center">
               <h1>Hello Home</h1>
            </div>
        </div>
    </div>
</template>

<script>
import Navbar from "@/components/layouts/Navbar";

export default {
    name: "Home",
    components: [
        Navbar
    ]

}
</script>

<style scoped>

</style>
