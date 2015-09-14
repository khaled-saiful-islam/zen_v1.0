<?php
//$paginator->options(array('url' => $this->passedArgs));
//extract the get variables
$url = $this->params['url'];
unset($url['url']);
$get_var = http_build_query($url);

$arg1 = array();
$arg2 = array();
//take the named url
if (!empty($this->params['named']))
  $arg1 = $this->params['named'];

//take the pass arguments
if (!empty($this->params['pass']))
  $arg2 = $this->params['pass'];

//merge named and pass
$args = array_merge($arg1, $arg2);

//add get variables
$args["?"] = $get_var;

?>



<div class="paginator">
  <table align="center" cellpadding="3" cellspacing="3" border="0">
    <tr>
      <td>

        <ul class="pager">
          <li><?php echo $this->Paginator->first(' First ', null, null, array('class' => 'disabled')); ?></li>
          <li>
            <?php echo $this->Paginator->prev('Previous ', null, null, array('class' => 'disabled')); ?>
          </li>
          <li><?php echo $this->Paginator->numbers(); ?></li>
          <li>
            <?php echo $this->Paginator->next(' Next ', null, null, array('class' => 'disabled')); ?>
          </li>
          <li><?php echo $this->Paginator->last(' Last ', null, null, array('class' => 'disabled')); ?></li>

        </ul>

      </td>

    </tr>
    <tr>
      <td>
        <?php
        echo $this->Paginator->counter(array(
            'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total', true)
        ));
        ?>



      </td>


    </tr>
  </table>
</div>
<?php echo $this->Js->writeBuffer(); ?>