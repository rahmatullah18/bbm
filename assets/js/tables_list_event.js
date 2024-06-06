/**
 * DataTables Advanced (jquery)
 */

'use strict';

$(function () {
  var dt_ajax_table = $('.datatables-ajax'),
	  startDateListEvent = $('#tgl_mulai'),
	  endDateListEvent = $('#tgl_selesai'),
	  searchListEvent = $('#cari_event'),
	  dt_ajax;

  // Ajax Sourced Server-side
  // --------------------------------------------------------------------

  if (dt_ajax_table.length) {
    var dt_ajax = dt_ajax_table.DataTable({
      processing: true,
      //ajax: assetsPath + 'json/ajax.php',
	  //ajax: '/get_data_list_event',
	  ajax:  {
		url: "/get_data_list_event",
		data: function(d){
			d.date_start = startDateListEvent.val();
			d.date_finish = endDateListEvent.val();
			d.search = searchListEvent.val();
		}
	  },
	  columns: [
        { data: 'cnmr_event' },
		{ data: 'status' },
		{ data: 'sta_pengajuan' },
        { data: 'dtgl_pengajuan' },
        { data: 'ckat' },
        { data: 'tipe' },
        { data: 'cabang' },
		{ data: 'cnama_spv' },
		{ data: 'dtgl_kegiatan' },
		{ data: 'lokasi' },
		{ data: 'aksi' }
      ],
      dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>><"table-responsive"t><"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
	  searching: false
    });
	
	$('#btn_search').on('click', function () {
		
		dt_ajax.ajax.reload();
	});
		
  }

  // on key up from input field
  $('input.dt-input').on('keyup', function () {
    filterColumn($(this).attr('data-column'), $(this).val());
  });

  // Filter form control to default size
  // ? setTimeout used for multilingual table initialization
  setTimeout(() => {
    $('.dataTables_filter .form-control').removeClass('form-control-sm');
    $('.dataTables_length .form-select').removeClass('form-select-sm');
  }, 200);
  
  //------------ Grafik ---------------//
  
  // Color Variables
  const purpleColor = '#836AF9',
    yellowColor = '#ffe800',
    cyanColor = '#28dac6',
    orangeColor = '#FF8132',
    orangeLightColor = '#FDAC34',
    oceanBlueColor = '#299AFF',
    greyColor = '#4F5D70',
    greyLightColor = '#EDF1F4',
    blueColor = '#2B9AFF',
    blueLightColor = '#84D0FF';

  let borderColor, axisColor;

  if (isDarkStyle) {
    borderColor = config.colors_dark.borderColor;
    axisColor = config.colors_dark.axisColor; // x & y axis tick color
  } else {
    borderColor = config.colors.borderColor; // same as template border color
    axisColor = config.colors.axisColor; // x & y axis tick color\
  }

  // Set height according to their data-height
  // --------------------------------------------------------------------
  const chartList = document.querySelectorAll('.chartjs');
  chartList.forEach(function (chartListItem) {
    chartListItem.height = chartListItem.dataset.height;
  });
  
  // Bar Chart
  // --------------------------------------------------------------------
  /*const barChart = document.getElementById('grafik_capai');
  if (barChart) {
    const barChartVar = new Chart(barChart, {
      type: 'bar',
      data: {
        labels: [
          '7/12',
          '8/12',
          '9/12',
          '10/12',
          '11/12',
          '12/12',
          '13/12',
          '14/12',
          '15/12',
          '16/12',
          '17/12',
          '18/12',
          '19/12'
        ],
        datasets: [
          {
            data: [275, 90, 190, 205, 125, 85, 55, 87, 127, 150, 230, 280, 190],
            backgroundColor: cyanColor,
            borderColor: 'transparent',
            maxBarThickness: 15,
            borderRadius: {
              topRight: 15,
              topLeft: 15
            }
          }
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        animation: {
          duration: 500
        },
        plugins: {
          tooltip: {
            rtl: isRtl,
            backgroundColor: config.colors.white,
            titleColor: config.colors.black,
            bodyColor: config.colors.black,
            borderWidth: 1,
            borderColor: borderColor
          },
          legend: {
            display: false
          }
        },
        scales: {
          x: {
            grid: {
              color: borderColor,
              borderColor: borderColor
            },
            ticks: {
              color: axisColor
            }
          },
          y: {
            min: 0,
            max: 400,
            grid: {
              color: borderColor,
              borderColor: borderColor
            },
            ticks: {
              stepSize: 100,
              tickColor: borderColor,
              color: axisColor
            }
          }
        }
      }
    });
  }*/
  
});
