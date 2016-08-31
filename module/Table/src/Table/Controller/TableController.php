<?php
namespace Table\Controller;

 use Zend\Mvc\Controller\AbstractActionController;
 use Zend\View\Model\ViewModel;
 use Table\Model\Table;          
 use Table\Form\TableForm;       
 use Table\Form\TableEditForm;       

 class TableController extends AbstractActionController
 {
    public function indexAction() //akcja pierwszego formularza
    {
        $form = new TableForm();

        return array('form' => $form);
    }

     public function editAction() //akcja drugiego formularza
     {
		$request = $this->getRequest();
         if ($request->isPost()) {
			
			$POSTtable=$this->getRequest()->getPost(); //pobranie tablicy $_POST
			
		 if($POSTtable['sizeROWS']<=50 && $POSTtable['sizeROWS']>0 &&
			$POSTtable['sizeCOLS']<=50 && $POSTtable['sizeCOLS']>0) 
			{
				$table=new Table($POSTtable['sizeROWS'],$POSTtable['sizeCOLS']);
				
				$table->fill();

				$form = new TableEditForm();

				for($i=0;$i<$POSTtable['sizeROWS'];$i++) //generowanie formularza
					for($j=0;$j<$POSTtable['sizeCOLS'];$j++) 
						$form->add(array(
						'name' => $i.'_'.$j, //nazwa pola w postaci wiersz_kolumna
						'type' => 'text',
						'attributes' => array(
							'value' => $table->getValue($i,$j),
							'class'=>'form-control',
							),
						));
						
				$form->get('sizeROWS')->setValue($POSTtable['sizeROWS']); //ustawienie ukrytego pola: liczba wierszy
				$form->get('sizeCOLS')->setValue($POSTtable['sizeCOLS']); //ustawienie ukrytego pola: liczba kolumn
				return array('form' => $form);
			}
			else return array('error' => '1');
         }
		 else return $this->redirect()->toRoute('table'); //jezeli formularz nie zostal przeslany przekieruj na /table/
     }

     public function printAction() //akcja koncowej strony
     {
		$request = $this->getRequest();
		if ($request->isPost()) 
		{
			$POSTtable=$this->getRequest()->getPost();
			
			$table=new Table($POSTtable['sizeROWS'],$POSTtable['sizeCOLS']);
			
			$table->update($POSTtable); //wypelnienie tablicy danymi z $_POST
			
			$table->snail(); //generowanie slimaka
			$snail = $table->getSnail();
			
			return array('table'=>$table->getTable(), //przeslanie tablicy, slimaka i rozmiaru tablicy do wyswietlenia
				'snail'=>$snail,
				'sizeROWS'=>$POSTtable['sizeROWS'],
				'sizeCOLS'=>$POSTtable['sizeCOLS']);
		
		}
		else return $this->redirect()->toRoute('table'); //jezeli formularz nie zostal przeslany przekieruj na /table/
     }
 }
 ?>