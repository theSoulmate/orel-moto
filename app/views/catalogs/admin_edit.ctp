<div class="ca-text">  
<h2>���������� ��������</h2>
	<div class="form">
		<?php echo $this->Form->create('Catalog', array('enctype' => 'multipart/form-data', 'action' => 'edit'));

			echo "<div class='field'>".$this->Form->input('company_id', array('type'=>'select', 'style' => 'width: 200px', 'label'=> '�����'))."</div>";
			echo "<br><div class='field'>".$this->Form->input('title', array( 'style' => 'width: 370px','label'=> '��������'))."</div>";
			echo "<br><div class='field'>".$this->Form->input('url', array('type' => 'file','style' => 'width: 370px', 'label'=> '����'))."</div>";
			echo "<br><div class='field'>".$this->Form->input('date_add', array('label'=> '����'))."</div>";
			echo $form->input('id', array('type'=>'hidden')); 
			echo "<div class='field'>".$this->Form->end('���������')."</div>";
		?>
	</div><div class="clear"></div>
</div>
