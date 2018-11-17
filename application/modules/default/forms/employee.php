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

class Default_Form_employee extends Zend_Form
{
	public function init()
	{
		$this->setMethod('post');
		$this->setAttrib('action',BASE_URL.'employee/add');
		$this->setAttrib('id', 'formid');
		$this->setAttrib('name', 'employee');
		$controller_name = Zend_Controller_Front::getInstance()->getRequest()->getControllerName();
		$id = new Zend_Form_Element_Hidden('id');
		$id_val = Zend_Controller_Front::getInstance()->getRequest()->getParam('id',null);
        $userid = new Zend_Form_Element_Hidden('user_id');
		$final_emp_id = new Zend_Form_Element_Hidden('final_emp_id');

		$reportingmanager = new Zend_Form_Element_Select('reporting_manager');
		$reportingmanager->addMultiOption('','Seleccione Gerente de Informes');
		$reportingmanager->setRegisterInArrayValidator(false);
        if($controller_name != 'organisationinfo')
        {
            $reportingmanager->setRequired(true);
            $reportingmanager->addValidator('NotEmpty', false, array('messages' => 'Por favor seleccione el administrador de informes.'));
        }
		$reportingmanager->addValidator(new Zend_Validate_Db_RecordExists(
										array('table' => 'main_users',
                                        		'field' => 'id',
                                                'exclude'=>'isactive = 1',
										)));
		$reportingmanager->getValidator('Db_RecordExists')->setMessage('El administrador de informes seleccionado está desactivado.');

		$emproleStr = Zend_Controller_Front::getInstance()->getRequest()->getParam('emprole',null);

		$empstatus = new Zend_Form_Element_Select('emp_status_id');
		$empstatus->setAttrib('onchange', 'displayempstatusmessage()');
		$empstatus->setRegisterInArrayValidator(false);
        if($controller_name != 'organisationinfo')
        {
            $empstatus->setRequired(true);
            $empstatus->addValidator('NotEmpty', false, array('messages' => 'Por favor seleccione el estado de empleo.'));
        }
        $empstatus->addValidator(new Zend_Validate_Db_RecordExists(
                                                        array('table' => 'main_employmentstatus',
                                                        'field' => 'workcodename',
                                                        'exclude'=>'isactive = 1',
                                                        )));
        $empstatus->getValidator('Db_RecordExists')->setMessage('Se elimina el estado de empleo seleccionado.');

		$businessunit = new Zend_Form_Element_Select('businessunit_id');
		$businessunit->setAttrib('onchange', 'displayEmployeeDepartments(this,"department_id","")');
		$businessunit->addValidator(new Zend_Validate_Db_RecordExists(
										array('table' => 'main_businessunits',
                                        		'field' => 'id',
                                                'exclude'=>'isactive = 1',
										)));
		$businessunit->getValidator('Db_RecordExists')->setMessage('Se elimina la unidad de negocio seleccionada.');

		$department = new Zend_Form_Element_Select('department_id');
		$department->addMultiOption('','Por favor seleccione el departamento.');
		$department->setRegisterInArrayValidator(false);
        $roleArr=array();
        if($controller_name != 'organisationinfo')
        {
            //For management 'department is not manditory'......
            if($emproleStr != "" )
            {
                $roleArr = explode('_',$emproleStr);
                if(!empty($roleArr))
                {
                    if(isset($roleArr[1]) && $roleArr[1] != MANAGEMENT_GROUP)
                    {
                        $department->setRequired(true);
                        $department->addValidator('NotEmpty', false, array('messages' => 'Por favor seleccione el departamento.'));
                    }
                }
            }else
            {
            		$department->setRequired(true);
                    $department->addValidator('NotEmpty', false, array('messages' => 'Por favor seleccione el departamento.'));

            }
        }

		$department->setAttrib("onchange", "displayReportingmanagers_emp('department_id','reporting_manager','emprole','id')");
		$department->addValidator(new Zend_Validate_Db_RecordExists(
										array('table' => 'main_departments',
                                        		'field' => 'id',
                                                'exclude'=>'isactive = 1',
										)));
		$department->getValidator('Db_RecordExists')->setMessage('Se elimina el departamento seleccionado.');

		$jobtitle = new Zend_Form_Element_Select('jobtitle_id');
		$jobtitle->setLabel("Título Profesional");
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
		$position->setLabel("Posición");
		$position->addMultiOption('','Seleccionar posición');
		$position->setRegisterInArrayValidator(false);
		$position->addValidator(new Zend_Validate_Db_RecordExists(
										array('table' => 'main_positions',
                                        		'field' => 'id',
                                                'exclude'=>'isactive = 1',
										)));
		$position->getValidator('Db_RecordExists')->setMessage('Se elimina la posición seleccionada.');

		$prefix_id = new Zend_Form_Element_Select('prefix_id');
		$prefix_id->addMultiOption('','Seleccione Prefijo');
		$prefix_id->setLabel("Prefijo");
		$prefix_id->setRegisterInArrayValidator(false);
		$prefix_id->addValidator(new Zend_Validate_Db_RecordExists(
										array('table' => 'main_prefix',
                                        		'field' => 'id',
                                                'exclude'=>'isactive = 1',
										)));
		$prefix_id->getValidator('Db_RecordExists')->setMessage('Se elimina el prefijo seleccionado.');

		$extension_number = new Zend_Form_Element_Text('extension_number');
		$extension_number->setAttrib('maxLength', 4);
		$extension_number->setLabel("Extensión");
		$extension_number->addFilter(new Zend_Filter_StringTrim());
		$extension_number->addValidator("regex",true,array(
                           'pattern'=>'/^[0-9]+$/',
                           'messages'=>array(
                               'regexNotMatch'=>'Por favor, introduzca sólo los números.'
                           )
        	));

	    $office_number = new Zend_Form_Element_Text('office_number');
        $office_number->setAttrib('maxLength', 10);

		$office_number->setLabel("Número de teléfono del trabajo");
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

		$yearsofexp = new Zend_Form_Element_Text('years_exp');
		$yearsofexp->setAttrib('maxLength', 2);
		$yearsofexp->addFilter(new Zend_Filter_StringTrim());
		$yearsofexp->addValidator("regex",true,array(
						  'pattern'=>'/^[0-9]\d{0,1}(\.\d*)?$/',
                           'messages'=>array(
                               'regexNotMatch'=>'Por favor, introduzca sólo los números'
                           )
        	));

		$date_of_joining = new ZendX_JQuery_Form_Element_DatePicker('date_of_joining');
        $date_of_joining->setLabel("Fecha de Ingreso");
		$date_of_joining->setOptions(array('class' => 'brdr_none'));
		$date_of_joining->setAttrib('onchange', 'validatejoiningdate(this)');
		$date_of_joining->setRequired(true);
		$date_of_joining->setAttrib('readonly', 'true');
		$date_of_joining->setAttrib('onfocus', 'this.blur()');
        $date_of_joining->addValidator('NotEmpty', false, array('messages' => 'Por favor seleccione la fecha de ingreso.'));

        $date_of_leaving = new ZendX_JQuery_Form_Element_DatePicker('date_of_leaving');
		$date_of_leaving->setOptions(array('class' => 'brdr_none'));
        $date_of_leaving->setAttrib('onchange', 'validateleavingdate(this)');
		$date_of_leaving->setAttrib('readonly', 'true');
		$date_of_leaving->setAttrib('onfocus', 'this.blur()');

		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setAttrib('id', 'submitbutton');
		$submit->setAttrib('onclick', 'saveEmployee()');
		$submit->setLabel('Save');

                //fields from user management
                //for emp code
                //formulario de nuevo empleado
                $employeeId = new Zend_Form_Element_Text("employeeId");
                $employeeId->setRequired("true");
                $employeeId->setLabel("Código de Empleado");
                $employeeId->setAttrib("class", "formDataElement");
                $employeeId->setAttrib("readonly", "readonly");
				$employeeId->setAttrib('onfocus', 'this.blur()');
				$employeeId->addValidator('NotEmpty', false, array('messages' => 'Los códigos de identidad aún no están configurados.'));
                //creacion de nuevo empleado
                //for emp id
                $employeeNumId = new Zend_Form_Element_Text("employeeNumId");
                //$employeeNumId->setRequired("true");
                $employeeNumId->setLabel("Id Empleado");
                $employeeNumId->setAttrib('maxLength', 15);
                $employeeNumId->setAttrib("class", "formDataElement");
                //$employeeNumId->addValidator('NotEmpty', false, array('messages' => 'Por favor ingrese el ID del empleado.'));
                /*$employeeNumId->addValidator("regex",true,array(
                           'pattern'=>'/^[0-9]+$/',
                           'messages'=>array(
                               'regexNotMatch'=>'Please enter only numbers.'
                           )));*/

/*                $final_emp_id->addValidator(new Zend_Validate_Db_NoRecordExists(
                                                                array('table' => 'main_users',
                                                                'field' => 'employeeId',
                                                                'exclude'=>'id!="'.Zend_Controller_Front::getInstance()->getRequest()->getParam('user_id',0).'" ',
                                                                )));
                $final_emp_id->getValidator('Db_NoRecordExists')->setMessage('Employee ID already exists. Please try again11.');*/

                /*$userfullname = new Zend_Form_Element_Text("userfullname");
                $userfullname->setLabel("Full Name");
                $userfullname->setAttrib("class", "formDataElement");
                $userfullname->setAttrib('maxlength', 50);*/

                $first_name = new Zend_Form_Element_Text("firstname");
                $first_name->setLabel("Nombre");
                $first_name->setAttrib("class", "formDataElement");
                $first_name->setAttrib('maxlength', 50);

                $last_name = new Zend_Form_Element_Text("lastname");
                $last_name->setLabel("Apellidos");
                $last_name->setAttrib("class", "formDataElement");
                $last_name->setAttrib('maxlength', 50);

                $other_modeofentry = new Zend_Form_Element_Text("other_modeofentry");
                $other_modeofentry->setLabel("Modo de Empleo (Otro)");
                $other_modeofentry->setAttrib("class", "formDataElement");
                $other_modeofentry->setAttrib('maxlength', 50);

                $modeofentry = new Zend_Form_Element_Select("modeofentry");
                $modeofentry->setLabel("Modo de Empleo")
                            ->addMultiOptions(array('' => 'Seleccione el modo de entrada',
													'Direct' => 'Directo',
													'Interview' => 'Entrevista',
													'Other' => 'Otro',
                                                    'Reference' => 'Referencia'
                                                    ));
                $modeofentry->setAttrib("class", "formDataElement");
                if($controller_name != 'organisationinfo')
                {
                    if($id_val == '')
                    {
                        $modeofentry->setRequired(true);
                        $modeofentry->addValidator('NotEmpty', false, array('messages' => 'Por favor, seleccione el modo de empleo.'));
                    }
                }
                $candidatereferredby = new Zend_Form_Element_Select("candidatereferredby");
                $candidatereferredby->setRegisterInArrayValidator(false);
                $candidatereferredby->setLabel("Referred By");
                $candidatereferredby->setAttrib("class", "formDataElement");

                $rccandidatename = new Zend_Form_Element_Select("rccandidatename");
                $rccandidatename->setRegisterInArrayValidator(false);
                $rccandidatename->setLabel("Candidate Name");
                $rccandidatename->setAttrib("class", "formDataElement");
                $rccandidatename->setAttrib("onchange", "disp_requisition(this.value,'disp_requi')");

                $emailaddress = new Zend_Form_Element_Text("emailaddress");
                $modeofentry_val = Zend_Controller_Front::getInstance()->getRequest()->getParam('modeofentry',null);
                $hid_modeofentry_val = Zend_Controller_Front::getInstance()->getRequest()->getParam('hid_modeofentry',null);
                if($modeofentry_val!='' || $hid_modeofentry_val !='')
                {
                    if($modeofentry_val == 'Direct' || $hid_modeofentry_val == 'Direct')
                    {
                        /*$userfullname->setRequired(true);
                        $userfullname->addValidator('NotEmpty', false, array('messages' => 'Please enter full name.'));*/

                        $first_name->setRequired(true);
                        $first_name->addValidator('NotEmpty', false, array('messages' => 'Por favor ingrese el nombre.'));

                        $last_name->setRequired(true);
                        $last_name->addValidator('NotEmpty', false, array('messages' => 'Por favor ingrese los apellidos.'));
                    }
                    else if($modeofentry_val == 'Other' || $hid_modeofentry_val == 'Direct')
                    {
                        $other_modeofentry->setRequired(true);
                        $other_modeofentry->addValidator('NotEmpty', false, array('messages' => 'Por favor ingrese el modo de empleo (Otro).'));

                        $rccandidatename->setRequired(true);
                        $rccandidatename->addValidator('NotEmpty', false, array('messages' => 'Por favor seleccione el nombre del candidato.'));
                    }
                    else if($modeofentry_val == 'Reference' || $hid_modeofentry_val == 'Direct')
                    {
                        $candidatereferredby->setRequired(true);
                        $candidatereferredby->addValidator('NotEmpty', false, array('messages' => 'Por favor seleccione referido por.'));

                        $rccandidatename->setRequired(true);
                        $rccandidatename->addValidator('NotEmpty', false, array('messages' => 'Por favor seleccione el nombre del candidato.'));
                    }
                    else
                    {
					    $empid = Zend_Controller_Front::getInstance()->getRequest()->getParam('id',null);
						if($empid == '')
						{
							$rccandidatename->setRequired(true);
							$rccandidatename->addValidator('NotEmpty', false, array('messages' => 'Por favor seleccione el nombre del candidato.'));
						}
                    }
                }
				else{

						$first_name->setRequired(true);
                        $first_name->addValidator('NotEmpty', false, array('messages' => 'Por favor ingrese el nombre.'));

                        $last_name->setRequired(true);
                        $last_name->addValidator('NotEmpty', false, array('messages' => 'Por favor ingrese los apellidos.'));
				}
                /*$userfullname->addValidator("regex",true,array(
                                   'pattern'=>'/^([a-zA-Z.]+ ?)+$/',
                                   'messages'=>array(

									   'regexNotMatch'=>'Please enter only alphabets.'
                                   )
                        ));*/

                $first_name->addValidator("regex",true,array(
                                   'pattern'=>'/^([a-zA-Z.]+ ?)+$/',
                                   'messages'=>array(

									   'regexNotMatch'=>'Por favor, introduzca sólo alfabetos.'
                                   )
                        ));

                $last_name->addValidator("regex",true,array(
                                   'pattern'=>'/^([a-zA-Z.]+ ?)+$/',
                                   'messages'=>array(

									   'regexNotMatch'=>'Por favor, introduzca sólo alfabetos.'
                                   )
                        ));

                $other_modeofentry->addValidator("regex",true,array(
                                   'pattern'=>'/^([a-zA-Z.]+ ?)+$/',
                                   'messages'=>array(

									    'regexNotMatch'=>'Por favor, introduzca sólo alfabetos.'
                                   )
                        ));

                $emailaddress->setRequired(true);
                $emailaddress->addValidator('NotEmpty', false, array('messages' => 'Por favor ingrese el correo.'));

                $emailaddress->addValidator("regex",true,array(

						    'pattern'=>'/^(?!.*\.{2})[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/',
                           'messages'=>array(
                               'regexNotMatch'=>'Por favor ingrese un correo valido.'
                           )
        	    ));

                $emailaddress->setLabel("Correo");
                $emailaddress->setAttrib("class", "formDataElement");
                $emailaddress->addValidator(new Zend_Validate_Db_NoRecordExists(
                                                                array('table' => 'main_users',
                                                                'field' => 'emailaddress',
                                                                'exclude'=>'id!="'.Zend_Controller_Front::getInstance()->getRequest()->getParam('user_id',0).'" ',
                                                                )));
                $emailaddress->getValidator('Db_NoRecordExists')->setMessage('Correo ya existe.');

                $role_id = '';
                if($emproleStr)
                {
                	$rolArr = explode('_',$emproleStr);
                 	if(!empty($rolArr))
                    {
                    	if(isset($rolArr[0]))
                    		$role_id = $rolArr[0];
                    }
                }

                $emprole = new Zend_Form_Element_Select("emprole");
                $emprole->setRegisterInArrayValidator(false);
                $emprole->setRequired(true);
				$emprole->setLabel("Rol");
                $emprole->setAttrib("class", "formDataElement");
                $emprole->addValidator('NotEmpty', false, array('messages' => 'Selecione Rol'));
                $emprole->addValidator(new Zend_Validate_Db_RecordExists(
										array('table' => 'main_roles',
                                        		'field' => 'id',
                                                'exclude'=>'isactive = 1 and id="'.$role_id.'" ',
										)));
				$emprole->getValidator('Db_RecordExists')->setMessage('Se elimina el rol seleccionado.');

                $hid_modeofentry = new Zend_Form_Element_Hidden('hid_modeofentry');
                $hid_rccandidatename = new Zend_Form_Element_Hidden('hid_rccandidatename');
                $act_inact = new Zend_Form_Element_Checkbox("act_inact");

                $disp_requi = new Zend_Form_Element_Text('disp_requi');
                $disp_requi->setAttrib('readonly', 'readonly');
				$disp_requi->setAttrib('onfocus', 'this.blur()');
                //end of fields from user management




		$this->addElements(array($id,$userid,$reportingmanager,$empstatus,$businessunit,$department,$jobtitle,
                                         $position,$prefix_id,$extension_number,$office_number,$office_faxnumber,$yearsofexp,$date_of_joining,$date_of_leaving,$submit,$employeeId,
                                         $modeofentry,$candidatereferredby,$rccandidatename,$emailaddress,
                                         $emprole,$hid_modeofentry,$hid_rccandidatename,$other_modeofentry,$act_inact,
                                         $disp_requi,$first_name,$last_name,$employeeNumId,$final_emp_id));
                $this->setElementDecorators(array('ViewHelper'));
                $this->setElementDecorators(array(
                    'UiWidgetElement',
        ),array('date_of_joining','date_of_leaving'));
	}
}
