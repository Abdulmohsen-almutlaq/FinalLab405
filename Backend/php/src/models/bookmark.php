<?php

class Bookmark
{
    private $id;
    private $url;
    private $title;
    private $dateAdded;
    private $dbConnection;
    private $dbTable = 'bookmarks';

    public function __construct($dbConnection)
    {
        $this->dbConnection = $dbConnection;
    }
    public function getid()
    {
        return $this->id;
    }
    public function getUrl()
    {
        return $this->url;
    }
    public function getTitle()
    {
        return $this->title;
    }
    public function getDateAdded()
    {
        return $this->dateAdded;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function setUrl($url)
    {
        $this->url = $url;
    }
    public function setTitle($title)
    {
        $this->title = $title;
    }
    public function setDateAdded($dateAdded)
    {
        $this->dateAdded = $dateAdded;
    }

    public function createBookmark()
    {
        $query = "INSERT INTO $this->dbTable (url, title, dateAdded) VALUES (:url, :title, :dateAdded)";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':url', $this->url);
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':dateAdded', $this->dateAdded);
        if ($stmt->execute()) {
            $this->id = $this->dbConnection->lastInsertId();
            return true;
        } else {
            return false;
        }
    }
    public function getBookmark()
    {
        $query = "SELECT * FROM $this->dbTable WHERE id = :id;";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':id', $this->id);
        if ($stmt->execute()) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                return $result;
            }
            return false;
        }
        return false;
    }

    public function getAllBookmarks()
    {
        $query = "SELECT * FROM $this->dbTable ORDER BY dateAdded DESC;";
        $stmt = $this->dbConnection->prepare($query);
        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($result) {
                return $result;
            }
            return [];
        }
        return [];
    }

    public function updateBookmark()
    {
        $query = "UPDATE $this->dbTable SET url = :url, title = :title WHERE id = :id;";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':url', $this->url);
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':id', $this->id);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function deleteBookmark()
    {
        $query = "DELETE FROM $this->dbTable WHERE id = :id;";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':id', $this->id);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    
    public function getBookmarkByTitle()
    {
        $query = "SELECT * FROM $this->dbTable WHERE title = :title;";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':title', $this->title);
        if ($stmt->execute()) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                return $result;
            }
            return false;
        }
        return false;
    }
}
