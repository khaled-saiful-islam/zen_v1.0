<div class="calendar-view">
  <?php
//  debug($installers);
//  debug($prev);
//  debug($next);
  $holiday_list = $this->InventoryLookup->holiday_list();
  $installer_schedule_list = $this->InventoryLookup->installer_schedule_list();
//  debug($installer_schedule_list);

  if (empty($prev) && empty($next)) {
    $week_day = date('N') - 1;
    $start_day = date('Y-m-d', strtotime("-" . $week_day . " days", strtotime('now')));
    $prev_day = date('Y-m-d', strtotime("-1 days", strtotime($start_day)));
    $next_day = date('Y-m-d', strtotime("7 days", strtotime($start_day)));
//    debug($week_day);
//    debug($start_day);
//    debug($prev_day);
//    debug($next_day);
  } elseif (!empty($prev) || !empty($next)) {
    $week_day = "";
    $start_day = "";
    if (!empty($prev)) {
      $week_day = date('N', strtotime($prev)) - 1;
      $start_day = date('Y-m-d', strtotime("-" . $week_day . " days", strtotime($prev)));
    } elseif (!empty($next)) {
      $week_day = date('N', $next) - 1;
      $start_day = date('Y-m-d', strtotime("-" . $week_day . " days", strtotime($next)));
    }
    $prev_day = date('Y-m-d', strtotime("-1 days", strtotime($start_day)));
    $next_day = date('Y-m-d', strtotime("7 days", strtotime($start_day)));
//    debug($week_day);
//    debug($start_day);
//    debug($prev_day);
//    debug($next_day);
  }
  ?>
  <div class="detail actions actions-left">
    <?php
    echo $this->Html->link('Previous Week', array('action' => 'calendar_view', $prev_day, null), array('class' => 'show-detail-ajax calendar-view calendar-view-prev btn btn-success btn-padding'));
    ?>
  </div>
  <form>
    <table class="table-form-big">
      <tr>
        <th>
          <label>For the week starting:</label>
        </th>
        <td>
          <input type="text" name="set_week_day" class="dateP set-week-day" />
        </td>
      </tr>
    </table>
  </form>
  <div class="detail actions actions-right">
    <?php
    echo $this->Html->link('Next Week', array('action' => 'calendar_view', null, $next_day), array('class' => 'show-detail-ajax calendar-view btn calendar-view-next btn-success btn-padding'));
    ?>
  </div>
  <div class="clear"></div>
  <div style="overflow: scroll;height: 400px;">
    <table class="table-form-big table-form-big-margin">
      <tr>
        <td>&nbsp;</td>
        <?php
        for ($i = 0; $i < 7; $i++) {
          $day_name = date('l', strtotime("+" . $i . " days", strtotime($start_day)));
          $week_date = date('d-M-Y', strtotime("+" . $i . " days", strtotime($start_day)));
          ?>
          <td>
            <?php echo $day_name; ?><br/><?php echo $week_date; ?>
          </td>
        <?php } ?>
      </tr>
      <?php
      foreach ($installers as $key => $installer) {
        ?>
        <tr>
          <td>
            <?php echo $installer['Installer']['name_lookup_id']; ?>
          </td>
          <?php
          for ($i = 0; $i < 7; $i++) {
            $week_date = date('Y-m-d', strtotime("+" . $i . " days", strtotime($start_day)));
            $flag = "";
            $wo_number = "";
            if (array_key_exists($week_date, $holiday_list[$installer['Installer']['id']]))
              $flag = "Holiday";
            else if (array_key_exists($week_date, $installer_schedule_list[$installer['Installer']['id']])) {
              $flag = "Busy";
            }
            ?>
            <?php
            if ($flag == "Holiday") {
              ?>
              <td style="background-color: red;color: #fff;">
                <?php echo h("Not Available"); ?>
              </td>
            <?php } elseif ($flag == "Busy") {
              ?>
              <td style="background-color: #C0DCC0;">
                <?php echo h($installer_schedule_list[$installer['Installer']['id']][$week_date]['work_order_number']); ?> <br/>
                <?php echo h($installer_schedule_list[$installer['Installer']['id']][$week_date]['name']); ?> <br/>
                <?php echo $installer_schedule_list[$installer['Installer']['id']][$week_date]['address']; ?> 
              </td>
              <?php
            } else {
              ?>
              <td style="background-color: #E9E9FF;">
                &nbsp;
              </td>
            <?php } ?>
          <?php } ?>
        </tr>
      <?php } ?>
    </table>
  </div>
</div>
<script type="text/javascript" >
  
    $(".set-week-day").datepicker({
      onSelect:function(date){
        console.log(date);
        //event.preventDefault();
        date = date.split('/');
        console.log(date);
        date = date[1]+'-'+date[0]+'-'+date[2];
        console.log(date);
      
        ajaxMainContent('<?php
      echo $this->Util->getURL(array(
          'controller' => "installer_schedules",
          'action' => 'set_week_calendar_view',
          'plugin' => 'schedule_manager',
      ))
      ?>/'+date);
                  }
     });
  
</script>