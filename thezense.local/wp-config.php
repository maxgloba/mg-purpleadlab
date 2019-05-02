<?php
/**
 * Основные параметры WordPress.
 *
 * Скрипт для создания wp-config.php использует этот файл в процессе
 * установки. Необязательно использовать веб-интерфейс, можно
 * скопировать файл в "wp-config.php" и заполнить значения вручную.
 *
 * Этот файл содержит следующие параметры:
 *
 * * Настройки MySQL
 * * Секретные ключи
 * * Префикс таблиц базы данных
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** Параметры MySQL: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define( 'DB_NAME', 'wp_thezense' );

/** Имя пользователя MySQL */
define( 'DB_USER', 'mysql' );

/** Пароль к базе данных MySQL */
define( 'DB_PASSWORD', 'mysql' );

/** Имя сервера MySQL */
define( 'DB_HOST', 'localhost' );

/** Кодировка базы данных для создания таблиц. */
define( 'DB_CHARSET', 'utf8mb4' );

/** Схема сопоставления. Не меняйте, если не уверены. */
define( 'DB_COLLATE', '' );

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу.
 * Можно сгенерировать их с помощью {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными. Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'Q!Ds|R!Po+dRHb6&<$&QxMlS[oMzX%P7mp3`dx!>FZ1uwr*P87~*M|W50JgL%|Gf' );
define( 'SECURE_AUTH_KEY',  'TRfy#3$>c23BS3bx2**/oVc-2@-}I!Per:s3qL6OW]<Mh%exr|CP1qp[a<2$i(t]' );
define( 'LOGGED_IN_KEY',    '+_sXF`[kdG o+ ;&(7r^oz]B@8:FOyId_*S<h^V9[R=]|0ut-!|U[{@%(:iLN?Y>' );
define( 'NONCE_KEY',        'AHnHxk8ymX_slR@0NC::H2m*|(hz^p(3t+Pe?6z>Knkvbj.=zscho3]ptAwpXU{p' );
define( 'AUTH_SALT',        'FvIDcjWs6G@-3M_MF.zC+tH#[<zYvrQ2I#Q5gTMO8Gd5}%0oh#0vZ0U)#Y^~l=Tr' );
define( 'SECURE_AUTH_SALT', 'd5@iZNtKSQzs&Zkj@7M8)r&_.[BpGE}r=^Y;fS$oYKUuq7hrs$Ft;MRXvX/f cI9' );
define( 'LOGGED_IN_SALT',   '[>?E=WPW#erzTW.aQW -;Q2_c(Gno`]ah>%CehM){n^0.>&JV$3LdB],YE:dbJb|' );
define( 'NONCE_SALT',       'Y<}x/Uf6Oj7~c9C&3fRY01D5Zzn}yp1M.47J#:K (0#)rfm.,v4._@sx@hMJ%x0x' );

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix = 'wp_';

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 *
 * Информацию о других отладочных константах можно найти в Кодексе.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Инициализирует переменные WordPress и подключает файлы. */
require_once( ABSPATH . 'wp-settings.php' );
