<?php
class MototechnicsController extends AppController {
    var $helpers = array ('Html','Form');
    var $name = 'Mototechnics';
		
	function _load_img ($oldimg, $optype) {		
		$fld_name = 'moto/';	
		$wrongformat = false;
		$file = $this->data['Mototechnic']['img'];
			if (!empty($file['name'])) { //����������� ������� ��� �������� 
				if (($file['type'] != 'image/jpeg')&&
				   ($file['type'] != 'image/gif')&&
				   ($file['type'] != 'image/png')) {
					$wrongformat = true;
				} 
				elseif ($file['error'] == 0) {
					if (!preg_match('/^[A-Za-z_0-9]+\.[A-Za-z]{3}$/',$file['name'],$fullname)) {
						$fullname[0] = str_replace('.','',strval(microtime(1))).substr($file['name'],-4);
					}
					$this->data['Mototechnic']['img'] = $fld_name.$fullname[0];			
					$f = file_get_contents($file['tmp_name']);
					file_put_contents(IMAGES.$this->data['Mototechnic']['img'],$f);
                    if (!empty($oldimg)) @unlink(IMAGES.$oldimg); // �������� ������� �����������					
				} else $this->Session->setFlash('������ ��� �������� �����������');  
				} else 	$this->data['Mototechnic']['img'] = $oldimg; // ��������� ������ �����������			
						
		//	print_r($this->data['Video']);
			if ($wrongformat) $this->Session->setFlash('������������ ������ �����������. ��������� �������: JPEG, GIF, PNG');
				elseif ($this->Mototechnic->saveAll($this->data, array('deep' => true))) {
					if ($optype === 'add') {
						//�������� -> do nothing

					}
				    if ($optype === 'add') $this->Session->setFlash('������ ������� ���������');
					if ($optype === 'edit') $this->Session->setFlash('������ ������� ���������');
					$this->redirect(array('controller' => 'users', 'admin'=> true, 'action' => 'index'));         
					return true;
				}
	}
	
	
    function index()  {
		
    }
	
	function scooters($company = null)  {
		if ($company != null) {
			$scooters = $this->Mototechnic->find('all',  array('conditions' => array('type' => 'scooter', 'company' => $company), 'order' => array('weight', 'date_add')));
			$this->set('thiscrumb','1');
		}
		else $scooters = $this->Mototechnic->find('all',  array('conditions' => array('type' => 'scooter', 'NOT' => array('Mototechnic.company' => array('omaks', 'hors'))), 'order' => array('company', 'weight', 'date_add')));
    foreach ($scooters as &$m) {
		  $m['Mototechnic']['short_txt']= $this->_decode_from_db($m['Mototechnic']['short_txt']);
			$m['Mototechnic']['full_txt']= $this->_decode_from_db($m['Mototechnic']['full_txt']);
		}
		$this->set('scooters',$scooters);
		$this->set('companies',$this->Mototechnic->query("SELECT distinct company FROM mototechnics WHERE type ='scooter' && company NOT IN ('omaks', 'hors') ORDER BY company ASC;"));
		$this->_setmeta('scooter');
	}
	
	function mopeds($company = null)  { 
		if ($company != null) {
			$mopeds = $this->Mototechnic->find('all',  array('conditions' => array('type' =>'moped', 'company' => $company), 'order' => array('weight', 'date_add')));
			$this->set('thiscrumb','1');
		}
		else 	$mopeds = $this->Mototechnic->find('all',  array('conditions' => array('type' => 'moped', 'NOT' => array('Mototechnic.company' => array('omaks', 'hors'))), 'order' => array('company', 'weight', 'date_add')));
		foreach ($mopeds as &$m) {
		  $m['Mototechnic']['short_txt']= $this->_decode_from_db($m['Mototechnic']['short_txt']);
			$m['Mototechnic']['full_txt']= $this->_decode_from_db($m['Mototechnic']['full_txt']);
		} 
		$this->set('mopeds',$mopeds );
				$this->set('companies',$this->Mototechnic->query("SELECT distinct company FROM mototechnics WHERE type = 'moped' && company NOT IN ('omaks', 'hors')  ORDER BY company ASC;"));

		$this->_setmeta('moped');
	}
	
