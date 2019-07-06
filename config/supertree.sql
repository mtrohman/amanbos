WITH RECURSIVE category_path (id, nama_rekening, nomor_rekening,parent_id) AS
(
  SELECT id, nama_rekening, kode_rekening as nomor_rekening, parent_id
    FROM koderekening
    WHERE parent_id IS NULL
  UNION ALL
  SELECT c.id, c.nama_rekening, CONCAT(cp.nomor_rekening, '.', c.kode_rekening), c.parent_id
    FROM category_path AS cp JOIN koderekening AS c
      ON cp.id = c.parent_id
)
SELECT
core.id, core.nama_rekening, nomor_rekening,
kr2.nama_rekening as parent
FROM category_path core
INNER JOIN koderekening kr2 ON kr2.id=core.parent_id
ORDER BY nomor_rekening