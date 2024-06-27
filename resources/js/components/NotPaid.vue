<template>
    <div class="page-404">
        <div class="content">
            <h1>Доступ запрещен</h1>
            <p>Уважаемый пользователь!</p>
            <p>Мы благодарим Вас за использование нашего ресурса.</p>
            <p>К сожалению, очередной платеж лицензионного вознаграждения за использование системы  Flow Expert по выбранному тарифу нами от Вас в установленный срок не получен, поэтому часть функционала данной системы заблокирована.</p>
            <p>Для продолжения использования полного функционала системы  Flow Expert  просим произвести оплату. Все ранее внесенные данные сохраняются.</p>
            <router-link to="/" class="home-link">Вернуться на главную</router-link>
        </div>
    </div>
</template>

<script>
export default {
    name: "NotPaid",
};
</script>

<style scoped lang="scss">
.page-404 {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    text-align: center;

    .content {
        transform: translateY(-50%);

        h1 {
            font-size: 6rem;
            margin-bottom: 1rem;
        }

        p {
            margin-bottom: 2rem;
        }

        .home-link {
            display: inline-block;
            padding: 0.5rem 1rem;
            background-color: #00A950;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;

            &:hover {
                background-color: darken(#00A950, 10%);
            }
        }
    }
}
</style>
