<div class="navbar">
    <div class="navbar-inner">
        <div class="container">

            <div class="pull-left">
                <ul class="sf-menu">
                    <?php if( $loginUser['permission_dashboard'] == 1 ) { ?>
                        <li id="top-dashboard">
                            <?php
                            echo $this->Html->link("<i class='icon-home icon-white'></i> Dashboard", array(
                                "controller" => "dashboards",
                                "action" => "index",
                                "plugin" => "inventory" ), array(
                                "style" => "padding: 0.75em 4em",
                                "escape" => false
                            ));
                            ?>
                        </li>
                    <?php } ?>
                    <!-- customer setup start -->
                    <?php if( $loginUser['permission_customer'] == 1 ) { ?>
                        <li id="top-customer">
                            <?php
                            echo $this->Html->link("<i class=' icon-user icon-white'></i> Customer", array(
                                "controller" => "customers",
                                "action" => "index",
                                "plugin" => "customer_manager",
                                "sort" => "name",
                                "direction" => "asc",
                                    ), array(
                                "escape" => false
                                    )
                            );
                            ?>
                        </li>
                    <?php } ?>
                    <!-- customer setup end -->

                    <!-- Quote start -->
                    <?php if( $loginUser['permission_quote'] == 1 ) { ?>
                        <li id="top-quote">
                            <?php
                            echo $this->Html->link("<i class='icon-file icon-white'></i> Quote", array(
                                "controller" => "quotes",
                                "action" => "index",
                                "plugin" => "quote_manager",
                                "sort" => "quote_number",
                                "direction" => "desc",
                                    ), array(
                                "escape" => false
                            ));
                            ?>
                        </li>
                    <?php } ?>
                    <!-- Quote end -->

                    <?php if( $loginUser['permission_work_order'] == 1 ) { ?>
                        <li id="top-workorder">
                            <?php
                            echo $this->Html->link("<i class='icon-file icon-white'></i> Work Orders", array(
                                "controller" => "work_orders",
                                "action" => "index",
                                "plugin" => "work_order_manager",
                                "sort" => "work_order_number",
                                "direction" => "desc" ), array(
                                "escape" => false
                            ));
                            ?>
                        </li>
                    <?php } ?>

                    <?php if( $loginUser['permission_purchase_order'] == 1 ) { ?>
                        <li id="top-purchase">
                            <?php
                            echo $this->Html->link("<i class='icon-file icon-white'></i> Purchase Order", array(
                                "controller" => "purchase_orders",
                                "action" => "index",
                                "plugin" => "purchase_order_manager",
                                "sort" => "purchase_order_num",
                                "direction" => "desc" ), array(
                                "escape" => false
                            ));
                            ?>
                        </li>
                    <?php } ?>

                    <?php if( $loginUser['permission_schedule'] == 1 ) { ?>
                        <li id="top-schedule">
                            <?php
                            echo $this->Html->link("<i class='icon-file icon-white'></i>Schedule", array(
                                "controller" => "appointments",
                                "action" => "index",
                                "plugin" => "schedule_manager" ), array(
                                "escape" => false
                            ));
                            ?>
                        </li>
                    <?php } ?>

                    <?php if( $loginUser['permission_admin'] == 1 ) { ?>
                        <li id="top-admin">
                            <?php
                            echo $this->Html->link("<i class='icon-file icon-white'></i>Admin", array(
                                "controller" => "users",
                                "action" => "index",
                                "plugin" => "user_manager" ), array(
                                "escape" => false
                            ));
                            ?>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
</div>


