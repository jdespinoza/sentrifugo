<?php
/*********************************************************************************
 *  This file is part of Sentrifugo.
 *  Copyright (C) 2015 Sapplica
 *
 *  Sentrifugo is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  Sentrifugo is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with Sentrifugo.  If not, see <http://www.gnu.org/licenses/>.
 *
 *  Sentrifugo Support <support@sentrifugo.com>
 ********************************************************************************/

class Default_EmpconfigurationController extends Zend_Controller_Action
{

	private $options;
	private $empConfigureArray;
	public function preDispatch()
	{


	}

	public function init()
	{
		$this->_options= $this->getInvokeArg('bootstrap')->getOptions();
		$this->empConfigureArray = array(
								   'employeedocs' => 'Documentos del Empleado',
									'emp_leaves' => 'Licencias de Empleados',
									'emp_leaves' => 'Licencia de Empleado',
								   'emp_holidays' => 'Vacaciones del Empleado',
								   'emp_salary' => 'Detalles del Salario',
								   'emppersonaldetails'=>'Detalles Personales',
								   'empcommunicationdetails'=>'Detalles de Contacto',
								   'emp_skills' => 'Habilidades del Empleado',
								   'emp_jobhistory' => 'Historial de Trabajo del Empleado',
								   'experience_details' => 'Experiencia',
								   'education_details' => 'Detalles de la Educación',
								   'trainingandcertification_details' => 'Detalles del Entrenamientos y Certificación',
								   'medical_claims' => 'Reclamaciones Médicas',
								   'disabilitydetails' => 'Detalles de la Discapacidad',
								   'dependency_details' => 'Detalles de Dependencia',
								   'visadetails' => 'Detalles de Inmigración & Visa',
								   'creditcarddetails' => 'Detalles de la tarjeta corporativa',
								   'workeligibilitydetails' => 'Detalles de elegibilidad de trabajo',
								   'emp_additional' => 'Detalles Adicionales',
								   //'emp_performanceappraisal' => 'Performance Appraisal',
								   'emp_payslips' => 'Recibos de Pago',
								   'emp_benifits' => 'Beneficios',
								   'emp_renumeration' => 'Detalles de Remuneración',
								   'emp_security' => 'Credenciales de Seguridad',
								   'assetdetails' => 'Detalles del Activo'
								   );

	}


	public function indexAction()
	{
		$dataArray = array();
		if(defined('EMPTABCONFIGS'))
		{
			$empOrganizationTabs = explode(",",EMPTABCONFIGS);

			if(!empty($empOrganizationTabs) && !empty($empOrganizationTabs[0])){
				foreach($this->empConfigureArray as $key => $val){
					if(in_array($key,$empOrganizationTabs)){
						$dataArray[$val] = 'YES';
					}else{
						$dataArray[$val] = 'NO';
					}
				}
			}
		}
		$this->view->dataArray = $dataArray;
		$this->view->messages = $this->_helper->flashMessenger->getMessages();
	}

	public function editAction()
	{
		$auth = Zend_Auth::getInstance();
		if($auth->hasIdentity()){
			$loginUserId = $auth->getStorage()->read()->id;
			$loginuserGroup = $auth->getStorage()->read()->group_id;
		}

		$empconfigurationform = new Default_Form_empconfiguration();

		$empconfigurationform->setAttrib('action',BASE_URL.'empconfiguration/edit');

		if($this->_request->getPost()){
			if($empconfigurationform->isValid($this->_request->getPost()))
			{
				$checktype = $this->_request->getParam('checktype');
				$emptab = sapp_Global::generateEmpTabConstants($checktype);
				$this->_helper->getHelper("FlashMessenger")->addMessage($emptab);
				$this->_redirect('empconfiguration');

			}else
			{
				$messages = $empconfigurationform->getMessages();
				foreach ($messages as $key => $val)
				{
					foreach($val as $key2 => $val2)
					{
						$msgarray[$key] = $val2;
						break;
					}
				}

				$this->view->msgarray = $msgarray;
			}
		}
		if(defined('EMPTABCONFIGS'))
		{
			$empOrganizationTabs = explode(",",EMPTABCONFIGS);

			if(!$this->_request->getPost()){
				if(!empty($empOrganizationTabs)){
					$empconfigurationform->setDefaults(array('checktype'=>$empOrganizationTabs));

					$keysempConfigArray = array_keys($this->empConfigureArray);
					if(count($keysempConfigArray) == count($empOrganizationTabs)){
						$empconfigurationform->setDefault('checkall',1);
					}
				}
			}
		}
		$this->view->form = $empconfigurationform;
		$this->view->succesmsg = $this->_helper->flashMessenger->getMessages();
	}

	public function addAction()
	{
		$auth = Zend_Auth::getInstance();
		if($auth->hasIdentity()){
			$loginUserId = $auth->getStorage()->read()->id;
			$loginuserGroup = $auth->getStorage()->read()->group_id;
		}
		$empconfigurationform = new Default_Form_empconfiguration();
		$empconfigurationform->setAttrib('action',BASE_URL.'empconfiguration/add');
		if($loginuserGroup == ''){
			$checkTypeArray = array_keys($this->empConfigureArray);
		}
		if(!empty($checkTypeArray)){
			$empconfigurationform->setDefaults(array('checktype'=>$checkTypeArray));
			$empconfigurationform->setDefault('checkall',1);
		}
		$this->view->form = $empconfigurationform;
		$this->view->succesmsg = $this->_helper->flashMessenger->getMessages();

		if($this->_request->getPost()){
			if($empconfigurationform->isValid($this->_request->getPost()))
			{
				$checktype = $this->_request->getParam('checktype');
				$emptab = sapp_Global::generateEmpTabConstants($checktype);
				$this->_helper->getHelper("FlashMessenger")->addMessage($emptab);
				$this->_redirect('empconfiguration');
			}else
			{
				$messages = $empconfigurationform->getMessages();
				foreach ($messages as $key => $val)
				{
					foreach($val as $key2 => $val2)
					{
						$msgarray[$key] = $val2;
						break;
					}
				}

				$this->view->msgarray = $msgarray;
			}
		}
	}
}
