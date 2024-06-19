<template>
    <Header></Header>
    <section class="landing-block2">
        <div class="content-container" style="max-width: 100%;">
            <div class="title-section">
                <h3>Инструкция</h3>
                <p>Как мне сформировать лоты для отправки на аукцион?</p>
            </div>
            <p>Если у вас на этом этапе нет приведенной потребности, нажмите на кликабельную ссылку <router-link to="../demand" target="_blank"><span class="text-green-600">«Как сформировать
                потребность»?</span></router-link></p>
            <p>1. Нажмите на кнопку «Загрузить потребность»</p>
            <p>2. Загрузите файл в формате xls/xlsx </p>
            <p>При корректном выполнении вышеописанных действий потребность появится в списке с наименованием файла, со
                статусом загрузки файла, количество позиций в потребности и датой загрузки. Информацию всегда можно
                просмотреть с помощью кнопки <span class="text-green-600">«Открыть»</span> и исправить с помощью кнопки <span class="text-green-500">«Редактировать»</span>.</p>
            <p class="text-green-600">Чтобы сформировать лоты:</p>
            <p>1. Нажмите на клавишу «Разбить на лоты»</p>
            <p>2. Выберите из предложенного списка категории, которые будут участвовать в распределении лекарственных средств на лоты</p>
            <p>3. В контекстном меню появится предложенные FlowExpert лоты</p>
            <p>Есть возможность отредактировать предложенные лоты, если Вас не устраивают сформированные лоты.</p>
            <p class="text-green-600">Обязательно подтвердите лот и появится возможность скачать его в xls формате</p>
        </div>
    </section>
    <Footer></Footer>
</template>

<script>

import Header from "./../Header.vue";
import Footer from "./../Footer.vue";

export default {
    components: {Header, Footer}
}
</script>
<style scoped>
.title-section p {
    font-size: 1.0em;
    color: green;
    text-indent: 0;
}
</style>
