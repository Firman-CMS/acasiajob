<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-sm-12 col-xs-12 col-md-8">
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title"><?php echo trans('new_company'); ?></h3>
                </div>
            </div><!-- /.box-header -->

            <!-- form start -->
            <?php echo form_open_multipart('aj_company_controller/add_new_post'); ?>

            <div class="box-body">

                <!-- include message block -->
                <?php $this->load->view('admin/includes/_messages'); ?>

                <div class="box-body">
                    <label class="control-label">Logo Perusahaan</label>
                    <div style="margin-bottom: 10px;">
                    </div>
                    <div class="display-block">
                        <a class='btn btn-success btn-sm btn-file-upload'>
                            <?php echo trans('select_logo'); ?>
                            <input type="file" name="logo_perusahaan" size="40" accept=".png, .jpg, .jpeg" onchange="$('#upload-file-info3').html($(this).val());">
                        </a>
                        (.png, .jpg, .jpeg)
                    </div>
                    <span class='label label-info' id="upload-file-info3"></span>
                </div>
                <div class="box-body">

                <div class="form-group">
                    <input type="text" name="company_name" class="form-control auth-form-input" placeholder="Nama Perusahaan" required>
                </div>
                <div class="form-group">
                    <textarea class="form-control" name="address" rows="2" placeholder="Alamat" required></textarea>
                </div>
                <div class="form-group">
                    <textarea class="form-control" name="description" rows="3" placeholder="Deskripsi Perusahan" required></textarea>
                </div>

            </div>

            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
            </div>
            <!-- /.box-footer -->
            <?php echo form_close(); ?><!-- form end -->
        </div>
        <!-- /.box -->
    </div>
</div>

<style>
    .form-group {
        margin-bottom: 30px !important;
    }
</style>