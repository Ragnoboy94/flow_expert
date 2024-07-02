<!DOCTYPE html>
<html>
<head>
    <title>Email Подтвержден</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }
        h1 {
            color: #333;
        }
        p {
            color: #555;
        }
        .footer {
            margin-top: 20px;
            border-top: 1px solid #ddd;
            padding-top: 10px;
            color: #777;
        }
    </style>
</head>
<body>
<h1>Здравствуйте, {{ $user->name }}</h1>
<p>Ваша кандидатура была успешно подтверждена организацией. Теперь вы можете использовать систему FlowExpert.</p>
<p>Для входа в систему, перейдите по следующей ссылке: <a href="{{ config('app.url') }}">{{ config('app.name') }}</a></p>
<p>Если у вас возникнут вопросы, пожалуйста, свяжитесь с нашей службой поддержки по электронному адресу <a href="mailto:aptekar@irk.ru">aptekar@irk.ru</a> или номеру телефона +7 (800) 500-1091.</p>
<p class="footer">С уважением,<br>Команда FlowExpert</p>
</body>
</html>