	function motorcycles($company = null)  {
		if ($company != null) {
			$motorcycles = $this->Mototechnic->find('all',  array('conditions' => array('type' => 'motorcycle', 'company' => $company), 'order' => array('weight', 'date_add')));
		  $this->set('thiscrumb','1');
		}
		else	$motorcycles =$this->Mototechnic->find('all',  array('conditions' => array('type' => 'motorcycle', 'NOT' => array('Mototechnic.company' => array('omaks', 'hors'))), 'order' => array('company', 'weight', 'date_add')));
		foreach ($motorcycles as &$m) {
		  $m['Mototechnic']['short_txt']= $this->_decode_from_db($m['Mototechnic']['short_txt']);
			$m['Mototechnic']['full_txt']= $this->_decode_from_db($m['Mototechnic']['full_txt']);
		}
		$this->set('motorcycles',$motorcycles);
		$this->set('companies',$this->Mototechnic->query("SELECT distinct company FROM mototechnics WHERE type = 'motorcycle' && company NOT IN ('omaks', 'hors')  ORDER BY company ASC;"));
		$this->_setmeta('motorcycle');
	}
	
	function motorollers($company = null)  {
		if ($company != null) {
			$motorollers = $this->Mototechnic->find('all',  array('conditions' => array('type' => 'motoroller', 'company' => $company), 'order' => array('weight', 'date_add')));
		  $this->set('thiscrumb','1');
		}
		else	$motorollers =$this->Mototechnic->find('all',  array('conditions' => array('type' => 'motoroller', 'NOT' => array('Mototechnic.company' => array('omaks', 'hors'))), 'order' => array('company', 'weight', 'date_add')));
		foreach ($motorollers as &$m) {
		  $m['Mototechnic']['short_txt']= $this->_decode_from_db($m['Mototechnic']['short_txt']);
			$m['Mototechnic']['full_txt']= $this->_decode_from_db($m['Mototechnic']['full_txt']);
		}
		$this->set('motorollers',$motorollers);
		$this->set('companies',$this->Mototechnic->query("SELECT distinct company FROM mototechnics WHERE type = 'motoroller' && company NOT IN ('omaks', 'hors')  ORDER BY company ASC;"));
		$this->_setmeta('motoroller');
	}
	
