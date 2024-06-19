
<template>
    <Header></Header>
    <section class="landing-block2">
        <div class="content-container" style="max-width: 100%;">
            <div class="title-section">
                <h3>Инструкция</h3>
                <p>Как мне узнать подробнее вашей компании?</p>
            </div>
            <p>Нажмите на клавишу «О нас»</p>
            <Image src="../instructions/AboutCompany.png" preview>
                <template #image>
                    <img src="/instructions/AboutCompany.png" alt="Image" style="width: 85vmin"/>
                </template>
            </Image>
            <p>Вы можете просмотреть в данном разделе:
                <br>- Свидетельство о государственной регистрации программы для ЭВМ
                <br>- Выписка из реестра аккредитованных организаций
                <br>- Заявление о включении сведений в единый реестр</p>
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
