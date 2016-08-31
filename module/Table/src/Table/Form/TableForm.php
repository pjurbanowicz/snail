<?php
namespace Table\Form;

use Zend\Form\Form;

class TableForm extends Form
{
     public function __construct($name = null)
     {
         parent::__construct('table');

		 $this->setAttribute('method', 'POST');
		 
         $this->add(array(
             'name' => 'sizeROWS',
             'type' => 'Text',
			 'options' => array(
                 'label' => 'Liczba wierszy',
				),
			 'attributes' => array(
				'class'=>'form-control',
			 ),
         ));
         $this->add(array(
             'name' => 'sizeCOLS',
             'type' => 'Text',
			  'options' => array(
                 'label' => 'Liczba kolumn',
             ),
			 'attributes' => array(
				'class'=>'form-control'   
			 )
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