	function quadrocycles($company = null)  {
		if ($company != null) { 
			$quadrocycles = $this->Mototechnic->find('all',  array('conditions' => array('type' => 'quadrocycle', 'company' => $company), 'order' => array('weight', 'date_add')));
		  $this->set('thiscrumb','1');
		}
		else 	$quadrocycles = $this->Mototechnic->find('all',  array('conditions' => array('type' => 'quadrocycle', 'NOT' => array('Mototechnic.company' => array('omaks', 'hors'))), 'order' => array('company', 'weight', 'date_add')));
		foreach ($quadrocycles as &$m) {
		  $m['Mototechnic']['short_txt']= $this->_decode_from_db($m['Mototechnic']['short_txt']);
			$m['Mototechnic']['full_txt']= $this->_decode_from_db($m['Mototechnic']['full_txt']);
		}
		$this->set('quadrocycles',$quadrocycles);
		$this->set('companies',$this->Mototechnic->query("SELECT distinct company FROM mototechnics WHERE type='quadrocycle' && company NOT IN ('omaks', 'hors')  ORDER BY company ASC;"));
		$this->_setmeta('quadrocycle');
	}
	
	
	function snows($company = null)  {
		if ($company != null) { 
			$snows = $this->Mototechnic->find('all',  array('conditions' => array('type' => 'snow', 'company' => $company), 'order' => array('weight', 'date_add')));
		  $this->set('thiscrumb','1');
		}
		else 	$snows = $this->Mototechnic->find('all',  array('conditions' => array('type' => 'snow', 'NOT' => array('Mototechnic.company' => array('omaks', 'hors'))), 'order' => array('company', 'weight', 'date_add')));
		foreach ($snows as &$m) {
		  $m['Mototechnic']['short_txt']= $this->_decode_from_db($m['Mototechnic']['short_txt']);
			$m['Mototechnic']['full_txt']= $this->_decode_from_db($m['Mototechnic']['full_txt']);
		}
		$this->set('snows',$snows);
		$this->set('companies',$this->Mototechnic->query("SELECT distinct company FROM mototechnics WHERE type='snow' && company NOT IN ('omaks', 'hors') ORDER BY company ASC;"));
		$this->_setmeta('snow');
	}
	
	
	function bicycles($sub_type = null, $company = null)  {
	    if ($sub_type != null) {
		$this->loadModel('Motofile');
		if ($company != null) {
		    
		    $bicycles = $this->Mototechnic->find('all',  array('conditions' => array('type' => 'bicycle', 'sub_type' => $sub_type, 'company' => $company), 'order' => array('date_add')));
		    $this->set('thiscrumb','1');
		    
		    $this->set('motofiles',$this->Motofile->find('first',  array('conditions' => array('type' => 'bicycle', 'sub_type' => $sub_type, 'company' => $company), 'order' => array('date_add' => 'DESC' ))));

		}
		else {
		    $bicycles = $this->Mototechnic->find('all',  array('conditions' => array('type' => 'bicycle', 'sub_type' => $sub_type), 'order' => array('company', 'date_add')));
		    $this->set('motofiles',$this->Motofile->find('all',  array('conditions' => array('type' => 'bicycle', 'sub_type' => $sub_type), 'order' => array('company', 'date_add' => 'DESC' ))));
		}
		//$this->set('thiscrumb','1');
		
		$bicycle_index = false;
		
		
		foreach ($bicycles as &$m) {
		  $m['Mototechnic']['short_txt']= $this->_decode_from_db($m['Mototechnic']['short_txt']);
			$m['Mototechnic']['full_txt']= $this->_decode_from_db($m['Mototechnic']['full_txt']);
		}
		$this->set('bicycles',$bicycles);
		$this->set('companies',$this->Mototechnic->query("SELECT distinct company FROM mototechnics WHERE type='bicycle' and sub_type='".$sub_type."' ORDER BY company ASC;"));
		
	    }
	    else $bicycle_index = true;
	    
	    $this->set('bicycle_index',$bicycle_index);
	    $this->_setmeta('bicycle');

	}
	
	
	function motochild ($sub_type = null, $company = null)  {
	    if ($sub_type != null) {
		$this->loadModel('Motofile');
		if ($company != null) {
		    
		    $motochild = $this->Mototechnic->find('all',  array('conditions' => array('type' => 'motochild', 'sub_type' => $sub_type, 'company' => $company), 'order' => array('date_add')));
		    $this->set('thiscrumb','1');
		    
		    $this->set('motofiles',$this->Motofile->find('first',  array('conditions' => array('type' => 'motochild', 'sub_type' => $sub_type, 'company' => $company), 'order' => array('date_add' => 'DESC' ))));

		}
		else {
		    $motochild = $this->Mototechnic->find('all',  array('conditions' => array('type' => 'motochild', 'sub_type' => $sub_type), 'order' => array('company', 'date_add')));
		    $this->set('motofiles',$this->Motofile->find('all',  array('conditions' => array('type' => 'motochild', 'sub_type' => $sub_type), 'order' => array('company', 'date_add' => 'DESC' ))));
		}
		//$this->set('thiscrumb','1');
		
		$motochild_index = false;
		
		
		foreach ($motochild as &$m) {
		  $m['Mototechnic']['short_txt']= $this->_decode_from_db($m['Mototechnic']['short_txt']);
			$m['Mototechnic']['full_txt']= $this->_decode_from_db($m['Mototechnic']['full_txt']);
		}
		$this->set('motochild',$motochild);
		$this->set('companies',$this->Mototechnic->query("SELECT distinct company FROM mototechnics WHERE type='motochild' and sub_type='".$sub_type."' ORDER BY company ASC;"));
		
	    }
	    else $motochild_index = true;
	    
	    $this->set('motochild_index',$motochild_index);
	    $this->_setmeta('motochild');

	}
	
	
	function view($id = null) {
		$this->loadModel('Video');
		$this->Mototechnic->id = $id;
		$tech = $this->Mototechnic->read();
		$tech['Mototechnic']['full_txt'] = $this->_decode_from_db($tech['Mototechnic']['full_txt']);
		$tech['Mototechnic']['short_txt'] = $this->_decode_from_db($tech['Mototechnic']['short_txt']);
		$tech['Mototechnic']['sub_txt'] = $this->_decode_from_db($tech['Mototechnic']['sub_txt']);
		$tech['Mototechnic']['video_txt'] = $this->_decode_from_db($tech['Mototechnic']['video_txt']);
		$this->set('tech', $tech);
		$this->_setmeta($tech['Mototechnic']['type']);
    }

