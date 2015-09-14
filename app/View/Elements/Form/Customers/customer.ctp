<div class="page-header"><h1>Customer</h1></div>
<fieldset>
    <table id="retail1" style="display: true" width="100%" border="0" cellspacing="0" cellpadding="0" >
    
    <legend>Basic Information</legend>

 <tr>
    <td> 
        <div class="input-box">
            <?php 

                echo $this->Form->input('Customer.first_name',array ( 
                                                    'class' => 'input-medium',
                                                    'id' => 'firstname',
                                                    "label" => "First Name",
                                                    "value" => isset($data['Customer']['first_name']) ? $data['Customer']['first_name'] : ""
                                                    ));
            ?>
            </div>
     </td>
      <td>
        <div class="input-box">
            <?php echo $this->Form->input('Customer.primary_phone',array
                (           'class' => 'input-medium',
                            'label' => 'Primary phone',
                            "value" => isset($data['Customer']['primary_phone']) ? $data['Customer']['primary_phone'] : ""
                 ));
            ?>
          
          </div>
    </td>
     <td>
        <div class="input-box"> 
            <?php echo $this->Form->input('Customer.email_address',array
                ( 'class' => 'input-medium',           
                'label' => 'Email Address',
                "value" => isset($data['Customer']['email_address']) ? $data['Customer']['email_address'] : ""
                ));
            ?>
          </div>
      </td>    
   
    <td>
          <div class="input-box">
                <?php
                    echo $this->Form->input("Customer.status", 
                            array("options" => $this->Lookup->lookup(STATUS),
                                                            "empty" => "",
                                                            "id" => "e2",
                                                            'label' => 'Customer Status',
                            "value" => isset($data['Customer']['status']) ? $data['Customer']['status'] : "",                                  
                        ));
                ?>         
        </div>
      </td>
  </tr> 
  <tr> 
      <td>
        <div class="input-box">
            <?php echo $this->Form->input('Customer.last_name',array
                        ( 'class' => 'input-medium',
                        'id' => 'last_name',
                        'label' => 'Last name',
                        "value" => isset($data['Customer']['last_name']) ? $data['Customer']['first_name'] : ""
                        ));
            ?>
        </div>            
    </td> 
    <td>
        <div class="input-box">
            <?php echo $this->Form->input('Customer.secondary_phone',array
                 (          'class' => 'input-medium',           
                            'label' => 'Secondary Phone: ',
                            "value" => isset($data['Customer']['secondary_phone']) ? $data['Customer']['secondary_phone'] : ""

                    ));
            ?>
           </div>           
    </td>
      <td>
         <div class="input-box">
          
                <?php
            echo $this->Form->input("Customer.client_type", 
                    array("options" => $this->Lookup->lookup(TYPE),
                                                    "empty" => "",
                                                    "id" => "e5",
                                                    'label' => 'Client Type',
                    "value" => isset($data['Customer']['client_type']) ? $data['Customer']['client_type'] : ""
                    ));
                ?>
        </div>
      </td>
       <td>
          <div class="input-box">
                <?php
                     echo $this->Form->input("Customer.marketing", 
                             array( "options" => $this->Lookup->lookup(MARKETING),
                                                    "empty" => "",
                                                    'label' => 'Marketing',
                                                    "value" => isset($data['Customer']['marketing']) ? $data['Customer']['marketing'] : "",
                                                    "id" => "e4"                                       
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
                <?php echo $this->Form->input('Customer.billing_address',array
                    ( 'class' => 'input-xlarge',
                    'label' => 'Billing Address 1',
                    "value" => isset($data['Customer']['billing_address']) ? $data['Customer']['billing_address'] : ""

                    ) );
                ?>          
          </div>         
      </td>     
            
      <td>
          <div class="input-box">
                <?php echo $this->Form->input('Customer.billing_address2',array
                    ( 'class' => 'input-xlarge',
                    'label' => 'Billing Address 2',
                    "value" => isset($data['Customer']['billing_address2']) ? $data['Customer']['billing_address2'] : ""

                    ) );
                ?>
          
          </div>          
      </td>
  </tr>
  <tr>     
      <td>
          <div class="input-box">
          <?php echo $this->Form->input('Customer.city',array
            ( 'class' => 'input-large',            
             'label' => 'City 1',
            "value" => isset($data['Customer']['city']) ? $data['Customer']['city'] : ""

             ) );
        ?>
          </div>        
      </td>     
      </td>     
      <td>
          <div class="input-box">
          <?php echo $this->Form->input('Customer.city2',array
            ( 'class' => 'input-large',            
              'label' => 'City 2',
              "value" => isset($data['Customer']['city2']) ? $data['Customer']['city2'] : ""
             ));
        ?>          
          </div>        
      </td>
  </tr>  
<tr>   
      <td>
          <div class="input-box">
              <?php echo $this->Form->input('Customer.province',array
                    ( 'class' => 'input-large',
                    'label' => 'Province 1',
                    "value" => isset($data['Customer']['province']) ? $data['Customer']['province'] : ""
                        ));
                ?>          
       </div>
          
      </td>
      
      </td>
      
      <td>
          <div class="input-box">
                <?php echo $this->Form->input('Customer.province2',array
                        ( 'class' => 'input-large',
                           'label' => 'Province 2',
                        "value" => isset($data['Customer']['province2']) ? $data['Customer']['province2'] : ""

                        ));
                ?>         
          </div>         
      </td>
  </tr>
<tr>
    
    <td>
       <div class="input-box">
            <?php echo $this->Form->input('Customer.postalcode1',array
                    ( 'class' => 'input-medium',
                'label' => 'Postal Code 1',
                    "value" => isset($data['Customer']['postalcode1']) ? $data['Customer']['postalcode1'] : ""

                    ));
            ?>
        </div>
    </td>
    <td>
        <div class="input-box">
            <?php echo $this->Form->input('Customer.postalcode2',array
                    ( 'class' => 'input-medium',
                    'label' => 'Postal Code 2',
                    "value" => isset($data['Customer']['postalcode2']) ? $data['Customer']['postalcode2'] : ""
                    ));
            ?>
        </div>
    </td>  
   </tr>   
   <tr>  
    <td>
        <div class="input-box">
          <?php echo $this->Form->input('Customer.project_address1',array
            ( 'class' => 'input-large',
            'label' => 'Project Address 1',
            "value" => isset($data['Customer']['project-address1']) ? $data['Customer']['project_address1'] : ""
             ));
        ?>
        </div>
    </td>
    <td>
      <div class="input-box">
          <?php echo $this->Form->input('Customer.project_address2',array
            ( 'class' => 'input-large',
            'label' => 'Project Address 2',
            "value" => isset($data['Customer']['project_address2']) ? $data['Customer']['project_address2'] : ""
             ));
        ?>
        </div>
    </td>   
   </tr>  
 </table>
 <table id="retail3" style="display: true" width="100%" border="0" cellspacing="0" cellpadding="0" >
   <tr><td colspan="4"><legend>Other Information</legend></td></tr>
  <tr>
   <tr>   
    <td width="20%">
        <div class="input-box">
            <?php echo $this->Form->input('Customer.sale_rep',array
                    ( 'class' => 'input-medium',           
                    'label' => 'Sale Representative',
                    "value" => isset($data['Customer']['sale_rep']) ? $data['Customer']['sale_rep'] : ""

                    ));
            ?>
        </div>
    </td>
    <td width="20%">
       <div class="input-box">
            <?php echo $this->Form->input('Customer.lockbox',array
                    ( 'class' => 'input-medium',
                    'label' => 'Lock Box',
                    "value" => isset($data['Customer']['lockbox']) ? $data['Customer']['lockbox'] : ""

                    ));
            ?>
        </div>
    </td> 
    <td>
        <div class="input-box">
           <?php
                echo $this->Form->input("Customer.classification_id", 
                            array( "options" => $this->Lookup->lookup(CLIENT_CLASSIFICATION),
                                                    "empty" => "",
                                                    'label' => 'Customer Classification',
                                                    "value" => isset($data['Customer']['classification_id']) ? $data['Customer']['classification_id'] : "",
                                                    "id" => "e1"

                ));
            ?>
        </div>
    </td>
   </tr>
   <tr>
       <td colspan="3">
        <div class="input-box">
            <?php echo $this->Form->input('Customer.customer_note',array
                ( 'class' => 'input-xlarge',
                'rows' => '5',
                'cols' => '50',          
                'label' => 'Customer Note',
                "value" => isset($data['Customer']['customer_note']) ? $data['Customer']['customer_note'] : ""
                ));
            ?>
        </div>      
    </td>
   </tr>
</table>
    <?php
    $flag=false;
    $classification=0;
    if(isset($data['Customer']['classification_id'])){
        
        $classification= $data['Customer']['classification_id'];
        
    };
    
if($classification==1 || $classification==8){
   $flag=true;  
}
else if($classification==0) {
    $flag=true;    
}
?>
    
<br/> 

  <!-- Builder Information Box -->  
 
  
<table id="builder" <?php if($flag==true){ ?> style="display: none" <?php } ?> width="100%" border="0" cellspacing="0" cellpadding="0" >
    <tr> 
        <td>
            <table id="retail3" style="display: true" width="100%" border="0" cellspacing="0" cellpadding="0">

            <tr><td colspan="3">
            <legend>Builder Information</legend>
            </td>
            </tr>
            <tr>
                <td width="20%"> 
                    <div class="input-box">
                            <?php 
                                echo $this->Form->input('Customer.legal_name',array ( 
                                                                'class' => 'input-medium',
                                                                'label' => 'Builders Legal Name',
                                                                "value" => isset($data['Customer']['legal_name']) ? $data['Customer']['legal_name'] : "",                                      
                                  ));
                            ?>
                    </div>
                </td>
                <td width="20%">
                    <div class="input-box">
                        <?php echo $this->Form->input('Customer.builder_pphone',array
                            ( 'class' => 'input-medium',
                            'label' => 'Primary Phone',
                            "value" => isset($data['Customer']['builder_pphone']) ? $data['Customer']['builder_pphone'] : "",                         
                            ) );
                        ?>   
                    </div>
                </td>
                <td>
                    <div class="input-box">
                        <?php echo $this->Form->input('Customer.GST',array
                                    ( 'class' => 'input-medium',
                                    'label' => 'GST Number',
                                    "value" => isset($data['Customer']['GST']) ? $data['Customer']['GST'] : "",           
                                    ));
                                ?>
                    </div>
                </td>

             
                

                </td>
            </tr>
            <tr>
                <td>
                    <div class="input-box">
                            <?php echo $this->Form->input('Customer.contact_name',array
                                ( 'class' => 'input-medium',
                                'label' => 'Contact Name',
                                "value" => isset($data['Customer']['contact_name']) ? $data['Customer']['contact_name'] : "",           

                                ) );
                            ?>
                     </div>        
                </td>
                <td>
                    <div class="input-box">
                        <?php echo $this->Form->input('Customer.builder_sphone',array
                            ( 'class' => 'input-medium',
                            'label' => 'Secondary Phone',
                            "value" => isset($data['Customer']['builder_sphone']) ? $data['Customer']['builder_sphone'] : "",           

                            ) );
                        ?>

                    </div>
                </td>
                 <td>

                    <div class="input-box">
                        <?php echo $this->Form->input('Customer.builder_email',array
                            ( 'class' => 'input-medium',
                            'label' => 'Email Address',
                            "value" => isset($data['Customer']['builder_email']) ? $data['Customer']['builder_email'] : "",           

                            ) );
                        ?>

                    </div>
                </td>
               

            </tr>
            </table>
         <table id="retail3" style="display: true" width="100%" border="0" cellspacing="0" cellpadding="0">
             <tr><td colspan="3"><legend>Builder Address</legend></td></tr>
            <tr>
                <td width="20%">
                    <div class="input-box">
                    <?php echo $this->Form->input('Customer.builder_billing_address1',array
                        ( 'class' => 'input-large',
                        'label' => 'Billing Address 1',
                        "value" => isset($data['Customer']['builder_billing_address1']) ? $data['Customer']['builder_billing_address2'] : ""      
                        ) );
                    ?>
                    </div>                    
                </td>

                </td>

                <td>
                    <div class="input-box">
                    <?php echo $this->Form->input('Customer.builder_billing_address2',array
                        ( 'class' => 'input-large',
                        'label' => 'Billing Address 2',
                        "value" => isset($data['Customer']['builder_billing_address2']) ? $data['Customer']['builder_billing_address2'] : "",           

                        ) );
                    ?>
                    </div>         
                </td>
            </tr>
            <tr>


                <td>
                    <div class="input-box">
                    <?php echo $this->Form->input('Customer.builder_city',array
                        ( 'class' => 'input-medium',
                        'label' => 'City',
                        "value" => isset($data['Customer']['builder_city']) ? $data['Customer']['builder_city'] : "",           

                        ) );
                    ?>
                    </div>

                </td>

                </td>
                <td>
                    <div class="input-box">
                    <?php echo $this->Form->input('Customer.builder_province',array
                        ( 'class' => 'input-medium',
                        'label' => 'Province',
                        "value" => isset($data['Customer']['builder_province']) ? $data['Customer']['builder_province'] : "",           

                        ) );
                    ?>
                    </div>

                </td>


            </tr>

            <tr>
                <td>
                    <div class="input-box">
                        <?php echo $this->Form->input('Customer.builder_postcode',array
                            ( 'class' => 'input-medium',
                            'label' => 'Postal Code',
                            "value" => isset($data['Customer']['builder_postcode']) ? $data['Customer']['builder_postcode'] : "",           

                            ));
                        ?>
                    </div>
                </td>
                </td>
                 <td>
                    <div class="input-box">
                        <?php echo $this->Form->input('Customer.site_location',array
                            ( 'class' => 'input-medium',
                            'label' => 'Site Location',
                            "value" => isset($data['Customer']['site_location']) ? $data['Customer']['site_location'] : "",           

                            ));
                        ?>

                </td>               
            </tr>
            <tr><td colspan="3"><legend>Credit Information</legend></td></tr>
            <tr>

                <td>
                    <div class="input-box">
                    <?php echo $this->Form->input('Customer.credit_request',array
                        ( 'class' => 'input-medium',
                        'label' => 'Credit Requested',
                        "value" => isset($data['Customer']['credit_request']) ? $data['Customer']['credit_request'] : "",           

                        ));
                    ?>  
                        </div>
                </td>

                <td>
                    <div class="input-box">
                    <?php echo $this->Form->input('Customer.credit_term',array
                        ( 'class' => 'input-medium',
                        'label' => 'Credit Term',
                        "value" => isset($data['Customer']['credit-term']) ? $data['Customer']['credit_term'] : "",           

                        ) );
                    ?>
                    </div>
                </td>

            </tr>

            <tr>

                <td>
                    <div class="input-box">
                    <?php echo $this->Form->input('Customer.approve_by',array
                        ( 'class' => 'input-medium',
                        'label' => 'Approved by',
                        "value" => isset($data['Customer']['approve_by']) ? $data['Customer']['approve_by'] : "",           

                        ) );
                    ?>
                    </div>
                </td>
                <td>
                    <div class="input-box">
                        <?php echo $this->Form->input('Customer.credit_approve',array
                            ( 'class' => 'input-medium',
                            'label' => 'Credit Approved',
                            "value" => isset($data['Customer']['credit_approve']) ? $data['Customer']['credit_approve'] : "",           

                            ) );
                        ?>
                     </div>
                </td>

            </tr>

            <tr>

                <td colspan="2">
                <div class="input-box">
                    <?php echo $this->Form->input('Customer.builder_note',array
                        ( 'class' => 'input-xlarge',
                        'rows' => '3',
                        'cols' => '2',
                        'label' => 'Customer Note',
                        "value" => isset($data['Customer']['builder_note']) ? $data['Customer']['builder_note'] : "",           

                        ) );
                    ?>
                    </div>
                </td>


            </tr>

            </table>
        
</td></tr> </table>
  <br/>
    <input type="submit" class="btn btn-warning btn-large" value="Submit">
    
    
        <?php echo $this->Form->end(); ?> 
    
    

</div>

<script type="text/javascript">
$(document).ready(function() { 
    
 
 $("#e1").select2(); 
 $("#e2").select2();
 $("#e4").select2();
 $("#e5").select2();

 
 $("#e1").change(function(e){
    
         
     var type = $("#e1 option:selected").val();
     
     if(type==1 || type==8) {
                    
                    
         $("#builder").fadeOut();
         
     }
  
     if(type==2 || type==6 || type==7) {
                    
          $("#e3").select2();          
         $("#builder").fadeIn();
         
     }
     
 });
 });
 
 </script>
    
    
</fieldset>



