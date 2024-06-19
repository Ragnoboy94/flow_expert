
<template>
    <Header></Header>
    <section class="landing-block2">
        <div class="content-container" style="max-width: 100%;">
            <div class="title-section">
                <h3>Инструкция</h3>
                <p>Как мне задать параметры для расчета НМЦК?</p>
            </div>
            <p>1. Убедитесь, что в вашем личном кабинете введен ваш ИНН:</p>
            <Image src="../instructions/SetParametersNmck1.png" preview>
                <template #image>
                    <img src="/instructions/SetParametersNmck1.png" alt="Image" style="width: 85vmin"/>
                </template>
            </Image>
            <p>2. Перейдите в раздел “Настройка параметров расчета НМЦК”:</p>
            <Image src="../instructions/SetParametersNmck2.png" preview>
                <template #image>
                    <img src="/instructions/SetParametersNmck2.png" alt="Image" style="width: 85vmin"/>
                </template>
            </Image>
            <p>3. Введите все данные, которые необходимы вам для расчета НМЦК.</p>
            <p><u><i>Если хотите изменить ИНН заказчика, то нажмите на кнопку “Изменить заказчика”:</i></u></p>
            <Image src="../instructions/SetParametersNmck3.png" preview>
                <template #image>
                    <img src="/instructions/SetParametersNmck3.png" alt="Image" style="width: 85vmin"/>
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
