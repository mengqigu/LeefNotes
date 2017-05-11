<?php
namespace OCA\MGLeefNotes\Controller;

use OCP\IRequest;
use OCP\AppFramework\Http\DataResponse;
use OCP\AppFramework\ApiController;

use OCA\MGLeefNotes\Service\NoteService;

class NoteApiController extends ApiController {
    private $service;
    private $userId;

    use Errors;

    public function __construct($AppName, IRequest $request,
                                NoteService $service, $UserId){
        parent::__construct($AppName, $request);
        $this->service = $service;
        $this->userId = $UserId;
    }

    /**
     * @CORS
     * @NoCSRFRequired
     * @NoAdminRequired
     */
    public function index() {
        return new DataResponse($this->service->findAll($this->userId));
    }

    /**
     * @CORS
     * @NoCSRFRequired
     * @NoAdminRequired
     *
     * @param int $id
     */
    public function show($id) {
        return $this->handleNotFound(function () use ($id) {
            return $this->service->find($id, $this->userId);
        });
    }

    /**
     * @CORS
     * @NoCSRFRequired
     * @NoAdminRequired
     *
     * @param string $title
     * @param string $content
     * @param string $folder
     */
    public function create($title, $content, $folder) {
        return $this->service->create($title, $content, $this->userId, $folder);
    }

    /**
     * @CORS
     * @NoCSRFRequired
     * @NoAdminRequired
     *
     * @param int $id
     * @param string $title
     * @param string $content
     * @param string $folder
     */
    public function update($id, $title, $content, $folder) {
        return $this->handleNotFound(function () use ($id, $title, $content, $folder) {
            return $this->service->update($id, $title, $content,
            $this->userId, $folder);
        });
    }

    /**
     * @CORS
     * @NoCSRFRequired
     * @NoAdminRequired
     *
     * @param int $id
     */
    public function destroy($id) {
        return $this->handleNotFound(function () use ($id) {
            return $this->service->delete($id, $this->userId);
        });
    }

}
