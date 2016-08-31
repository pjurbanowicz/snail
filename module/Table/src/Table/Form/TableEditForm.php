<?php
namespace Table\Form;

use Zend\Form\Form;

class TableEditForm extends Form
{
     public function __construct($name = null)
     {
         parent::__construct('table');

		 $this->setAttribute('method', 'POST');
		 
         $this->add(array(
             'name' => 'sizeROWS',
             'type' => 'hidden',
         ));
         $this->add(array(
             'name' => 'sizeCOLS',
             'type' => 'hidden',
        ));
		$this->add(array(
             'name' => 'submit',
             'type' => 'Submit',
             'attributes' => array(
                 'value' => 'Wyslij',
                 'id' => 'submitbutton',
				 'class' => 'btn btn-primary btn-block'
             ),
         ));
		
     }
 }
 ?>