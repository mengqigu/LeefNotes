<?php
namespace OCA\MGLeefNotes\Controller;

use Exception;
use OCP\IRequest;
use OCP\AppFramework\Http;
use OCP\AppFramework\Http\DataResponse;
use OCP\AppFramework\Controller;
use OCA\MGLeefNotes\Service\NoteService;

// https://github.com/nextcloud/jsxc.nextcloud/pull/12
// use OCP\IDBConnection;

class NoteController extends Controller {
    // private $db;
    private $userId;
    private $service;

    // public function __construct($AppName, IRequest $request,
    // IDBConnection $db, NoteMapper $mapper, $UserId){
    //     parent::__construct($AppName, $request);
    //     $this->db = $db;
    //     $this->userId = $UserId;
    // }
    //
    use Errors;

    public function __construct($AppName, IRequest $request,
    NoteService $service, $UserId){
        parent::__construct($AppName, $request);
        $this->service = $service;
        $this->userId = $UserId;
    }

    /**
    * @NoAdminRequired
    */
    public function index() {
        // $sql = 'SELECT * FROM *PREFIX*mgleefnotes_notes WHERE user_id = ?';
        // $stmt = $this->db->prepare($sql);
        // $stmt->bindParam(1, $this->userId, \PDO::PARAM_INT);
        // $stmt->execute();
        //
        // $row = $stmt->fetchAll();
        //
        // $stmt->closeCursor();
        // return new DataResponse($row);
        return new DataResponse($this->service->findAll($this->userId));
    }

    /**
    * @NoAdminRequired
    *
    * @param int $id
    */
    public function show($id) {
        // $sql =
        // 'SELECT * FROM *PREFIX*mgleefnotes_notes WHERE user_id = ? AND id = ?';
        // $stmt = $this->db->prepare($sql);
        // $stmt->bindParam(1, $this->userId, \PDO::PARAM_INT);
        // $stmt->bindParam(2, $id, \PDO::PARAM_INT);
        // $stmt->execute();
        //
        // $row = $stmt->fetch();
        //
        // $stmt->closeCursor();
        // return new DataResponse($row);
        return $this->handleNotFound(function () use ($id) {
            return $this->service->find($id, $this->userId);
        });
    }

    /**
    * @NoAdminRequired
    *
    * @param string $title
    * @param string $content
    * @param string $folder
    */
    public function create($title, $content, $folder) {
        //  return new DataResponse($this->db->insert('*PREFIX*mgleefnotes_notes',
        //  array('title' => $title, 'user_id' => $this->userId, 'content' => $content)));
         return $this->service->create($title, $content, $this->userId,$folder);
    }

    /**
    * @NoAdminRequired
    *
    * @param int $id
    * @param string $title
    * @param string $content
    * @param string $folder
    */
    public function update($id, $title, $content, $folder) {
        // return new DataResponse($this->db->update('*PREFIX*mgleefnotes_notes',
        // array('title' => $title, 'content' => $content), array('id' => $id)));
        return $this->handleNotFound(function () use ($id, $title, $content, $folder) {
            return $this->service->update($id, $title, $content,
            $this->userId, $folder);
        });
    }

    /**
    * @NoAdminRequired
    *
    * @param int $id
    */
    public function destroy($id) {
        // return new DataResponse(
        // $this->db->delete('*PREFIX*mgleefnotes_notes', array('id' => $id)));
        return $this->handleNotFound(function () use ($id) {
            return $this->service->delete($id, $this->userId);
        });
    }

}
