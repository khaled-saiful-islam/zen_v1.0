<div class="page-header"><h1>Vendor</h1></div>
<fieldset>
    <table id="retail1" style="display: true" width="100%" border="0" cellspacing="0" cellpadding="0" >
    
    <legend>Basic Information</legend>
    <tr>
        <td>
            <div class="input-box">
            <?php 

                echo $this->Form->input('Vendor.vendor_id',array ( 
                                                    'class' => 'input-medium',  
                                                    'type' => 'text',
                                                    "label" => "Vendor Identification Number",
                                                    "value" => isset($data['Vendor']['vendor_id']) ? $data['Vendor']['vendor_id'] : ""
                                                    ));
            ?>
            </div>
            
        </td>
        <td>
            <div class="input-box">
            <?php 

                echo $this->Form->input('Vendor.work_phone',array ( 
                                                    'class' => 'input-medium',  
                                                    'type' => 'text',
                                                    "label" => "Work Phone",
                                                    "value" => isset($data['Vendor']['work_phone']) ? $data['Vendor']['work_phone'] : ""
                                                    ));
            ?>
            </div>
            
        </td>
    </tr>

 <tr>
    <td width="20%"> 
        <div class="input-box">
            <?php 

                echo $this->Form->input('Vendor.first_name',array ( 
                                                    'class' => 'input-medium',
                                                    'id' => 'firstname',
                                                    "label" => "First Name",
                                                    "value" => isset($data['Vendor']['first_name']) ? $data['Vendor']['first_name'] : ""
                                                    ));
            ?>
            </div>
     </td>
      <td width="20%">
        <div class="input-box">
            <?php echo $this->Form->input('Vendor.cell_phone',array
                (           'class' => 'input-medium',
                            'label' => 'Cell Phone',
                            "value" => isset($data['Vendor']['primary_phone']) ? $data['Vendor']['primary_phone'] : ""
                 ));
            ?>         
          </div>
    </td>
     <td>
        <div class="input-box"> 
            <?php echo $this->Form->input('Vendor.email1',array
                ( 'class' => 'input-medium',           
                'label' => 'Email Address 1',
                "value" => isset($data['Vendor']['email1']) ? $data['Vendor']['email1'] : ""
                ));
            ?>
          </div>
      </td>    
   
    
  </tr> 
  <tr> 
      <td>
        <div class="input-box">
            <?php echo $this->Form->input('Vendor.last_name',array
                        ( 'class' => 'input-medium',
                        'id' => 'last_name',
                        'label' => 'Last name',
                        "value" => isset($data['Vendor']['last_name']) ? $data['Vendor']['first_name'] : ""
                        ));
            ?>
        </div>            
    </td> 
    <td>
        <div class="input-box">
            <?php echo $this->Form->input('Vendor.home_phone',array
                 (          'class' => 'input-medium',           
                            'label' => 'Home Phone: ',
                            "value" => isset($data['Vendor']['home_phone']) ? $data['Vendor']['home_phone'] : ""

                    ));
            ?>
           </div>           
    </td>
      <td>
        <div class="input-box"> 
            <?php echo $this->Form->input('Vendor.email2',array
                ( 'class' => 'input-medium',           
                'label' => 'Email Address 2',
                "value" => isset($data['Vendor']['email2']) ? $data['Vendor']['email2'] : ""
                ));
            ?>
          </div>
      </td>
       
  </tr>
  </table>
<table id="retail2" style="display: true" width="100%" border="0" cellspacing="0" cellpadding="0" >
  <tr><td colspan="4"><legend>Address</legend></td></tr>

  <tr>  
      <td width="20%">         
          <div class="input-box">
                <?php echo $this->Form->input('Vendor.home_address',array
                    ( 'class' => 'input-large',
                    'label' => 'Home Address',
                    "value" => isset($data['Vendor']['home_address']) ? $data['Vendor']['home_address'] : ""

                    ) );
                ?>          
          </div>         
      </td>     
            
      <td>
          <div class="input-box">
                <?php echo $this->Form->input('Vendor.work_address',array
                    ( 'class' => 'input-large',
                    'label' => 'Work Address',
                    "value" => isset($data['Vendor']['work_address']) ? $data['Vendor']['work_address'] : ""

                    ) );
                ?>
          
          </div>          
      </td>
  </tr>
  <tr>     
      <td>
          <div class="input-box">
          <?php echo $this->Form->input('Vendor.office_address',array
            ( 'class' => 'input-large',            
             'label' => 'Office Address',
            "value" => isset($data['Vendor']['office-address']) ? $data['Vendor']['office_address'] : ""
              
             ));
        ?>
          </div>        
      </td>     
      </td>     
      <td>
          <div class="input-box">
          <?php echo $this->Form->input('Vendor.company_type',array
            ( 'class' => 'input-large',            
              'label' => 'Company Type',
              "value" => isset($data['Vendor']['company_type']) ? $data['Vendor']['company_type'] : ""
             ));
        ?>          
          </div>        
      </td>
  </tr>  

</table>
    
  <br/>
    <input type="submit" class="btn btn-warning btn-large" value="Submit">
    
    
        <?php echo $this->Form->end(); ?> 
    
    

</div>

<script type="text/javascript">
$(document).ready(function() { 
    
 });
 
 </script>
    
    
</fieldset>



