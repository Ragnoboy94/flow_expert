
<template>
    <Header></Header>
    <section class="landing-block2">
        <div class="content-container" style="max-width: 100%;">
            <div class="title-section">
                <h3>Инструкция</h3>
                <p>Как мне рассчитать НМЦК?</p>
            </div>
        </div>
    </section>
    <Footer></Footer>
</template>

<script>

import Header from "./../Header.vue";
import Footer from "./../Footer.vue";

export default {
    components: {Header, Footer}
}
</script>
<style scoped>
.title-section p {
    font-size: 1.0em;
    color: green;
    text-indent: 0;
}
</style>
