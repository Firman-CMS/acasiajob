<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title"><?php echo trans("new_job_vacancy"); ?></h3>

        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
        </div>
    </div>
    <?php echo form_open('aj_job_controller/add_new_post'); ?>
    <div class="box-body">
        <div class="row">
            <div class="col-md-6">
                    <!-- form start -->
                <div class="box-body">
                    <!-- include message block -->
                    <?php $this->load->view('admin/includes/_messages_form'); ?>
                    <div class="form-group">
                        <label><?php echo trans("job_title"); ?></label>
                        <input type="text" class="form-control" name="title" placeholder="ex : Backend developer"
                               maxlength="200" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?> required>
                    </div>
                    <label><?php echo trans("salary"); ?></label>
                    <div class="row">
                        <div class="col-sm-6">
                          <!-- text input -->
                          <div class="form-group">
                            <label><?php echo trans("starting_from"); ?></label>
                            <input type="number" class="form-control" name="salary_min" placeholder="ex : 3000000"
                               maxlength="200" required>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label><?php echo trans("up_to"); ?></label>
                            <input type="number" class="form-control" name="salary" placeholder="ex : 8500000" 
                               maxlength="200" required>
                          </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                          <!-- text input -->
                          <div class="form-group">
                            <label><?php echo trans("job_position"); ?></label>
                            <select name="job_position_id" class="form-control">
                                <?php foreach ($position as $data) { ?>
                                    <option value="<?php echo $data['value']; ?>"><?php echo $data['label']; ?></option>
                                <?php } ?>
                            </select>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label><?php echo trans("job_category"); ?></label>
                            <select name="category_id" class="form-control">
                                <?php foreach ($category as $data) { ?>
                                    <option value="<?php echo $data['value']; ?>"><?php echo $data['label']; ?></option>
                                <?php } ?>
                            </select>
                          </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                          <!-- text input -->
                          <div class="form-group">
                            <label><?php echo trans("country"); ?></label>
                            <select name="country_id" class="form-control" onchange="get_state(this.value);">>
                                <?php foreach ($country as $data) { ?>
                                    <option value="<?php echo $data['value']; ?>"><?php echo $data['label']; ?></option>
                                <?php } ?>
                            </select>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label><?php echo trans("state"); ?></label>
                            <select id="states" name="state_id" class="form-control" onchange="get_cities(this.value);">
                                <?php #foreach ($state as $data) { ?>
                                    <!-- <option value="<?php #echo $data['value']; ?>"><?php #echo $data['label']; ?></option> -->
                                <?php #} ?>
                            </select>
                          </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label><?php echo trans("job_responsibilities"); ?></label>
                        <textarea id="ckEditor" class="form-control" name="job_responsibilities" required></textarea>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="box-body">
                    <div class="row">
                        <div class="form-group">
                            <label><?php echo trans("company"); ?></label>
                            <select name="company_id" class="form-control">
                                <?php foreach ($company as $data) { ?>
                                    <option value="<?php echo $data['value']; ?>"><?php echo $data['label']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label><?php echo trans('show_from'); ?></label>

                            <div class="input-group date" data-provide="datepicker">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" name="from" class="form-control" required>
                            </div>
                            <!-- /.input group -->
                        </div>
                        <div class="form-group">
                            <label><?php echo trans('show_to'); ?></label>
                            <div class="input-group date" data-provide="datepicker">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" name="to" class="form-control" required>
                            </div>
                            <!-- /.input group -->
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                              <div class="form-group">
                                <label><?php echo trans("city"); ?></label>
                                <select id="cities" name="city_id" class="form-control">
                                    
                                </select>
                              </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label><?php echo trans("job_requirement"); ?></label>
                            <textarea class="form-control ckeditor" name="job_requirement"><?php echo old('content'); ?></textarea>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-4 col-xs-12">
                                    <label><?php echo trans('show'); ?></label>
                                </div>
                                <div class="col-sm-4 col-xs-12 col-option">
                                    <input type="radio" name="status" value="1" id="show_image_on_navigation_1" class="square-purple" checked>
                                    <label for="show_image_on_navigation_1" class="option-label"><?php echo trans('yes'); ?></label>
                                </div>
                                <div class="col-sm-4 col-xs-12 col-option">
                                    <input type="radio" name="status" value="0" id="show_image_on_navigation_2" class="square-purple">
                                    <label for="show_image_on_navigation_2" class="option-label"><?php echo trans('no'); ?></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- /.box-body -->
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?php echo trans('new_job_vacancy'); ?></button>
                </div>
                <!-- /.box-footer -->
                <?php echo form_close(); ?><!-- form end -->
            </div>
        </div>
    </div>
</div>