=== real.Kit ===

Stable tag:        5.1.1
Requires at least: 6.1.1
Tested up to:      6.1
Requires PHP:      5.6
Contributors:      realmaster-1
Donate link:       https://donate.qiwi.com/payin/Realist
License:           GPLv2 or later
License URI:       http://www.gnu.org/licenses/gpl-2.0.html
Tags:              id, thumbnails, translit, modals, maintenance, kit, real, real.kit, image, images, thumb, thumbnail, category, categories, taxonomy, taxonomies, admin, reveal, post, page, media, user, l10n, transliteration, slugs, russian, rustolat, cyrtolat, cyrillic, add, modal, modals, window, windows, maintenace, maintenance, optimization, revisions, набор, реалист, картинка, миниатюра, категории, рубрики, таксономии, метки, админ, пост, запись, страница, меди, пользователи, транслит, транслитерация, слаг, ярлык, русский, кириллица, модальные окна, сайт в разработке, ведутся работы, оптимизация, ривизии, редакции

Набор дополнений и улучшений WordPress | Kit of additions and improvements for WordPress

== Description ==

*English read below*

= Возможности плагина: =

1) Добавляет колонку ID на страницах админ панели.

2) Позволяет задавать миниатюры для терминов таксономий (рубрик и меток). Отображает заданные миниатюры в админ панели (для терминов, страниц и записей).

Используйте PHP функцию `realkit_term_thumbnail($term_id, $size)` для того чтобы получить URL миниатюры, где `$term_id` - это `ID` желаемого термина таксономии (по умолчанию `ID` текущего термина), a `$size` - необходимый размер миниатюры: `thumbnail`, `medium`, `large`, `full` (по умолчанию `thumbnail`).

Известные баги. Если сохранить изменения в быстром редактировании (или добавить новый термин), и, затем, открыть форму быстрого редактирования того же термина, то в поле миниатюры будет пустым. Но это не страшно, на самом деле картинка была прикреплена к термину и после перезагрузки страницы поле будет заполнено.

3) Транслитерация (замена кириллических символов на латинские) слагов (алиасов). Настраиваемые правила замены символов.

4) Добавляет новый тип записей для создания простых модальных окон.

5) Режим разработки. В нем все посетители, кроме администратора, будут видеть заглушку, которую можно настроить через админ панель.

6) Заменяет существующий, в консоли, виджет "На виду" на расширенный вариант.

7) Добавляет опции оптимизации, такие как:
- ограничение количества ревизий
- отключение поиска обновлений на некоторых страницах админ панели
- отключение скриптов и стилей для Эмодзи

Все модули (возможности) плагина можно включать и выключать на странице настройек.

*Machine translation:*

= The features: =

1) Adds an ID column on the admin panel pages.

2) Allows you to set thumbnails for Taxonomies (Categories and Tags). Displays the specified thumbnails in the admin panel (for both Taxonomies and Posts).

Use the PHP function `realkit_term_thumbnail($term_id, $size)` to get the thumbnail URL, where `$term_id` is the `ID` of the desired taxonomy term (default is `ID` of the current term), and `$size` is the required thumbnail size: `thumbnail`, `medium`, `large`, `full` (default is `thumbnail`).

Known bugs. If you save the changes in quick edit (or add a new term), and then open the quick edit form for the same term, the thumbnail field will be empty. But it's not terrible, in fact, the picture was attached to the term and after reloading the page field will be filled.

3) Transliteration (replacement of Cyrillic characters into Latin) slugs (aliases). Customizable character replacement rules.

4) Adds a new Post type to create modal Windows.

5) Maintenance mode. This way all visitors, except administrator will see the plug that you can configure through admin panel.

6) Replaces the existing, in the console, widget "At a Glance" on the advanced version.

7) Adds optimization options, such as:
- limiting the number of revisions
- disable search for updates on some pages of the admin panel
- disable scripts and styles for Emojis

All modules (features) can be turned on and off on the settings page.

== Installation ==

Как и любой другой плагин WordPress.

**Machine translation:**

Like any other WordPress plugin.

== Screenshots ==

1. Все настройки на одной странице | All settings on one page
1. Колонки ID и миниатюр для записей | ID and Thumbnail columns for posts
1. Колонки ID и миниатюр для терминов | ID and Thumbnail columns for terms
1. Транслит | Translit
1. Модальные окна | Modal windows
1. Виджет "На виду" | Widget "At a Glance"
1. Лимит записей для конкретной рубрики | Posts per page for current category
1. Список меток для быстрого добавления | List of tags for quick adding

== Changelog ==

= 5.1.1 =

* Исправлена XSS уязвимость шорткода открытия модальных окон.

*Machine translation:*

* Fixed XSS vulnerability of the modal window opening shortcode.

= 5.1.0 =

