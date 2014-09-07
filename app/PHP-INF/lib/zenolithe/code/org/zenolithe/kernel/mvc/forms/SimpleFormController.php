<?php
/**
 * 11-aout-06 - david : Creation
 *
 * This class should be used as the base class for form controller.
 */

namespace org\zenolithe\kernel\mvc\forms;

use org\zenolithe\kernel\http\Request;
use org\zenolithe\kernel\mvc\controllers\IController;

define('FORM_STATE_NONE', 0);
define('FORM_STATE_INIT', 1);
define('FORM_STATE_ERROR', 2);
define('FORM_STATE_SUCCESS', 3);

class SimpleFormController implements IController {
	public $formFieldNames = array();
	public $formView;
	// if successView is null, the formView is rendered after successful form submission
	public $successView;
	private $formName;
	private $uname;
	protected $maxFormCount = 2;
	public $redirect_url;

	public function setFormView($formView) {
		$this->formView = $formView;
	}
	
	private final function isFormSubmission(Request $request) {
		$check = $request->getSession()->getAttribute('form_check');
		$postedUname = $request->getParameter('zenolithe_uname');
		$submission = !( $request->getSession()->isNew()
										 // The is a GET method instead of a POST one...
										 || (!$request->isPostMethod())
										 // ... or there is no cookie setted up for this form ...
										 || ($request->getCookie($this->formName) == null)
										 // ... or there is no posted 'zenolithe_uname' parameter and the cookie value for this form is already stored in the session,
										 // that means it is a multiple submission and should be considered as a new one ...
										 || (($postedUname == null) && ($check != null) && in_array($request->getCookie($this->formName), $check))
										 // ... or there is a posted 'zenolithe_uname' parameter which is already stored in the session,
										 // that means it is a multiple submission and should be considered as a new one ...
										 || (($postedUname != null) && ($check != null) && in_array($postedUname, $check)));

		if(!$submission) {
			// ... we generate a unique id based on time ...
			$this->uname = uniqid($this->formName.'_'.time().'_', 1);
			// ... and send a cookie for managing multiple submission.
			setcookie($this->formName, $this->uname, time() + 3600);
			$formCounts = array();
			$names = $request->getSession()->getAttributeNames();
			foreach($names as $name) {
				if(strpos($name, 'model_') !== false)  {
					$formName = substr($name, 6);
					$formName = substr($formName, 0, strrpos($formName, '_'));
					$formName = substr($formName, 0, strrpos($formName, '_'));
					if(isset($formCounts[$formName])) {
						$formCounts[$formName]++;
					} else {
						$formCounts[$formName] = 1;
					}
				}
			}
			foreach($formCounts as $formName => $formCount) {
				if($formCount > $this->maxFormCount) {
					$names = $request->getSession()->getAttributeNames();
					$formNames = array();
					foreach($names as $name) {
						if(strpos($name, 'model_'.$formName) !== false)  {
							$formNames[] = $name;
						}
					}
					asort($formNames);
					array_pop($formNames);
					array_pop($formNames);
					foreach($formNames as $name) {
						$request->getSession()->removeAttribute($name);
					}
				}
			}
		} else if($postedUname) {
			$this->uname = $postedUname;
		} else {
			$this->uname = $request->getCookie($this->formName);
		}
		
		return $submission;
	}

	private function bind(IFormModel $model, Request $request) {
		if($model) {
			foreach($model->getFields() as $name => $value) {
				$newValue = $request->getParameter($name);
				if(is_bool($value)) {
					if($newValue == null) {
						$model->setField($name, false);
					} else {
						$model->setField($name, ($newValue == 'true'));
					}
				} else {
					if(!$newValue && is_array($value)) {
						$model->setField($name, array());
					} else {
						$model->setField($name, $newValue);
					}
				}
			}
		}
	}

	protected function formBackingModel(Request $request) {
		$model = new SimpleFormModel();

		foreach($this->formFieldNames as $key) {
			$model->setField($key, '');
		}
		$this->bind($model, $request);

		return $model;
	}

	protected function validate(IFormModel $model) {
	}

	protected function doSubmitAction(IFormModel $model) {
	}

	private function storeFormSubmission(Request $request) {
		$check = $request->getSession()->getAttribute('form_check');

		if($check == null) {
			$check = array($this->uname);
			$request->getSession()->setAttribute('form_check', $check);
		} else {
			array_push($check, $this->uname);
			$request->getSession()->setAttribute('form_check', $check);
		}
	}

	public final function handleRequest(Request $request) {
		$model = null;

		$tmp = 'form_'.str_replace('.', '-', $request->url);
		$tmp = str_replace(',', '-', $tmp);
		$tmp = str_replace(':', '-', $tmp);
		$tmp = str_replace('=', '-', $tmp);
		$this->formName = str_replace(' ', '-', $tmp);

		// This request is a form submission ...
		if($this->isFormSubmission($request)) {
			// We retrieve the initial model from the session ...
			$model = $request->getSession()->getAttribute('model_'.$this->uname);
			// ... and update it with the Request supplied parameters ...
			$this->bind($model, $request);
			// ... and validate the model ...
			$this->validate($model);
			// ... if there is no error ...
			if(!$model->hasError()) {
				$request->setAttribute('formState', FORM_STATE_SUCCESS);
				$this->doSubmitAction($model);
				$this->storeFormSubmission($request);
				if(($this->redirect_url) || ($this->successView != null)) {
					setcookie($this->formName, '', time()-60*60*24);
					$request->getSession()->removeAttribute('model_'.$this->uname);
					if($this->redirect_url) {
						$request->redirect($this->redirect_url);
					} else {
						$model->setViewName($this->successView);
					}
				} else if($this->successView == null) {
					$request->setAttribute('formState', FORM_STATE_ERROR);
					// The form view should be shown again, so we generate a new cookie value
					$this->uname = uniqid(microtime(), 1);
					setcookie($this->formName, $this->uname, time() + 3600);
					$model->setViewName($this->formView);
					$request->getSession()->setAttribute('model_'.$this->uname, $model);
				}
				// ... else there is error(s) ...
			} else {
				$request->setAttribute('formState', FORM_STATE_ERROR);
				// ... store the modified model in the session ...
				$request->getSession()->setAttribute('model_'.$this->uname, $model);
				// ... and show the form.
				$model->setViewName($this->formView);
			}
			// ... and we had the unique id to the model for use in form view ...
			$model->setField('zenolithe_uname', $this->uname);

			// This request is not a form submission ...
		} else {
			// ... so we build the initial model ...
			$model = $this->formBackingModel($request);
			$request->setAttribute('formState', FORM_STATE_INIT);
			if($this->redirect_url) {
				$request->redirect($this->redirect_url);
			} else {
				// ... and we had the unique id to the model for use in form view ...
				$model->setField('zenolithe_uname', $this->uname);
				// ... and store it in the session ...
				$request->getSession()->setAttribute('model_'.$this->uname, $model);
				// ... and tell the main controller to render the form view.
				$model->setViewName($this->formView);
			}
		}

		return $model;
	}

	public function redirect($url) {
		$this->redirect_url = $url;
	}
}
?>