
<template>
    <Header></Header>
    <section class="landing-block2">
        <div class="content-container" style="max-width: 100%;">
            <div class="title-section">
                <h3>Инструкция</h3>
                <p>Как мне привести начальную потребность медицинского учреждения в требуемый вид?</p>
            </div>
            <p>1. Зайти на страницу «Получение приведенной потребности»</p>
            <Image src="../instructions/InitialNeeds1.png" alt="Image" width="100%" />
            <p>2. Нажмите на клавишу «Скачать шаблон»</p>
            <p>3. После заполнения шаблона, нажмите кнопку «Загрузить файл»</p>
            <Image src="../instructions/InitialNeeds2.png" alt="Image" width="100%" />
            <p>Flow Expert AI переведёт потребность в необходимый вид и подготовит файл к дальнейшему использованию</p>
            <Image src="../instructions/InitialNeeds3.png" alt="Image" width="100%" />
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
