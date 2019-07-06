WITH RECURSIVE category_path (id, nama_rekening, path) AS
(
  SELECT id, nama_rekening, kode_rekening as path
    FROM koderekening
    WHERE parent_id IS NULL
  UNION ALL
  SELECT c.id, c.nama_rekening, CONCAT(cp.path, '.', c.kode_rekening)
    FROM category_path AS cp JOIN koderekening AS c
      ON cp.id = c.parent_id
)
SELECT * FROM category_path
ORDER BY path