* Теперь модальные окна генерируются на сайте даже если на странице нет шорткода для их открытия (можно отключить для каждого окна отдельно).
* На странице редактирования рубрики добавлена возможность изменить количество записей на странице (для этой конкретной рубрики).
* На странице редактирования записи в блоке "Метки" (в т.ч. и для пользовательских типов) выводится список доступных меток для быстрого добавления.
* В разделе `Инструменты` создана страница с формой генерации транслита.
* На странице настроек плагина, добавлены поля, позволяющие вставить HTML-код метрик.
* Разные улучшения и исправления в коде.

*Machine translation:*

* Now modal windows are generated on the site even if there is no shortcode on the page to open them (you can disable it for each window separately).
* On the category editing page, added the ability to change the number of posts per page (for this particular category).
* On the post editing page, the Tags section (including custom types) displays a list of available tags for quick adding.
* In the `Tools` section, created a page with a translit generation form.
* On the plugin settings page, fields have been added that allow you to insert the HTML code of the metrics.
* Different code improvements and edits.

= 5.0.0 =

* Убрал модуль, формировавший древовидную структуру отмеченных рубрик (т.к. WordPress уже иммет данный функционал).
* Убрал модуль счетчика просмотров.
* Убрал шорткоды `[js]` и `[post]`.
* В админ панели теперь можно выводить колонку с миниатюрами записей и страниц.
* Добавил возможность настраивать правила транслитерации.
* Добавил расширенный виджет "На виду".
* Разные правки.

*Machine translation:*

* Removed the module that formed the hierarchical order of the marked categories (because WordPress already has this functionality).
* Removed the module counter views.
* Removed shortcodes `[js]` and `[post]`.
* In the admin panel, you can now display a column with Thumbnails of Posts and Pages.
* Added ability to configure transliteration rules.
* Added extended widget "At a Glance".
* Different edits.

= 4.2.3 =

* Добавлено предупреждение о грядущих изменениях.

*Machine translation:*

* Added warning about upcoming changes.

= 4.2.2 =

* Мелкие правки.

*Machine translation:*

* Minor changes.

= 4.2.1 =

* Убрал поддержку сочетания клавиш `Ctrl` + `S` (много разных нюансов).
* Исправлена ошибка в работе модальных окон (real.Modals).
* Для центровки модального окна теперь используется CSS а не JS.
* Мелкие правки.

*Machine translation:*

* Removed the keyboard shortcuts `Ctrl` + `S` (many different nuances).
* Fixed bug with modal windows (real.Modals).
* Now I use CSS (but not JS) for centering modal window.
* Minor changes.

= 4.2 =

* Добавлена поддержка сочетания клавиш `Ctrl` + `S`.
* Все настройки плагина теперь на одной странице.
* Исправлена ошибка работы с миниатюрами уже созданных рубрик.

*Machine translation:*

* Added support for keyboard shortcuts `Ctrl` + `S`.
* All plugin settings are now on one page.
* Fixed bug with thumbnails already created categories.

= 4.1 =

* Древовидная структура отмеченных рубрик.
* Добавлен режим разработки.

*Machine translation:*

* Categories in hierarchical order.
* Added a Maintenance mode.

= 4 =

* Добавлен шорткод `[post]`.

*Machine translation:*

* Added shortcode `[post]`.

= 3.3 =

* Мелкие правки.

*Machine translation:*

* Minor changes.

= 3.2 =

* Добавлена ссылка для сброса количества просмотров.

*Machine translation:*

* Added a link to reset the views counter.

= 3.1 =

* Добавлен шорткод `[views]`.

*Machine translation:*

* Added shortcode `[views]`.

= 3.0 =

* Добавлен опциональный счетчик количества просмотров
* Исправленна ошибка вызывающая NOTICE на странице категорий в админ панели.

*Machine translation:*

* Added optional views counter
* Fixed bug causing NOTICE on the category page in the admin panel.

= 2.0 =

* Добавлена возможность создания модальных окон

*Machine translation:*

* Added the ability to create modal Windows

= 1.3 =

* Убрано подключение не существующего файла стилей.
* Налажена совместимость с WordPress 4.2

*Machine translation:*

* Removed the connection not an existing stylesheet.
* Established compatibility with WordPress 4.2

= 1.2.3 =

* Исправленна ошибка версии 1.2.2

*Machine translation:*

* Fixed bug from 1.2.2

= 1.2.2 =

* Исправленна ошибка при вызове функции `realkit_taxonomy_thumb()`
* Расширено описание данной функции

*Machine translation:*

* Fixed bug when calling the function `realkit_taxonomy_thumb()`
* Extended description this function

= 1.2.1 =

* В шорткод `[js]...[/js]` добавлен параметр `src`.
* Другие правки.

*Machine translation:*

* In the shortcode `[js]...[/js]` added parameter `src`.
* Other changes.

= 1.2 =

* Добавлена поддержка шорткода `[js]...[/js]`.

*Machine translation:*

* Added shortcode `[js]...[/js]`.

= 1.1 =

* Добавлен русский перевод интерфейса.
* Исправлена ошибка транслитерации.
* Другие правки.

*Machine translation:*

* Added Russian localization.
* Fixed Transliteration bug.
* Other changes.