	function admin_index() {
		$this->layout = 'admin';
		$this->set('mopeds', $this->Mototechnic->find('all',  array('conditions' => array('type' =>  'moped'), 'order' => array('company', 'weight', 'date_add'))));
		$this->set('scooters', $this->Mototechnic->find('all',  array('conditions' => array('type' => 'scooter'), 'order' => array('company', 'weight', 'date_add'))));
		$this->set('undef', $this->Mototechnic->find('all',  array('conditions' => array('type' =>  array('scooter', 'moped'), 'volume' => ''), 'order' => array('company', 'weight', 'date_add'))));
		$this->set('motorollers', $this->Mototechnic->find('all',  array('conditions' => array('type' => 'motoroller'), 'order' => array('company', 'weight', 'date_add'))));
		$this->set('motorcycles', $this->Mototechnic->find('all',  array('conditions' => array('type' => 'motorcycle'), 'order' => array('company', 'weight', 'date_add'))));
		$this->set('quadrocycles', $this->Mototechnic->find('all',  array('conditions' => array('type' => 'quadrocycle'), 'order' => array('company', 'weight', 'date_add'))));
		$this->set('snow', $this->Mototechnic->find('all',  array('conditions' => array('type' => 'snow'), 'order' => array('company', 'weight', 'date_add'))));
		$this->set('title_for_layout', '�������������� �����������');
	}
	
	function admin_bicycles_index () {
	    $this->layout = 'admin';
	    $this->loadModel('Motofile');
	    $this->set('children', $this->Mototechnic->find('all',  array('conditions' => array('type' =>  'bicycle', 'sub_type' =>  'children'), 'order' => array('company', 'weight', 'date_add'))));
	    $this->set('folding', $this->Mototechnic->find('all',  array('conditions' => array('type' =>  'bicycle', 'sub_type' =>  'folding'), 'order' => array('company', 'weight', 'date_add'))));
	    $this->set('road', $this->Mototechnic->find('all',  array('conditions' => array('type' =>  'bicycle', 'sub_type' =>  'road'), 'order' => array('company', 'weight', 'date_add'))));
	    $this->set('sport', $this->Mototechnic->find('all',  array('conditions' => array('type' =>  'bicycle', 'sub_type' =>  'sport'), 'order' => array('company', 'weight', 'date_add'))));
	    $this->set('two_suspend', $this->Mototechnic->find('all',  array('conditions' => array('type' =>  'bicycle', 'sub_type' =>  'two_suspend'), 'order' => array('company', 'weight', 'date_add'))));
	    
	    $this->set('motofiles_children', $this->Motofile->find('all',  array('conditions' => array('type' =>  'bicycle', 'sub_type' =>  'children'), 'order' => array('company', 'date_add'))));
	    $this->set('motofiles_folding', $this->Motofile->find('all',  array('conditions' => array('type' =>  'bicycle', 'sub_type' =>  'folding'), 'order' => array('company', 'date_add'))));
	    $this->set('motofiles_road', $this->Motofile->find('all',  array('conditions' => array('type' =>  'bicycle', 'sub_type' =>  'road'), 'order' => array('company', 'date_add'))));
	    $this->set('motofiles_sport', $this->Motofile->find('all',  array('conditions' => array('type' =>  'bicycle', 'sub_type' =>  'sport'), 'order' => array('company', 'date_add'))));
	    $this->set('motofiles_two_suspend', $this->Motofile->find('all',  array('conditions' => array('type' =>  'bicycle', 'sub_type' =>  'two_suspend'), 'order' => array('company','date_add'))));

	    $this->set('title_for_layout', '�������������� �����������');  
	}
	
