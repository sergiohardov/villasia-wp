<div class="ct-core-bootstrap-wrapp">
    <div id="currencyWidgetUpdate" class="d-flex align-items-center justify-content-between">
        <button id="currencyWidgetUpdateBtn" class="btn btn-primary">
            <span><?php _e('Update', CTCORE_LANG_TEXT) ?></span>
            <span id="currencyWidgetUpdateBtnSpinner" class="spinner-border spinner-border-sm visually-hidden" role="status" aria-hidden="true"></span>
        </button>
        <div class="d-flex flex-column">
            <span>Month Quota: <b><?php echo $args['month_quota'] ?></b> left</span>
            <span>Last Update: <b><?php echo $args['last_updated'] ?></b></span>
        </div>
    </div>
</div>