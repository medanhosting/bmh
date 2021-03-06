<?php
// ** Data User logged ** //
$settings = App\Models\AdminSettings::first();

$data = App\Models\Donations::leftJoin('campaigns', function($join) {
  $join->on('donations.campaigns_id', '=', 'campaigns.id');
})
->where('donations.user_id', Auth::user()->id)
->where('donations.payment_status', '=', 'paid')
->select('donations.*')
->addSelect('campaigns.title')
->orderBy('donations.id','DESC')
->limit(5)
->paginate(5);

$address = App\Models\Address::where('user_id',Auth::user()->id)->where('jenis','rumah')->first();
$created = App\Models\Campaigns::where('user_id',Auth::user()->id)->count();
$followed = App\Models\Like::where('user_id',Auth::user()->id)->count();

?>
@extends('app')

@section('title') {{ trans('misc.donations') }} - @endsection

@section('content')


<div class="container margin-top-90 margin-bottom-40">

  <div class="col-md-8">
    <div class="row">
      <!-- Col MD -->
      <div class="col-md-12">
        <p class="subtitle-color-8 text-uppercase">Selamat datang <b>{{ Auth::user()->name }}</b> di dasboard <a>{{$settings->title}}</a></p>
      </div>
      <div class="col-md-6">
        <div class="panel panel-default">
          <div class="panel-body">
            <h1>{{ $settings->currency_symbol.number_format($user->donationMade()) }}</h1>
            <h4>Donasi disalurkan</h4>
          </div>
        </div>
      </div>


      <div class="col-md-6">
        <div class="panel panel-default">
          <div class="panel-body">
            <h1>{{ $settings->currency_symbol.number_format(Auth::user()->saldo) }}</h1>
            <h4>Saldo anda</h4>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12 margin-bottom-20">
        <h4>Donasi Terbaru</h4>
        <div class="table-responsive">
          <table class="table table-striped">

            @if( $data->total() !=  0 && $data->count() != 0 )
            <thead>
              <tr>
                <th class="active">No</th>
                <th class="active">{{ trans('auth.full_name') }}</th>
                <th class="active">{{ trans_choice('misc.campaigns_plural', 1) }}</th>
                <th class="active">{{ trans('auth.email') }}</th>
                <th class="active">{{ trans('misc.donation') }}</th>
                <th class="active">{{ trans('admin.date') }}</th>
              </tr>
            </thead>

            <tbody>
              @php
                $i = 1;
              @endphp
              @foreach( $data as $donation )
              <tr>
                <td>{{ $i }}</td>
                <td>{{ $donation->fullname }}</td>
                <td><a href="{{url('campaign',$donation->campaigns_id)}}" target="_blank">{{ str_limit($donation->title, 10, '...') }} <i class="fa fa-external-link-square"></i></a></td>
                <td>{{ $donation->email }}</td>
                <td>{{ $settings->currency_symbol.number_format($donation->donation) }}</td>
                <td>{{ date('d M, y', strtotime($donation->payment_date)) }}</td>
              </tr><!-- /.TR -->
              @php
                $i++;
              @endphp
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
        
      </div>
    </div>
  </div>

  <div  class="col-md-4 margin-top-50">
     
    @include('users.navbar-edit')
  </div>

</div><!-- container -->

<!-- container wrap-ui -->
@endsection
