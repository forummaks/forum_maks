<?php
/***************************************************************************
 *                         lang_bbcode.php [Russian]
 *                            -------------------
 *   begin                : Wednesday Oct 3, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *
 *   $Id: lang_bbcode.php,v 1.3 2001/12/18 01:53:26 psotfx Exp $
 *
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/
 
//
// Translation performed by Alexey V. Borzov (borz_off)
// borz_off@cs.msu.su
//

  
$faq[] = array("--","Вступление");
$faq[] = array("Что такое BBCode?", "BBCode &mdash; это специальный вариант HTML. Сможете вы или нет использовать BBCode в ваших сообщениях, определяется администратором форумов. Кроме того, вы сможете отключить использование BBCode в конкретном сообщении при его размещении. Сам BBCode похож по стилю на HTML, теги заключены в квадратные скобки [ и ], а не в &lt; и &gt;; он даёт больше возможностей управления тем, как выводятся данные. При использовании некоторых шаблонов вы сможете добавлять BBCode в ваши сообщения, пользуясь простым интерфейсом, расположенным над полем для ввода текста. Но даже в этом случае данное руководство может оказаться полезным.");

$faq[] = array("--","Форматирование текста");
$faq[] = array("Как сделать текст жирным, наклонным или подчёркнутым", "BBCode включает теги для быстрого изменения стиля шрифта,  сделать это можно следующими способами: <ul><li>Чтобы сделать текст жирным, заключите его в <b>[b][/b]</b>, например <br /><br /><b>[b]</b>Привет<b>[/b]</b><br /><br />станет <b>Привет</b></li><li>Для подчёркивания используйте <b>[u][/u]</b>, например:<br /><br /><b>[u]</b>Доброе утро<b>[/u]</b><br /><br />станет <u>Доброе утро</u></li><li>Курсив делается тегами <b>[i][/i]</b>, например:<br /><br />Это <b>[i]</b>круто!<b>[/i]</b><br /><br />выдаст Это <i>круто!</i></li></ul>");
$faq[] = array("Как изменить цвет или размер текста", "Для изменения цвета или размера шрифта могут быть использованы следующие теги (окончательный вид будет зависеть от системы и браузера пользователя): <ul><li>Цвет текста можно изменить, окружив его <b>[color=][/color]</b>. Вы можете указать либо известное имя цвета (red, blue, yellow и т.п.), или шестнадцатеричное представление, например #FFFFFF, #000000. Таким образом, для создания красного текста вы можете использовать:<br /><br /><b>[color=red]</b>Привет!<b>[/color]</b><br /><br />или<br /><br /><b>[color=#FF0000]</b>Привет!<b>[/color]</b><br /><br />оба способа дадут в результате <span style=\"color:red\">Привет!</span></li><li>Изменение размера достигается аналогичным образом при использовании <b>[size=][/size]</b>. Этот тег зависит от используемых шаблонов, рекомендуемый формат &mdash; число, показывающее размер текста в пикселях, начиная от 1 (настолько маленький, что вы его не увидите) до 29 (очень большой). Например:<br /><br /><b>[size=9]</b>МАЛЕНЬКИЙ<b>[/size]</b><br /><br />скорее всего будет <span style=\"font-size:9px\">МАЛЕНЬКИЙ</span><br /><br />в то время как:<br /><br /><b>[size=24]</b>ЗДОРОВЫЙ!<b>[/size]</b><br /><br />будет <span style=\"font-size:24px\">ЗДОРОВЫЙ!</span></li></ul>");
$faq[] = array("Могу ли я комбинировать теги?", "Да, конечно можете. Например для привлечения чьего-то внимания вы сможете написать:<br /><br /><b>[size=18][color=red][b]</b>ПОСМОТРИТЕ НА МЕНЯ!<b>[/b][/color][/size]</b><br /><br />что выдаст <span style=\"color:red;font-size:18px\"><b>ПОСМОТРИТЕ НА МЕНЯ!</b></span><br /><br />Мы не рекомендуем выводить таким образом длинные тексты! Учтите, что вы, автор сообщения, должны позаботиться о том, чтобы теги были правильно вложены. Вот этот BBCode, например, неправилен:<br /><br /><b>[b][u]</b>Это неверно<b>[/b][/u]</b>");

$faq[] = array("--","Цитирование и вывод форматированных текстов");
$faq[] = array("Цитирование при ответах", "Есть два способа процитировать текст, со ссылкой и без.<ul><li>Когда вы используете кнопку &laquo;Ответить с цитатой&raquo; для ответа на сообщение, то его текст добавляется в поле ввода окружённым блоком <b>[quote=\"\"][/quote]</b>. Этот метод позволит вам цитировать со ссылкой на автора, либо на что-то ещё, что вы туда впишете. Например для цитирования отрывка текста, написанного Mr. Blobby, вы напишете:<br /><br /><b>[quote=\"Mr. Blobby\"]</b>Текст Mr. Blobby будет здесь<b>[/quote]</b><br /><br />В результате перед текстом будут вставлены слова \"Mr. Blobby написал:\". Помните, вы <b>должны</b> поставить кавычки \"\" вокруг имени, они не могут быть опущены.</li><li>Второй метод просто позволяет вам что-то процитировать. Для этого вам надо заключить текст в теги <b>[quote][/quote]</b>. При просмотре сообщения перед текстом будет стоять только слово \"Цитата:\"</li></ul>");
$faq[] = array("Вывод кода или форматированного текста", "Если вам надо вывести кусок программы или что-то, что должно быть выведено шрифтом фиксированной ширины (Courier) вы должны заключить текст в теги <b>[code][/code]</b>, например<br /><br /><b>[code]</b>echo \"This is some code\";<b>[/code]</b><br /><br />Всё форматирование, используемое внутри тегов <b>[code][/code]</b> будет сохранено.");

$faq[] = array("--","Создание списков");
$faq[] = array("Создание маркированного списка", "BBCode поддерживает два вида списков: маркированные и нумерованные. Они практически идентичны своим эквивалентам из HTML. В маркированном списке все элементы выводятся последовательно, каждый отмечается символом-маркером. Для создания маркированного списка используйте <b>[list][/list]</b> и определите каждый элемент при помощи <b>[*]</b>. Например, чтобы вывести свои любимые цвета, вы можете использовать:<br /><br /><b>[list]</b><br /><b>[*]</b>Красный<br /><b>[*]</b>Синий<br /><b>[*]</b>Жёлтый<br /><b>[/list]</b><br /><br />Это выдаст такой список:<ul><li>Красный</li><li>Синий</li><li>Жёлтый</li></ul>");
$faq[] = array("Создание нумерованного списка", "Второй тип списка, нумерованный, позволяет выбрать, что именно будет выводиться перед каждым элементом. Для создания нумерованного списка используйте <b>[list=1][/list]</b> или <b>[list=a][/list]</b> для создания алфавитного списка. Как и в случае маркированного списка, элементы определяются с помощью <b>[*]</b>. Например:<br /><br /><b>[list=1]</b><br /><b>[*]</b>Пойти в магазин<br /><b>[*]</b>Купить новый компьютер<br /><b>[*]</b>Обругать компьютер, когда случится ошибка<br /><b>[/list]</b><br /><br />выдаст следующее:<ol type=\"1\"><li>Пойти в магазин</li><li>Купить новый компьютер</li><li>Обругать компьютер, когда случится ошибка</li></ol>Для алфавитного списка используйте:<br /><br /><b>[list=a]</b><br /><b>[*]</b>Первый возможный ответ<br /><b>[*]</b>Второй возможный ответ<br /><b>[*]</b>Третий возможный ответ<br /><b>[/list]</b><br /><br />что выдаст<ol type=\"a\"><li>Первый возможный ответ</li><li>Второй возможный ответ</li><li>Третий возможный ответ</li></ol>");

$faq[] = array("--", "Создание ссылок");
$faq[] = array("Ссылки на другой сайт", "В BBCode поддерживается несколько способов создания URL'ов.<ul><li>Первый из них использует тег <b>[url=][/url]</b>, после знака = должен идти нужный URL. Например, для ссылки на phpBB.com вы могли бы использовать:<br /><br /><b>[url=http://www.phpbb.com/]</b>Посетите phpBB!<b>[/url]</b><br /><br />Это создаст следующую ссылку: <a href=\"http://www.phpbb.com/\" target=\"_blank\">Посетите phpBB!</a> Ссылка будет открываться в новом окне, так что пользователь сможет продолжать читать форумы.</li><li>Если вы хотите, чтобы в качестве текста ссылки показывался сам URL, вы можете просто сделать следующее:<br /><br /><b>[url]</b>http://www.phpbb.com/<b>[/url]</b><br /><br />Это выдаст следующую ссылку: <a href=\"http://www.phpbb.com/\" target=\"_blank\">http://www.phpbb.com/</a></li><li>Кроме того phpBB поддерживает возможность, называемую <i>Автоматические ссылки</i>, это переведёт любой синтаксически правильный URL в ссылку без необходимости указания тегов и даже префикса http://. Например, ввод www.phpbb.com в ваше сообщение приведёт к автоматической выдаче <a href=\"http://www.phpbb.com/\" target=\"_blank\">www.phpbb.com</a> при просмотре сообщения.</li><li>То же самое относится и к адресам e-mail, вы можете либо указать адрес в явном виде:<br /><br /><b>[email]</b>no.one@domain.adr<b>[/email]</b><br /><br />что выдаст <a href=\"emailto:no.one@domain.adr\">no.one@domain.adr</a> или просто ввести no.one@domain.adr в ваше сообщение, и он будет автоматически преобразован при просмотре.</li></ul>Как и со всеми прочими тегами BBCode, вы можете заключать в URL'ы любые другие теги, например <b>[img][/img]</b> (см. следующий пункт), <b>[b][/b]</b> и т.д. Как и с тегами форматирования, правильная вложенность тегов зависит от вас, например:<br /><br /><b>[url=http://www.phpbb.com/][img]</b>http://www.phpbb.com/images/phplogo.gif<b>[/url][/img]</b><br /><br /> <u>неверно</u>, что может привести к последующему удалению вашего сообщения, так что будьте аккуратнее.");

$faq[] = array("--", "Показ картинок в сообщениях");
$faq[] = array("Добавление картинки в сообщение", "BBCode включает тег для добавления картинки в ваше сообщение. При этом следует помнить две очень важные вещи: во-первых, многих пользователей раздражает большое количество картинок, во-вторых, ваша картинка уже должна быть размещена в интернете (т.е. она не может быть расположена только на вашем компьютере, если, конечно, вы не запустили на нём вебсервер!). На данный момент нет возможности хранить изображения локально на phpBB (ожидается, что это ограничение будет снято в следующей версии phpBB). Для вывода картинки вы должны окружить её URL тегами <b>[img][/img]</b>. Например:<br /><br /><b>[img]</b>http://www.phpbb.com/images/phplogo.gif<b>[/img]</b><br /><br />Как указано в предыдущем пункте, вы можете заключить картинку в теги <b>[url][/url]</b>, то есть<br /><br /><b>[url=http://www.phpbb.com/][img]</b>http://www.phpbb.com/images/phplogo.gif<b>[/img][/url]</b><br /><br />выдаст:<br /><br /><a href=\"http://www.phpbb.com/\" target=\"_blank\"><img src=\"templates/default/images/logo_phpBB_med.gif\" border=\"0\" alt=\"\" /></a><br />");

$faq[] = array("--", "Прочее");
$faq[] = array("Могу ли я добавить собственные теги?", "Нет, по крайней мере, не в phpBB 2.0. Мы планируем добавить поддержку настраиваемых тегов BBCode в следующей версии");

//
// This ends the BBCode guide entries
//

?>