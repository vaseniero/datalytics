@extends('layouts.default')

@section('content')
		<!-- script-codes here -->
		<script type="text/javascript">
			jQuery(document).ready(function($)
			{
				// Sample Toastr Notification
				setTimeout(function()
				{
					var opts = {
						"closeButton": true,
						"debug": false,
						"positionClass": rtl() || public_vars.$pageContainer.hasClass('right-sidebar') ? "toast-top-left" : "toast-top-right",
						"toastClass": "black",
						"onclick": null,
						"showDuration": "300",
						"hideDuration": "1000",
						"timeOut": "5000",
						"extendedTimeOut": "1000",
						"showEasing": "swing",
						"hideEasing": "linear",
						"showMethod": "fadeIn",
						"hideMethod": "fadeOut"
					};
			
					toastr.success("You have been awarded with 1 year free subscription. Enjoy it!", "Account Subcription Updated", opts);
				}, 3000);
			
				// Sparkline Charts
				$('.inlinebar').sparkline('html', {type: 'bar', barColor: '#ff6264'} );
				$('.inlinebar-2').sparkline('html', {type: 'bar', barColor: '#445982'} );
				$('.inlinebar-3').sparkline('html', {type: 'bar', barColor: '#00b19d'} );
				$('.bar').sparkline([ [1,4], [2, 3], [3, 2], [4, 1] ], { type: 'bar' });
				$('.pie').sparkline('html', {type: 'pie',borderWidth: 0, sliceColors: ['#3d4554', '#ee4749','#00b19d']});
				$('.linechart').sparkline();
				$('.pageviews').sparkline('html', {type: 'bar', height: '30px', barColor: '#ff6264'} );
				$('.uniquevisitors').sparkline('html', {type: 'bar', height: '30px', barColor: '#00b19d'} );
		
				@php
					// Impression Sparkline
					$arrSparklineImpression = array();
					$sparklineImpression = $sparkline['Impression-Overall'];
					$cntSparklineImpression = count($sparklineImpression) - 1;
		
					for ( $i = 0; $i <= $cntSparklineImpression; $i++ ) {
						$arrSparklineImpression[$i] = intval($sparklineImpression[$i][1]);
					}
		
					// Clicks Sparkline
					$arrSparklineClicks = array();
					$sparklineClicks = $sparkline['Clicks-Overall'];
					$cntSparklineClicks = count($sparklineClicks) - 1;
		
					for ( $i = 0; $i <= $cntSparklineClicks; $i++ ) {
						$arrSparklineClicks[$i] = intval($sparklineClicks[$i][1]);
					}
					
					// Pixel Fires Sparkline
					$arrSparklinePixelFires = array();
					$sparklinePixelFires = $sparkline['PixelFires-Overall'];
					$cntSparklinePixelFires = count($sparklinePixelFires) - 1;
		
					for ( $i = 0; $i <= $cntSparklinePixelFires; $i++ ) {
						$arrSparklinePixelFires[$i] = intval($sparklinePixelFires[$i][1]);
					}
					
					// Leads Sparkline
					$arrSparklineLeads = array();
					$sparklineLeads = $sparkline['Leads-Overall'];
					$cntSparklineLeads = count($sparklineLeads) - 1;
		
					for ( $i = 0; $i <= $cntSparklineLeads; $i++ ) {
						$arrSparklineLeads[$i] = intval($sparklineLeads[$i][1]);
					}
					
					// Ad Spend Sparkline
					$arrSparklineAdSpend = array();
					$sparklineAdSpend = $sparkline['AdSpend-Overall'];
					$cntSparklineAdSpend = count($sparklineAdSpend) - 1;
		
					for ( $i = 0; $i <= $cntSparklineAdSpend; $i++ ) {
						$arrSparklineAdSpend[$i] = intval($sparklineAdSpend[$i][1]);
					}
					
					// Sales Sparkline
					$arrSparklineSales = array();
					$sparklineSales = $sparkline['Sales-Overall'];
					$cntSparklineSales = count($sparklineSales) - 1;
		
					for ( $i = 0; $i <= $cntSparklineSales; $i++ ) {
						$arrSparklineSales[$i] = intval($sparklineSales[$i][1]);
					}
					
					// Revenue Sparkline
					$arrSparklineRevenue = array();
					$sparklineRevenue = $sparkline['Revenue-Overall'];
					$cntSparklineRevenue = count($sparklineRevenue) - 1;
		
					for ( $i = 0; $i <= $cntSparklineRevenue; $i++ ) {
						$arrSparklineRevenue[$i] = intval($sparklineRevenue[$i][1]);
					}
				@endphp
			
				// Avg. Impression
				$(".monthly-impression").sparkline(@json($arrSparklineImpression), {
					type: 'bar',
					barColor: '#485671',
					height: '80px',
					barWidth: 10,
					barSpacing: 2
				});
		
				// Avg. Clicks
				$(".monthly-clicks").sparkline(@json($arrSparklineClicks), {
					type: 'bar',
					barColor: '#485671',
					height: '55px',
					width: '100%',
					barWidth: 8,
					barSpacing: 1
				});	
		
				// Avg. Ad Spend
				$(".monthly-adspend").sparkline(@json($arrSparklineAdSpend), {
					type: 'bar',
					barColor: '#ff4e50',
					height: '80px',
					barWidth: 10,
					barSpacing: 2
				});
		
				// Avg. Pixel Fires
				$(".monthly-pixelfires").sparkline(@json($arrSparklinePixelFires), {
					type: 'bar',
					barColor: '#485671',
					height: '55px',
					width: '100%',
					barWidth: 8,
					barSpacing: 1
				});	
		
				// Avg. Leads
				$(".monthly-leads").sparkline(@json($arrSparklineLeads), {
					type: 'bar',
					barColor: '#485671',
					height: '80px',
					barWidth: 10,
					barSpacing: 2
				});
		
				// Avg. Sales
				$(".monthly-sales").sparkline(@json($arrSparklineSales), {
					type: 'bar',
					barColor: '#ff4e50',
					height: '55px',
					width: '100%',
					barWidth: 8,
					barSpacing: 1
				});	
		
				// Avg. Revenue
				$(".monthly-revenue").sparkline(@json($arrSparklineRevenue), {
					type: 'bar',
					barColor: '#ff4e50',
					height: '55px',
					width: '100%',
					barWidth: 8,
					barSpacing: 1
				});	
		
				// JVector Maps
				var map = $("#map");
			
				map.vectorMap({
					map: 'europe_merc_en',
					zoomMin: '3',
					backgroundColor: '#383f47',
					focusOn: { x: 0.5, y: 0.8, scale: 3 }
				});
			
				// Line Charts
				// Impression
				var line_chart_impression = $("#line-chart-impression");
			
				var line_chartimpression = Morris.Line({
					element: "line-chart-impression",
					data: @json($data),
					parseTime: false,
					ymax: 'auto',
					ymin: 'auto',
					xkey: 'y',
					ykeys: @php echo $keys @endphp,
					labels: @php echo $labels @endphp,
					postUnits: '%',
					hideHover: true,
					hoverCallback: function(index, options, content, row) {
							var data = options.data[index];
							var values = @json($values);
							var totals = @json($totals);
							var val = values[index];
							var val2 = totals[index];
							var caption = "<br>";
							var caption2 = "<br>";
		
							for(i = 0; i < val.length; i++)
							{
								var num = val[i][1];
								var num2 = val2[i][1]
								caption = caption + val[i][0] + ": " + num.toLocaleString() + "<br>";
								caption2 = caption2 + val2[i][0] + ": " + num2.toLocaleString() + "<br>";
							}
							return(content + caption + caption2);
					},
					redraw: true
				});
			
				line_chart_impression.parent().attr('style', '');
				$("#tab-impression").click(function(){ ajaxActiveChartLabel("impression"); });
				
				// Clicks
				var line_chart_clicks = $("#line-chart-clicks");
				line_chart_clicks.parent().show();
				line_chart_clicks.parent().attr('style', '');
				$("#tab-clicks").click(function(){ ajaxActiveChartLabel("clicks"); });
		
				// AdServing CPM
				var line_chart_adservingcpm = $("#line-chart-adservingcpm");
				line_chart_adservingcpm.parent().show();
				line_chart_adservingcpm.parent().attr('style', '');
				$("#tab-adservingcpm").click(function(){ ajaxActiveChartLabelValue("adservingcpm"); });
		
				// Ad Spend
				var line_chart_adspend = $("#line-chart-adspend");
				line_chart_adspend.parent().show();
				line_chart_adspend.parent().attr('style', '');
				$("#tab-adspend").click(function(){ ajaxActiveChartLabel("adspend"); });
		
				// Pixel Fires
				var line_chart_pixelfires = $("#line-chart-pixelfires");
				line_chart_pixelfires.parent().show();
				line_chart_pixelfires.parent().attr('style', '');
				$("#tab-pixelfires").click(function(){ ajaxActiveChartLabel("pixelfires"); });
		
				// Leads
				var line_chart_leads = $("#line-chart-leads");
				line_chart_leads.parent().show();
				line_chart_leads.parent().attr('style', '');
				$("#tab-leads").click(function(){ ajaxActiveChartLabel("leads"); });
		
				// Sales
				var line_chart_sales = $("#line-chart-sales");
				line_chart_sales.parent().show();
				line_chart_sales.parent().attr('style', '');
				$("#tab-sales").click(function(){ ajaxActiveChartLabel("sales"); });
		
				// Revenue
				var line_chart_revenue = $("#line-chart-revenue");
				line_chart_revenue.parent().show();
				line_chart_revenue.parent().attr('style', '');
				$("#tab-revenue").click(function(){ ajaxActiveChartLabel("revenue"); });
		
				// Line Charts
				// AdServing Cost
				var line_chart_adservingcosts = $("#line-chart-adservingcosts");
			
				var line_chartadservingcosts = Morris.Line({
					element: "line-chart-adservingcosts",
					data: @json($data2),
					parseTime: false,
					ymax: 'auto',
					ymin: 'auto',
					xkey: 'y',
					ykeys: @php echo $keys2 @endphp,
					labels: @php echo $labels2 @endphp,
					postUnits: '',
					preUnits: '$',
					hideHover: true,
					hoverCallback: function(index, options, content, row) {
							var data = options.data[index];
							var values = @json($values2);
							var totals = @json($totals2);
							var val = values[index];
							var val2 = totals[index];
							var caption = "<br>";
							var caption2 = "<br>";
		
							for(i = 0; i < val.length; i++)
							{
								var num = val[i][1];
								var num2 = val2[i][1]
								caption = caption + val[i][0] + ": " + num.toLocaleString('en-US',{style:'currency',currency:'USD',minimumFractionDigits:2}) + "<br>";
								caption2 = caption2 + val2[i][0] + ": " + num2.toLocaleString('en-US',{style:'currency',currency:'USD',minimumFractionDigits:2}) + "<br>";
							}
							return(content + caption + caption2);
					},
					yLabelFormat: function(y) {
						var num = parseFloat((Math.round(y * 100) / 100).toFixed(2));
						var result = num.toLocaleString('en-US',{style:'currency',currency:'USD',minimumFractionDigits:2});
						return result;
					},
					redraw: true
				});
			
				line_chart_adservingcosts.parent().attr('style', '');
				$("#tab-adservingcosts").click(function(){ ajaxActiveChartLabelValue("adservingcosts"); });
		
				// Net Profit
				var line_chart_netprofit = $("#line-chart-netprofit");
				line_chart_netprofit.parent().show();
				line_chart_netprofit.parent().attr('style', '');		
				$("#tab-netprofit").click(function(){ ajaxActiveChartLabelValue("netprofit"); });
		
				// Conversion Rate
				var line_chart_conversionrate = $("#line-chart-conversionrate");
				line_chart_conversionrate.parent().show();
				line_chart_conversionrate.parent().attr('style', '');		
				$("#tab-conversionrate").click(function(){ ajaxActiveChartLabelValue("conversionrate"); });
		
				// Click To Rate
				var line_chart_clicktorate = $("#line-chart-clicktorate");
				line_chart_clicktorate.parent().show();
				line_chart_clicktorate.parent().attr('style', '');		
				$("#tab-clicktorate").click(function(){ ajaxActiveChartLabelValue("clicktorate"); });
		
				// Return of Investment
				var line_chart_returnofinvestment = $("#line-chart-returnofinvestment");
				line_chart_returnofinvestment.parent().show();
				line_chart_returnofinvestment.parent().attr('style', '');		
				$("#tab-returnofinvestment").click(function(){ ajaxActiveChartLabelValue("returnofinvestment"); });
		
				// Cost Per Click
				var line_chart_costperclick = $("#line-chart-costperclick");
				line_chart_costperclick.parent().show();
				line_chart_costperclick.parent().attr('style', '');		
				$("#tab-costperclick").click(function(){ ajaxActiveChartLabelValue("costperclick"); });
		
				// Earnings Per Click
				var line_chart_earningsperclick = $("#line-chart-earningsperclick");
				line_chart_earningsperclick.parent().show();
				line_chart_earningsperclick.parent().attr('style', '');		
				$("#tab-earningsperclick").click(function(){ ajaxActiveChartLabelValue("earningsperclick"); });
		
				// Cost Per Acquisition
				var line_chart_costperacquisition = $("#line-chart-costperacquisition");
				line_chart_costperacquisition.parent().show();
				line_chart_costperacquisition.parent().attr('style', '');		
				$("#tab-costperacquisition").click(function(){ ajaxActiveChartLabelValue("costperacquisition"); });
		
				// Cost Per Lead
				var line_chart_costperlead = $("#line-chart-costperlead");
				line_chart_costperlead.parent().show();
				line_chart_costperlead.parent().attr('style', '');		
				$("#tab-costperlead").click(function(){ ajaxActiveChartLabelValue("costperlead"); });
		
				// Lead Take Rate
				var line_chart_leadtakerate = $("#line-chart-leadtakerate");
				line_chart_leadtakerate.parent().show();
				line_chart_leadtakerate.parent().attr('style', '');		
				$("#tab-leadtakerate").click(function(){ ajaxActiveChartLabelValue("leadtakerate"); });
		
				// Search
				$("#tab-search").click(function(){ 
					$('#pnl-search-modal-dialog').modal('show');
				});
		
				// Search2
				$("#tab-search2").click(function(){ 
					$('#pnl-search-modal-dialog').modal('show');
				});
		
				// PNL Search Filter by Date Range
				$("#btn-pnl-search").click(function () {
					var dteStart;
					var dteEnd
					var label = $('#opt-pnl-search option:selected').val();
		
					var dayStart = $('div#datepickerStart .datepicker-inline .datepicker-days .table-condensed .active').text();
					var monthStart = getMonthNumericValue($('div#datepickerStart .datepicker-inline .datepicker-months .table-condensed .active').text());
					var yearStart = $('div#datepickerStart .datepicker-inline .datepicker-years .table-condensed .active').text();
					dteStart = yearStart + '-' + monthStart + '-' + dayStart;
		
					var dayEnd = $('div#datepickerEnd .datepicker-inline .datepicker-days .table-condensed .active').text();
					var monthEnd = getMonthNumericValue($('div#datepickerEnd .datepicker-inline .datepicker-months .table-condensed .active').text());
					var yearEnd = $('div#datepickerEnd .datepicker-inline .datepicker-years .table-condensed .active').text();
					dteEnd = yearEnd + '-' + monthEnd + '-' + dayEnd;
		
					$('#pnl-search-modal-dialog').modal('hide');
		
					ajaxActiveChartLabelDateRange(label.toLowerCase(),dteStart,dteEnd);
				});
			});
		
			function getRandomInt(min, max)
			{
				return Math.floor(Math.random() * (max - min + 1)) + min;
			}
		
			function getMonthNumericValue(month) {
				var monthNumber;
		
				switch (month.toLowerCase()) {
					case 'jan':
						monthNumber = 1;
						break;
					case 'feb':
						monthNumber = 2;
						break;
					case 'mar':
						monthNumber = 3;
						break;
					case 'apr':
						monthNumber = 4;
						break;
					case 'may':
						monthNumber = 5;
						break;
					case 'jun':
						monthNumber = 6;
						break;
					case 'jul':
						monthNumber = 7;
						break;
					case 'aug':
						monthNumber = 8;
						break;
					case 'sep':
						monthNumber = 9;
						break;
					case 'oct':
						monthNumber = 10;
						break;
					case 'nov':
						monthNumber = 11;
						break;
					case 'dec':
						monthNumber = 12;
						break;
					default:
						break;
				}
		
				return monthNumber;
			}
		
			function ajaxActiveChartLabel(label) {
				var csrf = $('meta[name="csrf-token"]').attr('content');
				var errMsg = "Error pulling " + label[0].toUpperCase() + label.slice(1) + " Line Chart, please contact support.";
				var ajax_url = ""
				var line_chart;
				var line_chart_element = "";
				var line_chart_postUnits =  "%";
				var line_chart_preUnits = "";
			
				switch (label.toLowerCase()) {
					case "impression":
						line_chart = $("#line-chart-impression");
						line_chart_element = "line-chart-impression";
						ajax_url = "{{ route('spreadsheet.chartLabelPercentage', 'impression') }}";
						break;
					case "clicks":
						line_chart = $("#line-chart-clicks");
						line_chart_element = "line-chart-clicks";
						ajax_url = "{{ route('spreadsheet.chartLabelPercentage', 'clicks') }}";
						break;
					case "adservingcpm":
						line_chart = $("#line-chart-adservingcpm");
						line_chart_element = "line-chart-adservingcpm";
						line_chart_postUnits = "";
						line_chart_preUnits = "$";
						ajax_url = "{{ route('spreadsheet.chartLabelValue', 'adservingcpm') }}";
						break;
					case "adspend":
						line_chart = $("#line-chart-adspend");
						line_chart_element = "line-chart-adspend";
						ajax_url = "{{ route('spreadsheet.chartLabelPercentage', 'adspend') }}";
						break;
					case "pixelfires":
						line_chart = $("#line-chart-pixelfires");
						line_chart_element = "line-chart-pixelfires";
						ajax_url = "{{ route('spreadsheet.chartLabelPercentage', 'pixelfires') }}";
						break;
					case "leads":
						line_chart = $("#line-chart-leads");
						line_chart_element = "line-chart-leads";
						ajax_url = "{{ route('spreadsheet.chartLabelPercentage', 'leads') }}";
						break;
					case "sales":
						line_chart = $("#line-chart-sales");
						line_chart_element = "line-chart-sales";
						ajax_url = "{{ route('spreadsheet.chartLabelPercentage', 'sales') }}";
						break;
					case "revenue":
						line_chart = $("#line-chart-revenue");
						line_chart_element = "line-chart-revenue";
						ajax_url = "{{ route('spreadsheet.chartLabelPercentage', 'revenue') }}";
						break;
					default:
						break;
				}		
		
				line_chart.empty();
				line_chart.attr('style', 'padding:30px;height:460px;');
				line_chart.append($("#chart-loading-htmlcss").html());
				line_chart.parent().show();
		
				$.ajax({
					type: "GET",
					url: ajax_url,
					dataType: "json",
					data: { chartLabelPercentage: label.toLowerCase(), '_token': csrf },
					success: function(result) {
						line_chart.empty();
		
						if ( result.data && (result.data.length > 0) ) {
							var keys = result.keys;
							var labels = result.labels;
							var line_chart_morris = Morris.Line({
								element: line_chart_element,
								data: result.data,
								parseTime: false,
								ymax: 'auto',
								ymin: 'auto',
								xkey: 'y',
								ykeys: keys.split(','),
								labels: labels.split(','),
								postUnits: line_chart_postUnits,
								preUnits: line_chart_preUnits,
								hideHover: true,
								hoverCallback: function(index, options, content, row) {
									var values = result.values;
									var totals = result.totals;
									var val = values[index];
									var val2 = totals[index];
									var caption = "<br>";
									var caption2 = "<br>";
		
									for(i = 0; i < val.length; i++)
									{
										var num = val[i][1];
										var num2 = val2[i][1]
		
										if ( label.toLowerCase() == "adservingcpm" ) {									
											caption = caption + val[i][0] + ": " + num.toLocaleString('en-US',{style:'currency',currency:'USD',minimumFractionDigits:2}) + "<br>";
											caption2 = caption2 + val2[i][0] + ": " + num2.toLocaleString('en-US',{style:'currency',currency:'USD',minimumFractionDigits:2}) + "<br>";
										}
										else {
											caption = caption + val[i][0] + ": " + num.toLocaleString() + "<br>";
											caption2 = caption2 + val2[i][0] + ": " + num2.toLocaleString() + "<br>";
										}
									}
		
									return(content + caption + caption2);
								},
								yLabelFormat: function(y) {
									var result = "";
									if ( label.toLowerCase() ==  'adservingcpm' ) {
										var num = parseFloat((Math.round(y * 100) / 100).toFixed(2));
										result = num.toLocaleString('en-US',{style:'currency',currency:'USD'});
									}
									else {
										result = y.toString() + '%';
									}
									return result;
								},
								redraw: true
							});
						}
						else {
							$('#pnl-ajax-error-modal-dialog').modal('show');
						}
					},
					error: function() {
						line_chart.empty();
						$('#pnl-ajax-error-modal-dialog').modal('show');
					}
				});
		
				line_chart.attr('style', 'height:460px;');
				line_chart.parent().attr('style', '');
			}
		
			function ajaxActiveChartLabelDateRange(label,dteStart,dteEnd) 
			{
				var csrf = $('meta[name="csrf-token"]').attr('content');
				var errMsg = "Error pulling " + label[0].toUpperCase() + label.slice(1) + " Line Chart, please contact support.";
				var ajax_url = ""
				var line_chart;
				var line_chart_element = "";
				var line_chart_postUnits = "%";
				var line_chart_preUnits = "";
		
				switch (label.toLowerCase()) {
					case "impression":
						line_chart = $("#line-chart-impression");
						line_chart_element = "line-chart-impression";
						var url =  "{{ route('spreadsheet') }}";
						url = url + "/impression/" + dteStart + "/" + dteEnd;
						ajax_url = url;
						break;
					case "clicks":
						line_chart = $("#line-chart-clicks");
						line_chart_element = "line-chart-clicks";
						var url =  "{{ route('spreadsheet') }}";
						url = url + "/clicks/" + dteStart + "/" + dteEnd;
						ajax_url = url;
						break;
					case "adservingcpm":
						line_chart = $("#line-chart-adservingcpm");
						line_chart_element = "line-chart-adservingcpm";
						line_chart_postUnits = "";
						line_chart_preUnits = "$";
						var url =  "{{ route('spreadsheet') }}";
						url = url + "/adservingcpm/" + dteStart + "/" + dteEnd;
						ajax_url = url;
						break;
					case "adspend":
						line_chart = $("#line-chart-adspend");
						line_chart_element = "line-chart-adspend";
						var url =  "{{ route('spreadsheet') }}";
						url = url + "/adspend/" + dteStart + "/" + dteEnd;
						ajax_url = url;
						break;
					case "pixelfires":
						line_chart = $("#line-chart-pixelfires");
						line_chart_element = "line-chart-pixelfires";
						var url =  "{{ route('spreadsheet') }}";
						url = url + "/pixelfires/" + dteStart + "/" + dteEnd;
						ajax_url = url;
						break;
					case "leads":
						line_chart = $("#line-chart-leads");
						line_chart_element = "line-chart-leads";
						var url =  "{{ route('spreadsheet') }}";
						url = url + "/leads/" + dteStart + "/" + dteEnd;
						ajax_url = url;
						break;
					case "sales":
						line_chart = $("#line-chart-sales");
						line_chart_element = "line-chart-sales";
						var url =  "{{ route('spreadsheet') }}";
						url = url + "/sales/" + dteStart + "/" + dteEnd;
						ajax_url = url;
						break;
					case "revenue":
						line_chart = $("#line-chart-revenue");
						line_chart_element = "line-chart-revenue";
						var url =  "{{ route('spreadsheet') }}";
						url = url + "/revenue/" + dteStart + "/" + dteEnd;
						ajax_url = url;
						break;
					case "adservingcosts":
						line_chart = $("#line-chart-adservingcosts");
						line_chart_element = "line-chart-adservingcosts";
						line_chart_postUnits = "";
						line_chart_preUnits = "$";
						var url =  "{{ route('spreadsheet') }}";
						url = url + "/adservingcosts/" + dteStart + "/" + dteEnd;
						ajax_url = url;
						break;
					case "netprofit":
						line_chart = $("#line-chart-netprofit");
						line_chart_element = "line-chart-netprofit";
						line_chart_postUnits = "";
						line_chart_preUnits = "$";
						var url =  "{{ route('spreadsheet') }}";
						url = url + "/netprofit/" + dteStart + "/" + dteEnd;
						ajax_url = url;
						break;
					case "conversionrate":
						line_chart = $("#line-chart-conversionrate");
						line_chart_element = "line-chart-conversionrate";
						var url =  "{{ route('spreadsheet') }}";
						url = url + "/conversionrate/" + dteStart + "/" + dteEnd;
						ajax_url = url;
						break;
					case "clicktorate":
						line_chart = $("#line-chart-clicktorate");
						line_chart_element = "line-chart-clicktorate";
						var url =  "{{ route('spreadsheet') }}";
						url = url + "/clicktorate/" + dteStart + "/" + dteEnd;
						ajax_url = url;
						break;
					case "returnofinvestment":
						line_chart = $("#line-chart-returnofinvestment");
						line_chart_element = "line-chart-returnofinvestment";
						var url =  "{{ route('spreadsheet') }}";
						url = url + "/returnofinvestment/" + dteStart + "/" + dteEnd;
						ajax_url = url;
						break;
					case "costperclick":
						line_chart = $("#line-chart-costperclick");
						line_chart_element = "line-chart-costperclick";
						line_chart_postUnits = "";
						line_chart_preUnits = "$";
						var url =  "{{ route('spreadsheet') }}";
						url = url + "/costperclick/" + dteStart + "/" + dteEnd;
						ajax_url = url;
						break;
					case "earningsperclick":
						line_chart = $("#line-chart-earningsperclick");
						line_chart_element = "line-chart-earningsperclick";
						line_chart_postUnits = "";
						line_chart_preUnits = "$";
						var url =  "{{ route('spreadsheet') }}";
						url = url + "/earningsperclick/" + dteStart + "/" + dteEnd;
						ajax_url = url;
						break;
					case "costperacquisition":
						line_chart = $("#line-chart-costperacquisition");
						line_chart_element = "line-chart-costperacquisition";
						line_chart_postUnits = "";
						line_chart_preUnits = "$";
						var url =  "{{ route('spreadsheet') }}";
						url = url + "/costperacquisition/" + dteStart + "/" + dteEnd;
						ajax_url = url;
						break;
					case "costperlead":
						line_chart = $("#line-chart-costperlead");
						line_chart_element = "line-chart-costperlead";
						line_chart_postUnits = "";
						line_chart_preUnits = "$";
						var url =  "{{ route('spreadsheet') }}";
						url = url + "/costperlead/" + dteStart + "/" + dteEnd;
						ajax_url = url;
						break;
					case "leadtakerate":
						line_chart = $("#line-chart-leadtakerate");
						line_chart_element = "line-chart-leadtakerate";
						line_chart_postUnits = "";
						line_chart_preUnits = "$";
						var url =  "{{ route('spreadsheet') }}";
						url = url + "/leadtakerate/" + dteStart + "/" + dteEnd;
						ajax_url = url;
						break;
					default:
						break;
				}		
		
				line_chart.empty();
				line_chart.attr('style', 'padding:30px;height:460px;');
				line_chart.append($("#chart-loading-htmlcss").html());
				line_chart.parent().show();
				line_chart.parent().focus();
		
				$('#' + label.toLowerCase()).focus();
		
				$('.nav-tabs a[href="#' + label.toLowerCase() + '"]').tab('show');
		
				$.ajax({
					type: "GET",
					url: ajax_url,
					dataType: "json",
					data: { chartLabel: label.toLowerCase(), dteStart: dteStart, dteEnd: dteEnd, '_token': csrf },
					success: function(result) {
						line_chart.empty();
		
						if ( result.data && (result.data.length > 0) ) {
							var keys = result.keys;
							var labels = result.labels;
							var line_chart_morris = Morris.Line({
								element: line_chart_element,
								data: result.data,
								parseTime: false,
								ymax: 'auto',
								ymin: 'auto',
								xkey: 'y',
								ykeys: keys.split(','),
								labels: labels.split(','),
								postUnits: line_chart_postUnits,
								preUnits: line_chart_preUnits,
								hideHover: true,
								hoverCallback: function(index, options, content, row) {
									var values = result.values;
									var totals = result.totals;
									var val = values[index];
									var val2 = totals[index];
									var caption = "<br>";
									var caption2 = "<br>";
		
									for(i = 0; i < val.length; i++)
									{
										var num = val[i][1];
										var num2 = val2[i][1]
										switch (label.toLowerCase()) {
											case "adservingcpm":
												caption = caption + val[i][0] + ": " + num.toLocaleString('en-US',{style:'currency',currency:'USD',minimumFractionDigits:2}) + "<br>";
												caption2 = caption2 + val2[i][0] + ": " + num2.toLocaleString('en-US',{style:'currency',currency:'USD',minimumFractionDigits:2}) + "<br>";
												break;
											case "adservingcosts":
												caption = caption + val[i][0] + ": " + num.toLocaleString('en-US',{style:'currency',currency:'USD',minimumFractionDigits:2}) + "<br>";
												caption2 = caption2 + val2[i][0] + ": " + num2.toLocaleString('en-US',{style:'currency',currency:'USD',minimumFractionDigits:2}) + "<br>";
												break;
											case "netprofit":
												caption = caption + val[i][0] + ": " + num.toLocaleString('en-US',{style:'currency',currency:'USD',minimumFractionDigits:2}) + "<br>";
												caption2 = caption2 + val2[i][0] + ": " + num2.toLocaleString('en-US',{style:'currency',currency:'USD',minimumFractionDigits:2}) + "<br>";
												break;
											case "costperclick":
												caption = caption + val[i][0] + ": " + num.toLocaleString('en-US',{style:'currency',currency:'USD',minimumFractionDigits:2}) + "<br>";
												caption2 = caption2 + val2[i][0] + ": " + num2.toLocaleString('en-US',{style:'currency',currency:'USD',minimumFractionDigits:2}) + "<br>";
												break;
											case "earningsperclick":
												caption = caption + val[i][0] + ": " + num.toLocaleString('en-US',{style:'currency',currency:'USD',minimumFractionDigits:2}) + "<br>";
												caption2 = caption2 + val2[i][0] + ": " + num2.toLocaleString('en-US',{style:'currency',currency:'USD',minimumFractionDigits:2}) + "<br>";
												break;
											case "clickperacquisition":
												caption = caption + val[i][0] + ": " + num.toLocaleString('en-US',{style:'currency',currency:'USD',minimumFractionDigits:2}) + "<br>";
												caption2 = caption2 + val2[i][0] + ": " + num2.toLocaleString('en-US',{style:'currency',currency:'USD',minimumFractionDigits:2}) + "<br>";
												break;
											case "costperlead":
												caption = caption + val[i][0] + ": " + num.toLocaleString('en-US',{style:'currency',currency:'USD',minimumFractionDigits:2}) + "<br>";
												caption2 = caption2 + val2[i][0] + ": " + num2.toLocaleString('en-US',{style:'currency',currency:'USD',minimumFractionDigits:2}) + "<br>";
												break;
											case "leadtakerate":
												caption = caption + val[i][0] + ": " + num.toLocaleString('en-US',{style:'currency',currency:'USD',minimumFractionDigits:2}) + "<br>";
												caption2 = caption2 + val2[i][0] + ": " + num2.toLocaleString('en-US',{style:'currency',currency:'USD',minimumFractionDigits:2}) + "<br>";
												break;
											case "conversionrate":
												caption = caption + val[i][0] + ": " + num.toLocaleString('en-US',{style:'percent',minimumFractionDigits:2}) + "<br>";
												caption2 = caption2 + val2[i][0] + ": " + num2.toLocaleString('en-US',{style:'percent',minimumFractionDigits:2}) + "<br>";
												break;
											case "clicktorate":
												caption = caption + val[i][0] + ": " + num.toLocaleString('en-US',{style:'percent',minimumFractionDigits:2}) + "<br>";
												caption2 = caption2 + val2[i][0] + ": " + num2.toLocaleString('en-US',{style:'percent',minimumFractionDigits:2}) + "<br>";
												break;
											case "returnofinvestment":
												caption = caption + val[i][0] + ": " + num.toLocaleString('en-US',{style:'percent',minimumFractionDigits:2}) + "<br>";
												caption2 = caption2 + val2[i][0] + ": " + num2.toLocaleString('en-US',{style:'percent',minimumFractionDigits:2}) + "<br>";
												break;
											default:
												caption = caption + val[i][0] + ": " + num.toLocaleString() + "<br>";
												caption2 = caption2 + val2[i][0] + ": " + num2.toLocaleString() + "<br>";
												break;
										}
									}
									return(content + caption + caption2);
								},
								yLabelFormat: function(y) {
									var result = "";
									var num = parseFloat((Math.round(y * 100) / 100).toFixed(2));
									switch (label.toLowerCase()) {
										case "adservingcpm":
											result = num.toLocaleString('en-US',{style:'currency',currency:'USD',minimumFractionDigits:2});
											break;
										case "adservingcosts":
											result = num.toLocaleString('en-US',{style:'currency',currency:'USD',minimumFractionDigits:2});
											break;
										case "netprofit":
											result = num.toLocaleString('en-US',{style:'currency',currency:'USD',minimumFractionDigits:2});
											break;
										case "costperclick":
											result = num.toLocaleString('en-US',{style:'currency',currency:'USD',minimumFractionDigits:2});
											break;
										case "earningsperclick":
											result = num.toLocaleString('en-US',{style:'currency',currency:'USD',minimumFractionDigits:2});
											break;
										case "clickperacquisition":
											result = num.toLocaleString('en-US',{style:'currency',currency:'USD',minimumFractionDigits:2});
											break;
										case "costperlead":
											result = num.toLocaleString('en-US',{style:'currency',currency:'USD',minimumFractionDigits:2});
											break;
										case "leadtakerate":
											result = num.toLocaleString('en-US',{style:'currency',currency:'USD',minimumFractionDigits:2});
											break;
										case "conversionrate":
											result = num.toLocaleString('en-US',{style:'percent',minimumFractionDigits:2});
											break;
										case "clicktorate":
											result = num.toLocaleString('en-US',{style:'percent',minimumFractionDigits:2});
											break;
										case "returnofinvestment":
											result = num.toLocaleString('en-US',{style:'percent',minimumFractionDigits:2});
											break;
										default:
											result = num.toLocaleString() + '%';
											break;
									}
									return result;
								},
								redraw: true
							});
						}
						else {
							$('#pnl-search-error-modal-dialog').modal('show');
						}
					},
					error: function() {
						line_chart.empty();
						$('#pnl-search-error-modal-dialog').modal('show');
					}
				});
		
				line_chart.attr('style', 'height:460px;');
				line_chart.parent().attr('style', '');
			}
		
			function ajaxActiveChartLabelValue(label) {
				var csrf = $('meta[name="csrf-token"]').attr('content');
				var errMsg = "Error pulling " + label[0].toUpperCase() + label.slice(1) + " Line Chart, please contact support.";
				var ajax_url = ""
				var line_chart;
				var line_chart_element = "";
				var line_chart_postUnits = "";
				var line_chart_preUnits = "$";
			
				switch (label.toLowerCase()) {
					case "adservingcpm":
						line_chart = $("#line-chart-adservingcpm");
						line_chart_element = "line-chart-adservingcpm";
						ajax_url = "{{ route('spreadsheet.chartLabelValue', 'adservingcpm') }}";
						break;
					case "adservingcosts":
						line_chart = $("#line-chart-adservingcosts");
						line_chart_element = "line-chart-adservingcosts";
						ajax_url = "{{ route('spreadsheet.chartLabelValue', 'adservingcosts') }}";
						break;
					case "netprofit":
						line_chart = $("#line-chart-netprofit");
						line_chart_element = "line-chart-netprofit";
						ajax_url = "{{ route('spreadsheet.chartLabelValue', 'netprofit') }}";
						break;
					case "conversionrate":
						line_chart = $("#line-chart-conversionrate");
						line_chart_element = "line-chart-conversionrate";
						line_chart_postUnits = "%";
						line_chart_preUnits = "";
						ajax_url = "{{ route('spreadsheet.chartLabelValue', 'conversionrate') }}";
						break;
					case "clicktorate":
						line_chart = $("#line-chart-clicktorate");
						line_chart_element = "line-chart-clicktorate";
						line_chart_postUnits = "%";
						line_chart_preUnits = "";
						ajax_url = "{{ route('spreadsheet.chartLabelValue', 'clicktorate') }}";
						break;
					case "returnofinvestment":
						line_chart = $("#line-chart-returnofinvestment");
						line_chart_element = "line-chart-returnofinvestment";
						line_chart_postUnits = "%";
						line_chart_preUnits = "";
						ajax_url = "{{ route('spreadsheet.chartLabelValue', 'returnofinvestment') }}";
						break;
					case "costperclick":
						line_chart = $("#line-chart-costperclick");
						line_chart_element = "line-chart-costperclick";
						ajax_url = "{{ route('spreadsheet.chartLabelValue', 'costperclick') }}";
						break;
					case "earningsperclick":
						line_chart = $("#line-chart-earningsperclick");
						line_chart_element = "line-chart-earningsperclick";
						ajax_url = "{{ route('spreadsheet.chartLabelValue', 'earningsperclick') }}";
						break;
					case "costperacquisition":
						line_chart = $("#line-chart-costperacquisition");
						line_chart_element = "line-chart-costperacquisition";
						ajax_url = "{{ route('spreadsheet.chartLabelValue', 'costperacquisition') }}";
						break;
					case "costperlead":
						line_chart = $("#line-chart-costperlead");
						line_chart_element = "line-chart-costperlead";
						ajax_url = "{{ route('spreadsheet.chartLabelValue', 'costperlead') }}";
						break;
					case "leadtakerate":
						line_chart = $("#line-chart-leadtakerate");
						line_chart_element = "line-chart-leadtakerate";
						line_chart_postUnits = "%";
						line_chart_preUnits = "";
						ajax_url = "{{ route('spreadsheet.chartLabelValue', 'leadtakerate') }}";
						break;
					default:
						break;
				}		
		
				line_chart.empty();
				line_chart.attr('style', 'padding:30px;height:460px;');
				line_chart.append($("#chart-loading-htmlcss").html());
				line_chart.parent().show();
		
				$.ajax({
					type: "GET",
					url: ajax_url,
					dataType: "json",
					data: { Label: label.toLowerCase(), '_token': csrf },
					success: function(result) {
						line_chart.empty();
		
						if ( result.data && (result.data.length > 0)) {
							var keys = result.keys;
							var labels = result.labels;
							var line_chart_morris = Morris.Line({
								element: line_chart_element,
								data: result.data,
								parseTime: false,
								ymax: 'auto',
								ymin: 'auto',
								xkey: 'y',
								ykeys: keys.split(','),
								labels: labels.split(','),
								postUnits: line_chart_postUnits,
								preUnits: line_chart_preUnits,
								hideHover: true,
								hoverCallback: function(index, options, content, row) {
									var values = result.values;
									var totals = result.totals;
									var val = values[index];
									var val2 = totals[index];
									var caption = "<br>";
									var caption2 = "<br>";
		
									for(i = 0; i < val.length; i++)
									{
										var num = val[i][1];
										var num2 = val2[i][1]
										switch (label.toLowerCase()) {
											case "adservingcpm":
												caption = caption + val[i][0] + ": " + num.toLocaleString('en-US',{style:'currency',currency:'USD',minimumFractionDigits:2}) + "<br>";
												caption2 = caption2 + val2[i][0] + ": " + num2.toLocaleString('en-US',{style:'currency',currency:'USD',minimumFractionDigits:2}) + "<br>";
												break;
											case "adservingcosts":
												caption = caption + val[i][0] + ": " + num.toLocaleString('en-US',{style:'currency',currency:'USD',minimumFractionDigits:2}) + "<br>";
												caption2 = caption2 + val2[i][0] + ": " + num2.toLocaleString('en-US',{style:'currency',currency:'USD',minimumFractionDigits:2}) + "<br>";
												break;
											case "netprofit":
												caption = caption + val[i][0] + ": " + num.toLocaleString('en-US',{style:'currency',currency:'USD',minimumFractionDigits:2}) + "<br>";
												caption2 = caption2 + val2[i][0] + ": " + num2.toLocaleString('en-US',{style:'currency',currency:'USD',minimumFractionDigits:2}) + "<br>";
												break;
											case "costperclick":
												caption = caption + val[i][0] + ": " + num.toLocaleString('en-US',{style:'currency',currency:'USD',minimumFractionDigits:2}) + "<br>";
												caption2 = caption2 + val2[i][0] + ": " + num2.toLocaleString('en-US',{style:'currency',currency:'USD',minimumFractionDigits:2}) + "<br>";
												break;
											case "earningsperclick":
												caption = caption + val[i][0] + ": " + num.toLocaleString('en-US',{style:'currency',currency:'USD',minimumFractionDigits:2}) + "<br>";
												caption2 = caption2 + val2[i][0] + ": " + num2.toLocaleString('en-US',{style:'currency',currency:'USD',minimumFractionDigits:2}) + "<br>";
												break;
											case "clickperacquisition":
												caption = caption + val[i][0] + ": " + num.toLocaleString('en-US',{style:'currency',currency:'USD',minimumFractionDigits:2}) + "<br>";
												caption2 = caption2 + val2[i][0] + ": " + num2.toLocaleString('en-US',{style:'currency',currency:'USD',minimumFractionDigits:2}) + "<br>";
												break;
											case "costperlead":
												caption = caption + val[i][0] + ": " + num.toLocaleString('en-US',{style:'currency',currency:'USD',minimumFractionDigits:2}) + "<br>";
												caption2 = caption2 + val2[i][0] + ": " + num2.toLocaleString('en-US',{style:'currency',currency:'USD',minimumFractionDigits:2}) + "<br>";
												break;
											case "leadtakerate":
												caption = caption + val[i][0] + ": " + num.toLocaleString('en-US',{style:'currency',currency:'USD',minimumFractionDigits:2}) + "<br>";
												caption2 = caption2 + val2[i][0] + ": " + num2.toLocaleString('en-US',{style:'currency',currency:'USD',minimumFractionDigits:2}) + "<br>";
												break;
											case "conversionrate":
												caption = caption + val[i][0] + ": " + num.toLocaleString('en-US',{style:'percent',minimumFractionDigits:2}) + "<br>";
												caption2 = caption2 + val2[i][0] + ": " + num2.toLocaleString('en-US',{style:'percent',minimumFractionDigits:2}) + "<br>";
												break;
											case "clicktorate":
												caption = caption + val[i][0] + ": " + num.toLocaleString('en-US',{style:'percent',minimumFractionDigits:2}) + "<br>";
												caption2 = caption2 + val2[i][0] + ": " + num2.toLocaleString('en-US',{style:'percent',minimumFractionDigits:2}) + "<br>";
												break;
											case "returnofinvestment":
												caption = caption + val[i][0] + ": " + num.toLocaleString('en-US',{style:'percent',minimumFractionDigits:2}) + "<br>";
												caption2 = caption2 + val2[i][0] + ": " + num2.toLocaleString('en-US',{style:'percent',minimumFractionDigits:2}) + "<br>";
												break;
											default:
												caption = caption + val[i][0] + ": " + num.toLocaleString() + "<br>";
												caption2 = caption2 + val2[i][0] + ": " + num2.toLocaleString() + "<br>";
												break;
										}
									}
									return(content + caption + caption2);
								},
								yLabelFormat: function(y) {
									var result = "";
									var num = parseFloat((Math.round(y * 100) / 100).toFixed(2));
									switch (label.toLowerCase()) {
										case "adservingcpm":
											result = num.toLocaleString('en-US',{style:'currency',currency:'USD',minimumFractionDigits:2});
											break;
										case "adservingcosts":
											result = num.toLocaleString('en-US',{style:'currency',currency:'USD',minimumFractionDigits:2});
											break;
										case "netprofit":
											result = num.toLocaleString('en-US',{style:'currency',currency:'USD',minimumFractionDigits:2});
											break;
										case "costperclick":
											result = num.toLocaleString('en-US',{style:'currency',currency:'USD',minimumFractionDigits:2});
											break;
										case "earningsperclick":
											result = num.toLocaleString('en-US',{style:'currency',currency:'USD',minimumFractionDigits:2});
											break;
										case "clickperacquisition":
											result = num.toLocaleString('en-US',{style:'currency',currency:'USD',minimumFractionDigits:2});
											break;
										case "costperlead":
											result = num.toLocaleString('en-US',{style:'currency',currency:'USD',minimumFractionDigits:2});
											break;
										case "leadtakerate":
											result = num.toLocaleString('en-US',{style:'currency',currency:'USD',minimumFractionDigits:2});
											break;
										case "conversionrate":
											result = num.toLocaleString('en-US',{style:'percent',minimumFractionDigits:2});
											break;
										case "clicktorate":
											result = num.toLocaleString('en-US',{style:'percent',minimumFractionDigits:2});
											break;
										case "returnofinvestment":
											result = num.toLocaleString('en-US',{style:'percent',minimumFractionDigits:2});
											break;
										default:
											result = num.toLocaleString() + '%';
											break;
									}
									return result;
								},
								redraw: true
							});
						}
						else {
							$('#pnl-ajax-error-modal-dialog').modal('show');
						}
					},
					error: function() {
						line_chart.empty();
						$('#pnl-ajax-error-modal-dialog').modal('show');
					}
				});
		
				line_chart.attr('style', 'height:460px;');
				line_chart.parent().attr('style', '');
			}
		</script>
		<!-- charts here -->
		<div class="row">
			<div class="col-sm-3 col-xs-6">		
				<div class="tile-stats tile-red">
					<div class="icon"><i class="entypo-users"></i></div>
					<div class="num" id="active-traffic-sources" data-start="0" data-end="{{ $traffic }}" data-postfix="" data-duration="1500" data-delay="0">0</div>		
					<h3>Traffic sources</h3>
					<p>found on the PNL Tracker spreadsheet.</p>
				</div>	
			</div>		
			<div class="col-sm-3 col-xs-6">
	
			</div>
			<div class="clear visible-xs"></div>
			<div class="col-sm-3 col-xs-6">		
	
			</div>		
			<div class="col-sm-3 col-xs-6">
	
			</div>
		</div>
		<br />
		<div class="row">
			<div class="col-sm-8">
				<div class="panel panel-primary" id="charts_env">
					<div class="panel-heading">
						<div class="panel-title">Profit AND Lost - Line Chart</div>
						<div class="panel-options">
							<ul class="nav nav-tabs" id="tab-pnl">
								<li class="active" id="tab-impression" data-label="impression"><a href="#impression" data-toggle="tab">Impression</a></li>
								<li class="" id="tab-clicks" data-label="clicks"><a href="#clicks" data-toggle="tab">Clicks</a></li>
								<li class="" id="tab-adservingcpm" data-label="adservingcpm"><a href="#adservingcpm" data-toggle="tab">AdServing CPM</a></li>
								<li class="" id="tab-adspend" data-label="adspend"><a href="#adspend" data-toggle="tab">Ad Spend</a></li>
								<li class="" id="tab-pixelfires" data-label="pixelfires"><a href="#pixelfires" data-toggle="tab">Pixel Fires</a></li>
								<li class="" id="tab-leads" data-label="leads"><a href="#leads" data-toggle="tab">Leads</a></li>
								<li class="" id="tab-sales" data-label="sales"><a href="#sales" data-toggle="tab">Sales</a></li>
								<li class="" id="tab-revenue" data-label="revenue"><a href="#revenue" data-toggle="tab">Revenue</a></li>
								<li class="" id="tab-search"><a href="#search" data-toggle="tab"><i class="entypo-cog"></i></a></li>
							</ul>						
						</div>
					</div>
					<div class="panel-body">
						<div class="tab-content">
							<div class="tab-pane active" id="impression">
								<div id="line-chart-impression" class="morrischart" style="height: 460px"></div>
							</div>
							<div class="tab-pane" id="clicks">
								<div id="line-chart-clicks" class="morrischart" style="height: 460px"></div>
							</div>
							<div class="tab-pane" id="adservingcpm">
								<div id="line-chart-adservingcpm" class="morrischart" style="height: 460px"></div>
							</div>
							<div class="tab-pane" id="adspend">
								<div id="line-chart-adspend" class="morrischart" style="height: 460px"></div>
							</div>
							<div class="tab-pane" id="pixelfires">
								<div id="line-chart-pixelfires" class="morrischart" style="height: 460px"></div>
							</div>
							<div class="tab-pane" id="leads">
								<div id="line-chart-leads" class="morrischart" style="height: 460px"></div>
							</div>
							<div class="tab-pane" id="sales">
								<div id="line-chart-sales" class="morrischart" style="height: 460px"></div>
							</div>
							<div class="tab-pane" id="sales">
								<div id="line-chart-sales" class="morrischart" style="height: 460px"></div>
							</div>
							<div class="tab-pane" id="revenue">
								<div id="line-chart-revenue" class="morrischart" style="height: 460px"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<div class="panel-title">
							<h4>
								Average Stats
							</h4>
						</div>	
						<div class="panel-options">
						</div>
					</div>	
					<div class="panel-body no-padding">
						<div class="tile-stats tile-white stat-tile">
							<h3>@php echo number_format(intval($overall['AdSpend-Overall'][0]/(count($overall['AdSpend-Overall'])-1))) @endphp Ad Spend</h3>
							<p>Avg. Ad Spend per day</p>
							<span class="monthly-adspend"></span>
						</div>
						<div class="tile-stats tile-white stat-tile">
							<h3>@php echo number_format(intval($overall['Sales-Overall'][0]/(count($overall['Sales-Overall'])-1))) @endphp Sales</h3>
							<p>Avg. Sales per day</p>
							<span class="monthly-sales"></span>
						</div>
						<div class="tile-stats tile-white stat-tile">
							<h3>@php echo number_format(intval($overall['Revenue-Overall'][0]/(count($overall['Revenue-Overall'])-1))) @endphp Revenue</h3>
							<p>Avg. Revenue per day</p>
							<span class="monthly-revenue"></span>
						</div>									
					</div>
				</div>
			</div>
		</div>
		<br />
		<div class="row">
			<div class="col-md-3 col-sm-6">
				<div class="tile-stats tile-white stat-tile">
					<h3>@php echo number_format(intval($overall['Impression-Overall'][0]/(count($overall['Impression-Overall'])-1)))  @endphp Impression</h3>
					<p>Avg. Impression per day</p>
					<span class="monthly-impression"></span>
				</div>
			</div>	
			<div class="col-md-3 col-sm-6">
				<div class="tile-stats tile-white stat-tile">
					<h3>@php echo number_format(intval($overall['Clicks-Overall'][0]/(count($overall['Clicks-Overall'])-1))) @endphp Clicks</h3>
					<p>Avg. Clicks per day</p>
					<span class="monthly-clicks"></span>
				</div>
			</div>	
			<div class="col-md-3 col-sm-6">
				<div class="tile-stats tile-white stat-tile">
					<h3>@php echo number_format(intval($overall['PixelFires-Overall'][0]/(count($overall['PixelFires-Overall'])-1))) @endphp Pixel Fires</h3>
					<p>Avg. Pixel per day</p>
					<span class="monthly-pixelfires"></span>
				</div>
			</div>	
			<div class="col-md-3 col-sm-6">
				<div class="tile-stats tile-white stat-tile">
					<h3>@php echo number_format(intval($overall['Leads-Overall'][0]/(count($overall['Leads-Overall'])-1))) @endphp Leads</h3>
					<p>Avg. Leads per day</p>
					<span class="monthly-leads"></span>
				</div>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-sm-12">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<div class="panel-title">Profit AND Lost - Line Chart</div>
						<div class="panel-options">
							<ul class="nav nav-tabs" id="tab-pnl2">
								<li class="active" id="tab-adservingcosts" data-label="adservingcosts"><a href="#adservingcosts" data-toggle="tab">AdServing Costs</a></li>
								<li class="" id="tab-netprofit" data-label="netprofit"><a href="#netprofit" data-toggle="tab">Net Profit</a></li>
								<li class="" id="tab-conversionrate" data-label="conversionrate"><a href="#conversionrate" data-toggle="tab">CR</a></li>
								<li class="" id="tab-clicktorate" data-label="clicktorate"><a href="#clicktorate" data-toggle="tab">CTR</a></li>
								<li class="" id="tab-returnofinvestment" data-label="returnofinvestment"><a href="#returnofinvestment" data-toggle="tab">ROI</a></li>
								<li class="" id="tab-costperclick" data-label="costperclick"><a href="#costperclick" data-toggle="tab">CPC</a></li>
								<li class="" id="tab-earningsperclick" data-label="earningsperclick"><a href="#earningsperclick" data-toggle="tab">EPC</a></li>
								<li class="" id="tab-costperacquisition" data-label="costperacquisition"><a href="#costperacquisition" data-toggle="tab">CPA</a></li>
								<li class="" id="tab-costperlead" data-label="costperlead"><a href="#costperlead" data-toggle="tab">CPL</a></li>
								<li class="" id="tab-leadtakerate" data-label="leadtakerate"><a href="#leadtakerate" data-toggle="tab">LTR</a></li>
								<li class="" id="tab-search2"><a href="#search2" data-toggle="tab"><i class="entypo-cog"></i></a></li>
							</ul>						
					</div>
					</div>
					<div class="panel-body">
						<div class="tab-content">
							<div class="tab-pane active" id="adservingcosts">
								<div id="line-chart-adservingcosts" class="morrischart" style="height: 460px"></div>
							</div>
							<div class="tab-pane" id="netprofit">
								<div id="line-chart-netprofit" class="morrischart" style="height: 460px"></div>
							</div>
							<div class="tab-pane" id="conversionrate">
								<div id="line-chart-conversionrate" class="morrischart" style="height: 460px"></div>
							</div>
							<div class="tab-pane" id="clicktorate">
								<div id="line-chart-clicktorate" class="morrischart" style="height: 460px"></div>
							</div>
							<div class="tab-pane" id="returnofinvestment">
								<div id="line-chart-returnofinvestment" class="morrischart" style="height: 460px"></div>
							</div>
							<div class="tab-pane" id="costperclick">
								<div id="line-chart-costperclick" class="morrischart" style="height: 460px"></div>
							</div>
							<div class="tab-pane" id="earningsperclick">
								<div id="line-chart-earningsperclick" class="morrischart" style="height: 460px"></div>
							</div>
							<div class="tab-pane" id="costperacquisition">
								<div id="line-chart-costperacquisition" class="morrischart" style="height: 460px"></div>
							</div>
							<div class="tab-pane" id="costperlead">
								<div id="line-chart-costperlead" class="morrischart" style="height: 460px"></div>
							</div>
							<div class="tab-pane" id="leadtakerate">
								<div id="line-chart-leadtakerate" class="morrischart" style="height: 460px"></div>
							</div>
						</div>
					</div>
					<table class="table table-bordered table-responsive">		
						<thead>
							<tr>
								<th width="50%" class="col-padding-1">
									<div class="pull-left">
										<div class="h4 no-margin">Legend</div>
										<ul>
											<li>CR - Conversion Rate</li>
											<li>CTR - Click To Rate</li>
											<li>ROI - Return Of Investment</li>
											<li>CPC - Cost Per Click</li>
										</ul>
									</div>
								</th>
								<th width="50%" class="col-padding-1">
									<div class="pull-left">
										<div class="h4 no-margin">Legend</div>
										<ul>
											<li>EPC - Earnings Per Click</li>
											<li>CPA - Cost Per Acquisition</li>
											<li>CPL - Cost Per Lead</li>
											<li>LTR - Lead Take Rate</li>
										</ul>
									</div>
								</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
		<br />
		<div id="chart-loading-htmlcss" style="display: none">
			<div id="spinningTextG" style="margin:auto;width:80%;height:80%;">
				<div id="spinningTextG_1" class="spinningTextG">L</div>
				<div id="spinningTextG_2" class="spinningTextG">o</div>
				<div id="spinningTextG_3" class="spinningTextG">a</div>
				<div id="spinningTextG_4" class="spinningTextG">d</div>
				<div id="spinningTextG_5" class="spinningTextG">i</div>
				<div id="spinningTextG_6" class="spinningTextG">n</div>
				<div id="spinningTextG_7" class="spinningTextG">g</div>
			</div>
			<style type="text/css">
			#spinningTextG{
				width:1410px;
				margin:auto;
				height:176px;
			}
			.spinningTextG{
				color:rgb(0,0,0);
				font-family:Arial;
				font-size:147px;
				text-decoration:none;
				font-weight:normal;
				font-style:normal;
				float:left;
				animation-name:bounce_spinningTextG;
					-o-animation-name:bounce_spinningTextG;
					-ms-animation-name:bounce_spinningTextG;
					-webkit-animation-name:bounce_spinningTextG;
					-moz-animation-name:bounce_spinningTextG;
				animation-duration:1.5s;
					-o-animation-duration:1.5s;
					-ms-animation-duration:1.5s;
					-webkit-animation-duration:1.5s;
					-moz-animation-duration:1.5s;
				animation-iteration-count:infinite;
					-o-animation-iteration-count:infinite;
					-ms-animation-iteration-count:infinite;
					-webkit-animation-iteration-count:infinite;
					-moz-animation-iteration-count:infinite;
				animation-direction:normal;
					-o-animation-direction:normal;
					-ms-animation-direction:normal;
					-webkit-animation-direction:normal;
					-moz-animation-direction:normal;
				transform:scale(.3);
					-o-transform:scale(.3);
					-ms-transform:scale(.3);
					-webkit-transform:scale(.3);
					-moz-transform:scale(.3);
			}
			#spinningTextG_1{
				animation-delay:0.75s;
					-o-animation-delay:0.75s;
					-ms-animation-delay:0.75s;
					-webkit-animation-delay:0.75s;
					-moz-animation-delay:0.75s;
			}
			#spinningTextG_2{
				animation-delay:0.9s;
					-o-animation-delay:0.9s;
					-ms-animation-delay:0.9s;
					-webkit-animation-delay:0.9s;
					-moz-animation-delay:0.9s;
			}
			#spinningTextG_3{
				animation-delay:1.05s;
					-o-animation-delay:1.05s;
					-ms-animation-delay:1.05s;
					-webkit-animation-delay:1.05s;
					-moz-animation-delay:1.05s;
			}
			#spinningTextG_4{
				animation-delay:1.2s;
					-o-animation-delay:1.2s;
					-ms-animation-delay:1.2s;
					-webkit-animation-delay:1.2s;
					-moz-animation-delay:1.2s;
			}
			#spinningTextG_5{
				animation-delay:1.35s;
					-o-animation-delay:1.35s;
					-ms-animation-delay:1.35s;
					-webkit-animation-delay:1.35s;
					-moz-animation-delay:1.35s;
			}
			#spinningTextG_6{
				animation-delay:1.5s;
					-o-animation-delay:1.5s;
					-ms-animation-delay:1.5s;
					-webkit-animation-delay:1.5s;
					-moz-animation-delay:1.5s;
			}
			#spinningTextG_7{
				animation-delay:1.64s;
					-o-animation-delay:1.64s;
					-ms-animation-delay:1.64s;
					-webkit-animation-delay:1.64s;
					-moz-animation-delay:1.64s;
			}
			@keyframes bounce_spinningTextG{
				0%{
					transform:scale(1);
					color:rgb(0,0,0);
				}
				100%{
					transform:scale(.3) rotate(90deg);
					color:rgb(255,255,255);
				}
			}
			@-o-keyframes bounce_spinningTextG{
				0%{
					-o-transform:scale(1);
					color:rgb(0,0,0);
				}

				100%{
					-o-transform:scale(.3) rotate(90deg);
					color:rgb(255,255,255);
				}
			}
			@-ms-keyframes bounce_spinningTextG{
				0%{
					-ms-transform:scale(1);
					color:rgb(0,0,0);
				}

				100%{
					-ms-transform:scale(.3) rotate(90deg);
					color:rgb(255,255,255);
				}
			}
			@-webkit-keyframes bounce_spinningTextG{
				0%{
					-webkit-transform:scale(1);
					color:rgb(0,0,0);
				}

				100%{
					-webkit-transform:scale(.3) rotate(90deg);
					color:rgb(255,255,255);
				}
			}
			@-moz-keyframes bounce_spinningTextG{
				0%{
					-moz-transform:scale(1);
					color:rgb(0,0,0);
				}

				100%{
					-moz-transform:scale(.3) rotate(90deg);
					color:rgb(255,255,255);
				}
			}
			</style>
		</div>
		<script type="text/javascript">
			// Code used to add Todo Tasks
			jQuery(document).ready(function($)
			{
				var $todo_tasks = $("#todo_tasks");
		
				$todo_tasks.find('input[type="text"]').on('keydown', function(ev)
				{
					if(ev.keyCode == 13)
					{
						ev.preventDefault();
		
						if($.trim($(this).val()).length)
						{
							var $todo_entry = $('<li><div class="checkbox checkbox-replace color-white"><input type="checkbox" /><label>'+$(this).val()+'</label></div></li>');
							$(this).val('');
		
							$todo_entry.appendTo($todo_tasks.find('.todo-list'));
							$todo_entry.hide().slideDown('fast');
							replaceCheckboxes();
						}
					}
				});
			});
		</script>
		<div class="row">
			<!-- task here -->
			<div class="col-sm-3">
				<div class="tile-block" id="todo_tasks">
					<div class="tile-header">
						<i class="entypo-list"></i>
						<a href="#">
							Tasks
							<span>To do list, tick one.</span>
						</a>
					</div>
					<div class="tile-content">
						<input type="text" class="form-control" placeholder="Add Task" />
						<ul class="todo-list">
							<li>
								<div class="checkbox checkbox-replace color-white">
									<input type="checkbox" />
									<label>Website Design</label>
								</div>
							</li>
							<li>
								<div class="checkbox checkbox-replace color-white">
									<input type="checkbox" id="task-2" checked />
									<label>Slicing</label>
								</div>
							</li>
							<li>
								<div class="checkbox checkbox-replace color-white">
									<input type="checkbox" id="task-3" />
									<label>WordPress Integration</label>
								</div>
							</li>
							<li>
								<div class="checkbox checkbox-replace color-white">
									<input type="checkbox" id="task-4" />
									<label>SEO Optimize</label>
								</div>
							</li>
							<li>
								<div class="checkbox checkbox-replace color-white">
									<input type="checkbox" id="task-5" checked="" />
									<label>Minify &amp; Compress</label>
								</div>
							</li>
						</ul>
					</div>
					<div class="tile-footer">
						<a href="#">View all tasks</a>
					</div>
				</div>
			</div>
			<!-- map here -->
			<div class="col-sm-9">
				<script type="text/javascript">
					jQuery(document).ready(function($)
					{
						var map = $("#map-2");
		
						map.vectorMap({
							map: 'europe_merc_en',
							zoomMin: '3',
							backgroundColor: '#383f47',
							focusOn: { x: 0.5, y: 0.8, scale: 3 }
						});
					});
				</script>
				<div class="tile-group">
					<div class="tile-left">
						<div class="tile-entry">
							<h3>Map</h3>
							<span>top visitors location</span>
						</div>
						<div class="tile-entry">
							<img src="{{ asset('assets/images/sample-al.png') }}" alt="" class="pull-right op" />
							<h4>Albania</h4>
							<span>25%</span>
						</div>
						<div class="tile-entry">
							<img src="{{ asset('assets/images/sample-it.png') }}" alt="" class="pull-right op" />
							<h4>Italy</h4>
							<span>18%</span>
						</div>
						<div class="tile-entry">
							<img src="{{ asset('assets/images/sample-au.png') }}" alt="" class="pull-right op" />
							<h4>Austria</h4>
							<span>15%</span>
						</div>
					</div>
					<div class="tile-right">
						<div id="map-2" class="map"></div>
					</div>
				</div>
			</div>
		</div>		
		<!-- Footer here -->
		<footer class="main">
			&copy; 2018 <strong>Datalytics</strong> Theme by <a href="http://laborator.co" target="_blank">Laborator</a>
		</footer>	
