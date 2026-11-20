<?php
class Database {
    private static ?PDO $connection = null;

    public static function getConnection(): PDO {
        if (self::$connection === null) {
            $environment = defined('APP_ENV') ? APP_ENV : 'development';
            $host = getenv('DB_HOST');
            $db = getenv('DB_NAME');
            $user    = getenv('DB_USER');
            $password = getenv('DB_PASS');
            if ($environment === 'production'
                && ($host === false || $host === ''
                    || $db === false || $db === ''
                    || $user === false || $user === ''
                    || $password === false || $password === '')) {
                Response::json(500, false, 'Konfigurasi database produksi belum lengkap.');
            }
            $host = $host ?: 'localhost';
            $db = $db ?: 'db_workshop';
            $charset = 'utf8mb4';
            $dsn     = "mysql:host=$host;dbname=$db;charset=$charset";
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ];
            try {
                self::$connection = new PDO(
                    $dsn,
                    $user === false ? 'root' : $user,
                    $password === false ? '' : $password,
                    $options
                );
            } catch (PDOException $e) {
                // Detail teknis hanya ditampilkan pada mode development.
                $errors = (defined('APP_ENV') && APP_ENV === 'development')
                    ? ['database' => [$e->getMessage()]]
                    : [];
                Response::json(500, false, 'Koneksi database gagal.', null, $errors);
            }
        }
        return self::$connection;
    }
}
