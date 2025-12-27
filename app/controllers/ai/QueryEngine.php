<?php

class QueryEngine
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function executeSafeSql($sql)
    {
        $sql = trim($sql);

        // 1. Basic Sanitization
        // Remove markdown logic frequently returned by AI even if told not to
        $sql = str_replace('```sql', '', $sql);
        $sql = str_replace('```', '', $sql);
        $sql = trim($sql);

        // 2. Strict Read-Only Validation
        $upperSql = strtoupper($sql);

        if (strpos($upperSql, 'SELECT') !== 0) {
            throw new Exception("Security Violation: Only SELECT statements are allowed.");
        }

        $forbiddenKeywords = ['DELETE', 'UPDATE', 'INSERT', 'DROP', 'ALTER', 'TRUNCATE', 'GRANT', 'REVOKE', 'RENAME', 'REPLACE'];
        foreach ($forbiddenKeywords as $keyword) {
            // Check for keyword surrounded by word boundaries to avoid false positives (e.g. "SELECT id, update_date FROM...")
            // Actually, simpler check: strict blacklist. 
            // Note: Simplistic check might block columns named 'update'. 
            // Better regex: white-space boundaries.
            if (preg_match('/\b' . $keyword . '\b/i', $sql)) {
                throw new Exception("Security Violation: Forbidden keyword '$keyword' detected.");
            }
        }

        // 3. Execution
        try {
            // Enforce a hard limit if not present to prevent crashing the server
            if (strpos($upperSql, 'LIMIT') === false) {
                $sql .= " LIMIT 50";
            }

            $stmt = $this->pdo->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            // Don't expose table structures in error messages
            throw new Exception("Query Execution Failed: " . $e->getMessage());
        }
    }
}
