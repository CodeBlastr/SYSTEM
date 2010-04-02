<?php
class InvoiceTimesheetTimesController extends AppController {

	var $name = 'InvoiceTimesheetTimes';
	
	function admin_ajax_edit($id = null) {
		$model = $this->modelClass;
		$controller = $this->name;
		if (!empty($this->data)) {
			if ($this->$model->save($this->data)) {
				$this->Session->setFlash(__($model.' saved', true));
			} else {
				$this->Session->setFlash(__('Could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->$model->read(null, $id);
		}
		## this might need to be fixed later, because I'm not 100% sure that 
		## we'll always need a type for the add / edit form
		## define the fields for the form and put them the order you want them displayed;
		## Edit these per controller
		$timesheetTimes = $this->$model->TimesheetTime->find('list');
		$this->set(compact('timesheetTimes'));
		$this->set('fields', array('invoice_id', 'timesheet_time_id'));
		## End edit per controller
		$this->set('model', $model);
		$this->set('controller', $controller);
		$this->viewPath = 'pages';
		$this->render('ajax_edit');
	}
	
	function admin_ajax_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id', true));
			$this->redirect(array('action'=>'index'));
		}
		$model = $this->modelClass;
		if ($this->$model->del($id)) {
			$this->redirect('/ajax_delete');
	        $this->layout = 'ajax';
		}
	}
	
}
?>