<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title"><?php echo $title; ?></h3>

        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-6">
                    <!-- form start -->
                <div class="box-body">
                    <!-- include message block -->
                    <?php $this->load->view('admin/includes/_messages_form'); ?>
                    <input type="hidden" name="id" value="<?php echo $job->id; ?>" >
                    <div class="form-group">
                        <label><?php echo trans("job_title"); ?></label>
                        <input type="text" class="form-control" name="title"  value="<?php echo html_escape($job->title); ?>"
                               disabled>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="box-body">
                    <div class="row">
                        <div class="form-group">
                            <label><?php echo trans("company"); ?></label>
                            <select name="company_id" class="form-control" disabled>
                                <?php foreach ($company as $data) { ?>
                                    <option value="<?php echo $data['value']; ?>" <?php echo ($data['value']==$job->company_id ? 'selected' : '');?>><?php echo $data['label']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div><!-- /.box-body -->
            </div>
        </div>
        <div class="row">
            <!-- include message block -->
            <div class="col-sm-12">
                <?php $this->load->view('admin/includes/_messages'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" role="grid">
                        <?php $this->load->view('admin/notif/_filter_notif'); ?>
                        <thead>
                        <tr role="row">
                            <th width="10"><input type="checkbox" class="checkbox-table" id="checkAll"></th>
                            <th><?php echo trans("first_name"); ?></th>
                            <th><?php echo trans("last_name"); ?></th>
                            <th><?php echo trans("email"); ?></th>
                            <th><?php echo trans("phone"); ?></th>
                            <th><?php echo trans("expected_salary"); ?></th>
                            <th>Pilihan</th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php foreach ($user as $item): ?>
                            <tr>
                                <td><input type="checkbox" name="checkbox-table" class="checkbox-table" value="<?php echo $item->id; ?>"></td>
                                <td>
                                    <?php echo html_escape($item->firstname); ?>
                                </td>
                                <td>
                                    <?php echo html_escape($item->lastname); ?>
                                </td>
                                <td><?php echo $item->email; ?></td>
                                <td><?php echo $item->phone; ?></td>
                                <?php
                                $gaji = "Rp " . number_format($item->expected_salary,0,',','.');
                                ?>
                                <td><?php echo $gaji; ?></td>
                                <td width="10%">
                                    <div class="dropdown">
                                        <button class="btn bg-purple dropdown-toggle btn-select-option"
                                                type="button"
                                                data-toggle="dropdown"><?php echo trans('select_option'); ?>
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu options-dropdown">
                                            <li>
                                                <a href="<?php echo base_url().$item->cv ?>" target="_blank"><i class="fa fa-edit option-icon"></i>Lihat cv</a>
                                            </li>
                                            <li>
                                                <a href="<?php echo admin_url(); ?>user-profile/<?php echo html_escape($item->id); ?>" target="_blank"><i class="fa fa-edit option-icon"></i>Lihat profile</a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>

                        <?php endforeach; ?>

                        </tbody>
                    </table>

                    <?php if (empty($user)): ?>
                        <p class="text-center">
                            <?php echo trans("no_records_found"); ?>
                        </p>
                    <?php endif; ?>
                    <div class="col-sm-12 table-ft">
                        <div class="row">
                            <div class="pull-right">
                                <?php echo $this->pagination->create_links(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>