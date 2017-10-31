/*
  название модели и количество машин
 */
SELECT
  m.`name`,
  COUNT(*)
FROM
  `models` m 
  INNER JOIN `cars` c ON c.`model_id` = m.`id`
GROUP BY
  m.`id`
;


/*
  машины ссылающиеся на несуществующие модели
 */
SELECT
  c.*
FROM
  `cars` c
  LEFT JOIN `models` m ON m.`id` = c.`model_id`
WHERE
  m.`id` IS NULL
;


/*
  название модели и сумму цен машин (игнорировать машины с ценой < 10 ,так же не выбирать если сумма цен<60)
 */
SELECT
  m.`name`,
  SUM(c.`price`) sum_price
FROM
  `models` m
  INNER JOIN `cars` c ON
    c.`model_id` = m.`id`
    AND c.`price` >= 10
GROUP BY
  m.`id`
HAVING
  sum_price >= 60
;