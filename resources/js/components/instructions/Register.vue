
<template>
    <Header></Header>
    <section class="landing-block2">
        <div class="content-container" style="max-width: 100%;">
            <div class="title-section">
                <h3>Инструкция</h3>
                <p>Как мне зарегистрироваться на сайте FlowExpert?</p>
            </div>
            <p>1. Нажмите на кнопку «Войти»</p>
            <Image src="../instructions/Register1.png" preview>
                <template #image>
                    <img src="/instructions/Register1.png" alt="Image" style="width: 85vmin"/>
                </template>
            </Image>
            <p>2. Нажмите на кнопку «Зарегистрироваться» и заполните предложенную форму. Далее нажмите на кнопку «Зарегистрироваться»</p>
            <Image src="../instructions/Register2.png" preview>
                <template #image>
                    <img src="/instructions/Register2.png" alt="Image" style="width: 85vmin"/>
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
