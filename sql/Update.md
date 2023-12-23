### 联表更新
```
UPDATE table AS T
LEFT JOIN table1 AS T1 ON T.t1_id=T1.id 
SET T.t1_name=T1.name
WHERE 1=1
```
