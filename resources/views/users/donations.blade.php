<?php
// ** Data User logged ** //
     $settings = App\Models\AdminSettings::first();

     $data = App\Models\Donations::leftJoin('campaigns', function ($join) {
         $join->on('donations.campaigns_id', '=', 'campaigns.id');
     })
  ->where('donations.user_id', Auth::user()->id)
    ->select('donations.*')
    ->addSelect('campaigns.title')
    ->orderBy('donations.id', 'DESC')
    ->paginate(20);

      ?>
@extends('app')

@section('title') {{ trans('misc.donations') }} - @endsection

@section('css')

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.css"/>

@endsection

@section('content')


<div class=" container margin-top-90 margin-bottom-40">
	 <h2 class="subtitle-color-7 text-uppercase">{{ trans('misc.donations') }}</h2>
		<!-- Col MD -->
		<div class=" login-form-2 col-md-8 margin-bottom-20">

<div class=" table-responsive">
   <table id="donation" class="table table-striped">

   	@if( $data->total() !=  0 && $data->count() != 0 )
   	<thead>
   		<tr>
   		 <th class="active">ID</th>
          <th class="active">{{ trans('auth.full_name') }}</th>
          <th class="active">{{ trans_choice('misc.campaigns_plural', 1) }}</th>
          <th class="active">{{ trans('misc.donation') }}</th>
           <th class="active">{{ trans('Status') }}</th>
          <th class="active">{{ trans('admin.date') }}</th>
			<th class="active">Link Referral</th>
          </tr>
   		  </thead>

   		  <tbody>
   		      @foreach( $data as $donation )
                    <tr>
                      <td>{{ $donation->id }}</td>
                      <td>{{ $donation->fullname }}</td>
                      <td><a href="{{url('campaign',$donation->campaigns_id)}}" target="_blank">{{ str_limit($donation->title, 10, '...') }} <i class="fa fa-external-link-square"></i></a></td>
                      <td>{{ $settings->currency_symbol.number_format($donation->donation) }}</td>
                      <td>{{ $donation->payment_status }}</td>
                      <td>{{ date('d M, y', strtotime($donation->payment_date)) }}</td>
											<td>{{url('ref/donasi/'.Auth::user()->email.'/'.$donation->campaigns_id)}}</td>
                    </tr><!-- /.TR -->
                    @endforeach

                    @else
                    <hr />
                    	<h3 class="text-center no-found">{{ trans('misc.no_results_found') }}</h3>

                    @endif
   		  		 		</tbody>
   		  		 		</table>
   		  		 		</div>

   		  		 	@if( $data->lastPage() > 1 )
   		  		 		{{ $data->links() }}
   		  		 	@endif

		</div><!-- /COL MD -->

		<div class="col-md-4">
			@include('users.navbar-edit')
		</div>

 </div><!-- container -->

 <!-- container wrap-ui -->
@endsection

@section('javascript')
<!-- Datatables -->
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.js"></script>

<script type="text/javascript">
$(document).ready(function() {
    $('#donation').DataTable( {
        initComplete: function () {
            this.api().columns().every( function () {
                var column = this;
                var select = $('<select><option value=""></option></select>')
                    .appendTo( $(column.footer()).empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );

                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );

                column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                } );
            } );
        }
    } );
} );
</script>
@endsection