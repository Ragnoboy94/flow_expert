<template>
    <section class="landing-block">
        <div class="content-container">
            <h1 class="title">Flow Expert</h1>
            <p class="subtitle">
                Интеллектуальная система управления заказами лекарственных препаратов и
                расходных материалов для медицины
            </p>
            <ConsultationButton />
        </div>
        <div class="image-container">
            <img src="doctor-image.png" alt="Doctor" />
        </div>
    </section>
</template>

<script>
import ConsultationButton from './ConsultationButton.vue'

export default {
    components: {
        ConsultationButton
    }
}
</script>

<style scoped>
.landing-block {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: #fff;
    padding: 2rem;
    border-radius: 1vw;
    margin-top: 2px;
}
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

.content-container {
    max-width: 50%; /* подстройте под ваш дизайн */
}

.title {
    font-size: 2.5rem; /* подстройте под ваш дизайн */
    color: #000; /* подстройте под ваш дизайн */
    margin-bottom: 1rem;
}

.subtitle {
    font-size: 1rem; /* подстройте под ваш дизайн */
    color: #666; /* подстройте под ваш дизайн */
    margin-bottom: 2rem;
}

.image-container {
    /* Добавьте стили если нужно */
}

.image-container img {
    max-width: 100%;
    height: auto;
}
</style>