@endsection

@section('menu-head')
	@parent

    <div class="row">
		<!-- Profile Info and Notifications -->
		<div class="col-md-6 col-sm-8 clearfix">
			<ul class="user-info pull-left pull-none-xsm">    
				<!-- Profile Info -->
				<li class="profile-info dropdown"><!-- add class "pull-right" if you want to place this from right -->        
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<img src="assets/images/thumb-0@2x.png" alt="" class="img-circle" width="44" />
						{{ $user->name }}
					</a>        
					<ul class="dropdown-menu">        
						<!-- Reverse Caret -->
						<li class="caret"></li>        
						<!-- Profile sub-links -->
						<li>
							<a href="#">
								<i class="entypo-user"></i>
								Edit Profile
							</a>
						</li>        
						<li>
							<a href="#">
								<i class="entypo-mail"></i>
								Inbox
							</a>
						</li>        
						<li>
							<a href="#">
								<i class="entypo-calendar"></i>
								Calendar
							</a>
						</li>        
						<li>
							<a href="#">
								<i class="entypo-clipboard"></i>
								Tasks
							</a>
						</li>
					</ul>
				</li>        
			</ul>            
		</div>
		<!-- Raw Links -->
		<div class="col-md-6 col-sm-4 clearfix hidden-xs">
			<ul class="list-inline links-list pull-right">
				<li>
					<a class="dropdown-item" href="{{ route('logout') }}"
						onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
							{{ __('Logout') }} <i class="entypo-logout right"></i>
					</a>
					<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
						@csrf
					</form>
				</li>
			</ul>
		</div>
	</div>	
@endsection