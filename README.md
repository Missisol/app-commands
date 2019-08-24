# app-commands
Командная разработка 2019-07
<p>За основу взят шаблон <a href="https://github.com/yiisoft/yii2-app-advanced">yii2-app-advanced</a>

В него модулем для frontend добавлена реализация API.

По умолчанию выводится index.html в которое разворачивается Vue-приложение.

Маршрутизация реализована средствами Vue.

Vue-приложение через API соединяется с бизнес-логикой и базой данных.

Авторизация запросов к API через токены.</p>

## Установка

<p>Приложение готово к развертыванию в <a href="https://heroku.com/">heroku</a>.

После <a href="https://devcenter.heroku.com/articles/getting-started-with-php">первоначальной настройки</a>, нужно поставить <a href="https://devcenter.heroku.com/articles/cleardb">бд</a> и инициализировать yii2-приложение:</p>
```
.../app-commands$ heroku run bash --apps <heroku-имя-приложения>
~$ php yii init
~$ php yii migrate
```
Узнать имя приложения можно следующей командой из домашней системы:
```
.../app-commands$ heroku apps
```
Для работы регистрации необходимо установить почтовый модуль <a href="https://devcenter.heroku.com/articles/sendgrid#php">SendGrid</a>
