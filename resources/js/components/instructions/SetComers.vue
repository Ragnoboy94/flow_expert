
<template>
    <Header></Header>
    <section class="landing-block2">
        <div class="content-container" style="max-width: 100%;">
            <div class="title-section">
                <h3>Инструкция</h3>
                <p>Как мне внести существующие коммерческие предложения для расчета НМЦК?</p>
            </div>
            <p>1. Укажите данные и нажмите загрузить</p>
            <Image src="../instructions/SetComers1.png" alt="Image" width="100%" />
            <p>2. После загрузки нажмите на кнопку «преобразовать»</p>
            <Image src="../instructions/SetComers2.png" alt="Image" width="100%" />
            <p>3. Преобразованный файл, который можете редактировать и изменять</p>
            <Image src="../instructions/SetComers3.png" alt="Image" width="100%" />
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
