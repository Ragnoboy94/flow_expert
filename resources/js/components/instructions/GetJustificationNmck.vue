
<template>
    <Header></Header>
    <section class="landing-block2">
        <div class="content-container" style="max-width: 100%;">
            <div class="title-section">
                <h3>Инструкция</h3>
                <p>Как мне получить обоснование НМЦК?</p>
            </div>
            <Image src="../instructions/GetJustificationNmck1.png" alt="Image" width="70%" />
            <p>Нажмите на клавишу “Скачать протокол” после прохождения всех этапов подготовки к расчету НМЦК. Кнопка подсветится ярким зеленым цветом.</p>
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
    text-indent: 0;
}
</style>
