@extends('admin.layout')


@section('content')

<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">

  <!-- Content Header (Page header) -->

  <section class="content-header">

    <h4>

      {{ trans('admin.admin') }} <i class="fa fa-angle-right margin-separator"></i> Slider ({{$sliders->total()}})

      <a href="{{ route('admin-slider-create') }}" class="btn btn-sm btn-success no-shadow pull-right">
        <i class="glyphicon glyphicon-plus myicon-right"></i> {{{ trans('misc.add_new') }}}
      </a>
    </h4>

  </section>


  <!-- Main content -->

  <section class="content">

    @if(Session::has('success_message'))

    <div class="alert alert-success">

      <button type="button" class="close" data-dismiss="alert" aria-label="Close">

        <span aria-hidden="true">×</span>

      </button>

      <i class="fa fa-check margin-separator"></i>  {{ Session::get('success_message') }}	        

    </div>

    @endif


    <div class="row">

      <div class="col-xs-12">

        <div class="box">

          <div class="box-header">

            <h3 class="box-title"> 

              Slider                 		

            </h3>

          </div><!-- /.box-header -->


          <div class="box-body table-responsive no-padding">

            <table class="table table-hover">

              <tbody>


                @if( $sliders->total() !=  0 && $sliders->count() != 0 )

                <tr>

                  <th class="active">ID</th>

                  <th class="active">Image</th>

                  <th class="active">{{ trans('admin.actions') }}</th>

                  <td class="active">Status</td>

                </tr><!-- /.TR -->


                  @foreach( $sliders as $slider )

                  <tr>

                    <td>{{ $slider->id }}</td>
                    <td>{{ $slider->image }}</td>
                    <td> 
                      <a href="{{ route('admin-slider-edit', $slider->id) }}" class="btn btn-success btn-xs padding-btn">

                        {{ trans('admin.edit') }}

                      </a> 
                    </td>
                    <td><span class="label label-{{ $slider->isActive?'success' : 'danger' }}">{{ $slider->isActive? 'Active' : 'Inactive' }}</span></td>

                  </tr><!-- /.TR -->

                  @endforeach


                @else

                <hr />

                <h3 class="text-center no-found">{{ trans('misc.no_results_found') }}</h3>


                @endif


              </tbody>


            </table>


          </div><!-- /.box-body -->

        </div><!-- /.box -->

        @if( $sliders->lastPage() > 1 )

        {{ $sliders->links() }}

        @endif

      </div>

    </div>        	


    <!-- Your Page Content Here -->


  </section><!-- /.content -->

</div><!-- /.content-wrapper -->

@endsection
