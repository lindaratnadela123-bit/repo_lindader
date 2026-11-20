USE db_workshop;

SET @foto_column_exists = (
    SELECT COUNT(*)
    FROM information_schema.columns
    WHERE table_schema = DATABASE()
      AND table_name = 'mahasiswa'
      AND column_name = 'foto'
);
SET @foto_column_sql = IF(
    @foto_column_exists = 0,
    'ALTER TABLE mahasiswa ADD COLUMN foto VARCHAR(255) DEFAULT NULL AFTER prodi',
    'SELECT 1'
);
PREPARE foto_column_stmt FROM @foto_column_sql;
EXECUTE foto_column_stmt;
DEALLOCATE PREPARE foto_column_stmt;
