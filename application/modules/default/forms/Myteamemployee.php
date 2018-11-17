<?php
/*********************************************************************************
 *  This file is part of Sentrifugo.
 *  Copyright (C) 2014 Sapplica
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

class Default_Form_Myteamemployee extends Zend_Form
{
	public function init()
	{
		$this->setMethod('post');
		$this->setAttrib('action',BASE_URL.'myemployees/add');
		$this->setAttrib('id', 'formid');
		$this->setAttrib('name', 'myteamemployee');
		$controller_name = Zend_Controller_Front::getInstance()->getRequest()->getControllerName();
		$id = new Zend_Form_Element_Hidden('id');
		$id_val = Zend_Controller_Front::getInstance()->getRequest()->getParam('id',null);
		$userid = new Zend_Form_Element_Hidden('user_id');

                //for emp code
                $employeeId = new Zend_Form_Element_Text("employeeId");
                $employeeId->setRequired("true");
                $employeeId->setLabel("Código de Empleado");
                $employeeId->setAttrib("class", "formDataElement");
                $employeeId->setAttrib("readonly", "readonly");
				$employeeId->setAttrib('onfocus', 'this.blur()');
				$employeeId->addValidator('NotEmpty', false, array('messages' => 'Los códigos de identidad aún no están configurados.'));

                //for emp id
                $employeeNumId = new Zend_Form_Element_Text("employeeNumId");
                $employeeNumId->setRequired("true");
                $employeeNumId->setLabel("Id Empleado");
                $employeeNumId->setAttrib('maxLength', 5);
                $employeeNumId->setAttrib("class", "formDataElement");
                $employeeNumId->addValidator('NotEmpty', false, array('messages' => 'Por favor ingrese el Id Empleado.'));
                $employeeNumId->addValidator("regex",true,array(
                           'pattern'=>'/^[0-9]+$/',
                           'messages'=>array(
                               'regexNotMatch'=>'Por favor, introduzca sólo los números.'
                           )));

				/*$employeeId = new Zend_Form_Element_Text("employeeId");
                $employeeId->setRequired("true");
                $employeeId->setLabel("Employee ID");
                $employeeId->setAttrib("class", "formDataElement");
                $employeeId->setAttrib("readonly", "readonly");
				$employeeId->setAttrib('onfocus', 'this.blur()');

				$employeeId->addValidator('NotEmpty', false, array('messages' => 'Identity codes are not configured yet.'));
				$employeeId->addValidator(new Zend_Validate_Db_NoRecordExists(
                                                                array('table' => 'main_users',
                                                                'field' => 'employeeId',
                                                                'exclude'=>'id!="'.Zend_Controller_Front::getInstance()->getRequest()->getParam('user_id',0).'" ',
                                                                )));
                $employeeId->getValidator('Db_NoRecordExists')->setMessage('Employee ID already exists. Please try again.');*/

		$prefix_id = new Zend_Form_Element_Select('prefix_id');
		$prefix_id->addMultiOption('','Select Prefix');
		$prefix_id->setLabel("Prefijo");
		$prefix_id->setRegisterInArrayValidator(false);
		$prefix_id->addValidator(new Zend_Validate_Db_RecordExists(
										array('table' => 'main_prefix',
                                        		'field' => 'id',
                                                'exclude'=>'isactive = 1',
										)));
		$prefix_id->getValidator('Db_RecordExists')->setMessage('Se elimina el prefijo seleccionado.');

				$first_name = new Zend_Form_Element_Text("firstname");
                $first_name->setLabel("Nombre");
               	$first_name->setRequired(true);
               	$first_name->addValidator('NotEmpty', false, array('messages' => 'Por favor introduzca el nombre.'));
                $first_name->setAttrib("class", "formDataElement");
                $first_name->setAttrib('maxlength', 50);
                $first_name->addValidator("regex",true,array(
                                   'pattern'=>'/^([a-zA-Z.]+ ?)+$/',
                                   'messages'=>array(
									   'regexNotMatch'=>'Por favor, introduzca sólo los alfabetos.'
                                   )
                        ));

                $last_name = new Zend_Form_Element_Text("lastname");
                $last_name->setLabel("Apellidos");
                $last_name->setRequired(true);
                $last_name->addValidator('NotEmpty', false, array('messages' => 'Por favor ingrese los apellidos.'));
                $last_name->setAttrib("class", "formDataElement");
                $last_name->setAttrib('maxlength', 50);
                $last_name->addValidator("regex",true,array(
                                   'pattern'=>'/^([a-zA-Z.]+ ?)+$/',
                                   'messages'=>array(
									   'regexNotMatch'=>'Por favor, introduzca sólo los alfabetos.'
                                   )
                        ));

				$modeofentry = new Zend_Form_Element_Select("modeofentry");
                $modeofentry->setLabel("Modo de Empleo")
                            ->addMultiOptions(array(
													'Direct' => 'Direct',
                                                    ));
                $modeofentry->setAttrib("class", "formDataElement");
                if($id_val == ''){
					$modeofentry->setRequired(true);
                	$modeofentry->addValidator('NotEmpty', false, array('messages' => 'Por favor, seleccione el modo de empleo.'));
                }

				$emprole = new Zend_Form_Element_Select("emprole");
                $emprole->setRegisterInArrayValidator(false);
                $emprole->setRequired(true);
				$emprole->setLabel("Rol");
                $emprole->setAttrib("class", "formDataElement");
                $emprole->addValidator('NotEmpty', false, array('messages' => 'Por favor seleccione rol'));
                $emprole->addValidator(new Zend_Validate_Db_RecordExists(
										array('table' => 'main_roles',
                                        		'field' => 'id',
                                                'exclude'=>'isactive = 1',
										)));
				$emprole->getValidator('Db_RecordExists')->setMessage('Se elimina el rol seleccionado.');

                $emailaddress = new Zend_Form_Element_Text("emailaddress");
				$emailaddress->setRequired(true);
                $emailaddress->addValidator('NotEmpty', false, array('messages' => 'Por favor ingrese el correo.'));
                $emailaddress->addValidator("regex",true,array(
						    'pattern'=>'/^(?!.*\.{2})[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/',
                           'messages'=>array(
                               'regexNotMatch'=>'Por favor ingrese un correo válido'
                           )
        	    ));
        		$emailaddress->setLabel("Email");
                $emailaddress->setAttrib("class", "formDataElement");
                $emailaddress->addValidator(new Zend_Validate_Db_NoRecordExists(
                                                                array('table' => 'main_users',
                                                                'field' => 'emailaddress',
                                                                'exclude'=>'id!="'.Zend_Controller_Front::getInstance()->getRequest()->getParam('user_id',0).'" ',
                                                                )));
                $emailaddress->getValidator('Db_NoRecordExists')->setMessage('Correo ya existe');

		$businessunit = new Zend_Form_Element_Select('businessunit_id');
		$businessunit->setRegisterInArrayValidator(false);
		$businessunit->addValidator(new Zend_Validate_Db_RecordExists(
										array('table' => 'main_businessunits',
                                        		'field' => 'id',
                                                'exclude'=>'isactive = 1',
										)));
		$businessunit->getValidator('Db_RecordExists')->setMessage('Se elimina la unidad de negocio seleccionada.');

		$department = new Zend_Form_Element_Select('department_id');
		$department->setRegisterInArrayValidator(false);
		$department->setRequired(true);
		$department->addValidator('NotEmpty', false, array('messages' => 'Por favor seleccione el departamento.'));
		$department->addValidator(new Zend_Validate_Db_RecordExists(
										array('table' => 'main_departments',
                                        		'field' => 'id',
                                                'exclude'=>'isactive = 1',
										)));
		$department->getValidator('Db_RecordExists')->setMessage('Se elimina el departamento seleccionado.');

		$reportingmanager = new Zend_Form_Element_Select('reporting_manager');
		$reportingmanager->setRegisterInArrayValidator(false);
		$reportingmanager->setRequired(true);
        $reportingmanager->addValidator('NotEmpty', false, array('messages' => 'Por favor seleccione el administrador de informes.'));
        $reportingmanager->addValidator(new Zend_Validate_Db_RecordExists(
										array('table' => 'main_users',
                                        		'field' => 'id',
                                                'exclude'=>'isactive = 1',
										)));
		$reportingmanager->getValidator('Db_RecordExists')->setMessage('El administrador de informes seleccionado está desactivado.');

        $jobtitle = new Zend_Form_Element_Select('jobtitle_id');
		$jobtitle->setLabel("Job Title");
        $jobtitle->addMultiOption('','Seleccione el título del trabajo');
		$jobtitle->setAttrib('onchange', 'displayPositions(this,"position_id","")');
		$jobtitle->setRegisterInArrayValidator(false);
		$jobtitle->addValidator(new Zend_Validate_Db_RecordExists(
										array('table' => 'main_jobtitles',
                                        		'field' => 'id',
                                                'exclude'=>'isactive = 1',
										)));
		$jobtitle->getValidator('Db_RecordExists')->setMessage('Se elimina el título del trabajo seleccionado.');

		$position = new Zend_Form_Element_Select('position_id');
        $position->setLabel("Position");
		$position->addMultiOption('','Seleccionar posición');
		$position->setRegisterInArrayValidator(false);
		$position->addValidator(new Zend_Validate_Db_RecordExists(
										array('table' => 'main_positions',
                                        		'field' => 'id',
                                                'exclude'=>'isactive = 1',
										)));
		$position->getValidator('Db_RecordExists')->setMessage('Se elimina la posición seleccionada.');

		$empstatus = new Zend_Form_Element_Select('emp_status_id');
		$empstatus->setAttrib('onchange', 'displayempstatusmessage()');
		$empstatus->setRegisterInArrayValidator(false);
		$empstatus->setRequired(true);
        $empstatus->addValidator('NotEmpty', false, array('messages' => 'Por favor seleccione el estado de empleo.'));
        $empstatus->addValidator(new Zend_Validate_Db_RecordExists(
                                                                array('table' => 'main_employmentstatus',
                                                                'field' => 'workcodename',
                                                                'exclude'=>'isactive = 1',
                                                                )));
     	$empstatus->getValidator('Db_RecordExists')->setMessage('Se elimina el estado de empleo seleccionado.');

        $date_of_joining = new ZendX_JQuery_Form_Element_DatePicker('date_of_joining');
		$date_of_joining->setLabel("Fecha de Ingreso");
		$date_of_joining->setOptions(array('class' => 'brdr_none'));
		$date_of_joining->setAttrib('onchange', 'validatejoiningdate(this)');
		$date_of_joining->setRequired(true);
		$date_of_joining->setAttrib('readonly', 'true');
		$date_of_joining->setAttrib('onfocus', 'this.blur()');
        $date_of_joining->addValidator('NotEmpty', false, array('messages' => 'Por favor, introduzca la fecha de ingreso'));

        $date_of_leaving = new ZendX_JQuery_Form_Element_DatePicker('date_of_leaving');
		$date_of_leaving->setOptions(array('class' => 'brdr_none'));
          $date_of_leaving->setAttrib('onchange', 'validateleavingdate(this)');
		$date_of_leaving->setAttrib('readonly', 'true');
		$date_of_leaving->setAttrib('onfocus', 'this.blur()');

		$yearsofexp = new Zend_Form_Element_Text('years_exp');
		$yearsofexp->setAttrib('maxLength', 2);
		$yearsofexp->addFilter(new Zend_Filter_StringTrim());
		$yearsofexp->addValidator("regex",true,array(
						  'pattern'=>'/^[0-9]\d{0,1}(\.\d*)?$/',
                           'messages'=>array(
                               'regexNotMatch'=>'Por favor, introduzca sólo números.'
                           )
        	));

		$extension_number = new Zend_Form_Element_Text('extension_number');
		$extension_number->setAttrib('maxLength', 4);
		$extension_number->setLabel("Extensión");
		$extension_number->addFilter(new Zend_Filter_StringTrim());
		$extension_number->addValidator("regex",true,array(
                           'pattern'=>'/^[0-9]+$/',
                           'messages'=>array(
                               'regexNotMatch'=>'Por favor, introduzca sólo números.'
                           )
        	));

	    $office_number = new Zend_Form_Element_Text('office_number');
        $office_number->setAttrib('maxLength', 10);
		$office_number->setLabel("Número de Teléfono del Trabajo");
        $office_number->addFilter(new Zend_Filter_StringTrim());
		$office_number->addValidator("regex",true,array(
                           'pattern'=>'/^(?!0{10})[0-9\+\-\)\(]+$/',
                           'messages'=>array(
                               'regexNotMatch'=>'Por favor, introduzca un número de teléfono válido.'
                           )
        	));

		$office_faxnumber = new Zend_Form_Element_Text('office_faxnumber');
        $office_faxnumber->setAttrib('maxLength', 15);
		$office_faxnumber->setLabel("Fax");
        $office_faxnumber->addFilter(new Zend_Filter_StringTrim());
		$office_faxnumber->addValidator("regex",true,array(
                           'pattern'=>'/^[0-9\+\-\)\(]+$/',
                           'messages'=>array(
							  'regexNotMatch'=>'Por favor, introduzca un número de fax válido.'
                           )
        	));

		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setAttrib('id', 'submitbutton');
		$submit->setLabel('Guardar');

		$this->addElements(array($id,$userid,$reportingmanager,$empstatus,$businessunit,$department,$jobtitle,$position,$prefix_id,$extension_number,$office_number,$office_faxnumber,$yearsofexp,$date_of_joining,$date_of_leaving,$submit,$employeeId,$modeofentry,$emailaddress,$emprole,$first_name,$last_name,$employeeNumId));
                $this->setElementDecorators(array('ViewHelper'));
                $this->setElementDecorators(array(
                    'UiWidgetElement',
        ),array('date_of_joining','date_of_leaving'));
	}
}