	function admin_motochild_index () {
	    $this->layout = 'admin';
	    $this->loadModel('Motofile');
	    $this->set('cars_akkum_radio', $this->Mototechnic->find('all',  array('conditions' => array('type' =>  'motochild', 'sub_type' =>  'cars_akkum_radio'), 'order' => array('company', 'weight', 'date_add'))));
	    $this->set('cars_akkum', $this->Mototechnic->find('all',  array('conditions' => array('type' =>  'motochild', 'sub_type' =>  'cars_akkum'), 'order' => array('company', 'weight', 'date_add'))));
	    $this->set('motocycle_akkum', $this->Mototechnic->find('all',  array('conditions' => array('type' =>  'motochild', 'sub_type' =>  'motocycle_akkum'), 'order' => array('company', 'weight', 'date_add'))));
	    $this->set('bicycles_3', $this->Mototechnic->find('all',  array('conditions' => array('type' =>  'motochild', 'sub_type' =>  'bicycles_3'), 'order' => array('company', 'weight', 'date_add'))));
	    $this->set('cars', $this->Mototechnic->find('all',  array('conditions' => array('type' =>  'motochild', 'sub_type' =>  'cars'), 'order' => array('company', 'weight', 'date_add'))));
	    
	    $this->set('motofiles_cars_akkum_radio', $this->Motofile->find('all',  array('conditions' => array('type' =>  'motochild', 'sub_type' =>  'cars_akkum_radio'), 'order' => array('company', 'date_add'))));
	    $this->set('motofiles_cars_akkum', $this->Motofile->find('all',  array('conditions' => array('type' =>  'motochild', 'sub_type' =>  'cars_akkum'), 'order' => array('company', 'date_add'))));
	    $this->set('motofiles_motocycle_akkum', $this->Motofile->find('all',  array('conditions' => array('type' =>  'motochild', 'sub_type' =>  'motocycle_akkum'), 'order' => array('company', 'date_add'))));
	    $this->set('motofiles_bicycles_3', $this->Motofile->find('all',  array('conditions' => array('type' =>  'motochild', 'sub_type' =>  'bicycles_3'), 'order' => array('company', 'date_add'))));
	    $this->set('motofiles_cars', $this->Motofile->find('all',  array('conditions' => array('type' =>  'motochild', 'sub_type' =>  'cars'), 'order' => array('company','date_add'))));

	    $this->set('title_for_layout', '�������������� �������� ����������');  
	}

	function admin_add() {
		$this->layout = 'admin';
		if (!empty($this->data)) {   
			if (empty($this->params['form']['spaw2'])) $this->Session->setFlash('��������� ������ �������� ������', 'default', array('class' => 'error-message'));  
				else  {
					$this->data['Mototechnic']['full_txt']= $this->_encode_to_db($this->params['form']['spaw2']);	
					$this->data['Mototechnic']['short_txt']= $this->_encode_to_db($this->params['form']['spaw1']);
					$this->data['Mototechnic']['sub_txt']= $this->_encode_to_db($this->params['form']['spaw3']);
					//$this->data['Mototechnic']['video_txt'] = $this->_encode_to_db($this->params['form']['spaw4']);
					$this->data['Mototechnic']['date_add'] = date('Y-m-d');

					$oldimg =''; 
					$optype ='add';	
					$this->_load_img ($oldimg, $optype) ;
				}			
		}    
		$this->set('title_for_layout', '���������� ������');
	}
	
	function admin_edit($id = null) {
		$this->layout = 'admin';
		$this->Mototechnic->id = $id;
		if (empty($this->data)) {
			$this->data = $this->Mototechnic->read();
			$this->data['Mototechnic']['short_txt'] = $this->_decode_from_db($this->data['Mototechnic']['short_txt']);
			$this->data['Mototechnic']['full_txt'] = $this->_decode_from_db($this->data['Mototechnic']['full_txt']);
			$this->data['Mototechnic']['sub_txt']= $this->_decode_from_db($this->data['Mototechnic']['sub_txt']);
			$this->data['Mototechnic']['video_txt']= $this->_decode_from_db($this->data['Mototechnic']['video_txt']);
		} else {
			if (empty($this->params['form']['spaw2'])) $this->Session->setFlash('��������� ��������� �������� ������', 'default', array('class' => 'error-message')); 
				else  {
					$this->data['Mototechnic']['full_txt']= $this->_encode_to_db($this->params['form']['spaw2']);	
	   			$this->data['Mototechnic']['short_txt']= $this->_encode_to_db($this->params['form']['spaw1']);
					$this->data['Mototechnic']['sub_txt']= $this->_encode_to_db($this->params['form']['spaw3']);
				//$this->data['Mototechnic']['video_txt']= $this->_encode_to_db($this->params['form']['spaw4']);
					$oldimg = $this->Mototechnic->field('img');
			    $optype ='edit';
					$this->_load_img ($oldimg, $optype) ;
				}
		}	
		$this->set('title_for_layout', '�������������� ������');
	}
	
	function admin_delete($id) {
		$this->layout = 'admin';
		//�������� ����������� � �����
		$this->Mototechnic->id = $id;
		$img = $this->Mototechnic->field('img');
		if ($this->Mototechnic->delete($id)) {
			if (!empty($img)) @unlink(IMAGES.$img);
			$this->Session->setFlash('������ ������� �������');
			$this->redirect(array('admin'=> true, 'action' => 'index'));     
		}
		$this->set('title_for_layout', '�������� ������');
	}
}

?>