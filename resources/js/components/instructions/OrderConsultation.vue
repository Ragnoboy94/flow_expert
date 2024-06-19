
<template>
    <Header></Header>
    <section class="landing-block2">
        <div class="content-container" style="max-width: 100%;">
            <div class="title-section">
                <h3>Инструкция</h3>
                <p>Как заказать консультацию по продукту?</p>
            </div>
            <p>Заполните форму и нажмите на кнопку «Заказать консультацию». Специалист свяжет ся с вами в ближайшее время!</p>
            <Image src="../instructions/OrderConsultation.webp" preview>
                <template #image>
                    <img src="/instructions/OrderConsultation.webp" alt="Image" style="width: 85vmin"/>
                </template>
            </Image>
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
