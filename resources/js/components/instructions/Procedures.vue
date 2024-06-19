
<template>
    <Header></Header>
    <section class="landing-block2">
        <div class="content-container" style="max-width: 100%;">
            <div class="title-section">
                <h3>Инструкция</h3>
                <p>Где мне прочитать процедуры, реализуемые на ресурсе, описанные в законодательных актах Российской Федерации?</p>
            </div>
            <p>Процессы, реализуемые на ресурсе FlowExpert представлены ниже:</p>
            <p>1	функция. Приведение потребности в необходимый вид</p>
            <Image src="../instructions/Procedures1.png" preview>
                <template #image>
                    <img src="/instructions/Procedures1.png" alt="Image" style="width: 85vmin"/>
                </template>
            </Image>
            <p>2	функция. Формирование лотов</p>
            <Image src="../instructions/Procedures2.png" preview>
                <template #image>
                    <img src="/instructions/Procedures2.png" alt="Image" style="width: 85vmin"/>
                </template>
            </Image>
            <p>3	функция. Настройка параметров расчета НМЦК</p>
            <Image src="../instructions/Procedures3.png" preview>
                <template #image>
                    <img src="/instructions/Procedures3.png" alt="Image" style="width: 85vmin"/>
                </template>
            </Image>
            <p>4	функция. Обоснование получения НМЦК</p>
            <Image src="../instructions/Procedures4.png" preview>
                <template #image>
                    <img src="/instructions/Procedures4.png" alt="Image" style="width: 85vmin"/>
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
