<style type="text/css">
    @page {size: landscape}
</style>
<div style='width: 80%; margin: 0 auto; font-family: "Times New Roman",Georgia,Serif; margin-top: 50px; size: landscape;'>
    <div style='margin-top: 20px;'>
        <div style="float: left; border: 1px solid; width: 35%; margin-right: 5%;">
            <span style="font-weight: bold; font-size: 35px; margin: 5px 5px 5px 10px;">NO: </span><span style="font-weight: bold; font-size: 35px; margin: 5px 5px 5px 10px;"><?php echo $data['ContainerSkid']['skid_no']; ?></span>
        </div>
        <div style="float: left; border: 1px solid; width: 48%; padding: 5px 5px 5px 10px;">
           <?php
            $wo_data = $this->InventoryLookup->getWOInfo($wo[0]);
            if(!empty($wo_data['Customer'])){
                echo $wo_data['Customer']['first_name']." ".$wo_data['Customer']['last_name'];
            }
            else {
                echo "Inventory</br>";
                echo "&nbsp;</br>";
            }
           ?> 
        </div>    
    </div>
    <div style="clear: both;"></div>

    <div style="width: 50%; margin: 0 auto; border: 1px solid black; margin-top: 40px;">
        <span style="width: 100%; text-align: center; display: block;">
        <?php
            foreach($wo as $w){
                $wo_data = $this->InventoryLookup->getWOInfo($w);
                if(!empty($wo_data['WorkOrder'])){
                    echo "WO".$wo_data['WorkOrder']['work_order_number']."</br>";
                }
                else
                  echo "No WO";  
            }
        ?>
        </span>    
    </div>

    <div style='margin-top: 40px;'>
        <div style="float: left; border: 1px solid; width: 35%; margin-right: 5%;">
            <?php
                if(!empty($wo[0])){
            ?>
            <span style="font-size: 35px; margin: 5px 5px 5px 10px;"><?php echo "LK049"; ?></span>
            <span style="font-size: 35px; margin: 5px 5px 5px 10px; display: block;"><?php echo "PARC01"; ?></span>
            <?php             
                }
                else {
                    echo "&nbsp;</br>";
                    echo "&nbsp;";
                }   
            ?>
        </div>
        <div style="float: left; border: 1px solid; width: 48%; padding: 5px 5px 5px 10px; font-size: 50px; ">
           <?php
            echo $data['ContainerSkid']['weight']." KG"; 
           ?> 
        </div>    
    </div>
</div>
