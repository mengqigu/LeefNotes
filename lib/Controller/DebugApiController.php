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

use OCP\IRequest;
use OCP\AppFramework\Http\DataResponse;
use OCP\AppFramework\ApiController;
use OCP\ILogger;

use OCA\MGLeefNotes\Service\Environment;
use OCA\MGLeefNotes\Service\DebugService;

// use OCA\MGLeefNotes\Service\NoteService;

class DebugApiController extends ApiController {
	/** @var Environment */
	private $environment;
    /** @var ILogger */
    protected $logger;

	/***
	 * Constructor
	 *
	 * @param string $AppName
	 * @param IRequest $request
	 * @param Environment $environment
	 * @param ILogger $logger
	 */
    public function __construct(
        $AppName,
        IRequest $request,
		Environment $environment,
        ILogger $logger
    ){
        parent::__construct($AppName, $request);
		$this->environment = $environment;
        $this->logger = $logger;
    }

    /**
     * @CORS
     * @NoCSRFRequired
     * @NoAdminRequired
     */
    public function index() {
        $this->logger->alert("Hello wtf2");
        return new DataResponse("No shit!");
    }
}
