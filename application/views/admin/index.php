<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box admin-small-box bg-success">
            <div class="inner">
                <h3 class="increase-count"><?php echo $order_count; ?></h3>
                <a href="<?php echo admin_url(); ?>orders">
                    <p>Lowongan Kerja</p>
                </a>
            </div>
            <div class="icon">
                <a href="#">
                    <i class="fa fa-list-alt"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box admin-small-box bg-purple">
            <div class="inner">
                <h3 class="increase-count"><?php echo $product_count; ?></h3>
                <a href="<?php echo admin_url(); ?>products">
                    <p>Perusahaan</p>
                </a>
            </div>
            <div class="icon">
                <a href="<?php echo admin_url(); ?>products">
                    <i class="fa fa-shopping-basket"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- <div class="col-lg-3 col-xs-6">
        <div class="small-box admin-small-box bg-danger">
            <div class="inner">
                <h3 class="increase-count"><?php #echo $pending_product_count; ?></h3>
                <a href="<?php #echo admin_url(); ?>pending-products">
                    <p><?php #echo trans("pending_products"); ?></p>
                </a>
            </div>
            <div class="icon">
                <a href="<?php #echo admin_url(); ?>pending-products">
                    <i class="fa fa-low-vision"></i>
                </a>
            </div>
        </div>
    </div> -->

    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box admin-small-box bg-warning">
            <div class="inner">
                <h3 class="increase-count"><?php echo $members_count; ?></h3>
                <a href="<?php echo admin_url(); ?>members">
                    <p><?php echo trans("members"); ?></p>
                </a>
            </div>
            <div class="icon">
                <a href="<?php echo admin_url(); ?>members">
                    <i class="fa fa-users"></i>
                </a>
            </div>
        </div>
    </div>

</div>

<div class="row">
    <div class="col-lg-6 col-sm-12 col-xs-12">
        <div class="box box-primary box-sm">
            <div class="box-header with-border">
                <h3 class="box-title">Lowongan Terbaru</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                class="fa fa-times"></i>
                    </button>
                </div>
            </div><!-- /.box-header -->

            <div class="box-body index-table">
                <div class="table-responsive">
                    <table class="table no-margin">
                        <thead>
                        <tr>
                            <th><?php echo trans("order"); ?></th>
                            <th><?php echo trans("total"); ?></th>
                            <th><?php echo trans("status"); ?></th>
                            <th><?php echo trans("date"); ?></th>
                            <th><?php echo trans("details"); ?></th>
                        </tr>
                        </thead>
                        <tbody>

                    

                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>

            <div class="box-footer clearfix">
                <a href="<?php echo admin_url(); ?>orders"
                   class="btn btn-sm btn-default pull-right"><?php echo trans("view_all"); ?></a>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-sm-12 col-xs-12">
        <div class="box box-primary box-sm">
            <div class="box-header with-border">
                <h3 class="box-title">Perusahaan terbaru</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                class="fa fa-times"></i>
                    </button>
                </div>
            </div><!-- /.box-header -->

            <div class="box-body index-table">
                <div class="table-responsive">
                    <table class="table no-margin">
                        <thead>
                        <tr>
                            <th><?php echo trans("id"); ?></th>
                            <th><?php echo trans("order"); ?></th>
                            <th><?php echo trans("payment_amount"); ?></th>
                            <th><?php echo trans('payment_method'); ?></th>
                            <th><?php echo trans('status'); ?></th>
                            <th><?php echo trans("date"); ?></th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>

            <div class="box-footer clearfix">
                <a href="<?php echo admin_url(); ?>transactions"
                   class="btn btn-sm btn-default pull-right"><?php echo trans("view_all"); ?></a>
            </div>
        </div>
    </div>
</div>

<div class="row">

    <div class="no-padding margin-bottom-20">
        <div class="col-lg-6 col-sm-12 col-xs-12">
            <!-- USERS LIST -->
            <div class="box box-primary box-sm">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo trans("latest_members"); ?></h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                    class="fa fa-times"></i>
                        </button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <ul class="users-list clearfix">

                        <?php foreach ($latest_members as $item) : ?>
                            <li>
                                <a href="<?php echo base_url(); ?>profile/<?php echo $item->slug; ?>">
                                    <img src="<?php echo get_user_avatar($item); ?>" alt="user" class="img-responsive">
                                </a>
                                <a href="<?php echo base_url(); ?>profile/<?php echo $item->slug; ?>" class="users-list-name"><?php echo html_escape($item->username); ?></a>
                                <span class="users-list-date"><?php echo time_ago($item->created_at); ?></span>
                            </li>

                        <?php endforeach; ?>
                    </ul>
                    <!-- /.users-list -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer text-center">
                    <a href="<?php echo admin_url(); ?>members" class="btn btn-sm btn-default btn-flat pull-right"><?php echo trans("view_all"); ?></a>
                </div>
                <!-- /.box-footer -->
            </div>
            <!--/.box -->
        </div>
    </div>
</div>



