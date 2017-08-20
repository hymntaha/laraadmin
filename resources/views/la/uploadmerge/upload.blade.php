@extends("la.layouts.app")

@section("contentheader_title", "Upload and Merge")
@section("contentheader_description", "Upload and Merge Functionality")
@section("section", "Upload and Merge")
@section("sub_section", "Listing")
@section("htmlheader_title", "Upload and Merge Files")

@section("main-content")
    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title" style="padding:12px 0px;font-size:25px;"><strong>Upload and Merge</strong></h3>
            </div>
            <div class="panel-body">

                @if ($message = Session::get('success'))
                    <div class="alert alert-success" role="alert">
                        {{ Session::get('success') }}
                    </div>
                @endif

                @if ($message = Session::get('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ Session::get('error') }}
                    </div>
                @endif

                <h3>Import File Form:</h3>
                <form style="border: 4px solid #a1a1a1;margin-top: 15px;padding: 20px;" action="{{ URL::to('admin/importExport') }}" class="form-horizontal" method="post" enctype="multipart/form-data">

                    <input type="file" name="import_file[]" multiple/>
                    {{ csrf_field() }}
                    <br/>

                    <button class="btn btn-success btn-lg">Merge</button>

                </form>
                <br/>

                <h3>Here is your merged file:</h3>
                    {{--{{ dd($rows[0]) }}--}}
                    {{--@for($i = 1; $i < count($rows); $i++)--}}
                        {{--<td>{{$rows[$i]}}<br /></td>--}}
                    {{--@endfor--}}
                    {{--{{dd($rows[0])}}--}}
                    <table style="width:100%" border="1">
                        <tr>
                            @foreach($rows[0] as $title)
                                <th>{{$title}}</th>
                            @endforeach
                            <br/>
                        </tr>
                        @foreach ($rows as $key=>$row)
                            <?php if($key === 0) continue; ?>

                            <tr>
                                <td>{{ implode('', $row)}}</td>
                                @foreach($row as $list)
                                    <td> {{ $list}}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </table>
                <hr>
                <h3>Import File From Database:</h3>
                <div style="border: 4px solid #a1a1a1;margin-top: 15px;padding: 20px;">
                    <a href="{{ url('importExport/xls') }}"><button class="btn btn-success btn-lg">Push Excel xls</button></a>
                    <a href="{{ url('importExport/xlsx') }}"><button class="btn btn-success btn-lg">Push Excel xlsx</button></a>
                    <a href="{{ url('importExport/csv') }}"><button class="btn btn-success btn-lg">Push CSV</button></a>
                </div>

            </div>
        </div>
    </div>
@endsection