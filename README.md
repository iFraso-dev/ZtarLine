<!-- Improved compatibility of back to top link: See: https://github.com/othneildrew/Best-README-Template/pull/73 -->
<!--
*** Thanks for checking out the Best-README-Template. If you have a suggestion
*** that would make this better, please fork the repo and create a pull request
*** or simply open an issue with the tag "enhancement".
*** Don't forget to give the project a star!
*** Thanks again! Now go create something AMAZING! :D
-->

<h1 align="center">Мониторинг сигнализации Starline</h1>
<p clear="both">
<div align="center">
<picture>
  <source media="(prefers-color-scheme: dark)" srcset="http://fraso777.ru/data/Ztar-Line-logo.png">
  <img alt="ZtarLine" src="http://fraso777.ru/data/Ztar-Line-logo.png" width="600">
</picture>
<p align="center">
  <img src="https://img.shields.io/badge/PHP-7.2.5 or later-blue" />
  <img src="https://img.shields.io/badge/Ubuntu_Server-18.04 or later-blue" />
  <img src="https://img.shields.io/badge/Zabbix-6.0 +-blue" />
  <img src="https://img.shields.io/badge/Apache-1.3.12 or later-blue" />
  <img src="https://img.shields.io/badge/Mysql-8.0.X-blue" />
</p>
</div>

*<h3 align="center">Скрипт ZstarLine нужен для интеграции автомобильной сигнализации Starline в систему мониторинга Zabbix как для личного использования, так и для коммерческого.</h3>*
*<h4 align="center">Данный скрипт тестируется на <a href="https://releases.ubuntu.com/22.04.2/">OC Ubuntu Server 22.04.2 LTS</a>, <a href="https://www.php.net/downloads.php#v8.1.20">PHP 8.1.2</a>, <a href="http://archive.apache.org/dist/httpd/">Apache 2.4.52</a>, <a href="https://downloads.mysql.com/archives/community/?tpl=files&os=22&version=8.0.32&osva=Ubuntu Linux 22.04 (x86, 64-bit)">MySQL 8.0.32</a>, <a href="https://store.starline.ru/catalog/avtosignalizatsii/starline_s96_bt_2can_4lin_2sim_gsm/">Starline s96v2</a></h4>*
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
<sub>Данное руководство для Ubuntu ОС</sub>

Скачиваем скрипт в домашнюю директорию ubuntu
```
sudo git clone https://github.com/Fraso777/ZtarLine.git
```
переходим в скаченную директорию
```
cd ZtarLine/
```
копируем файлы в директорию `/externalscripts` Zabbix [^1]
```
sudo cp ztarline.php user_data.php /usr/lib/zabbix/externalscripts
```
копируем дополнение с картами
```
sudo cp map_ztarline.php /usr/share/zabbix
```
меняем права доступа к файлам, измением владельца и группу
```
sudo chmod 755 /usr/lib/zabbix/externalscripts/ztarline.php
sudo chown root:root /usr/lib/zabbix/externalscripts/ztarline.php
sudo chmod 755 /usr/lib/zabbix/externalscripts/user_data.php
sudo chown root:root /usr/lib/zabbix/externalscripts/user_data.php
sudo chmod 755 /usr/share/zabbix/map_ztarline.php
sudo chown root:root /usr/share/zabbix/map_ztarline.php
```
<p align="right">(<a href="#readme-top">Вверх</a>)</p>
</br>

# Настройка

## AppId и Secret Starline

Войдите в личный кабинет [My Starline](https://my.starline.ru/developer) в раздел [Разработчикам](https://my.starline.ru/developer). 
Заполняете форму для получения AppId и Secret. Укажите цель полуения доступа к API (в нашем случае для интеграции в систему мониторинга).

После одобрения заявки будет доступна функция.  


## Настройка Zabbix
Переходим на страницу Zabbix http://host-ip/zabbix [^2]

Создаем "Узел сети"

`Настройка -> Узлы сети -> Создать узел сети`
<p align="right">(<a href="#readme-top">Вверх</a>)</p>
</br>

[^1]: Для определения расположени директории `/externalscripts` используйте команду `find / -type d -iname externalscripts`. В ответ получите `/usr/lib/zabbix/externalscripts` или другое расположение директории.
[^2]: URL-адрес по умолчанию для пользовательского интерфейса Zabbix при использовании веб-сервера Apache.
