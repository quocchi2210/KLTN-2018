<?php

namespace App\Http\Controllers;

use App\Common\ErrorFormat;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Lang;

class Controller extends BaseController {
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	/**
	 * HTTP header status code.
	 *
	 * @var int
	 */
	protected $statusCode = 200;

	/**
	 * Illuminate\Http\Request instance.
	 *
	 * @var Request
	 */
	protected $request;

	/**
	 * @var Validator
	 */
	public $validator;

	/**
	 * @var $auth
	 */
	public $auth;

	/**
	 * @var $apiErrorCodes
	 */
	public $apiErrorCodes;

	/**
	 * @var $apiSuccessMessage
	 */
	public $apiSuccessMessage;

	/**
	 * @var $email
	 */
	public $emailMessage;

	/**
	 * @var $phoneMessage
	 */
	public $phoneMessage;

	/**
	 * @var $notificationMessage
	 */
	public $notificationMessage;

	/**
	 * @var $ip
	 */
	public $ip;

	public function __construct(Request $request) {
		$this->request = $request;
		$this->apiErrorCodes = Lang::get('apiErrorCode');
		$this->apiSuccessMessage = Lang::get('apiSuccessMessage');
	}


	/**
	 * Getter for statusCode.
	 *
	 * @return int
	 */
	protected function getStatusCode() {
		return $this->statusCode;
	}

	/**
	 * Setter for statusCode.
	 *
	 * @param int $statusCode Value to set
	 *
	 * @return self
	 */
	protected function setStatusCode($statusCode) {
		$this->statusCode = $statusCode;
		return $this;
	}

	/**
	 * @param  string $errorMessage
	 * @param  int $errorCode
	 * @param  null $statusCode
	 * @param  array $headers
	 * @return mixed
	 */
	protected function respondWithErrorMessage($errorMessage, $errorCode = null, $statusCode = null, array $headers = []) {
		// if status code not change to error status => set it 400 error
		if (is_null($statusCode)) {
			$this->setStatusCode(400);
		} else {
			$this->setStatusCode($statusCode);
		}

		$response = array(
			'error' => true,
			'data' => null,
			'errors' => array((object) array("errorMessaage" => $errorMessage, "errorCode" => $errorCode)),
		);
		return response()->json($response, $this->statusCode, $headers);
	}

	/**
	 * @param  string $errorMessage
	 * @param  int $errorCode
	 * @param  null $statusCode
	 * @param  array $headers
	 * @return mixed
	 */
	protected function respondErrorWithCode($errorCode = null, $statusCode = null, array $headers = []) {
		// if status code not change to error status => set it 400 error
		if (is_null($statusCode)) {
			$this->setStatusCode(400);
		} else {
			$this->setStatusCode($statusCode);
		}

		$response = array(
			'error' => true,
			'data' => null,
			'errors' => (object) array("messaage" => $this->apiErrorCodes[$this->apiErrorCodes['ApiErrorCodesFlip'][$errorCode]], "errorCode" => $errorCode),
		);
		return response()->json($response, $this->statusCode, $headers);
	}

	/**
	 * @param  \App\Common\ErrorFormat[] $errors
	 * @param  null $statusCode
	 * @param  array $headers
	 * @return mixed
	 */
	protected function respondWithError($errors, $statusCode = null, array $headers = []) {
		// if status code not change to error status => set it 400 error
		$errorCode = $this->apiErrorCodes;
		if (is_null($statusCode)) {
			$this->setStatusCode(400);
		} else {
			$this->setStatusCode($statusCode);
		}

		$parseErrors = array();
		foreach ($errors as $key => $error) {
			$parseErrors[] = new ErrorFormat($error, $errorCode['ApiErrorMessage'][$error]);
		}
		$response = array(
			'error' => true,
			'data' => null,
			'errors' => $parseErrors,
		);
		return response()->json($response, $this->statusCode, $headers);
	}

	/**
	 * @param    {array|object|string} $data
	 * @param    array $headers
	 * @return                         mixed
	 */
	protected function respondWithSuccess($data, $statusCode = null, array $headers = []) {
		// if status code not change to error status => set it 400 error
		if (is_null($statusCode)) {
			$this->setStatusCode(200);
		} else {
			$this->setStatusCode($statusCode);
		}

		$response = array(
			'error' => false,
			'data' => $data,
			'errors' => null,
		);

		return response()->json($response, $this->statusCode, $headers);
	}

	/**
	 * Generate a Response with a 403 HTTP header and a given message.
	 *
	 * @param   string $message
	 * @param   int $errorCode
	 * @param    array $headers
	 * @return  mixed
	 */
	protected function errorForbidden($message = 'Forbidden', $errorCode = 0, array $headers = []) {
		return $this->respondWithErrorMessage($message, $errorCode, 403, $headers);
	}

	/**
	 * Generate a Response with a 500 HTTP header and a given message.
	 *
	 * @param   string $message
	 * @param   int $errorCode
	 * @param    array $headers
	 *
	 * @return Response
	 */
	protected function errorInternalError($message = 'Internal Error', $errorCode = 0, array $headers = []) {
		return $this->respondWithErrorMessage($message, $errorCode, 500, $headers);
	}

	/**
	 * Generate a Response with a 404 HTTP header and a given message.
	 *
	 * @param   string $message
	 * @param   int $errorCode
	 * @param    array $headers
	 *
	 * @return Response
	 */
	protected function errorNotFound($message = 'Resource Not Found', $errorCode = 0, array $headers = []) {
		return $this->respondWithErrorMessage($message, $errorCode, 404, $headers);
	}

	/**
	 * Generate a Response with a 401 HTTP header and a given message.
	 *
	 * @param   string $message
	 * @param   int $errorCode
	 * @param    array $headers
	 *
	 * @return Response
	 */
	protected function errorUnauthorized($message = 'Unauthorized', $errorCode = 0, array $headers = []) {
		return $this->respondWithErrorMessage($message, $errorCode, 401, $headers);
	}

	/**
	 * Generate a Response with a 400 HTTP header and a given message.
	 *
	 * @param   string $message
	 * @param   int $errorCode
	 * @param    array $headers
	 *
	 * @return Response
	 */
	protected function errorWrongArgs($message = 'Wrong Arguments', $errorCode = 0, array $headers = []) {
		return $this->respondWithErrorMessage($message, $errorCode, 400, $headers);
	}

	/**
	 * Generate a Response with a 501 HTTP header and a given message.
	 *
	 * @param   string $message
	 * @param   int $errorCode
	 * @param    array $headers
	 *
	 * @return Response
	 */
	protected function errorNotImplemented($message = 'Not implemented', $errorCode = 0, array $headers = []) {
		return $this->respondWithErrorMessage($message, $errorCode, 501, $headers);
	}

	/**
	 * Generate a Response with a 400 HTTP header and a given message.
	 *
	 * @param   Validation $validation
	 * @param   int $statusCode
	 * @param   array $headers
	 *
	 * @return Response
	 */
	protected function errorWithValidation($validation, $statusCode = null, array $headers = []) {
		$errors = $validation->errors();
		return $this->respondWithError($errors->all(), $statusCode, $headers);
	}
}
