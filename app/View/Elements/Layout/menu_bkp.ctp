<div class="navbar">
    <div class="navbar-inner">
        <div class="container">

            <div class="pull-left">
                <ul class="sf-menu">
                    <?php if( $loginUser['permission_dashboard'] == 1 ) { ?>
                        <li>
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
                        <li>
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
                            <ul>
                                <!-- retail customer setup start -->
                                <li>
                                    <?php
                                    echo $this->Html->link("<i class=' icon-user icon-white'></i> Retail Customer", array(
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
                                    <ul>
                                        <li>
                                            <?php
                                            echo $this->Html->link("<i class=' icon-plus icon-white'></i> Add Retail Customer", array(
                                                "controller" => "customers",
                                                "action" => ADD,
                                                "plugin" => "customer_manager" ), array(
                                                "escape" => false
                                            ));
                                            ?>
                                        </li>
                                        <li>
                                            <?php
                                            echo $this->Html->link("<i class='icon-list-alt icon-white'></i> View Retail Customers", array(
                                                "controller" => "customers",
                                                "action" => "index",
                                                "plugin" => "customer_manager",
                                                "sort" => "name",
                                                "direction" => "asc",
                                                    ), array(
                                                "escape" => false
                                            ));
                                            ?>
                                        </li>
                                    </ul>
                                </li>
                                <!-- retial customer setup end -->
                                <!-- builder setup start -->
                                <li>
                                <li>
                                    <?php
                                    echo $this->Html->link("<i class=' icon-user icon-white'></i> Builder", array(
                                        "controller" => "builders",
                                        "action" => "index",
                                        "plugin" => "customer_manager",
                                        "sort" => "name",
                                        "direction" => "asc",
                                            ), array(
                                        "escape" => false
                                            )
                                    );
                                    ?>
                                    <ul>
                                        <li>
                                            <?php
                                            echo $this->Html->link("<i class=' icon-plus icon-white'></i> Add Builder", array(
                                                "controller" => "builders",
                                                "action" => ADD,
                                                "plugin" => "customer_manager" ), array(
                                                "escape" => false
                                            ));
                                            ?>
                                        </li>
                                        <li>
                                            <?php
                                            echo $this->Html->link("<i class='icon-list-alt icon-white'></i> View Builders", array(
                                                "controller" => "builders",
                                                "action" => "index",
                                                "plugin" => "customer_manager",
                                                "sort" => "name",
                                                "direction" => "asc",
                                                    ), array(
                                                "escape" => false
                                            ));
                                            ?>
                                        </li>
                                        <li>
                                            <?php
                                            echo $this->Html->link("<i class='icon-list-alt icon-white'></i> View Projects", array(
                                                "controller" => "builder_projects",
                                                "action" => "index",
                                                "plugin" => "customer_manager",
                                                    ), array(
                                                "escape" => false
                                            ));
                                            ?>
                                        </li>
                                    </ul>
                                </li>
                        </li>
                        <!-- builder setup end -->
                        <li>
                            <?php
                            echo $this->Html->link("<i class='icon-wrench icon-white'></i> Customer Data Setup", array(
                                "controller" => "inventory_lookups",
                                "action" => 'index',
                                "plugin" => "inventory", 'Customer' ), array(
                                "escape" => false
                            ));
                            ?>
                        </li>
                    </ul>
                    </li>
                <?php } ?>
                <!-- customer setup end -->

                <!-- Quote start -->
                <?php if( $loginUser['permission_quote'] == 1 ) { ?>
                    <li>
                        <?php
//            echo $this->Html->link("<i class='icon-retweet icon-white'></i> Orders", array(
//                "controller" => "quotes",
//                "action" => "index",
//                "plugin" => "quote_manager"), array(
//                "escape" => false
//            ));
                        ?>
                        <!--<ul>
                          <li>-->
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
                        <ul>
                            <li>
                                <?php
                                echo $this->Html->link("<i class='icon-list-alt icon-white'></i> View Quotes", array(
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
                            <li>
                                <?php
                                echo $this->Html->link("<i class='icon-plus icon-white'></i> Add Quotes", array(
                                    "controller" => "quotes",
                                    "action" => ADD,
                                    "plugin" => "quote_manager" ), array(
                                    "escape" => false
                                ));
                                ?>
                            </li>
                            <li>
                                <?php
                                echo $this->Html->link("<i class='icon-file icon-white'></i> Report", array(
                                    "controller" => "quotes",
                                    "action" => "reports",
                                    "plugin" => "quote_manager" ), array(
                                    "escape" => false
                                ));
                                ?>
                            </li>
                            <!--            <li>
                            <?php
                            echo $this->Html->link("<i class='icon-wrench icon-white'></i> Quote Reports Settings", array(
                                "controller" => "quote_reports_settings",
                                "action" => "index",
                                "sort" => "report_name",
                                "plugin" => "quote_manager" ), array(
                                "escape" => false
                            ));
                            ?>
                                          <ul>
                                            <li>
                            <?php
                            echo $this->Html->link("<i class='icon-wrench icon-white'></i> Quote Reports Settings", array(
                                "controller" => "quote_reports_settings",
                                "action" => "index",
                                "sort" => "report_name",
                                "plugin" => "quote_manager" ), array(
                                "escape" => false
                            ));
                            ?>
                                            </li>
                                            <li>
                            <?php
                            echo $this->Html->link("<i class='icon-wrench icon-white'></i> Door/Drawer Width Setup", array(
                                "controller" => "inventory_lookups",
                                "action" => 'index',
                                "plugin" => "inventory", 'Door_Drawer_Width' ), array(
                                "escape" => false
                            ));
                            ?>
                                            </li>
                                            <li>
                            <?php
                            echo $this->Html->link("<i class='icon-wrench icon-white'></i> Door Height Setup", array(
                                "controller" => "inventory_lookups",
                                "action" => 'index',
                                "plugin" => "inventory", 'Door_Height' ), array(
                                "escape" => false
                            ));
                            ?>
                                            </li>
                                            <li>
                            <?php
                            echo $this->Html->link("<i class='icon-wrench icon-white'></i> Door Width Setup", array(
                                "controller" => "inventory_lookups",
                                "action" => 'index',
                                "plugin" => "inventory", 'Door_Width' ), array(
                                "escape" => false
                            ));
                            ?>
                                            </li>
                                            <li>
                            <?php
                            echo $this->Html->link("<i class='icon-wrench icon-white'></i> Drawer Height Setup", array(
                                "controller" => "inventory_lookups",
                                "action" => 'index',
                                "plugin" => "inventory", 'Drawer_Height' ), array(
                                "escape" => false
                            ));
                            ?>
                                            </li>
                                          </ul>
                                        </li>-->
                            <!--            <li>
                            <?php
                            echo $this->Html->link("<i class='icon-file icon-white'></i> Report", array(
                                "controller" => "quotes",
                                "action" => "reports",
                                "plugin" => "quote_manager" ), array(
                                "escape" => false
                            ));
                            ?>
                                        </li>-->
                            <li>
                                <?php
                                echo $this->Html->link("<i class='icon-wrench icon-white'></i> Quote Data Setup", array(
                                    "controller" => "inventory_lookups",
                                    "action" => 'index',
                                    "plugin" => "inventory", 'Quote' ), array(
                                    "escape" => false
                                ));
                                ?>
                            </li>
                            <!--						<li>
                            <?php
                            echo $this->Html->link("<i class='icon-wrench icon-white'></i> Production Time Setup", array(
                                "controller" => "quotes",
                                "action" => 'production_index',
                                "plugin" => "quote_manager" ), array(
                                "escape" => false
                            ));
                            ?>
                                        </li>-->
                        </ul>
                    </li>
                <?php } ?>
                <!-- Quote end -->

                <?php if( $loginUser['permission_work_order'] == 1 ) { ?>
                    <li>
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
                        <ul>
                            <!--            <li>
                            <?php
                            echo $this->Html->link("<i class='icon-plus icon-white'></i> Add Work Order", array(
                                "controller" => "work_orders",
                                "action" => ADD,
                                "plugin" => "work_order_manager" ), array(
                                "escape" => false
                            ));
                            ?>
                                        </li>-->
                            <li>
                                <?php
                                echo $this->Html->link("<i class='icon-list-alt icon-white'></i> View Work Order", array(
                                    "controller" => "work_orders",
                                    "action" => "index",
                                    "plugin" => "work_order_manager",
                                    "sort" => "work_order_number",
                                    "direction" => "desc"
                                        ), array(
                                    "escape" => false
                                ));
                                ?>
                            </li>
                            <li>
                                <?php
                                echo $this->Html->link("<i class='icon-list-alt icon-white'></i> Container Tracking", array(
                                    "controller" => "containers",
                                    "action" => "index",
                                    "plugin" => "container_manager",
                                    "sort" => "container_no",
                                    "direction" => "desc"
                                        ), array(
                                    "escape" => false
                                ));
                                ?>
                                <ul>
                                    <li>
                                        <?php
                                        echo $this->Html->link("<i class='icon-list-alt icon-white'></i> Book/load Container", array(
                                            "controller" => "containers",
                                            "action" => "container_index",
                                            "plugin" => "container_manager",
                                                ), array(
                                            "escape" => false
                                        ));
                                        ?>
                                    </li>
                                    <li>
                                        <?php
                                        echo $this->Html->link("<i class='icon-list-alt icon-white'></i> Inventory Skids", array(
                                            "controller" => "skid_inventorys",
                                            "action" => "index",
                                            "plugin" => "container_manager",
                                            "sort" => "skid_no",
                                            "direction" => "desc"
                                                ), array(
                                            "escape" => false
                                        ));
                                        ?>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                <?php } ?>

                <?php if( $loginUser['permission_purchase_order'] == 1 ) { ?>
                    <li>
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
                        <ul>
                            <li>
                                <?php
                                echo $this->Html->link("<i class='icon-list-alt icon-white'></i> Purchase Order", array(
                                    "controller" => "purchase_orders",
                                    "action" => "index",
                                    "plugin" => "purchase_order_manager",
                                    "sort" => "purchase_order_num",
                                    "direction" => "desc" ), array(
                                    "escape" => false
                                ));
                                ?>
                                <ul>
                                    <li>
                                        <?php
                                        echo $this->Html->link("<i class='icon-list-alt icon-white'></i> View Purchase Orders", array(
                                            "controller" => "purchase_orders",
                                            "action" => "index",
                                            "plugin" => "purchase_order_manager",
                                            "sort" => "purchase_order_num",
                                            "direction" => "desc"
                                                ), array(
                                            "escape" => false
                                        ));
                                        ?>
                                    </li>
                                    <li>
                                        <?php
                                        echo $this->Html->link("<i class='icon-plus icon-white'></i> Add Purchase Order", array(
                                            "controller" => "purchase_orders",
                                            "action" => ADD,
                                            "plugin" => "purchase_order_manager" ), array(
                                            "escape" => false
                                        ));
                                        ?>
                                    </li>
                                </ul>
                            </li>

                            <li>
                                <?php
                                echo $this->Html->link("<i class='icon-list-alt icon-white'></i> Purchase Receive", array(
                                    "controller" => "purchase_orders",
                                    "action" => "received_view",
                                    "plugin" => "purchase_order_manager",
                                    "sort" => "purchase_order_num",
                                    "direction" => "desc" ), array(
                                    "escape" => false
                                ));
                                ?>
                                <ul>
                                    <li>
                                        <?php
                                        echo $this->Html->link("<i class='icon-list-alt icon-white'></i> View Purchase Receive", array(
                                            "controller" => "purchase_orders",
                                            "action" => "received_view",
                                            "plugin" => "purchase_order_manager",
                                            "sort" => "purchase_order_num",
                                            "direction" => "desc" ), array(
                                            "escape" => false
                                        ));
                                        ?>
                                    </li>
                                    <li>
                                        <?php
                                        echo $this->Html->link("<i class='icon-plus icon-white'></i> Purchase Receive", array(
                                            "controller" => "purchase_orders",
                                            "action" => "received",
                                            "plugin" => "purchase_order_manager",
                                                ), array(
                                            "escape" => false
                                        ));
                                        ?>
                                    </li>
                                </ul>
                            </li>
                            <!--<li>
                            <?php
                            echo $this->Html->link("<i class='icon-file icon-white'></i> Report", array(
                                "controller" => "purchase_orders",
                                "action" => "reports",
                                "plugin" => "purchase_order_manager",
                                "sort" => "purchase_order_num",
                                "direction" => "asc" ), array(
                                "escape" => false
                            ));
                            ?>
                            </li>
                            <li>
                            <?php
                            echo $this->Html->link("<i class='icon-file icon-white'></i> Invoice", array(
                                "controller" => "invoices",
                                "action" => "index",
                                "plugin" => "invoice_manager", 'Purchase Order',
                                "sort" => "invoice_no",
                                "direction" => "asc"
                                    ), array(
                                "escape" => false
                            ));
                            ?>
                            </li>-->
                        </ul>
                    </li>
                <?php } ?>

                <?php if( $loginUser['permission_schedule'] == 1 ) { ?>
                    <li>
                        <?php
                        echo $this->Html->link("<i class='icon-file icon-white'></i>Schedule", array(
                            "controller" => "appointments",
                            "action" => "index",
                            "plugin" => "schedule_manager" ), array(
                            "escape" => false
                        ));
                        ?>
                        <ul>
                            <li>
                                <?php
                                echo $this->Html->link("<i class='icon-list-alt icon-white'></i> Services", array(
                                    "controller" => "service_entries",
                                    "action" => "index",
                                    "plugin" => "schedule_manager",
                                    "sort" => "work_order_id",
                                    "direction" => "asc"
                                        ), array(
                                    "escape" => false
                                ));
                                ?>
                                <ul class="schedule-sub-menu">
                                    <li>
                                        <?php
                                        echo $this->Html->link("<i class='icon-plus icon-white'></i> Add Service", array(
                                            "controller" => "service_entries",
                                            "action" => ADD,
                                            "plugin" => "schedule_manager" ), array(
                                            "escape" => false
                                        ));
                                        ?>
                                    </li>
                                    <li>
                                        <?php
                                        echo $this->Html->link("<i class='icon-list-alt icon-white'></i> View Services", array(
                                            "controller" => "service_entries",
                                            "action" => "index",
                                            "plugin" => "schedule_manager",
                                            "sort" => "work_order_id",
                                            "direction" => "asc"
                                                ), array(
                                            "escape" => false
                                        ));
                                        ?>
                                    </li>
                                </ul>
                            </li>
                            <!--            <li>
                            <?php
                            echo $this->Html->link("<i class='icon-list-alt icon-white'></i> Schedule", array(
                                "controller" => "appointments",
                                "action" => "index",
                                "plugin" => "schedule_manager",
                                    ), array(
                                "escape" => false
                            ));
                            ?>
                                        </li>-->
                            <li>
                                <?php
                                echo $this->Html->link("<i class='icon-list-alt icon-white'></i> Installer", array(
                                    "controller" => "installers",
                                    "action" => "index",
                                    "plugin" => "schedule_manager",
                                    "sort" => "name_lookup_id",
                                    "direction" => "asc"
                                        ), array(
                                    "escape" => false
                                ));
                                ?>
                                <ul class="schedule-sub-menu">
                                    <li>
                                        <?php
                                        echo $this->Html->link("<i class='icon-plus icon-white'></i> Add Installer", array(
                                            "controller" => "installers",
                                            "action" => ADD,
                                            "plugin" => "schedule_manager" ), array(
                                            "escape" => false
                                        ));
                                        ?>
                                    </li>
                                    <li>
                                        <?php
                                        echo $this->Html->link("<i class='icon-list-alt icon-white'></i> View Installer", array(
                                            "controller" => "installers",
                                            "action" => "index",
                                            "plugin" => "schedule_manager",
                                            "sort" => "name_lookup_id",
                                            "direction" => "asc"
                                                ), array(
                                            "escape" => false
                                        ));
                                        ?>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <?php
                                echo $this->Html->link("<i class='icon-list-alt icon-white'></i> View Installer Schedule", array(
                                    "controller" => "installer_schedules",
                                    "action" => "index",
                                    "plugin" => "schedule_manager",
                                    "sort" => "work_order_id",
                                    "direction" => "asc"
                                        ), array(
                                    "escape" => false
                                ));
                                ?>
                                <ul class="schedule-sub-menu">
                                    <li>
                                        <?php
                                        echo $this->Html->link("<i class='icon-plus icon-white'></i> Add Installer Schedule", array(
                                            "controller" => "installer_schedules",
                                            "action" => ADD,
                                            "plugin" => "schedule_manager" ), array(
                                            "escape" => false
                                        ));
                                        ?>
                                    </li>
                                    <li>
                                        <?php
                                        echo $this->Html->link("<i class='icon-list-alt icon-white'></i> View Installer Schedule", array(
                                            "controller" => "installer_schedules",
                                            "action" => "index",
                                            "plugin" => "schedule_manager",
                                                //"sort" => "",
                                                //"direction" => "asc"
                                                ), array(
                                            "escape" => false
                                        ));
                                        ?>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <?php
                                echo $this->Html->link("<i class='icon-wrench icon-white'></i> Schedule Data Setup", array(
                                    "controller" => "inventory_lookups",
                                    "action" => 'index',
                                    "plugin" => "inventory", 'Schedule' ), array(
                                    "escape" => false
                                ));
                                ?>
                            </li>
                        </ul>
                    </li>
                <?php } ?>

                <?php if( $loginUser['permission_admin'] == 1 ) { ?>
                    <li>
                        <?php
                        echo $this->Html->link("<i class='icon-file icon-white'></i>Admin", array(
                            "controller" => "users",
                            "action" => "index",
                            "plugin" => "user_manager" ), array(
                            "escape" => false
                        ));
                        ?>
                        <ul class="user-sub-menu">
                            <li>
                                <?php
                                echo $this->Html->link("<i class='icon-file icon-white'></i>Users", array(
                                    "controller" => "users",
                                    "action" => "index",
                                    "plugin" => "user_manager" ), array(
                                    "escape" => false
                                ));
                                ?>
                                <ul class="user-sub-menu">
                                    <li>
                                        <?php
                                        echo $this->Html->link("<i class='icon-plus icon-white'></i>Add User", array(
                                            "controller" => "users",
                                            "action" => ADD,
                                            "plugin" => "user_manager" ), array(
                                            "escape" => false
                                        ));
                                        ?>
                                    </li>
                                    <li>
                                        <?php
                                        echo $this->Html->link("<i class='icon-list-alt icon-white'></i>View User", array(
                                            "controller" => "users",
                                            "action" => "index",
                                            "plugin" => "user_manager",
                                            "sort" => "name",
                                            "direction" => "asc" ), array(
                                            "escape" => false
                                        ));
                                        ?>
                                    </li>
                                    <li>
                                        <?php
                                        echo $this->Html->link("<i class='icon-wrench icon-white'></i> User Data Setup", array(
                                            "controller" => "inventory_lookups",
                                            "action" => 'index',
                                            "plugin" => "inventory", 'User' ), array(
                                            "escape" => false
                                        ));
                                        ?>
                                    </li>
                                </ul>
                            </li>

                            <!-- inventory setup start -->
                            <li>
                                <?php
                                echo $this->Html->link("<i class=' icon-shopping-cart icon-white'></i> Inventory", array(
                                    "controller" => "items",
                                    "action" => "index",
                                    "plugin" => "inventory",
                                    "sort" => "number",
                                    "direction" => "asc",
                                        ), array( "escape" => false )
                                );
                                ?>
                                <!--              <ul>
                                                <li>
                                <?php
                                echo $this->Html->link("<i class='icon-cog icon-white'></i> Item/Item Department", array(
                                    "controller" => "items",
                                    "action" => "index",
                                    "plugin" => "inventory",
                                    "sort" => "number",
                                    "direction" => "asc",
                                        ), array(
                                    "escape" => false
                                ));
                                ?>
                                                  <ul>
                                                    <li>
                                <?php
                                echo $this->Html->link("<i class='icon-cog icon-white'></i> Item", array(
                                    "controller" => "items",
                                    "action" => "index",
                                    "plugin" => "inventory",
                                    "sort" => "number",
                                    "direction" => "asc",
                                        ), array(
                                    "escape" => false
                                ));
                                ?>
                                                      <ul>
                                                        <li>
                                <?php
                                echo $this->Html->link("<i class='icon-list-alt icon-white'></i> View Items", array(
                                    "controller" => "items",
                                    "action" => "index",
                                    "plugin" => "inventory",
                                    "sort" => "number",
                                    "direction" => "asc",
                                        ), array(
                                    "escape" => false
                                ));
                                ?>
                                                        </li>
                                                        <li>
                                <?php
                                echo $this->Html->link("<i class='icon-plus icon-white'></i> Add Item", array(
                                    "controller" => "items",
                                    "action" => ADD,
                                    "plugin" => "inventory" ), array(
                                    "escape" => false
                                ));
                                ?>
                                                        </li>
                                                        <li>
                                <?php
                                echo $this->Html->link("<i class='icon-wrench icon-white'></i> Item Data Setup", array(
                                    "controller" => "inventory_lookups",
                                    "action" => 'index',
                                    "plugin" => "inventory", 'Item' ), array(
                                    "escape" => false
                                ));
                                ?>
                                                        </li>
                                                        <li>
                                <?php
                                echo $this->Html->link("<i class='icon-wrench icon-white'></i> Item Group Setup", array(
                                    "controller" => "inventory_lookups",
                                    "action" => 'index',
                                    "plugin" => "inventory", 'Item_Group' ), array(
                                    "escape" => false
                                ));
                                ?>
                                                        </li>
                                                      </ul>
                                                    </li>
                                                    <li>
                                <?php
                                echo $this->Html->link("<i class='icon-cog icon-white'></i>Item Departments", array(
                                    "controller" => "item_departments",
                                    "action" => "index",
                                    "plugin" => "inventory",
                                    "sort" => "name",
                                    "direction" => "asc",
                                        ), array(
                                    "escape" => false
                                ));
                                ?>
                                                      <ul>
                                                        <li>
                                <?php
                                echo $this->Html->link("<i class='icon-list-alt icon-white'></i> View Item Departments", array(
                                    "controller" => "item_departments",
                                    "action" => "index",
                                    "plugin" => "inventory",
                                    "sort" => "name",
                                    "direction" => "asc",
                                        ), array(
                                    "escape" => false
                                ));
                                ?>
                                                        </li>
                                                        <li>
                                <?php
                                echo $this->Html->link("<i class='icon-plus icon-white'></i> Add Item Department", array(
                                    "controller" => "item_departments",
                                    "action" => ADD,
                                    "plugin" => "inventory" ), array(
                                    "escape" => false
                                ));
                                ?>
                                                        </li>
                                                      </ul>
                                                    </li>
                                                    <li>
                                <?php
                                echo $this->Html->link("<i class='icon-wrench icon-white'></i> Item Material Setup", array(
                                    "controller" => "material_groups",
                                    "action" => 'index',
                                    "plugin" => "inventory" ), array(
                                    "escape" => false
                                ));
                                ?>
                                                      <ul>
                                                        <li>
                                <?php
                                echo $this->Html->link("<i class='icon-list-alt icon-white'></i> View Material Groups", array(
                                    "controller" => "material_groups",
                                    "action" => "index",
                                    "plugin" => "inventory",
                                        ), array(
                                    "escape" => false
                                ));
                                ?>
                                                        </li>
                                                        <li>
                                <?php
                                echo $this->Html->link("<i class='icon-list-alt icon-white'></i> View Materials", array(
                                    "controller" => "materials",
                                    "action" => "index",
                                    "plugin" => "inventory" ), array(
                                    "escape" => false
                                ));
                                ?>
                                                        </li>
                                                      </ul>
                                                    </li>
                                                  </ul>
                                                </li>
                                
                                                <li>
                                <?php
                                echo $this->Html->link("<i class='icon-wrench icon-white'></i> Drawer", array(
                                    "controller" => "inventory_lookups",
                                    "action" => 'index',
                                    "plugin" => "inventory", 'Drawer' ), array(
                                    "escape" => false
                                ));
                                ?>
                                                </li>
                                
                                                <li>
                                <?php
                                echo $this->Html->link("<i class='icon-cog icon-white'></i> Door", array(
                                    "controller" => "doors",
                                    "action" => "index",
                                    "plugin" => "inventory",
                                    "sort" => "door_style",
                                    "direction" => "asc",
                                        ), array(
                                    "escape" => false
                                ));
                                ?>
                                                  <ul>
                                                    <li>
                                <?php
                                echo $this->Html->link("<i class='icon-list-alt icon-white'></i> View Doors", array(
                                    "controller" => "doors",
                                    "action" => "index",
                                    "plugin" => "inventory",
                                    "sort" => "door_style",
                                    "direction" => "asc",
                                        ), array(
                                    "escape" => false
                                ));
                                ?>
                                                    </li>
                                                    <li>
                                <?php
                                echo $this->Html->link("<i class='icon-plus icon-white'></i> Add Door", array(
                                    "controller" => "doors",
                                    "action" => ADD,
                                    "plugin" => "inventory" ), array(
                                    "escape" => false
                                ));
                                ?>
                                                    </li>
                                                    <li>
                                <?php
                                echo $this->Html->link("<i class='icon-wrench icon-white'></i> Door Data Setup", array(
                                    "controller" => "inventory_lookups",
                                    "action" => 'index',
                                    "plugin" => "inventory", 'Door' ), array(
                                    "escape" => false
                                ));
                                ?>
                                                    </li>
                                                  </ul>
                                                </li>
                                                <li>
                                <?php
                                echo $this->Html->link("<i class='icon-cog icon-white'></i> Cabinet", array(
                                    "controller" => "cabinets",
                                    "action" => "index",
                                    "plugin" => "inventory",
                                    "sort" => "name",
                                    "direction" => "asc",
                                        ), array(
                                    "escape" => false
                                ));
                                ?>
                                                  <ul>
                                                    <li>
                                <?php
                                echo $this->Html->link("<i class='icon-list-alt icon-white'></i> View Cabinets", array(
                                    "controller" => "cabinets",
                                    "action" => "index",
                                    "plugin" => "inventory",
                                    "sort" => "name",
                                    "direction" => "asc",
                                        ), array(
                                    "escape" => false
                                ));
                                ?>
                                                    </li>
                                                    <li>
                                <?php
                                echo $this->Html->link("<i class='icon-plus icon-white'></i> Add Cabinet", array(
                                    "controller" => "cabinets",
                                    "action" => ADD,
                                    "plugin" => "inventory" ), array(
                                    "escape" => false
                                ));
                                ?>
                                                    </li>
                                                    <li>
                                <?php
                                echo $this->Html->link("<i class='icon-wrench icon-white'></i> Cabinet Data Setup", array(
                                    "controller" => "inventory_lookups",
                                    "action" => 'index',
                                    "plugin" => "inventory", 'Cabinet' ), array(
                                    "escape" => false
                                ));
                                ?>
                                                    </li>
                                                    <li>
                                <?php
                                echo $this->Html->link("<i class='icon-wrench icon-white'></i> Installation Task", array(
                                    "controller" => "inventory_lookups",
                                    "action" => 'index',
                                    "plugin" => "inventory", 'Installation' ), array(
                                    "escape" => false
                                ));
                                ?>
                                                    </li>
                                                  </ul>
                                                </li>
                                
                                                <li>
                                <?php
                                echo $this->Html->link("<i class='icon-wrench icon-white'></i> Color Setup", array(
                                    "controller" => "colors",
                                    "action" => "index",
                                    "plugin" => "inventory",
                                    "sort" => "name",
                                    "direction" => "asc",
                                        ), array(
                                    "escape" => false
                                ));
                                ?>
                                                </li>
                                
                                              </ul>-->
                            </li>
                            <!-- inventory setup end -->

                            <!-- supplier setup start -->
                            <li>
                                <?php
                                echo $this->Html->link("<i class='icon-cog icon-white'></i> Vendor", array(
                                    "controller" => "suppliers",
                                    "action" => "index",
                                    "plugin" => "inventory",
                                    "sort" => "name",
                                    "direction" => "asc",
                                        ), array(
                                    "escape" => false
                                ));
                                ?>
                                <ul>
                                    <li>
                                        <?php
                                        echo $this->Html->link("<i class='icon-list-alt icon-white'></i> View Vendors", array(
                                            "controller" => "suppliers",
                                            "action" => "index",
                                            "plugin" => "inventory",
                                            "sort" => "name",
                                            "direction" => "asc",
                                                ), array(
                                            "escape" => false
                                        ));
                                        ?>
                                    </li>
                                    <li>
                                        <?php
                                        echo $this->Html->link("<i class='icon-plus icon-white'></i> Add Vendor", array(
                                            "controller" => "suppliers",
                                            "action" => ADD,
                                            "plugin" => "inventory" ), array(
                                            "escape" => false
                                        ));
                                        ?>
                                    </li>
                                    <li>
                                        <?php
                                        echo $this->Html->link("<i class='icon-wrench icon-white'></i> Vendor Data Setup", array(
                                            "controller" => "inventory_lookups",
                                            "action" => 'index',
                                            "plugin" => "inventory", 'Supplier' ), array(
                                            "escape" => false
                                        ));
                                        ?>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <?php
                                echo $this->Html->link("<i class='icon-wrench icon-white'></i> Quote Reports Settings", array(
                                    "controller" => "quote_reports_settings",
                                    "action" => "index",
                                    "sort" => "report_name",
                                    "plugin" => "quote_manager" ), array(
                                    "escape" => false
                                ));
                                ?>
                                <ul>
                                    <li>
                                        <?php
                                        echo $this->Html->link("<i class='icon-wrench icon-white'></i> Quote Reports Settings", array(
                                            "controller" => "quote_reports_settings",
                                            "action" => "index",
                                            "sort" => "report_name",
                                            "plugin" => "quote_manager" ), array(
                                            "escape" => false
                                        ));
                                        ?>
                                    </li>
                                    <li>
                                        <?php
                                        echo $this->Html->link("<i class='icon-wrench icon-white'></i> Door/Drawer Width Setup", array(
                                            "controller" => "inventory_lookups",
                                            "action" => 'index',
                                            "plugin" => "inventory", 'Door_Drawer_Width' ), array(
                                            "escape" => false
                                        ));
                                        ?>
                                    </li>
                                    <li>
                                        <?php
                                        echo $this->Html->link("<i class='icon-wrench icon-white'></i> Door Height Setup", array(
                                            "controller" => "inventory_lookups",
                                            "action" => 'index',
                                            "plugin" => "inventory", 'Door_Height' ), array(
                                            "escape" => false
                                        ));
                                        ?>
                                    </li>
                                    <li>
                                        <?php
                                        echo $this->Html->link("<i class='icon-wrench icon-white'></i> Door Width Setup", array(
                                            "controller" => "inventory_lookups",
                                            "action" => 'index',
                                            "plugin" => "inventory", 'Door_Width' ), array(
                                            "escape" => false
                                        ));
                                        ?>
                                    </li>
                                    <li>
                                        <?php
                                        echo $this->Html->link("<i class='icon-wrench icon-white'></i> Drawer Height Setup", array(
                                            "controller" => "inventory_lookups",
                                            "action" => 'index',
                                            "plugin" => "inventory", 'Drawer_Height' ), array(
                                            "escape" => false
                                        ));
                                        ?>
                                    </li>
                                </ul>
                            </li>
                            <!-- supplier setup end -->
                            <li>
                                <?php
                                echo $this->Html->link("<i class='icon-wrench icon-white'></i> General Settings", array(
                                    "controller" => "purchase_orders",
                                    "action" => "general_setting_list",
                                    "plugin" => "purchase_order_manager" ), array(
                                    "escape" => false
                                ));
                                ?>
                                <ul>
                                    <li>
                                        <?php
                                        echo $this->Html->link("<i class='icon-wrench icon-white'></i> Location Settings", array(
                                            "controller" => "purchase_orders",
                                            "action" => "location_list",
                                            "plugin" => "purchase_order_manager", null, 'location' ), array(
                                            "escape" => false
                                        ));
                                        ?>
                                    </li>                
                                </ul>
                            </li>
                        </ul>
                    </li>
                <?php } ?>
                </ul>
            </div>
        </div>
    </div>
</div>


