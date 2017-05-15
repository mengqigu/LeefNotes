<?php
/**
 *
 * @copyright Copyright (c) 2017, Mengqi Gu (mengqigu@gmail.com)
 *
 * @license GNU AGPL version 3 or any later version
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

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
