<!DOCTYPE html>
<html>
<head>
    <title>Подтверждение регистрации сотрудника</title>
</head>
<body>
<h1>Уважаемые представители {{ $organizationName }},</h1>
<p>
    Система FlowExpert получила запрос на регистрацию нового сотрудника в вашей организации. Пожалуйста, подтвердите регистрацию, перейдя по ссылке ниже.
</p>
<p>
    Персональные данные сотрудника:
    <br>
    ФИО: {{ $user->name }}
    <br>
    Телефон: {{ $user->phone }}
    <br>
    Должность: {{ $positionName }}
</p>
<p>
    Для подтверждения регистрации, пожалуйста, перейдите по следующей ссылке:
    <br>
    <a href="{{ $verificationUrl }}">Подтвердить регистрацию</a>
</p>
<p>
    Если у вас возникнут какие-либо вопросы или потребуется дополнительная информация, пожалуйста, свяжитесь с нашей службой поддержки по адресу <a href="mailto:aptekar@irk.ru">aptekar@irk.ru</a> или по телефону +7 (800) 500-1091.
</p>
<p>
    С уважением,
    <br>
    Команда FlowExpert
</p>
</body>
</html>
