<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-sm-12 col-xs-12 col-md-8">
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title"><?php echo $company->company_name?></h3>
                </div>
            </div><!-- /.box-header -->

            <!-- form start -->
            <?php echo form_open_multipart('aj_company_controller/edit_post'); ?>

            <div class="box-body">

                <!-- include message block -->
                <?php $this->load->view('admin/includes/_messages'); ?>
                <input type="hidden" name="id" value="<?php echo html_escape($company->id); ?>">
                <div class="box-body">
                    <label class="control-label">Logo Perusahaan</label>
                    <div style="margin-bottom: 10px;">
                        <img src="<?php echo getPicturePath($company->picture); ?>" alt="logo" style="max-width: 160px; max-height: 160px;">
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
                    <input type="text" name="company_name" class="form-control auth-form-input" value="<?php echo $company->company_name?>" placeholder="Nama Perusahaan" required>
                </div>
                <div class="form-group">
                    <textarea class="form-control" name="address" rows="3"  placeholder="Alamat" required><?php echo $company->address?></textarea>
                </div>
                <div class="form-group">
                    <textarea class="form-control" name="description" rows="3"  placeholder="Deskripsi Perusahan" required><?php echo $company->description?></textarea>
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