<?php
class RequestorsController extends PrivilegesAppController {

	var $name = 'Requestors';

	function index() {
		$this->set('requestors', $this->paginate());
	}

	/**
	 * @todo		Make foreign key return the model value (ie. UserRole, or User)->find('list')
	 * @todo		Requestor.alias isn't being filled in when users or roles are added.
	 */
	function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->flash(__('Invalid Requestor', true), array('action'=>'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->Requestor->save($this->request->data)) {
				$this->flash(__('The Requestor has been saved.', true), array('action'=>'index'));
			} else {
			}
		}
		if (empty($this->request->data)) {
			$this->Requestor->recursive = 0;
			$this->request->data = $this->Requestor->read(null, $id);
		}
	}

	function delete($id = null) {
		$this->__delete('Requestor', $id);
	}

}
?>
