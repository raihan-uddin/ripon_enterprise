---
name: db
description: Database helper — describe tables, run queries, check schema, explore relations. Use when the user says "show table", "describe", "schema", "db", or "database".
argument-hint: "<table name or query description>"
---

Database exploration and query helper for the `ripon_ent` MySQL database.

## Connection

```
Host:     localhost
Database: ripon_ent
User:     root
Password: (none)
```

Command: `mysql -u root ripon_ent -e "QUERY"`

## Steps

### Determine Intent

Based on `$ARGUMENTS`, determine what the user wants:

| Intent | Action |
|--------|--------|
| **Describe table** | Run `DESCRIBE table_name` and `SHOW CREATE TABLE table_name` |
| **List tables** | Run `SHOW TABLES` |
| **Find table** | Run `SHOW TABLES LIKE '%keyword%'` |
| **Show data** | Run `SELECT * FROM table_name LIMIT 20` |
| **Count records** | Run `SELECT COUNT(*) FROM table_name` |
| **Check relations** | Cross-reference with Yii model `relations()` |
| **Compare schema** | Diff table columns vs model `rules()` and `attributeLabels()` |
| **Run query** | Execute the user's query (read-only by default) |
| **Check indexes** | Run `SHOW INDEX FROM table_name` |
| **Find column** | Search across tables for a column name |

### Table Description

When describing a table:

1. Run `DESCRIBE table_name` to show columns, types, nullability, keys
2. Run `SHOW INDEX FROM table_name` to show indexes
3. Find the matching Yii model:
   - Search `protected/models/` and `protected/modules/*/models/` for `tableName()` returning this table
   - Read the model's `relations()`, `rules()`, `attributeLabels()`
4. Output a summary:

```
Table: table_name
Model: ModelName (protected/models/ModelName.php)
-----------------------------------------------
Column          Type           Null   Key   Default
-----------------------------------------------
id              int(11)        NO     PRI   auto_increment
name            varchar(255)   NO
created_at      datetime       YES          NULL
-----------------------------------------------

Relations (from model):
- customer → BELONGS_TO Customers (customer_id)
- details  → HAS_MANY OrderDetails (order_id)

Indexes:
- PRIMARY (id)
- idx_customer_id (customer_id)
```

### Schema Comparison

When comparing schema vs model:

1. Run `DESCRIBE table_name` to get DB columns
2. Read the model file to get `rules()`, `attributeLabels()`, `relations()`
3. Report:
   - Columns in DB but not in model rules (missing validation)
   - Columns in model rules but not in DB (stale rules)
   - Relations that don't have matching FK columns
   - Columns without labels

### Finding Columns

To find a column across all tables:
```sql
SELECT TABLE_NAME, COLUMN_NAME, DATA_TYPE
FROM INFORMATION_SCHEMA.COLUMNS
WHERE TABLE_SCHEMA = 'ripon_ent'
AND COLUMN_NAME LIKE '%keyword%';
```

### Query Execution

When running queries:
- **Read-only by default** — SELECT, DESCRIBE, SHOW, EXPLAIN only
- **Write queries require explicit user confirmation** — INSERT, UPDATE, DELETE, ALTER
- Always add `LIMIT` to SELECT queries if not present (default LIMIT 50)
- Format output as a readable table
- For large result sets, show first 20 rows and total count

### Common Queries

Provide these as shortcuts:

| Shortcut | Query |
|----------|-------|
| `db tables` | `SHOW TABLES` |
| `db {table}` | `DESCRIBE {table}` |
| `db count {table}` | `SELECT COUNT(*) FROM {table}` |
| `db find {column}` | Search INFORMATION_SCHEMA for column |
| `db fk {table}` | Show foreign key columns + related models |
| `db recent {table}` | `SELECT * FROM {table} ORDER BY id DESC LIMIT 10` |

## Rules

- NEVER run DROP, TRUNCATE, or ALTER without explicit user confirmation
- Always use LIMIT on SELECT queries to avoid dumping huge tables
- When showing data, mask sensitive columns (password, api_key, activkey)
- Cross-reference DB schema with Yii models when possible
- For write queries, show the query first and ask for confirmation before executing
- Use `--batch --raw` flags for scripted output when needed
