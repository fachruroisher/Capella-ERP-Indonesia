<div class="form">
<?php 
$form=$this->beginWidget('CActiveForm', array(
	'id'=>'project-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('enctype'=>'multipart/form-data')
)); ?>
<?php
$this->widget('ToolbarButton',array(
	'isSave'=>true,'UrlSave'=>'invoiceap/write',
	'isCancel'=>true,'UrlCancel'=>'invoiceap/cancelwrite'
));
?>
<?php echo $form->hiddenField($model,'invoiceid'); ?>
     
	<table class="table-condensed" style="width:100%">
	<tr> 
			<td>
		<div class="row">
          <?php echo $form->labelEx($model,'invoicedate'); ?>
<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
              'attribute'=>'invoicedate',
              'model'=>$model,
              // additional javascript options for the date picker plugin
             'options'=>array(
                  'showAnim'=>'fold',
				  'dateFormat'=>Yii::app()->params['dateviewcjui'],
				  'changeYear'=>true,
				  'changeMonth'=>true,
                                  'yearRange'=>'-10:+10'
              ),
              'htmlOptions'=>array(
                  'style'=>'height:20px',
                  'size'=>'10',
              ),
          ));?>          <?php echo $form->error($model,'invoicedate'); ?>
        </div>
		</td>
		<td>
		<?php echo $form->labelEx($model,'addressbookid'); ?>
    <?php echo $form->hiddenField($model,'addressbookid'); ?>
    <input type="text" name="customername" id="customername" readonly >
    <?php $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array('id'=>'customer_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Customer'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true
                                ),
                        ));
						$customer=new Customer('searchwfstatus');
	  $customer->unsetAttributes();  // clear any default values
	  if(isset($_GET['Customer']))
		$customer->attributes=$_GET['Customer'];
      $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'customer-grid',
        'dataProvider'=>$customer->searchwstatus(),
        'filter'=>$customer,
        'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
        'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("V",
          array("name" => "send_absstatus",
          "id" => "send_absstatus",
          "onClick" => "$(\"#customer_dialog\").dialog(\"close\"); $(\"#customername\").val(\"$data->fullname\"); 
		  $(\"#Invoice_addressbookid\").val(\"$data->addressbookid\");"))',
          ),
	array('name'=>'addressbookid', 'visible'=>false,
        'value'=>'$data->addressbookid','htmlOptions'=>array('width'=>'1%')),
          'fullname',
        ),
      ));
    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#customer_dialog").dialog("open"); return false;',
                       ))?>
    <?php echo $form->error($model,'addressbookid'); ?>
		</td>
		<td>
		<div class="row">
          <?php echo $form->labelEx($model,'invoiceno'); ?>
          <?php echo $form->textField($model,'invoiceno'); ?>
          <?php echo $form->error($model,'invoiceno'); ?>
        </div>
		</td>
		<td>
		<div class="row">
          <?php echo $form->labelEx($model,'pono'); ?>
          <?php echo $form->textField($model,'pono'); ?>
          <?php echo $form->error($model,'pono'); ?>
        </div>
		</td>
		</tr>
		<tr>
<td>
		<div class="row">
          <?php echo $form->labelEx($model,'amount'); ?>
          <?php echo $form->textField($model,'amount'); ?>
          <?php echo $form->error($model,'amount'); ?>
        </div>
		</td>
		<td>
		<?php echo $form->labelEx($model,'currencyid'); ?>
    <?php echo $form->hiddenField($model,'currencyid'); ?>
    <input type="text" name="currencyname" id="currencyname" readonly>
    <?php $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array('id'=>'currency_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Currency'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true
                                ),
                        ));
						$currency=new Currency('searchwfstatus');
	  $currency->unsetAttributes();  // clear any default values
	  if(isset($_GET['Currency']))
		$currency->attributes=$_GET['Currency'];
      $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'currency-grid',
        'dataProvider'=>$currency->searchwstatus(),
        'filter'=>$currency,
        'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
        'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("V",
          array("name" => "send_absstatus",
          "id" => "send_absstatus",
          "onClick" => "$(\"#currency_dialog\").dialog(\"close\"); $(\"#currencyname\").val(\"$data->currencyname\"); 
		  $(\"#Invoice_currencyid\").val(\"$data->currencyid\");"))',
          ),
	array('name'=>'currencyid', 'visible'=>false,
        'value'=>'$data->currencyid','htmlOptions'=>array('width'=>'1%')),
          'currencyname',
        ),
      ));
    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#currency_dialog").dialog("open"); return false;',
                       ))?>
    <?php echo $form->error($model,'addressbookid'); ?>
		</td>
		<td>
		<div class="row">
          <?php echo $form->labelEx($model,'rate'); ?>
          <?php echo $form->textField($model,'rate'); ?>
          <?php echo $form->error($model,'rate'); ?>
        </div>
		</td>		
		<td>
		<div class="row">
          <?php echo $form->labelEx($model,'headernote'); ?>
          <?php echo $form->textArea($model,'headernote'); ?>
          <?php echo $form->error($model,'headernote'); ?>
        </div>
		</td>		
	</tr>
	</table>
<?php $this->endWidget(); ?>
	<?php
	$this->widget('zii.widgets.jui.CJuiTabs', array(
	'tabs' => array(
         'Detail' => array('content' => $this->renderPartial('indexinvoicedet',
			 array('invoicedet'=>$invoicedet),true)),
         'Journal' => array('content' => $this->renderPartial('indexinvoiceacc',
			 array('invoiceacc'=>$invoiceacc),true)),
/*         'Informal' => array('content' => $this->renderPartial('indexinformal',
			 array('employeeinformal'=>$employeeinformal),true)),
         'Working Experience' => array('content' => $this->renderPartial('indexwo',
			 array('employeewo'=>$employeewo),true)),
         'Family' => array('content' => $this->renderPartial('indexfamily',
			 array('employeefamily'=>$employeefamily),true)),*/
	),
	// additional javascript options for the tabs plugin
	'options' => array(
		'collapsible' => true,
	),
));?>
</div><!-- form -->
