<?php

declare(strict_types=1);


namespace App\Library\Repository;

class BorrowRepository
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    function borrowBook($sid, $bid, $days)
    {
        $due = date('Y-m-d', strtotime('+' . $days . ' days'));
        $sql = "INSERT INTO borrow_records(student_id,book_id,borrow_date,due_date,status) VALUES(" . $sid . "," . $bid . ",'" . date('Y-m-d') . "','" . $due . "','borrowed')";
        $this->conn->query($sql);
        return true;
    }

    function getRecordById($rid)
    {
        $sql = "SELECT * FROM borrow_records WHERE record_id=" . $rid;
        return $this->conn->query($sql)->fetch_assoc();
    }

    function updateReturnStatus($rid, $fine)
    {
        $sql2 = "UPDATE borrow_records SET return_date='" . date('Y-m-d') . "', fine_amount=" . $fine . ", status='returned' WHERE record_id=" . $rid;
        $this->conn->query($sql2);
    }

    function getOverdueBooks()
    {
        $sql = "SELECT br.*, b.title, s.name FROM borrow_records br JOIN books b ON br.book_id=b.book_id JOIN students s ON br.student_id=s.student_id WHERE br.due_date<'" . date('Y-m-d') . "' AND br.status='borrowed'";
        $result = $this->conn->query($sql);
        $list = array();
        while ($row = $result->fetch_assoc()) {
            $list[] = $row;
        }
        return $list;
    }
}
