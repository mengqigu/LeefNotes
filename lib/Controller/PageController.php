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

use OCA\MGLeefNotes\Environment\Environment;
use OCA\MGLeefNotes\Service\SearchMediaService;

use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\DataResponse;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\ILogger;
use OCP\IRequest;

class PageController extends Controller {
	/**
	 * @var string
	 */
	private $userId;

	/**
	 * @var ILogger
	 */
	private $logger;
	/**
	 * @var Environment
	 */
	protected $environment;
	/**
	 * @var SearchMediaService
	 */
	protected $searchMediaService;
	/**
	 * Constructor
	 *
	 * @param string $AppName
	 * @param string $UserId
	 * @param Environment $environment
	 * @param SearchMediaService $searchMediaService
	 * @param IRequest $request
	 * @param ILogger $logger
	 */
	public function __construct(
		$AppName,
		$UserId,
		Environment $environment,
		SearchMediaService $searchMediaService,
		IRequest $request,
		ILogger $logger
	){
		parent::__construct($AppName, $request);
		$this->userId = $UserId;
		$this->environment = $environment;
		$this->searchMediaService = $searchMediaService;
		$this->logger = $logger;
	}

	/**
	 * CAUTION: the @Stuff turns off security checks; for this page no admin is
	 *          required and no CSRF check. If you don't know what CSRF is, read
	 *          it up in the docs or you might create a security hole. This is
	 *          basically the only required method to add this exemption, don't
	 *          add it to any other method if you don't exactly know what it does
	 *
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 */
	public function index() {
		// $this->logger->alert("In page controller: " . $this->searchMediaService->debug(),
		// array('app' => $this->appName));
		$searchResults = $this->searchMediaService->
			getMediaFiles($this->environment->getUserFolder(),[],[]);
		// $searchResults = $this->searchMediaService->debug();
		// $result = "";
		// foreach ($searchResults as $imageData) {
		// 	$result = $result . $imageData[0];
		// }
		$result = print_r($searchResults, true);
		$this->logger->alert("In page caceh? search: $result", array('app' => $this->appName));
		return new TemplateResponse('mgleefnotes', 'index');  // templates/index.php
	}

}
