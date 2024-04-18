<div class="wrap">
    <div id="ctcoreImportPage" class="ct-core-bootstrap-wrapp" data-rest-url="<?php echo get_rest_url(null, 'ctcore/import/v1/') ?>" data-api-key="<?php echo CTCORE_REST_API_TOKEN ?>"> <!-- TODO: create api in global options -->
        <div class="container pt-3 pb-3">

            <div class="mb-3 row">
                <h1><?php echo get_admin_page_title() ?></h1>
            </div>

            <div class="mb-3 row">
                <div class="mb-3 row">
                    <label for="ctcoreImportInputSeparator" class="col-sm-3 col-form-label ">Table separator</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="ctcoreImportInputSeparator">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="ctcoreImportInputSeparator" class="col-sm-3 col-form-label">Rewrite posts</label>
                    <div class="col-sm-9 align-self-center">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="ctcoreImportInputRewrite">
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="ctcoreImportInputFile" class="col-sm-3 col-form-label">Import file</label>
                    <div class="col-sm-9">
                        <input type="file" accept="text/csv" class="form-control" id="ctcoreImportInputFile">
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <button id="ctcoreImportBtnStart" type="button" class="btn btn-primary">Start</button>
                        <!-- <button id="ctcoreImportBtnStop" type="button" class="btn btn-danger" disabled>Stop</button> -->
                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="collapse" data-bs-target="#ctcoreImportDetailsCollapse" aria-expanded="false" aria-controls="ctcoreImportDetailsCollapse">Details </button>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <p class="fw-lighter"><span id="ctcoreImportProgressBarPercent">0%</span>: <span id="ctcoreImportProgressBarDetail">Ready to start.</span></p>
                    <div class="progress" role="progressbar" aria-label="Animated striped example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                        <div id="ctcoreImportProgressBarLine" class="progress-bar progress-bar-striped progress-bar-animated" style="width: 0%"></div>
                    </div>
                </div>
            </div>

            <div class="collapse" id="ctcoreImportDetailsCollapse">
                <textarea class="mt-3 import-details" id="ctcoreImportDetailsBody" rows="10" readonly></textarea>
            </div>
        </div>
    </div>
</div>