@extends('menu')

@section('content')
    <div class="container">
        <br>
        <div class="ibox-content">

            <section id="content">
                @if(Session::has('message'))
                    <div class="alert alert-success">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <em> {!! session('message') !!}</em>
                    </div>
                @endif

                @if(Session::has('errors'))
                    <div class="alert alert-danger">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        @foreach($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                {!! Form::model($model, ['route'=> ['seracademico.ouvidoria.psf.update', $model->id], 'method' => "POST", 'id'=> 'formPsf' ]) !!}
                    @include('tamplatesForms.tamplateFormPsf')
                {!! Form::close() !!}
            </section>
        </div>
    </div>
@stop