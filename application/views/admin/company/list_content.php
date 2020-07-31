<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><?php echo $title; ?></h3>
    </div><!-- /.box-header -->

    <div class="box-body">
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
                        <?php if (count($company) > 0): ?>
                            <div class="pull-left">
                                <button class="btn btn-sm btn-danger btn-table-delete" onclick="delete_selected_company('<?php echo trans("confirm_products"); ?>');"><?php echo trans('delete'); ?></button>
                            </div>
                        <?php endif; ?>
                        <thead>
                        <tr role="row">
                            <th width="10"><input type="checkbox" class="checkbox-table" id="checkAll"></th>
                            <th>Logo Perusahaan</th>
                            <th>Nama Perusahaan</th>
                            <th>Deskripsi</th>
                            <th>Alamat</th>
                            <th>Pilihan</th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php foreach ($company as $item): ?>
                            <tr>
                                <td><input type="checkbox" name="checkbox-table" class="checkbox-table" value="<?php echo $item->id; ?>"></td>
                                <td>
                                    <div class="img-table" style="height: 100px;">
                                        <a href="<?php echo getPicturePath($item->picture); ?>" target="_blank">
                                            <img src="<?php echo getPicturePath($item->picture); ?>" data-src="" alt="" class="lazyload img-responsive post-image">
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    <?php echo html_escape($item->company_name); ?>
                                </td>

                                <td><?php echo $item->description; ?></td>
                                <td><?php echo $item->address; ?></td>
                                <td width="10%">
                                    <div class="dropdown">
                                        <button class="btn bg-purple dropdown-toggle btn-select-option"
                                                type="button"
                                                data-toggle="dropdown"><?php echo trans('select_option'); ?>
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu options-dropdown">
                                            <li>
                                                <a href="<?php echo admin_url(); ?>detail-company/<?php echo html_escape($item->id); ?>"><i class="fa fa-edit option-icon"></i><?php echo trans('edit'); ?></a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0)" onclick="delete_item('aj_company_controller/delete_company_by_id','<?php echo $item->id; ?>','<?php echo trans("confirm_delete"); ?>');"><i class="fa fa-trash option-icon"></i><?php echo trans('delete'); ?></a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>

                        <?php endforeach; ?>

                        </tbody>
                    </table>

                    <?php if (empty($company)): ?>
                        <p class="text-center">
                            <?php echo trans("no_records_found"); ?>
                        </p>
                    <?php endif; ?>
                    <div class="col-sm-12 table-ft">
                        <div class="row">

                            <div class="pull-right">
                                <?php echo $this->pagination->create_links(); ?>
                            </div>
                            <?php if (count($company) > 0): ?>
                                <div class="pull-left">
                                    <button class="btn btn-sm btn-danger btn-table-delete" onclick="delete_selected_company('<?php echo trans("confirm_products"); ?>');"><?php echo trans('delete'); ?></button>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div><!-- /.box-body -->
</div>