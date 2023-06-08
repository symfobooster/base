Инпут отвечает за входящие данные. Здесь вы можете получить данные из разных источников, таких как:
1. тело запроса
1. гет-параметры
1. файлы
1. куки
1. серверные переменные
1. хттп заголовки

Создайте файл инпута и реализуйте его от InputInterface.  
Добавте необходимые свойства и укажите источники днных в виде аннотаций.  
Опишите валидаторы.

Пример:

```php
<?php

namespace App\User\Registration;

use Symfony\Component\Validator\Constraint;
use Zabachok\Symfobooster\Input\InputInterface;
use Symfony\Component\Validator\Constraints as Assert;

class RegistrationInput implements InputInterface
{
    public string $email;
    public string $username;

    public function getValidators(): Constraint
    {
        return new Assert\Collection([
            'email' => [
                new Assert\Required(),
                new Assert\NotNull(),
                new Assert\Email(),
            ],
            'username' => [
                new Assert\Required(),
                new Assert\NotNull(),
                new Assert\Regex('|^[\w\-\_]+$|'),
                new Assert\Length(['min' => 1, 'max' => 20]),
            ],
        ]);
    }
}
```

## Источники данных
Если метод GET, то по умолчанию данные берутся из гет-параметров. В остальных случаях данные берутся из тела запроса. 
Если в конкреном случае вам подходит такая логика, то вы можете не указывать источник.  
Если источние по-умолчанию не подходит, то вы можете использовать аннтацию `Zabachok\Symfobooster\Input\Attributes\Source` и указать его явно.
В примере ниже мы получаем поле из суперглобального массива _COOKIE.
```php
    #[Source('query')]
    public string $id;
```

## Переименование полей
Переименование полей позволяет разорвать связь между входящими полями и их названиями используемыми в коде.
Аннотация `Zabachok\Symfobooster\Input\Attributes\Renamed` позволяет указать название поле из входящих данных.
В примере ниже мы берём куку, которая назвается `_ga` и кладём в поле `$googleId`.
```php 
    #[Source('cookie')]
    #[Renamed('_ga')]
    public string $googleId;
```
Эта функция полезна при работе с суперглобальными массивом _SERVER, с куками, с заголовками.

## Подавление ошибок валидации
Бывает необходимо скрыть ошибки валидации для некоторых полей от клиента. Для этого необходимо использовать аннотацию `Zabachok\Symfobooster\Input\Attributes\Muted`.
Благодаря ей если поле не прошло валидацию будет выдан код 400, но в ответе не будет сообщения о валидации для этого поля.
```php 
    #[Source('server')]
    #[Renamed('HTTP_REFERER')]
    #[Muted]
    public string $referer;
```