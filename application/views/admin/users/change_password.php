<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-lg-6 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo $title; ?></h3>
            </div>
            <!-- /.box-header -->

            <!-- form start -->
            <?php echo form_open_multipart('aj_admin_controller/change_password_post'); ?>

            <div class="box-body">
                <!-- include message block -->
                <?php $this->load->view('admin/includes/_messages'); ?>

                <div class="form-group">
                    <input type="password" name="old_password" class="form-control auth-form-input" placeholder="password lama" required>
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control auth-form-input" placeholder="password baru" required>
                </div>
                <div class="form-group">
                    <input type="password" name="password_confirm" class="form-control auth-form-input" placeholder="konfirmasi password" required>
                </div>
            </div>

            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right"><?php echo trans('change_password'); ?></button>
            </div>
            <!-- /.box-footer -->
            <?php echo form_close(); ?><!-- form end -->
        </div>
        <!-- /.box -->
    </div>
</div>

