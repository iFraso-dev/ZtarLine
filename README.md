<h1 align="center">Мониторинг сигнализации Starline</h1>
<p clear="both">
<div align="center">
<picture>
  <source media="(prefers-color-scheme: dark)" srcset="https://thumb.cloud.mail.ru/weblink/thumb/xw1/W6iB/sgfcSLwR8">
  <img alt="ZtarLine" src="https://thumb.cloud.mail.ru/weblink/thumb/xw1/W6iB/sgfcSLwR8" width="600">
</picture>
<p align="center">
  <img src="https://img.shields.io/badge/PHP-7.2.5 or later-blue" />
  <img src="https://img.shields.io/badge/Ubuntu_Server-18.04 or later-blue" />
  <img src="https://img.shields.io/badge/Zabbix-6.x +-blue" />
  <img src="https://img.shields.io/badge/Apache-2.4 or later-blue" />
  <img src="https://img.shields.io/badge/Mysql-8.0.X-blue" />
</p>
</div>

*<h3 align="center">Скрипт ZstarLine нужен для интеграции автомобильной сигнализации Starline в систему мониторинга Zabbix как для личного использования, так и для коммерческого.</h3>*
*<h4 align="center">Данный скрипт тестируется на <a href="https://releases.ubuntu.com/focal/">OC Ubuntu Server 22.04.6 LTS</a>, <a href="https://www.php.net/downloads.php#v8.2.12">PHP 8.2.12</a>, <a href="http://archive.apache.org/dist/httpd/">Apache 2.4.58</a>, <a href="https://downloads.mysql.com/archives/community/?tpl=files&os=22&version=8.2.12&osva=Ubuntu Linux 22.04 (x86, 64-bit)">MySQL 8.2.12</a>, <a href="https://store.starline.ru/catalog/avtosignalizatsii/starline_s96_bt_2can_4lin_2sim_gsm/">Starline s96v2</a></h4>*
</br>

<!-- TABLE OF CONTENTS -->
<a name="readme-top"></a>
<details>
  <summary>МЕНЮ</summary>
  <ol>
      <li><a href="#Системные-требования">Системные требования</a></li>
      <li><a href="#Установка">Установка</a></li>
      <li><a href="#Настройка">Настройка</a></li>
      <ul>
        <li><a href="#AppId-и-Secret-Starline">AppId и Secret Starline</a></li>
        <li><a href="#Настройка-Zabbix">Настройка Zabbix</a></li>
      </ul>
    </li>
  </ol>
</details>
</br>

# Системные требования
Данный скрипт работает на установленной системе мониторинга Zabbix начиная с 6 версии и выше. С требованиями к системе вы можете ознакомиться в официальной инструкции -><a href="https://www.zabbix.com/documentation/6.0/ru/manual/installation/requirements#примеры-конфигураций-оборудования">Требования</a>
<p align="right">(<a href="#readme-top">Вверх</a>)</p>
</br>

# Установка
<sub>Данное руководство для Ubuntu/Debian OC</sub>

Скачиваем скрипт в домашнюю директорию ubuntu
```
sudo git clone https://github.com/iFraso-dev/ZtarLine.git
```
переходим в скаченную директорию
```
cd ZtarLine/
```
копируем файлы в директорию `/externalscripts` Zabbix [^1]
```
sudo cp ztarline.php user_data.php /usr/lib/zabbix/externalscripts
```
меняем права доступа к файлам, измением владельца и группу
```
sudo chmod 755 /usr/lib/zabbix/externalscripts/ztarline.php
sudo chown root:root /usr/lib/zabbix/externalscripts/ztarline.php
sudo chmod 755 /usr/lib/zabbix/externalscripts/user_data.php
sudo chown root:root /usr/lib/zabbix/externalscripts/user_data.php
```
отредактируйте файл "user_data.php". Внесите данные, полученные в разделе <a href="#AppId-и-Secret-Starline">AppId и Secret Starline</a>
```
sudo nano /usr/lib/zabbix/externalscripts/user_data.php
```
укажите:

* $user_login = 'Your@email.com'; ⇒ Ваш логин от https://my.starline.ru
* $user_pass = sha1('Your_password'); ⇒  Ваш пароль от https://my.starline.ru
* $user_AppId = 'AppId'; ⇒ Ваш сгенерированный AppId в личном кабинете
* $user_Secret = 'Your_generated_Secret'; ⇒ Ваш сгенерированный Secret в личном кабинете
* $user_Secret_md5 = md5('Your_generated_Secret'); ⇒ Ваш сгенерированный Secret в личном кабинете

<p align="right">(<a href="#readme-top">Вверх</a>)</p>
</br>

# Настройка

## AppId и Secret Starline

Войдите в личный кабинет [My Starline](https://my.starline.ru/developer) в раздел [Разработчикам](https://my.starline.ru/developer). 
Заполняете форму для получения AppId и Secret. Укажите цель полуения доступа к API (в нашем случае для интеграции в систему мониторинга).

После одобрения заявки будет доступен раздел "Разработчикам".

Нажмите "Создать приложение" и в окне "Новое приложение" задайте "Имя приложения". Далее "СОХРАНИТЬ".

<picture>
  <img alt="ZtarLine" src="https://thumb.cloud.mail.ru/weblink/thumb/xw1/fFVp/jYhWuKFPQ" width="800">
</picture>
<picture>
  <img alt="ZtarLine" src="https://thumb.cloud.mail.ru/weblink/thumb/xw1/EgvV/SwFL3GH39" width="800">
</picture>


## Настройка Zabbix
Переходим на страницу Zabbix http://host-ip/zabbix [^2]

Создаем "Узел сети"

`Настройка -> Узлы сети -> Создать узел сети`
<p align="right">(<a href="#readme-top">Вверх</a>)</p>
</br>

[^1]: Для определения расположени директории `/externalscripts` используйте команду `find / -type d -iname externalscripts`. В ответ получите `/usr/lib/zabbix/externalscripts` или другое расположение директории.
[^2]: URL-адрес по умолчанию для пользовательского интерфейса Zabbix при использовании веб-сервера Apache.
