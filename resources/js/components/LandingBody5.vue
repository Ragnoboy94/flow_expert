<template>
    <section class="landing-block2 about-section">
        <div class="content-container flex">
            <div class="flex1 about-content">
                <h3 class="title-section">О Нас</h3>
                <p>Компания ООО "Информационный центр Альтекарио" уже более 20 лет...Информационный центр Альтекарио" уже более 20 лет...Информационный центр Альтекарио" уже более 20 лет...</p>
                <p>ООО ИЦ "Альтекарио" является аккредитованной ИТ-компанией...</p>
                <p>Собственный штат разработчиков, инженеров, технической поддержки...</p>
                <p>Кроме основного офиса в Иркутске, у нашей компании есть...</p>
            </div>
            <div class="flex1 image-container hidden lg:block">
                <img src="../../pics/landing5_logo.png" alt="FlowExpert Logo" class="about-logo">
            </div>
        </div>
    </section>
</template>

<script>

export default {
    name: 'LandingBody5',
};
</script>

<style scoped>

.about-text h1 {
    font-weight: bold;
    color: #000;
}
.about-content{
    max-width: 80%;
}

.image-container{
    margin-left: 10%;
    margin-right: 10%;
}


@media screen and (max-width: 991px) {
    .about-content {
        max-width: 100%;
    }
}
</style>
