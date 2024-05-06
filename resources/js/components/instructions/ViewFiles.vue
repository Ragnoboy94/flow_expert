
<template>
    <Header></Header>
    <section class="landing-block2">
        <div class="content-container" style="max-width: 100%;">
            <div class="title-section">
                <h3>Инструкция</h3>
                <p>Как посмотреть все мои загруженные файлы?</p>
            </div>
            <p>Зайдите в Личный кабинет, здесь вы сможете посмотреть все файлы, которые ранее загружали</p>
            <Image src="../instructions/ViewFiles.png" alt="Image" width="100%" />
        </div>
    </section>
    <Footer></Footer>
</template>

<script>

import Header from "./../Header.vue";
import Footer from "./../Footer.vue";
import Image from "primevue/image";

export default {
    components: {Header, Footer, Image}
}
</script>
<style scoped>
.title-section p {
    font-size: 1.0em;
    color: green;
}
</style>
