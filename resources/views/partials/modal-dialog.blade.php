    <!-- PNL Line Chart Ajax Error Message Modal (Skin gray) -->
    <div class="modal gray fade" id="pnl-ajax-error-modal-dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Profit and Loss Line Chart Error</h4>
                </div>
                <div class="modal-body">
                    <p>Error has occured in pulling Line Chart. Please check your "Profit And Loss" spreadsheet or contact support if further assistance.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- PNL Line Chart Search Error Message Modal (Skin gray) -->
    <div class="modal gray fade" id="pnl-search-error-modal-dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Profit and Loss Line Chart Search Warning</h4>
                </div>
                <div class="modal-body">
                    <p>In order to pull date range from PNL spreadsheet. You must fill-in the Date Range which are Start and End dates</p>
                    <p>Also, check the Year and Month for both date range search filter and PNL current date used. They must be the same in order for the pull to be successful.</p>
                    <p>Please try again. If further assistance is needed, don't hesitate to contact support.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- PNL Line Chart Search Modal (Skin inverted) -->
    <div class="modal invert fade" id="pnl-search-modal-dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Profit and Loss Line Chart Search</h4>
                </div>
                <div class="modal-body" style="height:600px;">
                    <div id="line-chart-search" class="morrischart" style="height: 460px">
                        <form role="form" class="form-horizontal form-groups-bordered">
							<div class="form-group">
								<label class="col-sm-3 control-label">Start Date</label>								
								<div class="col-sm-5">									
									<div id="datepickerStart" class="datepicker"></div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">End Date</label>								
								<div class="col-sm-5">									
									<div id="datepickerEnd" class="datepicker"></div>
								</div>
							</div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Select Label</label>
                                <div class="col-sm-5">											
                                    <select id="opt-pnl-search" class="form-control" data-validate="required">
                                        <option value="impression">Impression</option>
                                        <option value="clicks">Clicks</option>
                                        <option value="adservingcpm">AdServing CPM</option>
                                        <option value="adspend">Ad Spend</option>
                                        <option value="pixelfires">Pixel Fires</option>
                                        <option value="leads">Leads</option>
                                        <option value="sales">Sales</option>
                                        <option value="revenue">Revenue</option>
                                        <option value="adservingcosts">AdServing Cost</option>
                                        <option value="netprofit">Net Profit</option>
                                        <option value="conversionrate">Conversion Rate</option>
                                        <option value="clicktorate">Click To Rate</option>
                                        <option value="returnofinvestment">Return Of Investment</option>
                                        <option value="costperclick">Cost Per Click</option>
                                        <option value="earningsperclick">Earnings Per Click</option>
                                        <option value="costperacquisition">Cost Per Acquisition</option>
                                        <option value="costperlead">Cost Per Lead</option>
                                        <option value="leadtakerate">Lead Take Rate</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btn-pnl-search">Search</button>
                </div>
            </div>
        </div>
    </div>