<?php
namespace OCA\MGLeefNotes\Db;

use OCP\AppFramework\Db\Mapper;
use OCP\IDBConnection;

class NoteMapper extends Mapper {
    public function __construct(IDBConnection $db) {
        parent::__construct($db, 'mgleefnotes_notes', '\OCA\MGLeefNotes\Db\Note');
    }

    public function find($id, $userId) {
        $sql = 'SELECT * FROM *PREFIX*mgleefnotes_notes WHERE id = ? AND user_id = ?';
        return $this->findEntity($sql, [$id, $userId]);
    }

    public function findAll($userId) {
        $sql = 'SELECT * FROM *PREFIX*mgleefnotes_notes WHERE user_id = ?';
        return $this->findEntities($sql, [$userId]);
    }
}
