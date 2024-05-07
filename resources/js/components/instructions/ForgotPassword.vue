
<template>
    <Header></Header>
    <section class="landing-block2">
        <div class="content-container" style="max-width: 100%;">
            <div class="title-section">
                <h3>Инструкция</h3>
                <p>Что делать, если я забыл пароль от своего личного кабинета?</p>
            </div>
            <p>Воспользуйтесь кликабельной ссылкой «Забыли пароль?» </p>
            <Image src="../instructions/ForgotPassword.png" alt="Image" width="70%" />
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
