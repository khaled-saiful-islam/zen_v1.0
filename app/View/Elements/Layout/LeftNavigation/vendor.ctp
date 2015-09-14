<style type="text/css">
div.left_menu {
    margin: 0px;
    padding: 0px;
}
div.left_menu ul{
    margin: 0px 0px;
    padding: 0px;
    list-style: none;
}
div.left_menu ul li{
    padding: 10px 0px;
    margin: 0px;
    border-bottom: 1px solid #cccccc;
}
div.left_menu ul li a{
    color: #000000;
    margin: 10px;
}
div.left_menu ul li a:hover{
    color: #648819;
    text-decoration: none;
}

</style>

<div class="left_menu">
    <ul>
        <li> 
           <b> <?php echo $this->Html->link('Add new Vendor <i class="icon-plus-sign"> </i>',
                    array('controller' => 'vendors', 'action' => 'action', ADD), array("escape" => false)); ?></b>
        </li>
        <li > 
           <b> <?php echo $this->Html->link('View Vendor List <i class="icon-list-alt"> </i>',
                    array('controller' => 'vendors', 'action' => 'action'), array("escape" => false)); ?></b>
        </li>
    </ul>
 </div>                  