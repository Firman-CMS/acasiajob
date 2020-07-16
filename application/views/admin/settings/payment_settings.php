<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row" style="margin-bottom: 15px;">
    <div class="col-sm-12">
        <h3 style="font-size: 18px; font-weight: 600;margin-top: 10px;"><?php echo trans('payment_settings'); ?></h3>
    </div>
</div>
<div class="row">
    <div class="col-lg-6 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans('paypal'); ?></h3>
            </div>
            <!-- /.box-header -->

            <!-- form start -->
            <?php echo form_open('settings_controller/paypal_settings_post'); ?>
            <div class="box-body">
                <!-- include message block -->
                <?php if (!empty($this->session->flashdata("mes_paypal"))):
                    $this->load->view('admin/includes/_messages');
                endif; ?>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-4 col-xs-12">
                            <label><?php echo trans("status"); ?></label>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="paypal_enabled" value="1" id="paypal_enabled_1"
                                   class="square-purple" <?php echo ($payment_settings->paypal_enabled == 1) ? 'checked' : ''; ?>>
                            <label for="paypal_enabled_1" class="option-label"><?php echo trans('enable'); ?></label>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="paypal_enabled" value="0" id="paypal_enabled_2"
                                   class="square-purple" <?php echo ($payment_settings->paypal_enabled != 1) ? 'checked' : ''; ?>>
                            <label for="paypal_enabled_2" class="option-label"><?php echo trans('disable'); ?></label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-4 col-xs-12">
                            <label><?php echo trans("mode"); ?></label>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="paypal_mode" value="production" id="paypal_mode_1"
                                   class="square-purple" <?php echo ($payment_settings->paypal_mode == 'production') ? 'checked' : ''; ?>>
                            <label for="paypal_mode_1" class="option-label">Live</label>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="paypal_mode" value="sandbox" id="paypal_mode_2"
                                   class="square-purple" <?php echo ($payment_settings->paypal_mode == 'sandbox') ? 'checked' : ''; ?>>
                            <label for="paypal_mode_2" class="option-label">Sandbox</label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label"><?php echo trans('client_id'); ?></label>
                    <input type="text" class="form-control" name="paypal_client_id" placeholder="<?php echo trans('client_id'); ?>"
                           value="<?php echo $payment_settings->paypal_client_id; ?>" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>

            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
            </div>
            <!-- /.box-footer -->
            <!-- /.box -->
            <?php echo form_close(); ?><!-- form end -->
        </div>
    </div>

    <div class="col-lg-6 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans('stripe'); ?></h3>
            </div>
            <!-- /.box-header -->

            <!-- form start -->
            <?php echo form_open('settings_controller/stripe_settings_post'); ?>
            <div class="box-body">
                <!-- include message block -->
                <?php if (!empty($this->session->flashdata("mes_stripe"))):
                    $this->load->view('admin/includes/_messages');
                endif; ?>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-4 col-xs-12">
                            <label><?php echo trans("status"); ?></label>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="stripe_enabled" value="1" id="stripe_enabled_1"
                                   class="square-purple" <?php echo ($payment_settings->stripe_enabled == 1) ? 'checked' : ''; ?>>
                            <label for="stripe_enabled_1" class="option-label"><?php echo trans('enable'); ?></label>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="stripe_enabled" value="0" id="stripe_enabled_2"
                                   class="square-purple" <?php echo ($payment_settings->stripe_enabled != 1) ? 'checked' : ''; ?>>
                            <label for="stripe_enabled_2" class="option-label"><?php echo trans('disable'); ?></label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label"><?php echo trans('publishable_key'); ?></label>
                    <input type="text" class="form-control" name="stripe_publishable_key" placeholder="<?php echo trans('publishable_key'); ?>"
                           value="<?php echo $payment_settings->stripe_publishable_key; ?>" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>
                <div class="form-group">
                    <label class="control-label"><?php echo trans('secret_key'); ?></label>
                    <input type="text" class="form-control" name="stripe_secret_key" placeholder="<?php echo trans('secret_key'); ?>"
                           value="<?php echo $payment_settings->stripe_secret_key; ?>" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
            </div>
            <!-- /.box-footer -->
            <!-- /.box -->
            <?php echo form_close(); ?><!-- form end -->
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans('iyzico'); ?></h3>
            </div>
            <!-- /.box-header -->

            <!-- form start -->
            <?php echo form_open('settings_controller/iyzico_settings_post'); ?>
            <div class="box-body">
                <!-- include message block -->
                <?php if (!empty($this->session->flashdata("mes_iyzico"))):
                    $this->load->view('admin/includes/_messages');
                endif; ?>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-4 col-xs-12">
                            <label><?php echo trans("status"); ?></label>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="iyzico_enabled" value="1" id="iyzico_enabled_1"
                                   class="square-purple" <?php echo ($payment_settings->iyzico_enabled == 1) ? 'checked' : ''; ?>>
                            <label for="iyzico_enabled_1" class="option-label"><?php echo trans('enable'); ?></label>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="iyzico_enabled" value="0" id="iyzico_enabled_2"
                                   class="square-purple" <?php echo ($payment_settings->iyzico_enabled != 1) ? 'checked' : ''; ?>>
                            <label for="iyzico_enabled_2" class="option-label"><?php echo trans('disable'); ?></label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-4 col-xs-12">
                            <label><?php echo trans("mode"); ?></label>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="iyzico_mode" value="live" id="iyzico_mode_1"
                                   class="square-purple" <?php echo ($payment_settings->iyzico_mode == 'live') ? 'checked' : ''; ?>>
                            <label for="iyzico_mode_1" class="option-label">Live</label>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="iyzico_mode" value="sandbox" id="iyzico_mode_2"
                                   class="square-purple" <?php echo ($payment_settings->iyzico_mode == 'sandbox') ? 'checked' : ''; ?>>
                            <label for="iyzico_mode_2" class="option-label">Sandbox</label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label"><?php echo trans('api_key'); ?></label>
                    <input type="text" class="form-control" name="iyzico_api_key" placeholder="<?php echo trans('api_key'); ?>"
                           value="<?php echo $payment_settings->iyzico_api_key; ?>" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>
                <div class="form-group">
                    <label class="control-label"><?php echo trans('secret_key'); ?></label>
                    <input type="text" class="form-control" name="iyzico_secret_key" placeholder="<?php echo trans('secret_key'); ?>"
                           value="<?php echo $payment_settings->iyzico_secret_key; ?>" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
            </div>
            <!-- /.box-footer -->
            <!-- /.box -->
            <?php echo form_close(); ?><!-- form end -->
        </div>
    </div>
    <div class="col-lg-6 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans('bank_transfer'); ?></h3>
            </div>
            <!-- /.box-header -->

            <!-- form start -->
            <?php echo form_open('settings_controller/bank_transfer_settings_post'); ?>
            <div class="box-body">
                <!-- include message block -->
                <?php if (!empty($this->session->flashdata("mes_bank_transfer"))):
                    $this->load->view('admin/includes/_messages');
                endif; ?>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-4 col-xs-12">
                            <label><?php echo trans("status"); ?></label>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="bank_transfer_enabled" value="1" id="bank_transfer_enabled_1"
                                   class="square-purple" <?php echo ($payment_settings->bank_transfer_enabled == 1) ? 'checked' : ''; ?>>
                            <label for="bank_transfer_enabled_1" class="option-label"><?php echo trans('enable'); ?></label>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="bank_transfer_enabled" value="0" id="bank_transfer_enabled_2"
                                   class="square-purple" <?php echo ($payment_settings->bank_transfer_enabled != 1) ? 'checked' : ''; ?>>
                            <label for="bank_transfer_enabled_2" class="option-label"><?php echo trans('disable'); ?></label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label"><?php echo trans('bank_accounts'); ?></label>
                    <textarea id="ckEditorBankAccounts" class="form-control" name="bank_transfer_accounts"><?php echo $payment_settings->bank_transfer_accounts; ?></textarea>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
            </div>
            <!-- /.box-footer -->
            <!-- /.box -->
            <?php echo form_close(); ?><!-- form end -->
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans('midtrans'); ?></h3>
            </div>
            <!-- /.box-header -->

            <!-- form start -->
            <?php echo form_open('settings_controller/midtrans_settings_post'); ?>
            <div class="box-body">
                <!-- include message block -->
                <?php if (!empty($this->session->flashdata("mes_midtrans"))):
                    $this->load->view('admin/includes/_messages');
                endif; ?>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-4 col-xs-12">
                            <label><?php echo trans("status"); ?></label>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="midtrans_enabled" value="1" id="midtrans_enabled"
                                   class="square-purple" <?php echo ($payment_settings->midtrans_enabled == 1) ? 'checked' : ''; ?>>
                            <label for="midtrans_enabled_1" class="option-label"><?php echo trans('enable'); ?></label>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="midtrans_enabled" value="0" id="midtrans_enabled_2"
                                   class="square-purple" <?php echo ($payment_settings->midtrans_enabled != 1) ? 'checked' : ''; ?>>
                            <label for="midtrans_enabled_2" class="option-label"><?php echo trans('disable'); ?></label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-4 col-xs-12">
                            <label><?php echo trans("mode"); ?></label>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="midtrans_mode" value="live" id="midtrans_mode_1"
                                   class="square-purple" <?php echo ($payment_settings->midtrans_mode == 'live') ? 'checked' : ''; ?>>
                            <label for="midtrans_mode_1" class="option-label">Live</label>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="midtrans_mode" value="sandbox" id="midtrans_mode_2"
                                   class="square-purple" <?php echo ($payment_settings->midtrans_mode == 'sandbox') ? 'checked' : ''; ?>>
                            <label for="midtrans_mode_2" class="option-label">Sandbox</label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <h4><label class="control-label">Api Url :</label></h4>
                    <label class="control-label">live</label>
                    <input type="text" class="form-control" name="midtrans_api_url_live" placeholder="Api url live"
                           value="<?php echo $payment_settings->midtrans_api_url_live; ?>" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                    <br>                           
                    <label class="control-label">sandbox</label>
                    <input type="text" class="form-control" name="midtrans_api_url_sandbox" placeholder="Api url sandbox"
                           value="<?php echo $payment_settings->midtrans_api_url_sandbox; ?>" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>
                <div class="form-group">
                    <h4><label class="control-label">Server Key :</label></h4>
                    <label class="control-label">live</label>
                    <input type="text" class="form-control" name="midtrans_server_key_live" placeholder="Server key live"
                           value="<?php echo $payment_settings->midtrans_server_key_live; ?>" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                   <br>
                   <label class="control-label">sandbox</label>
                    <input type="text" class="form-control" name="midtrans_server_key_sandbox" placeholder="Server key sandbox"
                           value="<?php echo $payment_settings->midtrans_server_key_sandbox; ?>" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
            </div>
            <!-- /.box-footer -->
            <!-- /.box -->
            <?php echo form_close(); ?><!-- form end -->
        </div>
    </div>

</div>