<template>
    <section class="landing-block">
        <div class="content-container">
            <h1 class="title">Flow<br><span style="margin-left:5rem;">Expert</span></h1>
            <p class="subtitle">
                Интеллектуальная система управления заказами лекарственных препаратов и
                расходных материалов для медицины
            </p>
            <ConsultationButton/>
        </div>
        <div class="image-container">
            <img src="../../pics/landing_image1.webp" alt="Doctor"/>
        </div>
    </section>
</template>

<script>
import ConsultationButton from './buttons/ConsultationButton.vue'

export default {
    name: 'LandingBody1',
    components: {
        ConsultationButton
    }
}
</script>

<style scoped>

@media (min-width: 768px) {
    .landing-block {
        border-radius: 7.5px;
    }
}

@media (min-width: 1200px) {
    .landing-block {
        border-radius: 10px;
    }
}

@media (max-width: 1200px) {
    .image-container img {
        display: none;
    }
}

.content-container {
    max-width: 50%;
    margin-left: 10%;
    margin-right: 10%;
}

.title {
    font-size: 5.5rem;
}

.subtitle {
    font-size: 1rem;
    margin-bottom: 2rem;
}

.image-container img {
    height: auto;
    margin-right: 10%;
}
</style>
