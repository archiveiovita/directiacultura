@extends('admin::admin.app')
@include('admin::admin.nav-bar')
@include('admin::admin.left-menu')
@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/back') }}">Control Panel</a></li>
            <li class="breadcrumb-item"><a href="{{ route('posts.index') }}">Articole</a></li>
            <li class="breadcrumb-item active" aria-current="page">Crearea articolului</li>
        </ol>
    </nav>
    <div class="title-block">
        <h3 class="title"> Crearea articolului </h3>
        @include('admin::admin.list-elements', [
        'actions' => [
        trans('variables.add_element') => route('posts.create'),
        ]
        ])
    </div>

    @include('admin::admin.alerts')


    <div class="list-content">

        <form class="form-reg" method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
            {{ csrf_field() }}

            <div class="part full-part" style="padding: 25px 8px;">

                <label>Category</label>
                <select class="form-control" name="category_id">
                    <option disabled>- - -</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->translation()->first()->name }}</option>
                    @endforeach
                </select>
            </div>


            @if (!empty($langs))

                <div class="tab-area" style="margin-top: 25px;">
                    <ul class="nav nav-tabs nav-tabs-bordered">
                        @if (!empty($langs))
                            @foreach ($langs as $key => $lang)
                                <li class="nav-item">
                                    <a href="#{{ $lang->lang }}" class="nav-link  {{ $key == 0 ? ' open active' : '' }}"
                                       data-target="#{{ $lang->lang }}">{{ $lang->lang }}</a>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>


                @foreach ($langs as $lang)

                    <div class="tab-content {{ $loop->first ? ' active-content' : '' }}" id={{ $lang->lang }}>
                        <div class="part left-part">

                            <ul style="padding: 25px 0;">

                                <li>
                                    <label>{{trans('variables.title_table')}} [{{ $lang->lang }}]</label>
                                     <input type="text" name="title_{{ $lang->lang }}"
                                    class="name"
                                    data-lang="{{ $lang->lang }}">
                                </li>

                                <li>
                                    <label for="">{{trans('variables.body')}} [{{ $lang->lang }}]</label>
                                    <textarea name="body_{{ $lang->lang }}" id="body-{{ $lang->lang }}"
                                              data-type="ckeditor"></textarea>
                                    <script>
                                        CKEDITOR.replace('body-{{ $lang->lang }}', {
                                            language: '{{$lang->lang}}',
                                            // filebrowserBrowseUrl: "{{route('infos.upload',['_token' => csrf_token() ])}}",
                                            // filebrowserImageBrowseUrl: "{{route('infos.upload',['_token' => csrf_token() ])}}",
                                            // filebrowserUploadUrl: "{{route('infos.upload',['_token' => csrf_token() ])}}",
                                            // filebrowserImageUploadUrl: "{{route('infos.upload',['_token' => csrf_token() ])}}"
                                            filebrowserBrowseUrl: "https://directiacultura.md/back/settings/ckeditor/upload/images?_token={{ csrf_token() }}",
                                            filebrowserImageBrowseUrl: "https://directiacultura.md/back/settings/ckeditor/upload/images?_token={{ csrf_token() }}",
                                            filebrowserUploadUrl: "https://directiacultura.md/back/settings/ckeditor/upload/images?_token={{ csrf_token() }}",
                                            filebrowserImageUploadUrl: "https://directiacultura.md/back/settings/ckeditor/upload/images?_token={{ csrf_token() }}"
                                        });
                                    </script>
                                </li>
                            </ul>
                        </div>


                        <div class="part right-part">
                            <ul>
                                <li>
                                    <label>{{trans('variables.meta_title_page')}} [{{ $lang->lang }}]</label>
                                    <input type="text" name="meta_title_{{ $lang->lang }}">
                                </li>

                                <li>
                                    <label>{{trans('variables.meta_keywords_page')}} [{{ $lang->lang }}]</label>
                                    <input type="text" name="meta_keywords_{{ $lang->lang }}">
                                </li>

                                <li>
                                    <label>{{trans('variables.meta_description_page')}} [{{ $lang->lang }}]</label>
                                    <input type="text" name="meta_description_{{ $lang->lang }}">
                                </li>
                            </ul>
                        </div>

                    </div>
                @endforeach
            @endif

            <div class="part">
              <ul>
                <li>
                    <span>On Home</span>
                    <input type="checkbox" name="on_home">
                </li>
                <li>
                    <label>Alias</label>
                    <input type="text" name="alias" class="form-control" id="slug-{{ $lang->lang }}">
                </li>
                <li>
                    <label>Image</label>
                    <input type="file" name="image" id="upload-file">
                    <img id="upload-img" src="" alt="" width="200px">
                </li>
                <li>
                    <label>Date</label>
                    <input type="date" name="date">
                    <input type="time" name="time">
                </li>
                <li>
                  <input type="submit" value="{{trans('variables.save_it')}}">
                </li>
              </ul>
            </div>
        </form>
    </div>

@stop

@section('footer')
    <footer>
        @include('admin::admin.footer')

        <script>

            $('button.tag').click(function(e) {
                e.preventDefault();

                $input = $(this).siblings().last().clone().val('');
                $(this).parent().append($input);
            });

        </script>
    </footer>
@stop
