<template>
    <section class="landing-block2 about-section">
        <div class="content-container">
            <div class="flex align-items-center">
                <div class="flex-1 about-content">
                    <div class="title-section">
                        <h3 class="title-section">О Нас</h3>
                    </div>
                    <p><b>Компания ООО Информационный центр «Аптекарь» уже более 20 лет</b>, с 2002г, занимается
                        разработкой
                        программного обеспечения для автоматизации деятельности аптек, медицинских учреждений,
                        ветеринарных клиник.</p>
                    <p>ООО ИЦ «Аптекарь» является <b>аккредитованной ИТ-компанией</b> (Запись в реестре Минцифры № 10096
                        от
                        15.04.2019).</p>
                    <p><b>Собственный штат разработчиков, инженеров, технической поддержки</b> обеспечивает законченный
                        цикл
                        обслуживания.</p>
                    <p>Кроме основного офиса в Иркутске в нашей команде есть сотрудники в <b>Новосибирске, Омске,
                        Санкт-Петербурге</b>.</p>
                </div>
                <div class="flex-1 image-container hidden lg:block">
                    <img src="../../pics/landing5_logo.webp" alt="FlowExpert Logo" class="about-logo mt-5" width="90%">
                </div>
            </div>
            <Card class="card-landing2">
                <template #content>
                    <p><i class="pi pi-bullseye feature-icon"></i><b>Цель компании</b> — предоставить фармацевтическим
                        организациям и медицинским учреждениям
                        современные технологичные решения, сервисы для продуктивного взаимодействия между
                        участниками фармацевтического рынка и быстрого доступа к информации о лекарствах.</p>
                    <p><b>А значит – помочь людям быть здоровыми!</b></p>
                </template>
            </Card>
            <div class="p-grid">
                <div class="p-col-12">
                    <p class="registry-title">Все наши продукты внесены в Единый реестр программного обеспечения
                        Министерства цифрового развития, связи и массовых коммуникаций.</p><p><b>Вместо рутины —
                            искусственный интеллект!</b></p>
                </div>
                <div class="p-col-12">
                    <p>Все наши продукты внесены в Единый реестр программного обеспечения Министерства цифрового
                        развития, связи
                        и массовых коммуникаций:</p>
                </div>
                <div class="flex justify-content-center xl:flex-row flex-column">
                    <a href="/downloads/certificate.pdf" download="Certificate_of_Registration.pdf" class="card-landing2 flex align-items-center justify-content-center" Link>
                        <span>Свидетельство о государственной регистрации программы для ЭВМ </span>
                        <i class="pi pi-file-export registry-icon ml-1"></i>
                    </a>
                    <a href="/downloads/extract.pdf" download="Extract_from_the_Accredited_Organizations_Register.pdf" class="card-landing2 flex align-items-center justify-content-center" Link>
                        <span>Выписка из реестра аккредитованных организаций </span>
                        <i class="pi pi-file-export registry-icon ml-1"></i>
                    </a>
                    <a href="/downloads/application1.pdf" download="Application_for_Inclusion_in_the_Unified_Register.pdf" class="card-landing2 flex align-items-center justify-content-center" Link>
                        <span>Запись о внесении в единый реестр российского программного обеспечения</span>
                        <i class="pi pi-file-export registry-icon ml-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import Card from "primevue/card";

export default {
    name: 'LandingBody5',
    components: {
        Card,
    }
};
</script>

<style scoped>

.about-text h1 {
    font-weight: bold;
    color: #000;
}

.about-content {
    max-width: 80%;
}

.image-container {
    margin-left: 10%;
    margin-right: 10%;
}

.card-landing2 {
    height: 100%;
    border: 2px solid #00A950;
    padding: 1rem;
    box-shadow: 0 4px 8px rgba(0, 169, 80, 0.2);
    border-radius: 7vh;
    text-decoration: none;
}

.registry-title {
    font-size: 1.2rem;
    margin-bottom: 1rem;
}

.registry-icon {
    font-size: 2rem;
    color: #00A950;
}

@media screen and (max-width: 991px) {
    .about-content {
        max-width: 100%;
    }
}
</style>
