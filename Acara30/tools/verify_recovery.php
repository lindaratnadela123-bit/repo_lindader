<?php
$targetDatabase = 'db_workshop_recovery';
$host = getenv('DB_HOST') ?: 'localhost';
$username = getenv('DB_USER') ?: 'root';
$password = getenv('DB_PASS') === false ? '' : getenv('DB_PASS');
$dsn = "mysql:host=$host;charset=utf8mb4";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

$server = new PDO($dsn, $username, $password, $options);
$check = $server->prepare(
    'SELECT COUNT(*) FROM information_schema.schemata WHERE schema_name = ?'
);
$check->execute([$targetDatabase]);
if ((int) $check->fetchColumn() !== 0) {
    fwrite(STDERR, "Database $targetDatabase sudah ada; tidak ada perubahan dilakukan.\n");
    exit(2);
}

$created = false;
try {
    $server->exec(
        'CREATE DATABASE `' . $targetDatabase . '` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci'
    );
    $created = true;
    $backupPath = __DIR__ . '/../../Acara26/backups/db_workshop_acara26_demo.sql';
    $backup = file_get_contents($backupPath);
    if ($backup === false) {
        throw new RuntimeException('Backup contoh Acara26 tidak dapat dibaca.');
    }

    $database = new PDO(
        "mysql:host=$host;dbname=$targetDatabase;charset=utf8mb4",
        $username,
        $password,
        $options
    );
    restoreSql($database, $backup);
    $before = (int) $database->query('SELECT COUNT(*) FROM mahasiswa')->fetchColumn();

    $database->exec('DROP TABLE mahasiswa');
    $exists = $database->query(
        "SELECT COUNT(*) FROM information_schema.tables
         WHERE table_schema = DATABASE() AND table_name = 'mahasiswa'"
    )->fetchColumn();
    if ((int) $exists !== 0) {
        throw new RuntimeException('Simulasi gagal: tabel mahasiswa masih ada.');
    }

    restoreSql($database, $backup);
    $after = (int) $database->query('SELECT COUNT(*) FROM mahasiswa')->fetchColumn();
    $users = (int) $database->query('SELECT COUNT(*) FROM users')->fetchColumn();
    if ($before < 2 || $after < 2 || $users < 1) {
        throw new RuntimeException('Pemulihan tidak mengembalikan tabel/data contoh.');
    }

    echo "Database uji: $targetDatabase\n";
    echo "Data sebelum simulasi: $before mahasiswa\n";
    echo "Tabel mahasiswa hilang setelah simulasi: ya\n";
    echo "Data setelah restore: $after mahasiswa, $users user\n";
    echo "Database utama db_workshop: tidak disentuh\n";
} finally {
    if ($created) {
        $server->exec('DROP DATABASE `' . $targetDatabase . '`');
    }
}

function restoreSql(PDO $database, string $sql): void {
    $statements = preg_split('/;\s*(?:\r?\n|$)/', $sql);
    foreach ($statements as $statement) {
        if (trim($statement) !== '') {
            $database->exec($statement);
        }
    }
}
