<template>
    <div class="container">
        <div v-if="">

        </div>
    </div>
</template>

<script>
export default {
    name: "App"
}
</script>

<style>
* {
    margin: 0;
    padding: 0;
}

body {
    background: -webkit-linear-gradient(90deg, #dd06a0, #19a6c3);
    background: -moz-linear-gradient(90deg, #dd06a0, #19a6c3);
    background: -ms-linear-gradient(90deg, #dd06a0, #19a6c3);
    background: -o-linear-gradient(90deg, #dd06a0, #19a6c3);
    background: linear-gradient(90deg, #dd06a0, #19a6c3);
    height: 100vh;
}

#app {
    height: 100%;
}

.container {
    background-color: rgba(0, 0, 0, 0.2);
    max-width: 800px;
    margin: 0 auto;
    height: 100%;
    backdrop-filter: blur(10px);
}
</style>
