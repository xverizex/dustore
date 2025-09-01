<?php
class Organization
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->connect();
    }

    public function getAllStaff($studio_id)
    {
        $query = 'SELECT * FROM staff WHERE org_id = ?';
        $stmt = $this->db->prepare($query);
        $stmt->execute([$studio_id]);

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getAllProjects($studio_id)
    {
        $query = 'SELECT * FROM games WHERE developer = ?';
        $stmt = $this->db->prepare($query);
        $stmt->execute([$studio_id]);

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}
